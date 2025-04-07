<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Services\BrevoService;
class EnquiryController extends Controller
{
    public function enquiryLead()
    {
        $enquiries = Enquiry::all();
        return view('admin.enquiry.index', compact('enquiries'));
    }
    public function showForm()
    {
        return view('frontend.enquiry-form');
    }

    public function store(Request $request,  BrevoService $brevoService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|string|max:15',
            'amount' => '|numeric',
            'address' => '|string',
            'message' => '|string',
            'enquiry_type' => 'string'
        ]);
        Enquiry::create($validated);
        $brevoService->sendEnquiryEmail([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'message' => $request->message,
        ]);
        return response()->json(['success' => true, 'message' => 'Enquiry submitted successfully!']);
    }
}
