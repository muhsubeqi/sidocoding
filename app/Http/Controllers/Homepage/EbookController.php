<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use App\Http\Services\GoogleDrive;
use App\Models\Category;
use App\Models\Comment;
use App\Models\DataUser;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    public function listEbook()
    {
        $ebooks = Ebook::all();
        return view('homepage/ebook/list', compact('ebooks'));
    }

    public function index(Request $request)
    {
        $ebooks = Ebook::orderBy('id', 'desc')->paginate(10);
        $showEbook = '';
        if ($request->ajax()) {
            foreach ($ebooks as $ebook) {
                $category = '';
                    if (isset($ebook->category->name) != null) {
                        $category .= '<a
                        href="'. route('tutorial.list', ['id' => isset($ebook->category->id)]) .'">'.$ebook->category->name.'</a>';
                    }else{
                        $category .= 'Uncategorized';
                    }
                $status = '';
                    if ($ebook->status == 'Premium') {
                        $status .= '';
                    }else{
                        $status .= ' <a href=" '.GoogleDrive::link($ebook->path).'"
                        class="btn btn-sm btn-success text-white w-100" target="_blank">Baca Sekarang</a>';
                    }
                $statusRibbon = '';
                    if ($ebook->status == 'Premium') {
                        $statusRibbon .= '<div class="ribbon-holder">
                            <div class="ribbon sale">Premium</div>
                        </div>';
                    }
                $showEbook .='
                <div class="col-lg-3 col-md-4">
                    <div class="product">
                        <div class="image" style="border: 1px solid #000">
                            <a href="'.GoogleDrive::link($ebook->path).'"><img
                                    src="'. asset('/data/ebook/cover/' . $ebook->cover) .'" alt=""
                                    class="img-fluid ebook image1"></a>
                        </div>
                        <div class="text">
                            <h3 class="h5"><a data-toggle="tooltip" data-placement="top"
                            title="' . $ebook->title .'" href="'.GoogleDrive::link($ebook->path).'">'. Str::limit($ebook->title,50) .'</a></h3>
                            '.$status.'
                            '.$statusRibbon.'
                        </div>
                    </div>
                </div>
                ';
            }
            return $showEbook;
        }
        return view('homepage/ebook/index');
    }

    public function search(Request $request)
    {
        $ebooks = Ebook::limit(0)->get();
        if($request->keyword != ''){
            $ebooks = Ebook::where([
                ['title','LIKE','%'.$request->keyword.'%']
                ])->limit(10)->get();
        }
        return response()->json([
            'ebooks' => $ebooks
        ]);

    }
}