<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\ReferralEarning;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function showInvestForm()
    {
        $user = Auth::user();
        $investments = Investment::where('user_id', $user->id)->latest()->get();

        return view('user.invest', compact('investments'));
    }

    public function invest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = Auth::user();
        $investment = Investment::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'Approved'
        ]);

        $this->handleReferralCommission($user, $investment);

        return redirect()->route('user.investments')->with('success', 'Investment successful!');
    }
    private function handleReferralCommission($user, $investment)
    {
        $commissionPercentage = Setting::getValue('commission_percentage') / 100;
        $maxCommissionPerUser = Setting::getValue('max_commission_per_user');
    
        $referrer = $user->referredBy;
        $level = 1;
    
        while ($referrer && $level <= 10) {
            $existingCommissions = ReferralEarning::where('user_id', $referrer->id)
                ->where('referred_user_id', $user->id)
                ->count();
    
            if ($existingCommissions >= $maxCommissionPerUser) {
                break;
            }
    
            $commissionAmount = $investment->amount * $commissionPercentage;
            ReferralEarning::create([
                'user_id' => $referrer->id,
                'referred_user_id' => $user->id,
                'investment_id' => $investment->id,
                'commission_amount' => $commissionAmount,
                'level' => $level
            ]);
          $referrer = $referrer->referredBy;
            $level++;
        }
    }
    

    public function myInvestments()
    {
        $investments = Investment::where('user_id', Auth::id())->latest()->get();

        return view('user.investments', compact('investments'));
    }
}
