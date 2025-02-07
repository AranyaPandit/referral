<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\ReferralEarning;
use App\Models\User;
use App\Models\Setting;

class InvestmentController extends Controller
{
    public function invest(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:100']);

        $investment = Investment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'Approved',
        ]);

        $this->distributeReferralCommission(auth()->user(), $investment);

        return response()->json(['message' => 'Investment successful'], 201);
    }

    private function distributeReferralCommission($user, $investment, $level = 1)
    {
        $maxCommissions = Setting::getValue('max_commission_per_user') ?? 5;
        $commissionPercentage = Setting::getValue('commission_percentage') ?? 10;

        if ($user->referred_by && $level <= 2) {
            $referrer = User::find($user->referred_by);
            if ($referrer) {

                $existingCommissions = ReferralEarning::where('user_id', $referrer->id)
                    ->where('referred_user_id', $user->id)
                    ->count();

                if ($existingCommissions >= $maxCommissions) {
                    return;
                }

                $commission = $investment->amount * ($commissionPercentage / 100);
                ReferralEarning::create([
                    'user_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                    'investment_id' => $investment->id,
                    'commission_amount' => $commission,
                    'level' => $level,
                ]);

                $this->distributeReferralCommission($referrer, $investment, $level + 1);
            }
        }
    }
}
