<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PayoutDetail;
use Illuminate\Http\Request;

class PayoutDetailController extends Controller
{
    public function index()
    {
        try {
            $payoutDetails = PayoutDetail::where('user_id', auth()->id())
                ->get();

            return $this->success($payoutDetails);
        } catch (\Exception | \Error $e) {
            return $this->errorOk('Something went wrong!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required'],
        ]);

        if ($request->get('type') == PayoutDetail::TYPE_BANK) {
            $request->validate([
                'account_holder_name' => ['required'],
                'account_number' => ['required'],
                'ifsc_code' => ['required'],
                'branch' => ['required'],
            ]);
        }

        if ($request->get('type') == PayoutDetail::TYPE_UPI) {
            $request->validate([
                'upi_holder_name' => ['required'],
                'upi_id' => ['required'],
            ]);
        }

        try {
            $payload = null;

            if ($request->get('type') == PayoutDetail::TYPE_BANK) {
                $payload['account_holder_name'] = $request->get('account_holder_name');
                $payload['account_number'] = $request->get('account_number');
                $payload['ifsc_code'] = $request->get('ifsc_code');
                $payload['branch'] = $request->get('branch');
            } else {
                $payload['upi_holder_name'] = $request->get('upi_holder_name');
                $payload['upi_id'] = $request->get('upi_id');
            }

            $payoutDetail = PayoutDetail::where('user_id', auth()->id())->where('type', $request->get('type'));
            if($payoutDetail->exists()){
                $payoutDetail->update([
                    'payload' => json_encode($payload),
                ]);
            } else {
                PayoutDetail::create([
                    'user_id' => auth()->id(),
                    'payload' => json_encode($payload),
                    'type' => $request->get('type'),
                ]);
            }

            return $this->successMessage('Payout detail saved successfully.');
        } catch (\Exception | \Error $e) {
            return $this->errorOk('Something went wrong!'. $e->getMessage());
        }
    }
}

