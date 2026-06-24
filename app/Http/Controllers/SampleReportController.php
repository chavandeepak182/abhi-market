<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SampleReportController extends Controller
{
   public function index(Request $request)
{
$query = DB::table('sample_reports');


if($request->filled('search'))
{
    $query->where(
        'report_title',
        'like',
        '%'.$request->search.'%'
    );
}

$reports = $query
    ->orderBy('id','DESC')
    ->paginate(10);

return view(
    'admin.sample-reports.index',
    compact('reports')
);


}


    public function create()
    {
        return view(
            'admin.sample-reports.create'
        );
    }

    public function store(Request $request)
    {
        $pdf = '';

        if($request->hasFile('sample_pdf'))
        {
            $pdf = $request
                ->file('sample_pdf')
                ->store(
                    'sample-reports',
                    'public'
                );
        }

        DB::table('sample_reports')->insert([

            'report_title' =>
            $request->report_title,

            'pdf_file' =>
            $pdf,

            'created_at' => now(),

            'updated_at' => now()

        ]);

        return redirect()
            ->route(
                'sample-reports.index'
            );
    }
}