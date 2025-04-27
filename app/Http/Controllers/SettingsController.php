<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    
    /**
     * Display the settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch settings from the database or cache
        $settings = Setting::paginate(5);
        return view('settings.index', compact('settings')); // Ensure this view file exists
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate and update settings logic here

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

}
