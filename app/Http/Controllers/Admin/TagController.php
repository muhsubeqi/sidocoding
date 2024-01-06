<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TagController extends Controller
{
    private $folder = 'admin/tag';
    public function index()
    {
        return view ("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::select('*');
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
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'nullable',
            ]);

            foreach ($dataValidated['name'] as $lt) {
                $tags = Tag::where('name', $lt)->first();
                if ($tags == null) {
                    Tag::insert([
                        'name' => $lt,
                    ]);
                }
            }
 
            $data = [
                'message' => 200,
                'data' => "Berhasil memasukkan data tag"
            ];

        } catch (\Throwable $th) {
            $data = [
                'message' => 500,
                'data' => $th->getMessage()
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
            ]);

            $category = Tag::findOrFail($dataValidated['id_edit']);

            $category->update([
                'id' => $dataValidated['id_edit'],
                'name' => $dataValidated['name'],
            ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil Mengedit Data Dengan Nama '.$dataValidated['name']
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

            Tag::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data " . $dataValidated['name']
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