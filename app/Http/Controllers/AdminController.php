<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Investment;


class AdminController extends Controller
{
    public function updateSettings(Request $request)
    {
        $request->validate([
            'commission_percentage' => 'required|numeric|min:1|max:100',
            'max_commission_per_user' => 'required|integer|min:1|max:50',
        ]);

        Setting::where('key', 'commission_percentage')->update(['value' => $request->commission_percentage]);
        Setting::where('key', 'max_commission_per_user')->update(['value' => $request->max_commission_per_user]);

        return response()->json(['message' => 'Settings updated successfully']);
    }


    public function settings()
{
    return view('admin.settings', [
        'commission_percentage' => Setting::getValue('commission_percentage'),
        'max_commission_per_user' => Setting::getValue('max_commission_per_user'),
    ]);
}

public function investments()
{
    $investments = Investment::with(['user', 'referralEarnings.user'])->get();
    return view('admin.investments', compact('investments'));
}

}
