<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'deskripsi', 'content', 'image', 'date', 'last_date', 'kategori_id', 'tags', 'slug', 'status', 'views', 'user_id',];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
