<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function handleContactForm(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:15',
            'msg_subject' => '|string|max:255',
            'message' => 'string',
        ]);

        try {
            // Call the email function to send the emails
            $this->sendEmail($data);
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions that occur
            return redirect()->back()->with('error', 'An error occurred while sending your message: ' . $e->getMessage());
        }
    }

    private function sendEmail($data)
    {
        // Specify the API key
        $apiKey = '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'; 
        
        // Use Guzzle to send the email to both the user and admin
        $client = new Client();

        // Send template email to the user (confirmation email)
        $client->post('https://api.brevo.com/v3/smtp/email', [
            'headers' => [
                'Content-Type' => 'application/json',
                'api-key' => $apiKey,
            ],
            'json' => [
                'sender' => ['email' => 'deepak@jfstechnologies.com', 'name' => 'JFS Technology'],
                'to' => [['email' => $data['email'], 'name' => $data['name']]],
                'templateId' => 4, // Replace with your user email template ID
                'params' => [
                    'name' => $data['name'],
                    'message' => $data['message'],
                ],
            ],
        ]);

        // Send email to the admin with user-entered details
        $response = $client->post('https://api.brevo.com/v3/smtp/email', [
            'headers' => [
                'Content-Type' => 'application/json',
                'api-key' => $apiKey,
            ],
            'json' => [
                'sender' => ['email' => 'deepak@jfstechnologies.com', 'name' => 'JFS Technology'], // Admin's sender email
                'to' => [['email' => 'mayuresh@jfstechnologies.com', 'name' => 'Sales Head']],
                'cc' => [
                            ['email' => 'vaibhav@jfstechnologies.com', 'name' => 'Admin'],
                            ['email' => 'sayaam@jfstechnologies.com', 'name' => 'Sales Manager']
                        ],
                'subject' => "New Contact Form Submission: {$data['msg_subject']}",
                'htmlContent' => "
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> {$data['name']}</p>
                    <p><strong>Email:</strong> {$data['email']}</p>
                    <p><strong>Phone Number:</strong> {$data['phone_number']}</p>
                    <p><strong>Subject:</strong> {$data['msg_subject']}</p>
                    <p><strong>Message:</strong> {$data['message']}</p>
                ",
            ],
        ]);
        
        $body = $response->getBody()->getContents();
        \Log::info('Admin Email Response: ' . $body);
    }
}