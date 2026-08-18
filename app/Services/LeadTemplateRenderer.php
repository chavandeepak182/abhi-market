<?php

namespace App\Services;

use App\Models\Enquiry;

class LeadTemplateRenderer
{
    public static function render(string $content, Enquiry $lead): string
    {
        return strtr($content, [
            '{{name}}' => $lead->name ?? '',
            '{{lead_name}}' => $lead->name ?? '',
            '{{agent_name}}' => $lead->user?->name ?? 'Our CRM team',
            '{{company}}' => $lead->company ?? '',
        ]);
    }
}
