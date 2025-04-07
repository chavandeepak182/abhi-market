<?php

namespace App\Services;

use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('services.brevo.api_key'));

        // Assign to the class property
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    public function sendEnquiryEmail(array $data)
    {
        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [[
                'email' => 'vaibhav@jfstechnologies.com',
                'name'  => 'Admin'
            ]],
            'templateId' => 1, // Replace with your actual Brevo template ID
            'params' => [
                'name'    => $data['name'],
                'email'   => $data['email'],
                'contact' => $data['contact'],
                'message' => $data['message'] ?? '',
            ],
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
            \Log::info("Brevo enquiry email sent successfully.");
        } catch (\Exception $e) {
            \Log::error("Brevo Error: " . $e->getMessage());
        }
    }
}
