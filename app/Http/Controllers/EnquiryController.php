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
        ->paginate(15); // 👈 Show 25 per page

    return view('admin.enquiry.index', compact('enquiries'));
}
public function contactLead()
{
    $contacts = DB::table('contact')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // pagination added

    return view('contact.index', compact('contacts'));
}
    public function showForm()
    {
        return view('frontend.enquiry-form');
    }
public function store(Request $request)
{
    // Log raw captcha
    \Log::info('Raw captcha response:', [
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

    \Log::info('Captcha passed:', $validated);

    try {
        // Get selected country
        $country = null;
        if (!empty($validated['country_id'])) {
            $country = DB::table('countries')->where('id', $validated['country_id'])->first();
        }

        // Visitor country from IP
        $ip = $request->getClientIp();
        if ($ip === '127.0.0.1' || $ip === '::1') {
            $ip = null;
        }

        $visitor_country = null;
        if ($ip) {
            try {
                $response = Http::timeout(5)->get("https://ipapi.co/{$ip}/country_name/");
                if ($response->successful()) {
                    $visitor_country = $response->body();
                }
            } catch (\Exception $e) {
                \Log::warning("Geo lookup failed for IP {$ip}: " . $e->getMessage());
            }
        }

        // Insert into DB
        DB::table('enquiries')->insert([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'contact'         => $validated['contact'],
            'amount'          => $validated['amount'] ?? null,
            'address'         => $validated['address'] ?? null,
            'message'         => $validated['message'] ?? null,
            'enquiry_type'    => $validated['enquiry_type'] ?? null,
            'page_url'        => $validated['page_url'] ?? null,
            'page_name'       => $validated['page_name'] ?? null,
            'job_title'       => $validated['job_title'] ?? null,
            'company_name'    => $validated['company_name'] ?? null,
            'country_id'      => $validated['country_id'] ?? null,
            'phone_code'      => $country->phone_code ?? null,
            'visitor_country' => $visitor_country,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        \Log::info('Enquiry saved successfully.');
    } catch (\Exception $e) {
        \Log::error('Enquiry store failed: ' . $e->getMessage());
        return back()->withErrors(['msg' => 'Something went wrong, please try again.']);
    }

    $slug = $request->slug; // Get slug from hidden input
    return redirect()->route('thank.you', $slug);
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

public function contactdestroy($id)
{
    DB::table('contact')
        ->where('id', $id)
        ->delete(); // ✅ Permanently remove record

    return redirect()->back()->with('status', 'Contact deleted successfully!');
}
 public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'contact'  => 'required|string|max:20',
            'email'    => 'required|email|max:255',
            'message'  => 'nullable|string',
            'page_url' => 'nullable|string',
            'page_name'=> 'nullable|string',
        ]);

        DB::table('contact')->insert([
            'name'       => $validated['name'],
            'contact'    => $validated['contact'],
            'email'      => $validated['email'],
            'message'    => $validated['message'] ?? null,
            'page_url'   => $validated['page_url'] ?? null,
            'page_name'  => $validated['page_name'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('contact.thank-you');
    }

}
