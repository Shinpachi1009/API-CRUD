<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $fillable = [
        'image_url',
        'user_id',
        'album_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function album(){
        return $this ->belongsTo(Album::class);
    }
}
