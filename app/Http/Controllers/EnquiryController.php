<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Services\BrevoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;


class EnquiryController extends Controller
{
   public function enquiryLead()
{
    $enquiries = DB::table('enquiries')
        ->leftJoin('countries', 'enquiries.country_id', '=', 'countries.id')
        ->whereNull('enquiries.deleted_at') // Exclude soft deleted
        ->orderBy('enquiries.created_at', 'desc')
        ->select('enquiries.*', 'countries.name as country_name')
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
        'name'         => 'required|string|max:255',
        'email'        => 'required|email|max:255',
        'contact'      => 'required|string|max:15',
        'amount'       => 'nullable|numeric',
        'address'      => 'nullable|string',
        'message'      => 'nullable|string',
        'enquiry_type' => 'nullable|string',
        'page_url'     => 'nullable|url',
        'page_name'    => 'nullable|string',
        'job_title'    => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'country_id'   => 'nullable|exists:countries,id',
        'g-recaptcha-response' => 'required|captcha',
    ]);

    \Log::info('Captcha validation passed.', [
        'validated_token' => $validated['g-recaptcha-response'] ?? null,
    ]);

    \Log::info('Enquiry Store - Validated Request:', $validated);

    try {
        // Get country details from selected country_id
        $country = null;
        if (!empty($validated['country_id'])) {
            $country = DB::table('countries')->where('id', $validated['country_id'])->first();
        }

        // Get visitor IP
        $ip = $request->getClientIp();
        if ($ip === '127.0.0.1' || $ip === '::1') {
            $ip = null; // skip for local development
        }

        // Get visitor country from IP
        $visitor_country = null;
        if ($ip) {
            try {
                $response = Http::timeout(5)->get("https://ipapi.co/{$ip}/country_name/");
                if ($response->successful()) {
                    $visitor_country = $response->body(); // e.g., "India"
                }
            } catch (\Exception $e) {
                \Log::warning("Geo lookup failed for IP {$ip}: " . $e->getMessage());
            }
        }

        // Insert enquiry into DB
        DB::table('enquiries')->insert([
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'contact'          => $validated['contact'],
            'amount'           => $validated['amount'] ?? null,
            'address'          => $validated['address'] ?? null,
            'message'          => $validated['message'] ?? null,
            'enquiry_type'     => $validated['enquiry_type'] ?? null,
            'page_url'         => $validated['page_url'] ?? null,
            'page_name'        => $validated['page_name'] ?? null,
            'job_title'        => $validated['job_title'] ?? null,
            'company_name'     => $validated['company_name'] ?? null,
            'country_id'       => $validated['country_id'] ?? null,
            'phone_code'       => $country->phone_code ?? null,
            'visitor_country'  => $visitor_country,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        \Log::info('Enquiry saved successfully.');

        // --- WhatsApp Notification via Twilio ---
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

       $message = "*New Enquiry Received:*\n"
        . "*Name:* {$validated['name']}\n"
        . "*Email:* {$validated['email']}\n"
        . "*Contact:* " . ($country->phone_code ?? '') . " {$validated['contact']}\n"
        . "*Job Title:* " . ($validated['job_title'] ?? '-') . "\n"
        . "*Company:* " . ($validated['company_name'] ?? '-') . "\n"
        . "*Country (selected):* " . ($country->name ?? '-') . "\n"
        . "*Visitor Country:* " . ($visitor_country ?? '-') . "\n"
        . "*Message:* " . ($validated['message'] ?? '-') . "\n"
        . "*Report/Page:* " . ($validated['page_name'] ?? '-') . "\n"
        . "*Submitted At:* " . now()->toDateTimeString();

        $twilio->messages->create(
            'whatsapp:+918788524747', // Replace with admin WhatsApp number
            [
                'from' => env('TWILIO_WHATSAPP_NUMBER'),
                'body' => $message
            ]
        );

        \Log::info('WhatsApp notification sent successfully.');

    } catch (\Exception $e) {
        \Log::error('Error in enquiry store: ' . $e->getMessage());
        return back()->withErrors(['msg' => 'Something went wrong, please try again.']);
    }

    // Redirect to thank-you page
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
