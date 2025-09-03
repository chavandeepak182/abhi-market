<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Services\BrevoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


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
public function store(Request $request)
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

        Log::info('Enquiry Store - Validated Request:', $validated);

        try {
            // Insert enquiry into DB
            DB::table('enquiries')->insert([
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'contact'     => $validated['contact'],
                'amount'      => $validated['amount'] ?? null,
                'address'     => $validated['address'] ?? null,
                'message'     => $validated['message'] ?? null,
                'enquiry_type' => $validated['enquiry_type'] ?? null,
                'page_url'    => $validated['page_url'] ?? null,
                'page_name'   => $validated['page_name'] ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            // --- Send email to the admin ---
            $adminMessage = "
            A new enquiry has been submitted:\n\n
            Name: {$validated['name']}\n
            Email: {$validated['email']}\n
            Contact: {$validated['contact']}\n
            Message: " . ($validated['message'] ?? '-') . "\n
            Report Name: " . ($validated['page_name'] ?? '-') . "\n
            Submitted At: " . now()->toDateTimeString() . "
            ";

            Mail::raw($adminMessage, function ($mail) use ($validated) {
                $mail->to('deepak@jfstechnologies.com')
                    ->from(config('mail.from.address'), $validated['name'])
                    ->subject('M2Squre-New Enquiry Received - ' . $validated['name']);
            });

            Log::info('Enquiry saved & email sent successfully via Brevo SMTP.');
        } catch (\Exception $e) {
            Log::error('Error in enquiry store: ' . $e->getMessage());
        }

        return redirect()->route('thank.you');
    }
}
