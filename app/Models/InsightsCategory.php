<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsightsCategory extends Model
{
    protected $table = 'insights_category';
    protected $primaryKey = 'pid';
    public $timestamps = false;

    public function subcategories()
    {
        return $this->hasMany(InsightsSubcategory::class, 'pid', 'pid');
    }
}
