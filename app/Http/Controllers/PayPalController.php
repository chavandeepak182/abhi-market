<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayPalController extends Controller
{
     public function handlePayment(Request $request)
    {
        $reportName = $request->input('report_name');
        $licenseType = $request->input('license_type');
        $price = $request->input('price');

        return view('frontend.paypal_form', compact('reportName', 'licenseType', 'price'));
    }

    public function paymentSuccess(Request $request)
    {
        return view('frontend.paypal.paypal_success');
    }

    public function paymentCancel()
    {
        return view('frontend.paypal.paypal_cancel');
    }
}
