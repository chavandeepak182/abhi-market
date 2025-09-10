<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['title', 'image', 'folder_id', 'alt'];

    public function folder()
    {
        return $this->belongsTo(GalleryFolder::class, 'folder_id');
    }
}