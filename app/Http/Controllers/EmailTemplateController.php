<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();

        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        $template = new EmailTemplate();

        return view('admin.email-templates.form', compact('template'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        EmailTemplate::create($data);

        return redirect()->route('email-templates.index')->with('success', 'Email template created successfully.');
    }

    public function edit(EmailTemplate $template)
    {
        return view('admin.email-templates.form', compact('template'));
    }

    public function update(Request $request, EmailTemplate $template)
    {
        $data = $this->validated($request);

        $template->update($data);

        return redirect()->route('email-templates.index')->with('success', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $template)
    {
        $template->delete();

        return back()->with('success', 'Email template deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'                => 'required|string|max:255',
            'type'                => 'required|in:global,followup',
            'subject'             => 'required|string|max:255',
            'body'                => 'required|string',
            'followup_number'     => 'nullable|integer|min:1|max:6',
            'days_after_creation' => 'nullable|integer|min:1',
        ]);
    }
}
