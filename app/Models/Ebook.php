<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ebook extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category_id',
        'description',
        'cover_path',
        'file_path',
        'access_type',
        'whatsapp_number',
        'price',
        'download_count',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured'  => 'boolean',
    ];

    /* ===============================
       AUTO SLUG
    =============================== */

    protected static function booted()
    {
        static::creating(function ($ebook) {
            if (!$ebook->slug) {
                $ebook->slug = $ebook->generateUniqueSlug(
                    self::class,
                    $ebook->title
                );
            }

            $ebook->download_count = 0;
            $ebook->access_type = $ebook->access_type ?? 'free';
        });

        static::updating(function ($ebook) {
            if ($ebook->isDirty('title')) {
                $ebook->slug = $ebook->generateUniqueSlug(
                    self::class,
                    $ebook->title,
                    $ebook->id
                );
            }
        });
    }

    /* ===============================
       RELATION
    =============================== */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* ===============================
       SCOPES
    =============================== */

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /* ===============================
       ACCESSOR
    =============================== */

    public function getCoverUrlAttribute()
    {
        return $this->cover_path
            ? asset('storage/'.$this->cover_path)
            : null;
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/'.$this->file_path);
    }

    /* ===============================
       HELPER
    =============================== */

    public function incrementDownload()
    {
        $this->increment('download_count');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
