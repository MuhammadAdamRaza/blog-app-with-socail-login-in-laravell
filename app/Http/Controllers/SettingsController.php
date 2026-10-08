<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{
    public function index()
    {
        Gate::authorize('settings.manage');

        $settings = Setting::pluck('value', 'key');

        return view('settings.index', [
            'siteName' => $settings->get('site_name', config('app.name')),
            'allowRegistration' => $settings->get('allow_registration', '1') === '1',
        ]);
    }

    public function update(Request $request)
    {
        Gate::authorize('settings.manage');

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:100'],
            'allow_registration' => ['nullable', 'boolean'],
        ]);

        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $validated['site_name']]
        );

        Setting::updateOrCreate(
            ['key' => 'allow_registration'],
            ['value' => $request->boolean('allow_registration') ? '1' : '0']
        );

        return redirect()->route('settings.index')->with('status', 'Settings saved.');
    }
}
