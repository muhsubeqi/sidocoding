<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'comment' => 'nullable',
                'posts_id' => 'nullable',
            ]);

            Comment::create([
                'name' => $dataValidated['name'],
                'email' => $dataValidated['email'],
                'comment' => $dataValidated['comment'],
                'posts_id' => $dataValidated['posts_id'],
                'confirm' => 'Menunggu'
            ]);

            session(['name' => $dataValidated['name'], 'email' => $dataValidated['email'], 'comment' => $dataValidated['comment'], 'posts_id' => $dataValidated['posts_id']]);

            return redirect()->back()->with('success', 'Berhasil berkomentar, komentar anda menunggu persetujuan admin');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors([$th]);
        }


    }
}