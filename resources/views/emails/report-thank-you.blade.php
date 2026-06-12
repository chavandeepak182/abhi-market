<p>
Dear {{ $data['customer_name'] }},
</p>

<p>
{{ $data['email_body'] }}
</p>

@if(!empty($data['questions']))
<h3>A Few Quick Questions</h3>

<ol>
@foreach($data['questions'] as $question)
    <li>{{ $question }}</li>
@endforeach
</ol>
@endif

<p>
Your answers will help us direct you to the most relevant sections, insights, and data points within the report rather than sending a generic overview.
</p>

<p>
Warm Regards,<br>
<strong>M2Square Consultancy</strong><br>
sales@m2squareconsultancy.com<br>
+91 8788524747
</p>