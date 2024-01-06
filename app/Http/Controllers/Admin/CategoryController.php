<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    private $folder = 'admin/category';
    public function index()
    {
        return view("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('*');
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="button" class="dropdown-item" 
                                data-toggle="modal" data-target="#modal_edit"
                                data-id="' . $row->id . '"
                                data-name="' . $row->name . '"
                                data-slug="' . $row->slug . '"
                                data-description="' . $row->description . '"
                                data-image="' . $row->image . '"
                                >Edit</button>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id .'">
                                <input type="hidden" name="name" value="' . $row->name .'">
                                <button type="submit" class="dropdown-item text-danger">
                                    Delete    
                                </button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->editColumn('image', function($item){
                    return $item->image ? '<img src="' . asset('data/category/image/' . $item->image) . '" class="profile-user-img img-fluid img-circle"
                    style="width: 100px; height: 100px; object-fit:cover;" alt="Category Image"/>' : '<img class="profile-user-img img-fluid img-circle"
                    style="width: 100px; height: 100px; object-fit:cover;" alt="Category Image">';
                })
                ->rawColumns(['action', 'image'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'description' => 'nullable',
                'image' => 'nullable'
            ]);

            $check = Category::where('name', $dataValidated['name'])->first();
            if ($check == null) {
                if ($request->has('image')) {
                    $lokasi = 'data/category/image/';
                    $image = $request->file('image');
                    $extensi = $request->file('image')->extension();
                    $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
    
                    $image->move(public_path($lokasi), $new_image_name);
                    Category::create([
                        'name' => $dataValidated['name'],
                        'slug' => $dataValidated['slug'],
                        'description' => $dataValidated['description'],
                        'image' => $new_image_name,
                    ]);
                } else {
                    Category::create([
                        'name' => $dataValidated['name'],
                        'slug' => $dataValidated['slug'],
                        'description' => $dataValidated['description'],
                    ]);
        
                }
    
                $data = [
                    'message' => 200,
                    'data' => 'Berhasil menambahkan data kategori dengan nama '.$dataValidated['name']
                ];
            }else{
                $data = [
                    'message' => 500,
                    'data' => 'Data kategori dengan nama '.$dataValidated['name'].' sudah tersedia'
                ];
            }

        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'message' => 500,
                'data' => 'Gagal menambahkan data kategori dengan nama '.$dataValidated['name']
            ];
        }

        return $data;
    }

    public function update(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id_edit' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'description' => 'nullable',
            ]);

            $category = Category::findOrFail($dataValidated['id_edit']);
            $getImageOld = $request->input('image_old');

            if ($request->has('image_edit')) {
                $lokasi = 'data/category/image/';
                $image = $request->file('image_edit');
                $extensi = $request->file('image_edit')->extension();
                $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $image->move(public_path($lokasi), $new_image_name);
                $getImageOld = $new_image_name;
                if ($upload) {
                    $getImage = Category::find($dataValidated['id_edit'])->image;
                    if ($getImage != null) {
                        File::delete(public_path('data/category/image/' . $getImage));
                    }
                }
            }

            $category->update([
                'id' => $dataValidated['id_edit'],
                'name' => $dataValidated['name'],
                'slug' => $dataValidated['slug'],
                'description' => $dataValidated['description'],
                'image' => $getImageOld,
            ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit data kategori dengan nama '.$dataValidated['name']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'message' => 500,
                'data' => $th->getMessage()
            ];
        }
        
        return $data;
    }

    public function destroy(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'name' => 'required',
            ]);

            $getImage = Category::find($dataValidated['id'])->image;

            if ($getImage != null) {
                File::delete(public_path('data/category/image/' . $getImage));
            }

            Category::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data kategori dengan nama " . $dataValidated['name']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                "message" => 500,
                "data" => $th->getMessage()
            ];
        }

        return $data;
    }
}