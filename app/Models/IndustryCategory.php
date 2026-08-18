<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Maps to the existing `industries_category` table (see
 * IndustriesCategoryController, which still uses DB::table() directly for
 * its own CRUD - this model exists purely so the CRM side, e.g.
 * Enquiry::reportCategory()/LeadTemplateRenderer, can read it via a
 * relation). No migration - the table already exists, uses `pid` as its
 * primary key, and has no timestamp columns.
 */
class IndustryCategory extends Model
{
    protected $table = 'industries_category';

    protected $primaryKey = 'pid';

    public $timestamps = false;

    protected $fillable = [
        'category_name',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'industry_category_id', 'pid');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'report_category_id', 'pid');
    }
}
