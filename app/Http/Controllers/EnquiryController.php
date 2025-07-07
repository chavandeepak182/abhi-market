<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Services\BrevoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

   public function store(Request $request, BrevoService $brevoService)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact' => 'required|string|max:15',
        'amount' => 'nullable|numeric',
        'address' => 'nullable|string',
        'message' => 'nullable|string',
        'enquiry_type' => 'nullable|string',
        'page_url' => 'nullable|url',
        'page_name' => 'nullable|string',
    ]);

    // Log the validated data
    Log::info('Enquiry Store - Validated Request:', $validated);

    try {
        DB::table('enquiries')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'amount' => $validated['amount'] ?? null,
            'address' => $validated['address'] ?? null,
            'message' => $validated['message'] ?? null,
            'enquiry_type' => $validated['enquiry_type'] ?? null,
            'page_url' => $validated['page_url'] ?? null,
            'page_name' => $validated['page_name'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Enquiry successfully inserted into database.');
    } catch (\Exception $e) {
        Log::error('Error inserting enquiry: ' . $e->getMessage());
    }

    // Send email
    $brevoService->sendEnquiryEmail([
        'name' => $request->name,
        'email' => $request->email,
        'contact' => $request->contact,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Enquiry Submitted Successfully!');
}
}
