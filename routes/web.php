<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Homepage\CommentController as HomepageCommentController;
use App\Http\Controllers\Homepage\EbookController as HomepageEbookController;
use App\Http\Controllers\Homepage\ShopController as HomepageShopController;
use App\Http\Controllers\Homepage\HomeController as HomepageHomeController;
use App\Http\Controllers\Homepage\PortfolioController as HomepagePortfolioController;
use App\Http\Controllers\Homepage\PostController as HomepagePostController;
use App\Http\Controllers\Homepage\RegisterLoginController as HomepageRegisterLoginController;
use App\Http\Controllers\Homepage\TutorialController as HomepageTutorialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home
Route::get('/', [HomepageHomeController::class, 'index'])->name('home');
// Tutorial
Route::prefix('tutorial')->group(function () {
    Route::get('/', [HomepageTutorialController::class, 'index'])->name('tutorial');
    Route::get('/{id}/daftar-tutorial', [HomepageTutorialController::class, 'listTutorial'])->name('tutorial.list');
    Route::get('/{id}/daftar-ebook', [HomepageTutorialController::class, 'listEbook'])->name('ebook.list');
});
// Kategori
Route::prefix('kategori')->group(function () {
    Route::get('/{id}/daftar-ebook', [HomepageTutorialController::class, 'listEbook'])->name('ebook.list');
});
// Postingan
Route::prefix('postingan')->group(function () {
    Route::get('/', [HomepagePostController::class, 'index'])->name('postingan');
    Route::get('/{id}/{slug}', [HomepagePostController::class, 'detail'])->name('postingan.detail');
    Route::get('/daftar', [HomepagePostController::class, 'listPostingan'])->name('postingan.list');
    Route::post('/search', [HomepagePostController::class, 'search'])->name('postingan.search');
});
// Ebook
Route::prefix('ebook')->group(function () {
    Route::get('/', [HomepageEbookController::class, 'index'])->name('ebook');
    Route::post('/search', [HomepageEbookController::class, 'search'])->name('ebook.search');
});
// Ebook
Route::prefix('shop')->group(function () {
    Route::get('/', [HomepageShopController::class, 'index'])->name('shop');
    Route::get('/{id}/daftar-produk', [HomepageShopController::class, 'list'])->name('shop.list');
    Route::get('/{slug}', [HomepageShopController::class, 'detail'])->name('shop.detail');
    Route::post('/search', [HomepageShopController::class, 'search'])->name('shop.search');
});
// Komentar
Route::prefix('komentar')->group(function () {
    Route::get('/', [HomepageCommentController::class, 'index'])->name('comment');
    Route::post('/store', [HomepageCommentController::class, 'store'])->name('comment.store');
});

Auth::routes(['register' => false]);

// ======= Administrator ======= //
Route::group(['prefix' => 'administrator', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::group(['middleware' => ['role:admin']], function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        });
    });
    // Data Master
    Route::prefix('master')->middleware('role:admin')->group(function () {
        // Data Kategori
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
            Route::get('/list', [CategoryController::class, 'getData'])->name('admin.category.list');
            Route::post('/add', [CategoryController::class, 'store'])->name('admin.category.add');
            Route::post('/edit', [CategoryController::class, 'update'])->name('admin.category.edit');
            Route::delete('/delete', [CategoryController::class, 'destroy'])->name('admin.category.delete');
        });
        // Data Tag
        Route::prefix('tags')->group(function () {
            Route::get('/', [TagController::class, 'index'])->name('admin.tags');
            Route::get('/list', [TagController::class, 'getData'])->name('admin.tags.list');
            Route::post('/add', [TagController::class, 'store'])->name('admin.tags.add');
            Route::post('/edit', [TagController::class, 'update'])->name('admin.tags.edit');
            Route::delete('/delete', [TagController::class, 'destroy'])->name('admin.tags.delete');
        });
        // Data Kategori
        Route::prefix('product-category')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->name('admin.productCategory');
            Route::get('/list', [ProductCategoryController::class, 'getData'])->name('admin.productCategory.list');
            Route::post('/add', [ProductCategoryController::class, 'store'])->name('admin.productCategory.add');
            Route::post('/edit', [ProductCategoryController::class, 'update'])->name('admin.productCategory.edit');
            Route::delete('/delete', [ProductCategoryController::class, 'destroy'])->name('admin.productCategory.delete');
        });
    });
    // Data Postingan
    Route::prefix('postingan')->middleware('role:admin')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('admin.post');
        Route::get('/list', [PostController::class, 'getData'])->name('admin.post.list');
        Route::get('/create', [PostController::class, 'create'])->name('admin.post.create');
        Route::post('/store', [PostController::class, 'store'])->name('admin.post.store');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::put('/{id}/update', [PostController::class, 'update'])->name('admin.post.update');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('admin.post.show');
        Route::delete('/delete', [PostController::class, 'destroy'])->name('admin.post.delete');
        // get tag
        Route::post('/get-tags', [PostController::class, 'getTags'])->name('admin.post.getTags');
    });
    // Data Ebook
    Route::prefix('ebook')->middleware('role:admin')->group(function () {
        Route::get('/', [EbookController::class, 'index'])->name('admin.ebook');
        Route::get('/list', [EbookController::class, 'getData'])->name('admin.ebook.list');
        Route::get('/create', [EbookController::class, 'create'])->name('admin.ebook.create');
        Route::post('/store', [EbookController::class, 'store'])->name('admin.ebook.store');
        Route::get('/{id}/edit', [EbookController::class, 'edit'])->name('admin.ebook.edit');
        Route::put('/{id}/update', [EbookController::class, 'update'])->name('admin.ebook.update');
        Route::delete('/delete', [EbookController::class, 'destroy'])->name('admin.ebook.delete');
    });
    // Data Produk
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product');
        Route::get('/list', [ProductController::class, 'getData'])->name('admin.product.list');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/{id}/update', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete', [ProductController::class, 'destroy'])->name('admin.product.delete');
        Route::post('/edit-file', [ProductController::class, 'editFile'])->name('admin.product.editFile');
    });
    // Komentar
    Route::prefix('komentar')->middleware('role:admin')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('admin.comment');
        Route::get('/list', [CommentController::class, 'getData'])->name('admin.comment.list');
        Route::post('/confirm', [CommentController::class, 'confirm'])->name('admin.comment.confirm');
        Route::delete('/delete', [CommentController::class, 'destroy'])->name('admin.comment.delete');
    });
    // Profile
    Route::prefix('profil')->middleware('role:admin')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    });

});

Route::get('test', function () {
    Storage::disk('google')->put('test.txt', 'Hello World');
});