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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // if(getSetting('recaptcha') == 0){
        //     $validate = ['recaptcha','sometimes'];
        // }else{
        //     $validate = ['recaptcha','required'];
        // }
        return Validator::make($data, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            // 'g-recaptcha-response' => $validate,
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(getSetting('sms_verify')){
            $otp = rand(000000,999999);
            $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"otp-send")->first();
            if($mailcontent_data){
                $arr=[
                    '{OTP}'=>$otp,
                    '{reason}'=>"registeration",
                    '{app_name}'=>"Defenzelite",
                    '{date_time}'=>\Carbon\Carbon::now()->format('d M Y,h:i'),
                 ];
                 // return short_code_parser($mailcontent_data->body,$arr);
                 $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
                 return sendSms($data['phone'],$msg,$mailcontent_data->footer);
            }
            // manualSms($data['phone'],$otp." is your ".getSetting('app_name')." OTP. Do not share it with anyone. ");
        }else{
            $otp = null;
        }
        $user = User::create([
            'name' => $data['fname'] .' '. $data['lname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'temp_otp' => $otp,
            'password' => Hash::make($data['password']),
        ]);
        return 's';
                $user->syncRoles(3);

        // Push On Site Notification
        $data_notification = [
            'title' => "Welcome in ".getSetting('app_name'),
            'notification' => "Your account has been activated",
            'link' => "#",
            'user_id' => $user->id,
        ];
        pushOnSiteNotification($data_notification);
        // End Push On Site Notification

            return $user;
    }

}
