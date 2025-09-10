<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryFolder extends Model
{
    protected $fillable = ['name'];

    public function images()
    {
        return $this->hasMany(Gallery::class, 'folder_id');
    }
}
