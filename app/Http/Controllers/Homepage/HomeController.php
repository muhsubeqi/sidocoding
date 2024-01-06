<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'Publish')->orderBy('id', 'DESC')->limit(9)->get();
        $ebooks = Ebook::orderBy('id', 'DESC')->limit(4)->get();

        return view('homepage/index', compact('posts', 'ebooks'));
    }
}