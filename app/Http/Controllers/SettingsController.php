<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the settings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch all settings and map to key-value array
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        // Merge with defaults to avoid undefined index errors
        $defaults = [
            'school_name' => 'EMS',
            'school_address' => 'Pakpattan, Pakistan.',
            'school_phone' => '+92 3026572894',
            'school_email' => 'chaudharyaliajaz@gmail.com',
            'school_logo' => '', // storing path
            'session' => '2025-2026',
        ];

        $settings = array_merge($defaults, $settings);

        return view('settings.index', compact('settings'));
    }

    /**
     * Update the system settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'nullable|string|max:500',
            'school_phone' => 'nullable|string|max:50',
            'school_email' => 'nullable|email|max:100',
            'session' => 'required|string|max:20',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $inputs = $request->only(['school_name', 'school_address', 'school_phone', 'school_email', 'session']);

        // 1. Handle Text Inputs
        foreach ($inputs as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'general']
            );
        }

        // 2. Handle File Upload (Logo)
        if ($request->hasFile('school_logo')) {
            $path = $request->file('school_logo')->store('public/logos');
            // Store relative path accessible via storage link
            $publicPath = str_replace('public/', 'storage/', $path);
            
            \App\Models\Setting::updateOrCreate(
                ['key' => 'school_logo'],
                ['value' => $publicPath, 'group' => 'general']
            );
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
