<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::where('status', 'Publish')->orderBy('id', 'desc')->get();

        return new PostResource('true', 'Daftar Semua Post', $posts);
    }
}