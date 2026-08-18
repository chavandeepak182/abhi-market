<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>{{ $subject ?? 'Thank you' }}</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#333;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
<tr>
<td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
    <tr>
        <td style="background:#006186;padding:24px 32px;">
            <h1 style="margin:0;color:#ffffff;font-size:20px;">{{ config('app.name', 'M2Square Consultancy') }}</h1>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <p style="font-size:16px;margin:0 0 16px;">Hi {{ $enquiry->name ?? 'there' }},</p>

            <p style="font-size:15px;line-height:1.6;margin:0 0 16px;">
                Thank you for your interest in
                <strong>{{ $report?->report_title ?? ($enquiry->page_name ?? 'our report') }}</strong>.
                We've received your request and one of our team members
                will get in touch with you shortly.
            </p>

            @if($agent)
            <p style="font-size:15px;line-height:1.6;margin:0 0 16px;">
                Your point of contact is
                <strong>{{ $agent->name }}</strong>
                @if(!empty($agent->email))
                    (<a href="mailto:{{ $agent->email }}" style="color:#006186;">{{ $agent->email }}</a>)
                @endif
                — feel free to reach out with any questions in the meantime.
            </p>
            @endif

            @if(!empty($faqs))
            <hr style="border:none;border-top:1px solid #eee;margin:24px 0;">
            <h3 style="font-size:16px;color:#006186;margin:0 0 12px;">Frequently Asked Questions</h3>
            @foreach($faqs as $faq)
                <p style="font-size:14px;line-height:1.6;margin:0 0 4px;"><strong>{{ $faq['question'] }}</strong></p>
                @if(!empty($faq['answer']))
                    <p style="font-size:14px;line-height:1.6;margin:0 0 16px;color:#555;">{{ $faq['answer'] }}</p>
                @else
                    <p style="margin:0 0 16px;"></p>
                @endif
            @endforeach
            @endif

            <p style="font-size:14px;line-height:1.6;margin:24px 0 0;color:#777;">
                Regards,<br>
                {{ config('app.name', 'M2Square Consultancy') }} Team
            </p>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</body>
</html>
