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
use App\Models\WalletLog;
use App\Models\UserSubscription;
use App\Models\FollowUp;
use App\User;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function addMemberIndex(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
        ]);
        try {
            $imageName = null;
            if ($request->file('avatar')) {
                $image = $request->file('avatar');
                $path = storage_path() . '/app/public/backend/users/';
                $imageName = 'profile_image_' . strtotime(now()) . rand(000, 999) . '.' . $image->getClientOriginalExtension();
                $image->move($path, $imageName);
            }
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone ?? rand(0, 9999999999),
                'gender' => $request->gender,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'relation' => $request->relation,
                'dob' => $request->dob,
                'state' => $request->state,
                'city' => $request->city,
                'avatar' => $imageName,
                'email' => $request->get('email') ?? getRandomEmail(),
                'progress' => 1,
                'is_member' => 0,
            ]);
            $role = $user->assignRole(3);
            $subscription = UserSubscription::where('user_id', auth()->id());
            if ($subscription->where('parent_id', null)->latest()->exists()) {
                // if($subscription->where('subscription_id','!=',1)->latest()->exists()){
                $now = now();
                UserSubscription::create([
                    'user_id' => $user->id,
                    'subscription_id' => 1,
                    'from_date' => $now,
                    'to_date' => $now->addDays(30),
                ]);
                UserSubscription::create([
                    'user_id' => $user->id,
                    'parent_id' => auth()->id(),
                    'subscription_id' => $subscription->latest()->first()->subscription_id,
                    'from_date' => $subscription->latest()->first()->from_date,
                    'to_date' => $subscription->latest()->first()->to_date,
                ]);
                return $this->successMessage('Member Created Succesfully!');
                // }else{
                // return $this->errorOk('You are using a Trial package. You can\'t add member! Kindly subscribe');
                //}
            } else {
                return $this->errorOk('You are using your parent subscription!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function linkMemberNumber(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
        ]);

        try {
            $otp = rand(1000, 9999);
            $subscriptionOwner = UserSubscription::where('user_id', auth()->id());
            if (!$subscriptionOwner->first()) {
                return $this->errorOk('You don\'t have any package');
            }
            //elseif(!$subscriptionOwner->whereNotIn('subscription_id',[1])->first()){
            //  return $this->errorOk('You are using a trial package, You can\'t add the member! Kindly subscribe');
            //}
            elseif (!$subscriptionOwner->whereDate('to_date', '>=', \Carbon\Carbon::now()->format('y-m-d'))->latest()->first()) {
                return $this->errorOk('Your package has been expired, so please subscribe now to continue using.');
            }

            $chkSubscriber = User::role('User')->where('phone', $request->phone)->first();
            if (!$chkSubscriber) {
                return $this->errorOk('This user does not exist in our system! Please check number and try again.');
            }

            // Chk if subscriber already linked in another account
            $subscriptionUser = UserSubscription::where('user_id', $chkSubscriber->id);
            $subscriber_package = $subscriptionUser->whereNotIn('subscription_id', [1])->whereNotNull('parent_id')->latest()->first();
            if ($subscriber_package) {
                return $this->errorOk("This user is already using another user's subscription.");
            }

            // Chk Self Package
            $subscriber_package = $subscriptionUser->whereNotIn('subscription_id', [1])->whereNull('parent_id')->latest()->first();

            if (!$subscriber_package || isset($subscriber_package->to_date) && $subscriber_package->to_date < now()->format('Y-m-d')) {
                $chkSubscriber->update([
                    'linkmember_otp' => $otp,
                ]);
                $message = " Dear User, Your OTP to access Health Details account is $otp. It will be valid upto 30 minutes. PLEASE DO NOT SHARE IT WITH ANYONE.";
                pushSMSNotification($request->phone, $message);
                $this->fcm()
                    ->setTokens([$chkSubscriber->fcm_token])
                    ->setTitle(config('app.name'))
                    ->setBody(auth()->user()->full_name . " shared his membership benefits with you.")
                    ->send();
                return $this->success($otp);
            } else {
                return $this->errorOk('This User have a active package, You can\'t link this user!');
            }

        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function linkMember(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
            'otp' => 'required',
        ]);

        try {
            $subscriptionOwner = UserSubscription::where('user_id', auth()->id());
            $user = User::where('phone', $request->get('phone'))->where('linkmember_otp', $request->get('otp'))->role('User');

            if (!$user->exists()) {
                return $this->errorOk('Invalid OTP.');
            }
            // Link User to package
            $subscriber = $subscriptionOwner->latest()->first();
            UserSubscription::create([
                'user_id' => $user->first()->id,
                'subscription_id' => $subscriber->subscription_id,
                'from_date' => $subscriber->from_date,
                'to_date' => $subscriber->to_date,
                'parent_id' => $subscriber->user_id,
            ]);

            $doctor_name = $user->first()->name;
            $user_name = auth()->user()->name;
            callWhatsappNotification($user->first()->phone, "Hey $doctor_name, $user_name linked you as a family member in Healthdetails account. Now enjoy the shared subscription and manage your digital health file easily. Welcome to era of digital health. Download Healthdetails app today https://healthdetails.in .");

            return $this->successMessage('User Link Succesfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function memberSubscriptionDelete(Request $request, $id)
    {
        try {
            $subscription = UserSubscription::where('user_id', $id)->where('parent_id', auth()->id())->first();
            if ($subscription) {
                $subscription->delete();
                return $this->successMessage('Member Unlink Successfully!');
            } else {
                return $this->errorOk('Subscription not found!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function selfDelete(Request $request, $user_id, $user_subscription_id)
    {
        try {
            if ($user_id == auth()->id()) {
                $parent_subscription = UserSubscription::whereId($user_subscription_id)->first();
                if (!$parent_subscription) {
                    return $this->errorOk('Parent Subscription not found!');
                }

                $subscription = UserSubscription::where('user_id', $user_id)->whereParentId($parent_subscription->user_id)->first();
                if ($subscription) {
                    $subscription->delete();
                    return $this->successMessage('Subscription Deleted Successfully.');
                } else {
                    return $this->errorOk('Subscription not found!');
                }
            } else {
                return $this->errorOk('You don\'t have access to delete this subscription!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function myFamilyMembersList(Request $request)
    {
        try {
            $subscription = UserSubscription::where('parent_id', auth()->id());
            if ($subscription->exists()) {
                $subscription = $subscription->with(['user' => function ($q) {
                    $q->select('id', 'first_name', 'last_name', 'phone', 'avatar', 'gender', 'address', 'pincode', 'email', 'relation', 'dob', 'state', 'city');
                }])->get();
                return $this->success($subscription);
            } else {
                return $this->errorOk('No Members found!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function loginMember(Request $request, $user_id, $id)
    {
        try {
            $userSubscription = UserSubscription::where('parent_id', $id)->where('user_id', $user_id);
            if ($userSubscription->exists()) {
                $user = User::where('id', $userSubscription->first()->user_id)->first();
                if ($user) {
                    auth()->loginUsingId($user->id);
                    $accessToken = auth()->user()->createToken('authToken')->accessToken;
                    $user = User::where('id', auth()->id())->first();
                    $user['pri_dr_note'] = json_decode($user->pri_dr_note);
                    return $this->success([
                        'user' => $user,
                        'token' => $accessToken,
                    ]);
                } else {
                    return $this->errorOk('This User does\'t exist!');
                }
            } else {
                return $this->errorOk('This User is not your family member!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function activateAccountOtp(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users',
        ]);
        try {

            $user = User::where('phone', $request->phone)->role('User')->first();
            if ($user) {
                return $this->errorOk('This phone number already exists in our system.');
            }
            $otp = rand(1000, 9999);
            auth()->user()->update([
                'linkmember_otp' => $otp
            ]);
            $msg = " Dear User, Your OTP to access Health Details account is $otp. It will be valid upto 30 minutes. PLEASE DO NOT SHARE IT WITH ANYONE.";
            pushSMSNotification($request->phone, $msg);
            return $this->success($otp);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function activateAccount(Request $request)
    {
        try {
            $this->validate($request, [
                'phone' => 'required|numeric',
                'email' => 'required',
            ]);
//            $user = User::where('linkmember_otp', $request->otp)->first();

            if (auth()->user()->linkmember_otp != $request->get('otp')) {
                return $this->errorOk('Invalid OTP.');
            }
            auth()->user()->update([
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'is_member' => 1
            ]);
            return $this->successMessage('Account Activated Successfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function linkDoctor(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->role('Doctor')->first();
            if (!$user) {
                return $this->errorOk('No Doctor associated with this number, Please fill doctor details manually.');
            }

            // $subs_bonus = getSetting('subscription_bonus');
            // $wallet =  WalletLog::create([
            //     'user_id' => $user->id,
            //     'type' => 'credit',
            //     'model' => 'InviteSuperBonus',
            //     'amount' => $subs_bonus,
            //     'remark'=>'To Link by '.NameById(auth()->user()->name)
            // ]);
            
            return $this->success($user);
        } catch (\Exception $e) {
            info($e);
            return $this->error("Oops! " . $e->getMessage());
        }
    }

}
