# Phase 1: Timezone Auto-Detect + Auto Agent Assignment + Thank-You Email

## Kya add hua

1. Enquiry form (`sample-form.blade.php`) ab visitor ka browser timezone
   auto-detect karke ek hidden field mein bhejta hai.
2. `EnquiryController::store()` us timezone ko 8 broad regions (North
   America, South America, Europe, Africa, Middle East, South Asia, East
   Asia, Australia & Oceania) mein map karta hai, aur us region ko cover
   karne wale agent mein se sabse kam-load wale agent ko lead auto-assign
   karta hai.
3. Assign hote hi visitor ko automatic "Thank You" email jaata hai
   (assigned agent CC mein), report ke FAQs ke saath.
4. Agar kisi region ka koi agent map nahi hai, purana hardcoded fallback
   (APAC → Amol, baaki → Tarun) chalta rahega — kuch bhi break nahi hoga.
5. Ek naya admin page (`/admin/agent-regions`) jahan se aap decide kar
   sakte hain kaunsa agent kaunsa region cover karta hai.

## Files (copy in the same relative path into your abhi-market project)

```
database/migrations/2026_08_17_100001_create_regions_table.php
database/migrations/2026_08_17_100002_create_agent_timezone_table.php
database/seeders/RegionSeeder.php
app/Models/Region.php
app/Services/TimezoneRegionMapper.php
app/Services/LeadThankYouMailer.php
app/Http/Controllers/EnquiryController.php   (replaces existing file)
app/Http/Controllers/AgentController.php     (replaces existing file)
resources/views/emails/lead-thank-you.blade.php
resources/views/admin/agents/regions.blade.php
resources/views/sample-form.blade.php  → copy over
    resources/views/frontend/reports/sample-form.blade.php
```

`routes_addition.php` is NOT a real route file — it's just the 4 lines
you need to paste into your existing `routes/web.php`.

## Setup steps

1. Copy the files above into their matching paths.
2. Add the routes from `routes_addition.php` into `routes/web.php`
   (near your other `agent.*` routes).
3. Run:
   ```
   php artisan migrate
   php artisan db:seed --class=RegionSeeder
   ```
   Both the migration and the seeder are safe to re-run — they check
   `Schema::hasTable/hasColumn` and use `updateOrInsert`, so they won't
   error or duplicate data if run twice.
4. **Important — mail is not configured yet.** Your `.env` has no
   `MAIL_MAILER`/SMTP values set right now, so the thank-you email will
   fail silently (it's caught + logged, so it won't break enquiry
   submission — but nothing will actually send). Add SMTP credentials to
   `.env`, e.g.:
   ```
   MAIL_MAILER=smtp
   MAIL_HOST=...
   MAIL_PORT=587
   MAIL_USERNAME=...
   MAIL_PASSWORD=...
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=hello@m2squareconsultancy.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```
5. Go to `/admin/agent-regions` (logged in as admin) and tick which
   region(s) each agent covers. Until you do this for at least one
   agent, every new enquiry keeps going through the old APAC/Amol
   fallback — that's expected and safe.
6. Test: submit the enquiry form yourself. Check:
   - `enquiries` row has `timezone`, `timezone_region_id`, `assigned_to`
     filled in correctly.
   - `storage/logs/laravel.log` for the "Lead thank-you email sent" /
     "failed to send" log line.
   - The visitor inbox (and CC'd agent inbox) for the actual email.

## What was deliberately NOT touched

- The existing `country_id` → `region_id` (APAC/Amol/Tarun) logic is
  untouched and still runs as a fallback — nothing about existing leads
  or that flow changes.
- `BrevoService::sendEnquiryEmail()` (the internal notification to
  `vaibhav@jfstechnologies.com`) is untouched — this is a separate,
  additional email, not a replacement.
- No changes to `enquiryLead()`, `assignAgent()`, or any of the manual
  admin-assignment screens — auto-assignment only applies to brand-new
  enquiries at submission time, same as in global-crm.

## Next phases (not done yet, per your list)

- Agent dashboard sending email from the agent's own connected inbox
- Meeting scheduling + calendar / "today's work" page

Say the word and we'll do the next one the same way.

---

# Phase 2: Agent Management (Create / Edit / List / View-Leads / Delete)

## Kya add hua

A full **Agents** admin section:

- `/admin/agents` — list of all agents: lead count, regions covered,
  team-lead flag, active/inactive status
- `/admin/agents/create` — create a new agent (name, email, mobile,
  password, team-lead toggle, timezone regions covered)
- `/admin/agents/{id}/edit` — edit an agent, reset password, toggle
  active/inactive, change their regions
- `/admin/agents/{id}` — agent detail page: profile summary + **every
  lead currently assigned to that agent**, with the same
  status/date filters as the main enquiries screen
- Delete (soft-delete) an agent — their historical leads stay assigned
  to them, nothing gets orphaned

## Files (add on top of Phase 1's files, same relative paths)

```
database/migrations/2026_08_17_100003_add_active_to_users_table.php
app/Http/Controllers/AgentController.php   (replaces Phase 1's version — has everything Phase 1 had, plus this)
app/Http/Controllers/EnquiryController.php (small update — auto-assign now skips inactive agents; re-copy over Phase 1's file)
resources/views/admin/agents/index.blade.php
resources/views/admin/agents/create.blade.php
resources/views/admin/agents/edit.blade.php
resources/views/admin/agents/show.blade.php
```

`routes_addition.php` and `sidebar_addition.blade.php` are updated —
re-copy the lines from both into your `routes/web.php` and
`resources/views/admin/layouts/header.blade.php` (the sidebar one goes
right after your existing "All Enquiries" `<li>`, around line 193).

## Setup steps

1. Copy/replace the files above.
2. Paste the (updated) routes from `routes_addition.php` into
   `routes/web.php` — if you already added the Phase 1 routes, just
   add the new `agents.*` lines inside the same `isAdminAgent` group.
3. Paste the sidebar block from `sidebar_addition.blade.php` into
   `admin/layouts/header.blade.php`.
4. Run:
   ```
   php artisan migrate
   ```
   (safe to re-run, checks `Schema::hasColumn` first)

## ⚠️ Two things worth knowing before you use this in production

1. **Password hashing matches your existing system, not best practice.**
   Your real login (`FrontendController::userLogin`) compares
   `md5($password)` — not Laravel's `Hash::make()`. So agent passwords
   created/reset here use `md5()` too, otherwise a newly created agent
   could never log in. This mirrors what `UsersController::insertUser()`
   already does for customers — it's not something this feature
   introduced, just something it had to match.

2. **The `profile` table might have more required columns than I could
   see from here.** I don't have access to your live database, so agent
   creation only fills `user_id` and `mobile_no` in `profile` (the two
   columns actually used elsewhere in the code). If your `profile`
   table has other `NOT NULL` columns (like `dob`, `city`, etc. that
   `insertUser()` also sets for customers), agent creation will fail
   with a clear "Could not create agent: ..." error instead of silently
   breaking anything — the whole insert is wrapped in a DB transaction
   that rolls back on failure. If you hit that error, tell me the exact
   message and I'll adjust the insert.

## Test checklist

- Create an agent, assign 1-2 regions, log out, log back in as that
  agent's email/password → should land on `/agent/dashboard`.
- Submit the enquiry form with a timezone matching that agent's
  region → it should auto-assign to them (Phase 1) and show up under
  `/admin/agents/{id}`.
- Edit the agent, untick "Active" → inactive agents are now excluded
  from Phase 1's timezone auto-assignment automatically (this file also
  updates `EnquiryController.php` from Phase 1 to check
  `users.active = true`, so re-copy that file too, not just Phase 2's
  new files).
- Delete an agent → confirm their old leads are still visible/filterable
  under `/admin/enquiries` (they're not deleted, just the agent is).

