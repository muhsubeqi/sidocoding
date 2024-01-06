<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    private $folder = 'admin/product';
    public function index()
    {
        return view("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('*', 'product_categories_id as kategori', 'users_id as pemilik');
            return DataTables::of($data)
                ->editColumn('image', function($item){
                    $url= asset('data/product/image/'.$item->image);
                    return '<img src="'.$url.'" border="0" class="img-rounded" style="width:50px;" align="center" />';
                })
                ->editColumn('kategori', function($item){
                    $kategori = '';
                    if(isset($item->productCategory->name) ? $kategori .= $item->productCategory->name : $kategori .= 'Tidak Ada Kategori') ;
                    return $kategori;
                })
                ->editColumn('pemilik', function($item){
                    return $item->user->name ;
                })
                ->editColumn('price', function($item){
                    return "Rp. " . number_format($item->price,0,",",".");
                })
                ->addColumn('file', function($row){
                    $fileBtn = '
                    <div class="row">
                        <a class="btn btn-sm btn-secondary m-1"
                        href="'.$row->file.'" target="_blank"><i class="fa fa-download"></i></a>
                        <button class="btn btn-sm btn-secondary m-1"
                        data-toggle="modal" data-target="#modal_edit"
                        data-id="' . $row->id . '"
                        data-file="' . $row->file . '"
                        data-confirm="'. $row->confirm .'"><i class="fa fa-edit"></i></button>
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
                                href="'. route('admin.product.edit', ['id' => $row->id]) .'">Edit</a>
                            <form
                                action="' . route('admin.product.delete', ['id' => $row->id]) . '"
                                class="form-hapus" method="POST" onsubmit="deleteData(event)">
                                ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" value="' . $row->id .'"
                                    name="id">
                                <input type="hidden" value="'. $row->name .'"
                                    name="name">
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['image', 'kategori', 'pemilik', 'price', 'file','action' ])
                ->toJson();
        }
    }

    public function create()
    {
        $productCategories = ProductCategory::all();

        return view ("$this->folder/create", compact('productCategories'));
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'product_categories_id' => 'nullable',
                'description' => 'nullable',
                'file' => 'required',
                'price' => 'required',
            ]);
    
            if ($request->has('image')) {
                $lokasi = 'data/product/image/';
                $image = $request->file('image');
                $extensi = $request->file('image')->extension();
                $new_image_name = 'Product' . date('YmdHis') . uniqid() . '.' . $extensi;
    
                $image->move(public_path($lokasi), $new_image_name);
            
                Product::create([
                    'name' => $dataValidated['name'],
                    'slug' => $dataValidated['slug'],
                    'product_categories_id' => $dataValidated['product_categories_id'],
                    'description' => $dataValidated['description'],
                    'price' => $dataValidated['price'],
                    'users_id' => auth()->user()->id,
                    'file' => $dataValidated['file'],
                    'image' => $new_image_name,
                ]);
            } else {
                Product::create([
                    'name' => $dataValidated['name'],
                    'slug' => $dataValidated['slug'],
                    'product_categories_id' => $dataValidated['product_categories_id'],
                    'description' => $dataValidated['description'],
                    'price' => $dataValidated['price'],
                    'users_id' => auth()->user()->id,
                    'file' => $dataValidated['file'],
                ]);
            }
            return redirect()->route('admin.product')->with('success', "Berhasil menambahkan data produk dengan nama " . $dataValidated['name']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.product')->with('failed', "Gagal menambahkan data produk dengan nama " . $dataValidated['name']);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $productCategories = ProductCategory::all();

        return view('admin.product.edit', compact('product', 'productCategories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'product_categories_id' => 'nullable',
                'description' => 'nullable',
                'price' => 'required',
            ]);

            $namaImage = $request->input('image_lama');

            if ($request->has('image')) {
                $lokasi = 'data/product/image/';
                $image = $request->file('image');
                $extensi = $request->file('image')->extension();
                $new_image_name = 'Product' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $image->move(public_path($lokasi), $new_image_name);
                $namaImage = $new_image_name;
                if ($upload) {
                    $getImage = Product::find($id)->image;
                    if ($getImage != null) {
                        File::delete(public_path('data/product/image/' . $getImage));
                    }
                }

                Product::where('id', $id)->update([
                    'name' => $dataValidated['name'],
                    'slug' => $dataValidated['slug'],
                    'product_categories_id' => $dataValidated['product_categories_id'],
                    'description' => $dataValidated['description'],
                    'price' => $dataValidated['price'],
                    'users_id' => auth()->user()->id,
                    'image' => $namaImage
                ]);
            }else{
                Product::where('id', $id)->update([
                    'name' => $dataValidated['name'],
                    'slug' => $dataValidated['slug'],
                    'product_categories_id' => $dataValidated['product_categories_id'],
                    'description' => $dataValidated['description'],
                    'price' => $dataValidated['price'],
                    'users_id' => auth()->user()->id,
                ]);
            }

            return redirect()->route('admin.product')->with('success', "Berhasil mengedit data produk dengan nama " . $dataValidated['name']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('admin.product')->with('failed', "Gagal mengedit data produk dengan nama " . $dataValidated['name']);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'name' => 'required',
            ]);
           
            $getImage = Product::find($dataValidated['id'])->image;
                if ($getImage != null) {
                    File::delete(public_path('data/product/image/' . $getImage));
                }

            Product::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data ebook dengan nama " . $dataValidated['name']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data ebook dengan nama " . $dataValidated['name']
            ];
        }

        return $data;
    }

    public function editFile(Request $request)
    {
        try {

            $dataValidated = $request->validate([
                'id_edit' => 'required',
                'file' => 'required',
            ]);

            $product = Product::findOrFail($dataValidated['id_edit']);
        
            $product->update([
                'id' => $dataValidated['id_edit'],
                'file' => $dataValidated['file'],
            ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit url file ebook'
            ];
        } catch (\Throwable $th) {
            $data = [
                'message' => 500,
                'data' => 'Gagal mengedit url file ebook'
            ];
        }
        return $data;
    }
}