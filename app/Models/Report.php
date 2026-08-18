<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Maps to the existing `reports` table (see ReportController, which still
 * uses DB::table('reports') directly for its own CRUD - this model exists
 * purely so the CRM side, e.g. LeadThankYouMailer/LeadTemplateRenderer,
 * can read report_title/faq_que/faq_ans via a relation instead of a raw
 * query). No migration needed - the table already exists in the DB.
 */
class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'report_name',
        'report_title',
        'author_name',
        'bio',
        'industry_category_id',
        'publish_date',
        'description',
        'schema_markup',
        'toc',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'faq_que',
        'faq_ans',
        'image',
    ];

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'report_id');
    }
}
