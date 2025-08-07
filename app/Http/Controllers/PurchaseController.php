<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function showById($id)
{
    $report = DB::table('reports')->where('id', $id)->first();
    if (!$report) {
        abort(404);
    }
    return view('frontend.purchase', compact('report'));
}
}
