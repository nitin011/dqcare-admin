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
use App\User;
use App\Models\UserSubscription;
use App\Models\City;
use App\Models\State;
use Auth;

class PatientAuthController extends Controller
{
    public function patientLogin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $otp = rand(1000, 9999);

        // $user = User::where('phone', $request->get('phone'));

        $user = User::role('User')->where('phone', $request->get('phone'));

        if (!$user->exists()) {
            // $user = User::create([
            //     'email'=>$request->phone.'@gmail.com',
            //     'phone'=>$request->phone,
            // ]);
            $user = User::create([
                'email' => null,
                'phone' => $request->phone,
            ]);

            // Student
            $user->syncRoles(3);

            pushSMSNotification($user->phone, "Welcome! Respected Doctor. Thank you for joining DQ Care. Now you can track appointments, manage your patient's details, medical story, referrals and take regular followup updates easily on your DQ Care app.");
        } else if (!$user->first()->hasRole('User')) {
            return $this->errorOk("Please use 'Doctor' app to continue.");
        }

        $user->update([
            'temp_otp' => $otp,
        ]);

        $message = " Dear User, Your OTP to access DQ Care account is $otp. It will be valid upto 30 minutes. PLEASE DO NOT SHARE IT WITH ANYONE.";
        pushSMSNotification($request->phone, $message);

        return $this->success($otp);
    }


    public function patientVerifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required',
        ]);

        $user = User::role('User')
            ->where('phone', $request->get('phone'))
            ->where('temp_otp', $request->get('otp'));

        if (!$user->exists()) {
            return $this->errorOk('Invalid OTP.');
        }

        auth()->loginUsingId($user->first()->id);

        $accessToken = Auth::user()->createToken('authToken')->accessToken;
        $userData = User::whereId(auth()->id())->latest()->first();
        $userData['pri_dr_note'] = json_decode($userData->pri_dr_note);

        $userSubsCheck = UserSubscription::where('user_id', $userData->id)->whereNotNull('parent_id');
        
        if ($userSubsCheck->exists()) {
            $userSubs = UserSubscription::where('user_id', $userSubsCheck->latest()->first()->parent_id)->latest()->first();
        } else {
            $userSubs = UserSubscription::where('user_id', $userData->id)->latest()->first();
        }
        $userData['subscription'] = $userSubs;

        return $this->success([
            'user' => $userData,
            'token' => $accessToken,
        ]);
    }

    public function patientProfileSetup(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|string|',
            'address' => 'required',
            'pincode' => 'required',
        ]);
        $email = User::where('email', $request->email)->exists();
        $userSubs = UserSubscription::where('user_id', $user->id)->where('subscription_id', 1)->first();
        try {
            if ($user) {
                if (!$email) {
                    $user->update([
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'address' => $request->address,
                        'pincode' => $request->pincode,
                        'date' => $request->date,
                        'gender' => $request->gender,
                        'state' => $request->state,
                        'city' => $request->city,
                        'dob' => $request->dob,
                        'progress' => 1,
                    ]);

                    // Check for aleady have primary Dr.
                    if ($user->doctor_id != null) {
                        $user->update([
                            'progress' => 2,
                        ]);
                        if (!$userSubs) {
                            UserSubscription::create([
                                'user_id' => $user->id,
                                'subscription_id' => 1,
                                'from_date' => now(),
                                'to_date' => now()->addDay(30),
                            ]);
                        }
                    }
                    return $this->successMessage('Patient Profile Updated Successfully!');
                } else {
                    return $this->errorOk('This Email already exists!');
                }
            } else {
                return $this->errorOk('This Patient does not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientDoctorSelector(Request $request, User $user)
    {
        $request->validate([
            'doctor_name' => 'required',
            'phone_no' => 'required|numeric',
            'pincode' => 'required',
            'address' => 'required',
        ]);

        $UserPhone = User::where('phone', $request->phone_no);
        $userSubs = UserSubscription::where('user_id', $user->id)->where('subscription_id', 1)->first();
        $pri_dr_note = json_encode([
            'doctor_name' => $request->doctor_name,
            'phone_no' => $request->phone_no,
            'state' => $request->state,
            'state_name' => State::where('id', $request->state)->value('name'),
            'city' => $request->city,
            'city_name' => City::where('id', $request->city)->value('name'),
            'address' => $request->address,
            'pincode' => $request->pincode,
        ]);
        try {
            if ($user) {
                if ($UserPhone->first()) {
                    if ($UserPhone->role('Doctor')->first()) {

                        // Update Primary Dr
                        $user->update([
                            'doctor_id' => $UserPhone->first()->id,
                            'pri_dr_note' => $pri_dr_note,
                            'progress' => 2,
                        ]);

                        // Send Alert to Dr
                        $patient_name = $user->name;
                        $doctor_name = $UserPhone->first()->name;
                        $message = "Hello Dr $doctor_name, $patient_name added you as a primary doctor in DQ Care. Free your patients from physical files and get to see their smart digital health file everytime they visit. Also, digitalise your practise . Welcome to era of digital health. Download DQ Care app today https://dqcare.in .";
                        callWhatsappNotification($UserPhone->first()->phone, $message);

                        // Update Invited by if not have
                        if ($user->invited_by == null) {
                            $user->update([
                                'invited_by' => $UserPhone->first()->id,
                            ]);
                        }

                        if (!$userSubs) {
                            UserSubscription::create([
                                'user_id' => $user->id,
                                'subscription_id' => 1,
                                'from_date' => now(),
                                'to_date' => now()->addDay(30),
                            ]);
                        }
                    } else {
                        return $this->errorOk('This user already exists in our system, but it is a user, not a doctor, so please enter the mobile number associated with your primary doctor!');
                    }
                } else {
                    $user->update([
                        'pri_dr_note' => $pri_dr_note,
                        'progress' => 2,
                    ]);
                    if (!$userSubs) {
                        UserSubscription::create([
                            'user_id' => $user->id,
                            'subscription_id' => 1,
                            'from_date' => now(),
                            'to_date' => now()->addDay(30),
                        ]);
                    }
                }

                return $this->successMessage('Primary Doctor Created & Your trial package Started Successfully!');
            } else {
                return $this->errorOk('This User is not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

}
