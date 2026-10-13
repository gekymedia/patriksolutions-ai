<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    public function show()
    {
        return view('pages.free-guide');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Store (idempotent by email) so repeat sign-ups don't duplicate.
        Lead::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['name' => $data['name'], 'source' => 'ai-income-starter-kit']
        );

        // Optional: push to MailerLite so welcome/nurture automation can run.
        $this->pushToMailerLite($data['name'], strtolower($data['email']));

        return redirect()->route('lead.thanks')->with('lead_name', $data['name']);
    }

    public function thanks()
    {
        return view('pages.free-guide-thanks');
    }

    /**
     * Best-effort subscribe to MailerLite. Never breaks the opt-in if it fails
     * or if no API key is configured.
     */
    private function pushToMailerLite(string $name, string $email): void
    {
        $apiKey = config('platform.mailerlite.api_key');

        if (empty($apiKey)) {
            return;
        }

        $payload = ['email' => $email, 'fields' => ['name' => $name]];

        if ($groupId = config('platform.mailerlite.group_id')) {
            $payload['groups'] = [$groupId];
        }

        try {
            Http::withToken($apiKey)
                ->acceptJson()
                ->timeout(8)
                ->post('https://connect.mailerlite.com/api/subscribers', $payload);
        } catch (\Throwable $e) {
            Log::warning('MailerLite subscribe failed: ' . $e->getMessage());
        }
    }
}
