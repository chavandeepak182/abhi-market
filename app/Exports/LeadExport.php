<?php

namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Enquiry::where('id', $this->id)->get([
            'id',
            'name',
            'email',
            'contact',
            'job_title',
            'company_name',
            'usage_type',
            'status',
            'lead_type',
            'remark',
            'followup_date',
            'converted_amount',
            'created_at'
        ]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Contact',
            'Job Title',
            'Company Name',
            'Usage Type',
            'Status',
            'Lead Type',
            'Remark',
            'Followup Date',
            'Converted Amount',
            'Created At'
        ];
    }
}