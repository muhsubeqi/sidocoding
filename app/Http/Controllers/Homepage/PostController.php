<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function listPostingan()
    {
        $posts = Post::where('status', 'Publish')->orderBy('id', 'desc')->get();
        return view('homepage/postingan/list', compact('posts'));
    }

    public function index(Request $request)
    {
        $posts = Post::where('status', 'Publish')->orderBy('id', 'desc')->paginate(10);
        $artilces = '';
        if ($request->ajax()) {
            foreach ($posts as $post) {
                $category = '';
                if (isset($post->category->name) != null) {
                    $category .= '<a
                    href="' . route('tutorial.list', ['id' => isset($post->category->id)]) . '">' . $post->category->name . '</a>';
                } else {
                    $category .= 'Uncategorized';
                }
                $artilces .= '
                    <div class="col-lg-3">
                        <div class="home-blog-post">
                            <div class="image">
                                <img src="' . asset('/data/post/image/' . $post->image) . '"
                                    style="width: 500px; height: 200px; object-fit:cover;" alt="..."
                                    class="img-fluid" />
                                <div class="overlay d-flex align-items-center justify-content-center">
                                    <a href="' . route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) . '"
                                        class="btn btn-template-outlined-white"><i class="fa fa-chain">
                                        </i> Read More</a>
                                </div>
                            </div>
                            <div class="text">
                                <h4>
                                    <a
                                        href="' . route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) . '">' . Str::limit($post->title, 30) . '</a>
                                </h4>
                                <p class="author-category">
                                    By <a href="#">' . $post->user->name . '</a> in
                                    ' . $category . '
                                </p>
                                <a href="' . route('postingan.detail', ['id' => $post->id, 'slug' => $post->slug]) . '"
                                    class="btn btn-template-outlined">Continue
                                    Reading</a>
                            </div>
                        </div>
                    </div>
                ';
            }
            return $artilces;
        }

        return view('homepage/postingan/index');

    }

    public function detail($id, $slug)
    {
        $post = Post::where([['id', $id], ['status', 'Publish']])->first();

        $categories = Category::all();

        $listTagId = json_decode($post->tags);

        $getTags = [];
        foreach ($listTagId as $lt) {
            $tags = Tag::where('id', $lt)->first();
            array_push($getTags, $tags);
        }

        $comments = Comment::where('posts_id', $id)->get();
        $jmlComment = [];
        foreach ($comments as $c) {
            if ($c->confirm == 'Setuju') {
                array_push($jmlComment, $c->confirm);
            }
        }

        $category = Category::where('id', $post->categories_id)->first();
        $listPost = [];
        $getNameCategory = null;
        if ($category != null) {
            $listPost = Post::where([
                ['categories_id', $category->id],
                ['status', 'Publish']
            ])->get();
            $getNameCategory = $category->name;
        }

        return view('homepage/postingan/detail', compact('post', 'categories', 'getTags', 'comments', 'jmlComment', 'listPost', 'getNameCategory'));
    }

    public function search(Request $request)
    {
        $posts = Post::limit(0)->get();
        if ($request->keyword != '') {
            $posts = Post::where([
                ['title', 'LIKE', '%' . $request->keyword . '%'],
                ['status', 'Publish']
            ])->limit(10)->get();
        }
        return response()->json([
            'posts' => $posts
        ]);

    }
}