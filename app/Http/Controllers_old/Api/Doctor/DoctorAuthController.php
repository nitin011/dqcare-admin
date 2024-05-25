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

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;

class DoctorAuthController extends Controller
{

    public function login(Request $request)
    {
        // return 's';
        $request->validate([
            'phone' => 'required',
        ]);

         $otp = rand(1000, 9999);

        // $user = User::where('phone', $request->get('phone'));
        $user =  User::role('Doctor')->where('phone', $request->get('phone'));

       if (!$user->exists()) {
            // $user = User::create([
            //     'email' => $request->phone . '@gmail.com',
            //     'phone' => $request->phone,
            // ]);
            $user = User::create([
                'email'=>null,
                'phone'=>$request->phone,
            ]);
            // Student
            $user->syncRoles(5);
            pushSMSNotification($user->phone, "Welcome! " . $user->full_name . " Thank you for joining HealthDetails. Now you can manage medical records, track family's health and get health related updates easily on your HealthDetails app.");
        } else if(!$user->first()->hasRole('Doctor')){
            return $this->errorOk("Please use 'Patient' app to continue.");
        }


        $user->update([
            'temp_otp' => $otp,
        ]);
        $message = " Dear User, Your OTP to access Health Details account is $otp. It will be valid upto 30 minutes. PLEASE DO NOT SHARE IT WITH ANYONE.";
        pushSMSNotification($request->phone, $message);

        return $this->success($otp);
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'phone' => 'required',
            'otp' => 'required',
        ]);

        $user = User::role('Doctor')->where('phone', $request->get('phone'))->where('temp_otp', $request->get('otp'));

        // if($user->role('User')->first()){
        //     return $this->errorOk('You can not login as a user because your ');
        // }

        if(!$user->exists()){
            return $this->errorOk('Invalid OTP.');
        }

        auth()->loginUsingId($user->first()->id);

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        $user = User::where('id',auth()->id())->first();
        $user['pri_dr_note'] = json_decode($user->pri_dr_note);
        return $this->success([
            'user' => $user,
            'token' => $accessToken,
        ]);
    }

    public function doctorProfileSetup(Request $request, User $user){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|string',
        ]);
        try{
            $email = User::where('email',$request->email)->exists();
            if($user){
                if(!$email){
                    $user->update([
                        'salutation' => $request->salutation,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'pincode' => $request->pincode,
                        'email' => $request->email,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'speciality' => $request->speciality,
                        'progress' => 1,
                    ]);
                    return $this->successMessage('Your Profile Updated Successfully!');
                }else{
                    return $this->errorOk('This Email already exist!');
                }
            }else{
                return $this->errorOk('This User does\'t exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function doctorProfessionalDetails(Request $request, User $user){
        // return 's';
        $request->validate([
            'speciality' => 'required',
        ]);
        try{
            if($user){
                $user->update([
                    'speciality' => $request->speciality,
                    'progress' => 2,
                ]);
                return $this->successMessage('Your Specialty Updated Successfully!');
            }
            else{
                return $this->errorOk('This User does\'t exist!!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function getSpecilities(Request $request){
        // return 's';
        $request->validate([
            'speciality' => 'required',
        ]);
        try{
            if($user){
                $user->update([
                    'speciality' => $request->speciality,
                    'progress' => 2,
                ]);
                return $this->successMessage('Your Specialty Updated Successfully!');
            }
            else{
                return $this->errorOk('This User does\'t exist!!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function doctorClinicDetails(Request $request, User $user){
        // return 's';
        $request->validate([
            'name_of_clinic' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'phone_no' => 'sometimes',
            'address' => 'required',
        ]);
        $pri_dr_note = json_encode([
            'name_of_clinic' => $request->name_of_clinic,
            'clinic_contact_no' => $request->clinic_contact_no,
            'state' => $request->state,
            'city' => $request->city,
            'address' => $request->address,
            'phone_no' => $request->phone_no,
        ]);
        try{
            if($user){
                $user->update([
                    'pri_dr_note' => $pri_dr_note,
                    'progress' => 2,
                ]);
                return $this->successMessage('Your Clinic Details Updated Successfully!');
            }else{
                return $this->errorOk('This User does\'t exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function updateClinicDetails(Request $request,$id){
        $request->validate([
            'name_of_clinic' => 'required',
            'address' => 'required',
        ]);
        try{
            $user = User::where('id',$id)->first();
                $pri_dr_note = json_encode([
                    'name_of_clinic' => $request->name_of_clinic,
                    'clinic_contact_no' => $request->clinic_contact_no,
                    'state' => $request->state,
                    'city' => $request->city,
                    'address' => $request->address,
                    'phone_no' => $request->phone_no,
                ]);
            if($user){
                $user->update([
                    'pri_dr_note' => $pri_dr_note,
                    'progress' => 2,
                ]);
                return $this->successMessage('Your Clinic Details Updated Successfully!');
            }else{
                return $this->errorOk('This User does\'t exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

}
//Parent Mayank
//"subscription": {
//"id": 182,
//        "user_id": 834,
//        "subscription_id": 1,
//        "from_date": "2022-12-23",
//        "to_date": "2023-01-22",
//        "parent_id": null,
//        "created_at": "2022-12-23T07:10:08.000000Z",
//        "updated_at": "2022-12-23T07:10:08.000000Z",
//        "deleted_at": null
//    },


