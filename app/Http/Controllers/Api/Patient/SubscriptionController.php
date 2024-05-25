<?php
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Slider;
use App\Models\UserSubscription;
use App\Models\Subscription;
use App\User;
use Razorpay\Api\Api;

class SubscriptionController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function getSubscriptions(Request $request)
    {
        try {
            $subscriptions = Subscription::where('id','!=',1)->get();
            if($subscriptions){
                return $this->success($subscriptions);
            }else{
                return $this->errorOk('Subscription data is not available!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function buySubscription(Request $request)
    {
        try {
            $api = new Api(config('razorpay.api_key'), config('razorpay.api_secret'));
            //Fetch payment information by rzrpay_payment_id
            $payment = $api->payment->fetch($request->get('rzrpay_payment_id'));
            $order_from = User::whereId(auth()->id())->first();
            $order_to = User::whereId(auth()->id())->first();

            if ($request->has('rzrpay_payment_id') && $request->get('rzrpay_payment_id') != null) {
                try {
                    $api->payment->fetch($request->get('rzrpay_payment_id'))
                    ->capture(array('amount' => $payment['amount']));
                } catch (\Exception $e) {
                    return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
                }
            } else {
                return $this->errorOk('Payment unsuccessful.');
            }

            $subscription = Subscription::where('id',$request->get('subscription_id'))->first();
            if($subscription){
                $fromDate = now()->addDay(1);
                $toDate = $fromDate->addDay($subscription->duration);
                $userSubs = UserSubscription::create([
                    'user_id' => auth()->id(),
                    'subscription_id' =>$subscription->id,
                    'from_date' => now()->addDay(),
                    'to_date' => $toDate,
                ]);
                giveSubsciptionBonus($userSubs->user_id,$userSubs->subscription_id);

                $user = User::where('id', $userSubs->user_id)->first();
                $inviter = User::where('id', $user->invited_by)->first();
                // if(!is_null($user->invited_by)) {
                //     $inviter->update([
                //         'wallet_balance' => $inviter->wallet_balance + getSetting('scan_bonus') + 10,
                //     ]);
                // }
                $package_commission = getSetting('package_amount');
                $amount  = $subscription->price * $package_commission / 100;
                if(!is_null($user->invited_by)) {
                    $this->fcm()
                        ->setTokens([$inviter->fcm_token])
                        ->setTitle(config('app.name'))
                        ->setBody("You got " . $amount . " amount as patient took subscription.")
                        ->send();
                }

                $this->fcm()
                    ->setTokens([auth()->user()->fcm_token])
                    ->setTitle(config('app.name'))
                    ->setBody("Congratulations! You have premium membership now.")
                    ->send();

                return $this->successMessage('User Subscription Created Successfully!');
            }else{
                return $this->errorOk('Subscription data is not available!');
            }
        } catch (\Exception $e) {
            info($e);
            return $this->error($e->getMessage());
        }
    }
    public function mySubscription(Request $request)
    {
        try {
            $user = User::whereId(auth()->id())->first();
            $userSubsCheck = UserSubscription::where('user_id',auth()->id())->whereNotNull('parent_id');
            if($userSubsCheck->exists()){
                $userSubs = UserSubscription::where('user_id', $userSubsCheck->first()->parent_id)->latest()->first();
            }else{
                $userSubs = UserSubscription::where('user_id', auth()->id())->latest()->first();
            }

            if(!isset($userSubs->subscription_id)){
                // return $this->error("Please Complete Your Registration");
                UserSubscription::create([
                            'user_id' => $user->id,
                            'subscription_id' => 1,
                            'from_date' => now(),
                            'to_date' => now()->addDay(30),
                        ]);
            }

            $subscription_status = '';
                if($userSubs->subscription_id == 1){
                    if($userSubs->to_date > now() && $userSubs->subscription_id == 1){
                        $userSubs['subscription_status'] = 'Trial';
                    }elseif($userSubs->to_date < now()){
                        $userSubs['subscription_status'] = 'Expired';
                    }else{
                        $userSubs['subscription_status'] = 'Upgrade';
                    }
                }
                if($userSubs->subscription_id != 1){
                    if($userSubs->to_date > now() && $userSubs->subscription_id != 1){
                        $userSubs['subscription_status'] = 'Paid';
                    }elseif($userSubs->to_date < now() && $userSubs->subscription_id != 1){
                        $userSubs['subscription_status'] = 'Expired';
                    }else{
                        $userSubs['subscription_status'] = 'Renew';
                    }
                }

                if($userSubs && $userSubs->subscription_id != 1 ){
                    if($userSubs->parent_id == auth()->id() || $userSubs->user_id == auth()->id()){
                        $userSubs['unlink_user'] = 'Unlink';
                    }
                }
            return $this->success($userSubs);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e);
        }
    }
}

