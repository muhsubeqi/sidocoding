<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
{
    private $folder = 'admin/product-category';
    public function index()
    {
        return view("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::select('*');
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
                                data-icon="' . $row->icon . '"
                                data-color="' . $row->color . '"
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
                ->addColumn('icon', function($row){
                    $icon = '';
                    isset($row->icon) ? $icon .= '<i class="' . $row->icon .'"></i>' : $icon .= '';
                    return $icon;
                })
                ->addColumn('color', function($row){
                    $color = '';
                    isset($row->color) ? $color .= '<badge style="padding: 2px 10px;" class="bg-' . $row->color .'"></badge>' : $color .= '<badge style="padding: 2px 10px;" class="bg-secondary"></badge>';
                    return $color;
                })
                ->rawColumns(['action', 'icon', 'color'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'icon' => 'nullable',
                'color' => 'nullable',
            ]);

            $check = ProductCategory::where('name', $dataValidated['name'])->first();
            if ($check == null) {
                ProductCategory::create([
                    'name' => $dataValidated['name'],
                    'slug' => $dataValidated['slug'],
                    'icon' => $dataValidated['icon'],
                    'color' => $dataValidated['color'],
                ]);
    
                $data = [
                    'message' => 200,
                    'data' => 'Berhasil menambahkan data kategori produk dengan nama '.$dataValidated['name']
                ];
            }else{
                $data = [
                    'message' => 500,
                    'data' => 'Data kategori produk dengan nama '.$dataValidated['name'].' sudah tersedia'
                ];
            }

        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'message' => 500,
                'data' => 'Gagal menambahkan data kategori produk dengan nama '.$dataValidated['name']
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
                'icon' => 'nullable',
                'color' => 'nullable',
            ]);

            $productCategory = ProductCategory::findOrFail($dataValidated['id_edit']);

            $productCategory->update([
                'id' => $dataValidated['id_edit'],
                'name' => $dataValidated['name'],
                'slug' => $dataValidated['slug'],
                'icon' => $dataValidated['icon'],
                'color' => $dataValidated['color'],
            ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengedit data kategori produk dengan nama '.$dataValidated['name']
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

            ProductCategory::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data kategori produk dengan nama " . $dataValidated['name']
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