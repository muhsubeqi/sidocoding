<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleDrive;
use App\Models\Category;
use App\Models\Ebook;
use App\Services\BulkData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class EbookController extends Controller
{
    private $folder = 'admin/ebook';
    public function index()
    {
        return view("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Ebook::where('users_id', '=', auth()->user()->id)
                        ->select('*', 'categories_id as kategori', 'users_id as pemilik')
                        ->with('category', 'user');
            return DataTables::of($data)
                ->editColumn('cover', function($item){
                    $url= asset('data/ebook/cover/'.$item->cover);
                    return '<img src="'.$url.'" border="0" class="img-rounded" style="width:50px;" align="center" />';
                })
                ->editColumn('kategori', function($item){
                    $kategori = '';
                    if(isset($item->category->name) ? $kategori .= $item->category->name : $kategori .= 'Tidak Ada Kategori') ;
                    return $kategori;
                })
                ->editColumn('pemilik', function($item){
                    return $item->user->name ;
                })
                ->editColumn('status', function($item){
                    return $item->status == "Premium" ? '<td class="align-middle"><span
                    class="badge badge-pill badge-primary">'.$item->status.'</span>
                    </td>' : '<td class="align-middle"><span
                    class="badge badge-pill badge-warning">'.$item->status.'</span></td>';
                })
                ->addColumn('file', function($row){
                    $url = GoogleDrive::link($row->path);
                    $fileBtn = '
                    <div class="row">
                        <a class="btn btn-sm btn-secondary m-1"
                        href="'.$url.'" target="_blank"><i class="fa fa-eye"></i></a>
                    </div>
                    ';
                    return $fileBtn;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="'. route('admin.ebook.edit', ['id' => $row->id]) .'">Edit</a>
                            <form
                                action="' . route('admin.ebook.delete', ['id' => $row->id]) . '"
                                class="form-hapus" method="POST" onsubmit="deleteData(event)">
                                ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" value="' . $row->id .'"
                                    name="id">
                                <input type="hidden" value="'. $row->title .'"
                                    name="title">
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['cover', 'kategori', 'pemilik', 'status', 'file','confirm','action' ])
                ->toJson();
        }
    }

    public function create()
    {
        $categories = Category::all();

        return view ('admin.ebook.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'categories_id' => 'nullable',
                'description' => 'nullable',
                'file' => 'required',
                'status' => 'required',
            ]);
    
            if ($request->has('cover') && $request->has('file')) {
                // Upload Cover ke lokal
                $lokasi = 'data/ebook/cover/';
                $cover = $request->file('cover');
                $extensi = $request->file('cover')->extension();
                $new_cover_name = 'Cover' . date('YmdHis') . uniqid() . '.' . $extensi;
                $cover->move(public_path($lokasi), $new_cover_name);
                // Upload File ke Google Drive
                $fileEbook = $request->file('file');
                $type = 'Ebook';
                $uploadFileEbook = GoogleDrive::upload($fileEbook, $type);
                // dapatkan path untuk ambil link 
                $path = GoogleDrive::getData($uploadFileEbook['name']);
                $getPath = $path['path'];

                // Upload data ke database
                Ebook::create([
                    'title' => $dataValidated['title'],
                    'slug' => $dataValidated['slug'],
                    'categories_id' => $dataValidated['categories_id'],
                    'description' => $dataValidated['description'],
                    'status' => $dataValidated['status'],
                    'users_id' => auth()->user()->id,
                    'cover' => $new_cover_name,
                    'file' => $uploadFileEbook['name'],
                    'path' => $getPath,
                ]);
                return redirect()->route('admin.ebook')->with('success', "Berhasil menambahkan data ebook dengan nama " . $dataValidated['title']);
            }
        } catch (\Throwable $th) {
            return redirect()->route('admin.ebook')->with('failed', "Gagal menambahkan data ebook dengan nama " . $dataValidated['title']);
        }
       
    }

    public function edit($id)
    {
        $ebook = Ebook::find($id);
        $categories = Category::all();

        return view('admin.ebook.edit', compact('ebook', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'categories_id' => 'nullable',
                'description' => 'nullable',
                'status' => 'required',
            ]);

            $namaCover = $request->input('cover_lama');
            $getFile = $request->input('file_lama');

            $ebook = Ebook::find($id);
            $ebook->title = $dataValidated['title'];
            $ebook->slug = $dataValidated['slug'];
            $ebook->categories_id = $dataValidated['categories_id'];
            $ebook->description = $dataValidated['description'];
            $ebook->status = $dataValidated['status'];

            if ($request->has('cover')) {
                $lokasi = 'data/ebook/cover/';
                $cover = $request->file('cover');
                $extensi = $request->file('cover')->extension();
                $new_cover_name = 'Cover' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $cover->move(public_path($lokasi), $new_cover_name);
                $namaCover = $new_cover_name;
                if ($upload) {
                    $getCover = Ebook::find($id)->cover;
                    if ($getCover != null) {
                        File::delete(public_path('data/ebook/cover/' . $getCover));
                    }
                }
                $ebook->cover = $namaCover;
            }

            if($request->has('file')){
                $fileEbook = $request->file('file');
                if ($fileEbook) {
                    $getFileLama = Ebook::find($id)->file;
                    if ($getFileLama != null) {
                        GoogleDrive::delete($getFileLama);
                    }

                    $type = 'Ebook';
                    $uploadFileEbook = GoogleDrive::upload($fileEbook, $type);
                    // ambil path
                    $path = GoogleDrive::getData($uploadFileEbook['name']);
                    $getPath = $path['path'];
                    $ebook->file = $uploadFileEbook['name'];
                    $ebook->path = $getPath;
                }
            }

            $ebook->save();

            return redirect()->route('admin.ebook')->with('success', "Berhasil mengedit data ebook dengan nama " . $dataValidated['title']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.ebook')->with('failed', "Berhasil mengedit data ebook dengan nama " . $dataValidated['title']);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'title' => 'required',
            ]);
           
            $getCover = Ebook::find($dataValidated['id'])->cover;
                if ($getCover != null) {
                    File::delete(public_path('data/ebook/cover/' . $getCover));
                }
            
            $getFile = Ebook::find($dataValidated['id'])->file;
                if ($getFile != null) {
                    GoogleDrive::delete($getFile);
                }

            Ebook::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data ebook dengan nama " . $dataValidated['title']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data ebook dengan nama " . $dataValidated['title']
            ];
        }

        return $data;
    }
}