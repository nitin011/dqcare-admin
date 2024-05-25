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

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\State;
use App\Models\UserSubscription;
use App\Models\City;
use App\Models\FollowUp;
use Auth;

class AuthController extends Controller
{
    public function profile(Request $request)
    {
        try {
            $user = Auth::user();
            $user['pri_dr_note'] = json_decode($user->pri_dr_note);
            $user['followup'] = FollowUp::where('doctor_id', auth()->id())->whereDate('created_at', \Carbon\Carbon::today())->count();


//        $subscription = UserSubscription::where('user_id',auth()->id());
//        if($subscription->exists()){
//            $user['subscription'] = $subscription->latest()->first();
//        }else{
//             $user['subscription'] = null;
//        }

            $subscription = UserSubscription::where('user_id', $user->id)->whereNotNull('parent_id');
            if ($subscription->exists()) {
                $userSubs = UserSubscription::where('user_id', $subscription->latest()->first()->parent_id)->latest()->first();
            } else {
                $userSubs = UserSubscription::where('user_id', $user->id)->latest()->first();
            }
			$dob = $user['dob'];
			if($dob == NULL)
			{
			$user['age'] = NULL;	
			} else {
			$age = (date('Y') - date('Y',strtotime($dob)));
            $user['age'] = $age;
			}
			
            $user['subscription'] = $userSubs;
            return $this->success($user);
        } catch (\Exception $e) {
            return $e;

        }
    }


    public function getStates(Request $request)
    {
        // return auth()->id();
        $states = State::where('country_id', 101)->orderBy('name', 'ASC')->get(['id', 'name']);
        if ($states->count() > 0) {
            return $this->success($states);
        } else {
            return $this->error('No States Found!');
        }
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->orderBy('name', 'ASC')->get(['id', 'name']);
        if ($cities->count() > 0) {
            return $this->success($cities);
        } else {
            return $this->error('No City Found!');
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validData = $request->validate([
                'email' => 'required|email|string',
            ]);

            $user = User::where('email', $request->get('email'))->first();
            if (!$user) {
                return response()->json([
                    'message' => 'User not found!',
                    'success' => 0
                ], 200);
            }
            $otp = rand(1000, 9999);
            $user->temp_otp = $otp;
            $user->save();
            $body = "To reset your password, please use the following One Time Password (OTP):" . $otp . "<br> Thank you for using." . config('app.name');
            StaticMail($user->name, $user->email, "Reset Password in" . config('app.name'), $body, $mail_footer = null);
            return $this->success("OTP Sent Successfully!");
        } catch (\Throwable $th) {
            return $this->error("Sorry! Failed to reset password! " . $th->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        // match old password
        if (Hash::check($request->old_password, Auth::user()->password)) {

            User::find(auth()->user()->id)
                ->update([
                    'password' => Hash::make($request->password)
                ]);

            return response([
                'message' => 'Password has been changed',
                'status' => 1
            ]);

        }
        return response([
            'message' => 'Password not matched!',
            'status' => 0
        ]);
    }


    public function updateProfile(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = Auth::user();
        // check unique email except this user
        if (isset($request->email)) {
            $check = User::where('email', $request->email)
                ->where('id', '!=', $user->id)
                ->count();
            if ($check > 0) {
                return response([
                    'message' => 'The email address is already used!',
                    'success' => 0
                ]);
            }
        }

        $user->update($validData);
        return response([
            'message' => 'Profile updated successfully!',
            'status' => 1
        ]);
    }


    public function logout(Request $request)
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response([
            'message' => 'Logged out succesfully!',
            'status' => 0
        ]);
    }


    public function updateDeviceToken(Request $request)
    {
        auth()->user()->update([
            'fcm_token' => $request->get('fcm_token'),
        ]);

        return $this->successMessage('Updated');
    }


}
