<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommentController extends Controller
{
    public function index()
    {
        return view('admin.comment.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Comment::select('*');
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $content = '';
                    if ($row->confirm == 'Menunggu') {
                       $content .= '
                            <form action="" onsubmit="confirmData(event)" method="POST">
                            ' . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <input type="hidden" name="confirm" value="Setuju">
                                <button type="submit" class="btn btn-sm btn-success m-1">
                                    <i class="fa fa-check"></i>  
                                </button>
                                </form>
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id .'">
                                <input type="hidden" name="name" value="' . $row->name .'">
                                <button type="submit" class="btn btn-sm btn-danger m-1">
                                <i class="fa fa-times"></i>  
                                </button>
                            </form>';
                    }

                    if ($row->confirm == 'Setuju') {
                        $content .= '
                            <form action="" onsubmit="deleteData(event)" method="POST">
                            ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" name="id" value="' . $row->id .'">
                                <input type="hidden" name="name" value="' . $row->name .'">
                                <button type="submit" class="btn btn-sm btn-danger m-1">
                                <i class="fa fa-times"></i>  
                                </button>
                            </form>';
                    }

                    $actionBtn = '
                    <div class="row">
                    '. $content .'
                    </div>
                    ';
                    return $actionBtn;
                })
                ->editColumn('confirm', function($row){
                    $confirm = '';
                    if ($row->confirm == 'Menunggu') {
                       $confirm .= '<div class="btn btn-sm rounded-pill btn-secondary text-center w-100">Menunggu</div>';
                    }
                    if ($row->confirm == 'Setuju') {
                        $confirm .= '<span class="btn btn-sm rounded-pill btn-success text-center w-100">Setuju</span>';
                    }

                    return $confirm;
                  
                })
                ->addColumn('judul', function($item){
                    $content = '';
                    if ($item->posts_id != null) {
                        $content .= '<p>' .'<span class="badge bg-info"> ' . $item->post->category->name .'</span> - '. $item->post->title . '</p>';
                     }
                    return $content ;
                })
                ->rawColumns(['action','judul','confirm'])
                ->toJson();
        }
    }

    public function confirm(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'confirm' => 'required'
            ]);

            $comment = Comment::findOrFail($dataValidated['id']);
    
            $comment->update([
                'id' => $dataValidated['id'],
                'confirm' => $dataValidated['confirm']
            ]);

            $data = [
                'message' => 200,
                'data' => 'Berhasil mengupdate konfirmasi '. '"'. $dataValidated['confirm'] . '"' .' untuk komentar ini'
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

            Comment::destroy($dataValidated['id']);

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data komentar dari " . $dataValidated['name']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data komentar dari " . $dataValidated['name']
            ];
        }

        return $data;
    }

}