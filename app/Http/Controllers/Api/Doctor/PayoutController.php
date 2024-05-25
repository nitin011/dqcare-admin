<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\PayoutDetail;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required'],
            'amount' => ['required'],
        ]);
        try {

            $payoutRequest = Payout::where('user_id', auth()->id())->where('type', $request->get('type'))->where('status', 0);
            $payoutDetail = PayoutDetail::where('user_id', auth()->id())->where('type', $request->get('type'))->first();


            if (auth()->user()->isInactive()) {
                return $this->errorOk('Your account is in active.');
            }

            if ($payoutRequest->exists()) {
                return $this->errorOk('You already have a pending payout request.');
            }

            if ((int)auth()->user()->wallet_balance < (int)$request->get('amount')) {
                return $this->errorOk('You dont have sufficient balance.');
            }

            if (PayoutDetail::where('user_id', auth()->id())->count() <= 0) {
                return $this->errorOk('Please setup payout details to continue.');
            }

            Payout::create([
                'user_id' => auth()->id(),
                'amount' => $request->get('amount'),
                'type' => $request->get('type'),
                'bank_details' => json_encode($payoutDetail->payload),
                'status' => 0,
            ]);

            return $this->successMessage('Payout request created.');
        } catch (\Exception | \Error $e) {
            return $this->errorOk('Something went wrong!');
        }
    }

    public function payoutIndex(Request $request)
    {
        try {
            $payoutRequest = Payout::where('user_id', auth()->id());
            if($payoutRequest->exists()){
                $payoutRequest = $payoutRequest->latest()->get();
            }else{
                $payoutRequest = [];
            }
            return $this->success($payoutRequest);
        } catch (\Exception | \Error $e) {
            return $this->errorOk('Something went wrong!');
        }
    }
}


