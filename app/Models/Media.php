<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id', 'file_path', 'video_url', 'type',
        'title', 'description', 'order', 'is_featured'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function getUrlAttribute()
    {
        return $this->file_path ? asset('storage/'.$this->file_path) : null;
    }

    public function isImage()
    {
        return $this->type === 'image';
    }

    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Return embed HTML for video (YouTube/TikTok)
     */
    public function getEmbedHtmlAttribute()
    {
        if (!$this->video_url) return null;

        // TikTok
        if (str_contains($this->video_url, 'tiktok.com')) {
            preg_match('/video\/(\d+)/', $this->video_url, $matches);
            $id = $matches[1] ?? null;
            if ($id) {
                return <<<HTML
<blockquote class="tiktok-embed" cite="{$this->video_url}" data-video-id="{$id}" style="max-width: 605px;min-width: 325px;">
    <section></section>
</blockquote>
<script async src="https://www.tiktok.com/embed.js"></script>
HTML;
            }
        }

        // YouTube
        if (str_contains($this->video_url, 'youtube.com') || str_contains($this->video_url, 'youtu.be')) {
            $urlParts = parse_url($this->video_url);
            parse_str($urlParts['query'] ?? '', $query);
            $id = $query['v'] ?? basename($urlParts['path']);
            return "<iframe width='400' height='225' src='https://www.youtube.com/embed/{$id}' frameborder='0' allowfullscreen></iframe>";
        }

        return null;
    }
}
