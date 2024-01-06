<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    private $folder = 'admin/post';

    public function index()
    {
        return view("$this->folder/index");
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->role == 'admin') {
                $data = Post::select('*', 'categories_id as kategori', 'users_id as penulis')
                    ->with('category', 'user');
            } else {
                $data = Post::where('users_id', '=', auth()->user()->id)
                    ->select('*', 'categories_id as kategori', 'users_id as penulis')
                    ->with('category', 'user');
            }
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Klik
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="' . route('admin.post.edit', ['id' => $row->id]) . '">Edit</a>
                            <form
                                action="' . route('admin.post.delete', ['id' => $row->id]) . '"
                                class="form-hapus" method="POST" onsubmit="deleteData(event)">
                                ' . method_field('delete') . csrf_field() . '
                                <input type="hidden" value="' . $row->id . '"
                                    name="id">
                                <input type="hidden" value="' . $row->title . '"
                                    name="title">
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>';
                    return $actionBtn;
                })
                ->editColumn('kategori', function ($item) {
                    $kategori = '';
                    if (isset($item->category->name) ? $kategori .= $item->category->name : $kategori .= 'Tidak Ada Kategori')
                        ;
                    return $kategori;
                })
                ->editColumn('penulis', function ($item) {
                    return $item->user->name;
                })
                ->editColumn('status', function ($item) {
                    return $item->status == "Publish" ? '<td class="align-middle"><span
                    class="badge badge-pill badge-success">' . $item->status . '</span>
                    </td>' : '<td class="align-middle"><span
                    class="badge badge-pill badge-warning">' . $item->status . '</span></td>';
                })

                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view("$this->folder/create", compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required|max:255',
                'slug' => 'required|max:255',
                'content' => 'nullable',
                'categories_id' => 'nullable',
                'status' => 'required',
                'tags' => 'required'
            ]);

            $dataValidated['tags'] = json_encode($request->tags);

            if ($request->has('image')) {
                $lokasi = 'data/post/image/';
                $image = $request->file('image');
                $extensi = $request->file('image')->extension();
                $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;

                $image->move(public_path($lokasi), $new_image_name);

                Post::create([
                    'title' => $dataValidated['title'],
                    'slug' => $dataValidated['slug'],
                    'content' => $dataValidated['content'],
                    'categories_id' => $dataValidated['categories_id'],
                    'tags' => $dataValidated['tags'],
                    'status' => $dataValidated['status'],
                    'users_id' => auth()->user()->id,
                    'image' => $new_image_name,
                ]);
            } else {
                Post::create([
                    'title' => $dataValidated['title'],
                    'slug' => $dataValidated['slug'],
                    'content' => $dataValidated['content'],
                    'categories_id' => $dataValidated['categories_id'],
                    'tags' => $dataValidated['tags'],
                    'status' => $dataValidated['status'],
                    'users_id' => auth()->user()->id,
                ]);

            }

        } catch (\Throwable $th) {
            return redirect()->route("admin.post.create")->with('failed', "Gagal menambahkan data postingan dengan nama" . $dataValidated['title']);
        }
        return redirect()->route("admin.post")->with('success', "Berhasil menambahkan data postingan dengan nama " . $dataValidated['title']);

    }

    public function edit($id)
    {
        $posts = Post::find($id);
        $categories = Category::all();

        // get from table post (tags)
        $listTagId = json_decode($posts->tags);

        $getTags = [];
        foreach ($listTagId as $lt) {
            $tags = Tag::where('id', $lt)->first();
            array_push($getTags, $tags);
        }

        $allTags = Tag::all();
        return view("$this->folder/edit", compact('posts', 'categories', 'getTags', 'allTags'));
    }

    public function update(Request $request, $id)
    {
        try {
            $dataValidated = $request->validate([
                'title' => 'required|max:255',
                'slug' => 'required|max:255',
                'content' => 'nullable',
                'categories_id' => 'nullable',
                'status' => 'required',
                'tag' => 'nullable'
            ]);

            $dataValidated['tags'] = json_encode($request->tags);
            $namaImage = $request->input('image_lama');

            if ($request->has('image')) {
                $lokasi = 'data/post/image/';
                $foto = $request->file('image');
                $extensi = $request->file('image')->extension();
                $new_image_name = 'Image' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $foto->move(public_path($lokasi), $new_image_name);
                $namaImage = $new_image_name;
                if ($upload) {
                    $getImage = Post::find($id)->image;
                    if ($getImage != null) {
                        File::delete(public_path('data/post/image/' . $getImage));
                    }
                }

                Post::where('id', $id)->update([
                    'title' => $dataValidated['title'],
                    'slug' => $dataValidated['slug'],
                    'content' => $dataValidated['content'],
                    'categories_id' => $dataValidated['categories_id'],
                    'tags' => $dataValidated['tags'],
                    'status' => $dataValidated['status'],
                    'users_id' => auth()->user()->id,
                    'image' => $namaImage
                ]);
            } else {
                Post::where('id', $id)->update([
                    'title' => $dataValidated['title'],
                    'slug' => $dataValidated['slug'],
                    'content' => $dataValidated['content'],
                    'categories_id' => $dataValidated['categories_id'],
                    'tags' => $dataValidated['tags'],
                    'status' => $dataValidated['status'],
                    'users_id' => auth()->user()->id,
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route("admin.post.edit")->with('failed', "Gagal mengedit data postingan dengan nama " . $dataValidated['title']);
        }
        return redirect()->route("admin.post")->with('success', "Berhasil mengedit data postingan dengan nama " . $dataValidated['title']);
    }

    public function destroy(Request $request)
    {
        try {
            $dataValidated = $request->validate([
                'id' => 'required',
                'title' => 'required',
            ]);

            $getImage = Post::find($dataValidated['id'])->image;
            if ($getImage != null) {
                File::delete(public_path('data/post/image/' . $getImage));
            }
            Post::destroy($dataValidated['id']);
            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data postingan dengan nama " . $dataValidated['title']
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data postingan dengan nama " . $dataValidated['title']
            ];
        }

        return $data;
    }


    // get Tags
    function getTags(Request $request)
    {
        $tags = [];
        if ($search = $request->name) {
            $tags = Tag::where('name', 'LIKE', "%$search%")->get();
        }

        return response()->json($tags);
    }
}