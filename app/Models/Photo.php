<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'image',
        'caption',
        'order',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
