<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }

    public function ebook()
    {
        return $this->belongsTo(Ebook::class, 'ebooks_id');
    }

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolios_id');
    }
}
