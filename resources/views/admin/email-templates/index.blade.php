@extends('admin.layouts.header')

@push('styles')
<style>
.template-page{max-width:1100px;margin:auto;padding:30px}.template-intro{display:flex;justify-content:space-between;gap:20px;align-items:center;margin-bottom:22px}.template-intro h1{margin:0;color:#1f2937}.template-intro p{color:#64748b;margin:7px 0 0}.template-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(270px,1fr));gap:18px}.template-card{background:#fff;border:1px solid #e5e7eb;border-radius:15px;padding:21px;box-shadow:0 2px 8px #00000008}.template-card h3{margin:0 0 8px;color:#1f2937}.template-card p{color:#64748b;min-height:42px;margin:0 0 14px}.template-status{display:inline-block;background:#eff6ff;color:#1d4ed8;border-radius:999px;padding:5px 10px;font-size:13px;font-weight:600;margin-bottom:17px}.template-card a{color:#2563eb;font-weight:700;text-decoration:none}.template-card .template-actions{display:flex;gap:16px;align-items:center}.template-card .template-delete{background:none;border:none;padding:0;color:#dc2626;font-weight:700;cursor:pointer;font-size:14px;font-family:inherit}.template-help{margin:0 0 22px;padding:17px 20px;border-radius:12px;background:#f8fafc;color:#475569}.template-empty{background:#fff;border:1px dashed #cbd5e1;border-radius:15px;padding:25px;color:#64748b}.template-add-card{border:1px dashed #cbd5e1;box-shadow:none;background:#f8fafc}@media(max-width:600px){.template-page{padding:16px}.template-intro{align-items:flex-start;flex-direction:column}}
</style>
@endpush

@section('content')
<main class="template-page">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    <!-- <div class="template-intro"><div><h1>Email messages</h1><p>Set the emails your CRM sends automatically and the messages agents can use manually.</p></div><a href="{{ route('email-templates.create') }}" class="btn-primary">Add email message</a></div>
    <div class="template-help"><strong>How automatic follow-ups work:</strong> create up to six Follow-up templates. For each one, choose how many days after the countdown starts it should send. The countdown does not start when a lead is created — it starts the first time an agent sends a Global template to that lead. If the lead replies, any remaining follow-ups stop automatically.</div>
    <div class="template-help"><strong>Thank-you email:</strong> the email sent as soon as an agent is assigned to a lead (right away for a new enquiry that auto-matches an agent, or as soon as one is assigned/reassigned afterwards) is fixed and includes that report's FAQs automatically — it's no longer managed here.</div> -->
    <section class="template-grid">
        @for($number = 1; $number <= 6; $number++)
            @php($followup = $templates->first(fn($template) => $template->type === 'followup' && (int) $template->followup_number === $number))
            <article class="template-card"><span class="template-status">@if($followup) Sends {{ $followup->days_after_creation }} minute{{ $followup->days_after_creation == 1 ? '' : 's' }} after the countdown starts @else Not set @endif</span><h3>Follow-up {{ $number }}</h3><p>@if($number === 1)First reminder after the countdown starts.@elseif($number === 6)Final reminder if there is still no reply.@else Reminder #{{ $number }} if there is still no reply.@endif</p>@if($followup)<div class="template-actions"><a href="{{ route('email-templates.edit',$followup) }}">Edit Follow-up {{ $number }} →</a><form method="POST" action="{{ route('email-templates.destroy',$followup) }}" onsubmit="return confirm('Delete Follow-up {{ $number }}?');">@csrf @method('DELETE')<button type="submit" class="template-delete">Delete</button></form></div>@else<a href="{{ route('email-templates.create',['type'=>'followup','number'=>$number]) }}">Set up Follow-up {{ $number }} →</a>@endif</article>
        @endfor
        {{-- Only one Sample Report (global) template is supported - it's the
             single template agents/admins can pick from the manual email
             composer, and it always starts the follow-up countdown. Show
             just the first one that exists rather than every 'global' row,
             and don't offer a way to create a second one. --}}
        @php($sampleReportTemplate = $templates->firstWhere('type','global'))
        @if($sampleReportTemplate)
            <article class="template-card"><span class="template-status">Sample Report — starts the follow-up countdown</span><h3>{{ $sampleReportTemplate->name }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($sampleReportTemplate->subject), 70) }}</p><div class="template-actions"><a href="{{ route('email-templates.edit',$sampleReportTemplate) }}">Edit message →</a></div></article>
        @else
            <article class="template-card"><h3>Sample Report</h3><p>No Sample Report template has been created yet.</p><div class="template-actions"><a href="{{ route('email-templates.create',['type'=>'global']) }}">+ Create the Sample Report template →</a></div></article>
        @endif
        {{-- Adding more than one Sample Report (global) template, and
             deleting the only one, are disabled on purpose - there's
             exactly one and it must always exist.
        @foreach($templates->where('type','global') as $template)<article class="template-card"><span class="template-status">Global template — starts the follow-up countdown</span><h3>{{ $template->name }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($template->subject), 70) }}</p><div class="template-actions"><a href="{{ route('email-templates.edit',$template) }}">Edit message →</a><form method="POST" action="{{ route('email-templates.destroy',$template) }}" onsubmit="return confirm('Delete this email message?');">@csrf @method('DELETE')<button type="submit" class="template-delete">Delete</button></form></div></article>@endforeach<article class="template-card template-add-card"><h3>Add another</h3><p>Create as many Global templates as you need — agents pick one when composing a manual email.</p><a href="{{ route('email-templates.create',['type'=>'global']) }}">+ Add global template →</a></article>
        --}}
    </section>
    {{-- Leftover 'global' rows from before Sample Report was locked down to
         a single template (e.g. old Education/Energy templates) are never
         shown to agents/admins as pickable options anymore and are never
         used to send anything - but they still exist in the database, so
         surface them here with nothing but a Delete action, to actually
         clean them out. This section shows nothing once none are left. --}}
    @php($extraGlobalTemplates = $templates->where('type','global')->reject(fn($template) => $sampleReportTemplate && $template->id === $sampleReportTemplate->id))
    @if($extraGlobalTemplates->isNotEmpty())
        <section style="margin-top:26px">
            <h2 style="font-size:16px;color:#1f2937;margin:0 0 4px">Unused templates</h2>
            <p style="color:#64748b;margin:0 0 14px">Left over from before Sample Report was limited to one template. They can't be picked or sent anymore — delete them to clean up.</p>
            <div class="template-grid">
                @foreach($extraGlobalTemplates as $template)
                    <article class="template-card"><h3>{{ $template->name }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($template->subject), 70) }}</p><div class="template-actions"><form method="POST" action="{{ route('email-templates.destroy',$template) }}" onsubmit="return confirm('Delete this unused template?');">@csrf @method('DELETE')<button type="submit" class="template-delete">Delete</button></form></div></article>
                @endforeach
            </div>
        </section>
    @endif
</main>
@endsection