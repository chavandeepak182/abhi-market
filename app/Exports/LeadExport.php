<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LeadExport implements FromCollection, WithHeadings
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return DB::table('enquiries')
            ->leftJoin(
                'users',
                'enquiries.assigned_to',
                '=',
                'users.id'
            )
            ->leftJoin(
                'regions',
                'enquiries.region_id',
                '=',
                'regions.id'
            )
            ->where('enquiries.id', $this->id)
            ->select(
                'enquiries.id',
                'enquiries.name',
                'enquiries.email',
                'enquiries.contact',
                'enquiries.job_title',
                'enquiries.company_name',
                'enquiries.usage_type',
                'enquiries.status',
                'enquiries.lead_type',
                'enquiries.remark',
                'enquiries.followup_date',
                'enquiries.converted_amount',
                'enquiries.created_at',
                'users.name as assigned_to',
                'regions.region_name as region'
            )
            ->get();
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
            'Created At',
            'Assigned To',
            'Region'
        ];
    }
}