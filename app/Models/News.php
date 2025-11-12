<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['title', 'slug', 'meta_title', 'meta_description', 'meta_keywords','content', 'image', 'status'];
}
