<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'gallery_id',
        'image_path',
        'thumbnail_path',
        'caption',
        'uploaded_by',
        'sort_order',
    ];
    
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
    
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
