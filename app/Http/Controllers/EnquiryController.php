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
         $enquiries = DB::table('enquiries')
        ->whereNull('deleted_at')   // Exclude soft deleted
        ->orderBy('created_at', 'desc')
        ->get();

         return view('admin.enquiry.index', compact('enquiries'));
    }
    public function showForm()
    {
        return view('frontend.enquiry-form');
    }
public function store(Request $request)
{
    // 🔍 Log raw captcha response
    \Log::info('Raw captcha response from request:', [
        'g-recaptcha-response' => $request->input('g-recaptcha-response')
    ]);

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
        'g-recaptcha-response' => 'required|captcha',
    ]);

    // 🔍 Log after validation success
    \Log::info('Captcha validation passed.', [
        'validated_token' => $validated['g-recaptcha-response'] ?? null,
    ]);

    \Log::info('Enquiry Store - Validated Request:', $validated);

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
            $mail->to('swapnil@jfsmarketresearch.com')
                ->from(config('mail.from.address'), $validated['name'])
                ->subject('M2Squre - New Enquiry Received - ' . $validated['name']);
        });

        \Log::info('Enquiry saved & email sent successfully via Brevo SMTP.');
    } catch (\Exception $e) {
        \Log::error('Error in enquiry store: ' . $e->getMessage());
    }

    return redirect()->route('thank.you');
}

public function destroy($id)
{
    DB::table('enquiries')
        ->where('enquiry_id', $id)
        ->update([
            'deleted_at' => now()
        ]);

    return redirect()->back()->with('status', 'Enquiry deleted successfully!');
}

}
