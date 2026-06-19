<p>
Dear {{ $data['customer_name'] }},
</p>

<p>
{{ $data['email_body'] }}
</p>

<p>
I'd love to ask a few quick questions:
</p>

<p><strong>1.</strong> {{ $data['questions'][0] ?? '' }}</p>

<p><strong>2.</strong> {{ $data['questions'][1] ?? '' }}</p>

<p><strong>3.</strong> {{ $data['questions'][2] ?? '' }}</p>

<p>
Your answers will help us direct you to the most relevant sections, insights, and data points within the report rather than sending a generic overview.
</p>

<p>
Looking forward to your response.
</p>

<p>
Warm Regards,<br>
<strong>M2Square Consultancy</strong><br>
sales@m2squareconsultancy.com<br>
+1 929-447-0100
</p>