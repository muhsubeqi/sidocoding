<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Post;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('homepage/tutorial/index', compact('categories'));
    }

    public function listTutorial($id)
    {
        $post = Post::where([
            ['categories_id', $id],
            ['status', 'Publish']])->paginate(9);

        $listPost = Post::where([
            ['categories_id', $id],
            ['status', 'Publish']])->get();

        $category = Category::find($id);
        $categoryList = Category::all();

        return view('homepage/postingan/list', compact('post','listPost', 'category', 'categoryList'));
    }

    public function listEbook($id)
    {
        $listEbook = Ebook::where([
            ['categories_id', $id],
            ['confirm', 'Setuju']])->get();

        $category = Category::find($id);
        $categoryList = Category::all();

        return view('homepage/ebook/list', compact('listEbook', 'category', 'categoryList'));
    }
}