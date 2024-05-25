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
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        // return $request->all();
        $this->validateLogin($request);
        
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            
            return $this->sendLockoutResponse($request);
        }
        // return $request->all();

        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 3])) {
                // return redirect()->intended('dashboard');
                $this->incrementLoginAttempts($request);
                return response()->json([
                    'error' => 'This account is not activated.'
                ], 401);
            } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
                return redirect('/panel/dashboard');
            } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 2])) {
                return redirect('/panel/dashboard');
            }
        } else {
            // dd('ok');
            $this->incrementLoginAttempts($request);
            return redirect()->back()->with('error','Credentials do not match our database.');
            // return response()->json([
            //     'error' => 'Credentials do not match our database.'
            // ], 401);
        }
    }

    protected function validateLogin(Request $request)
    {
        if(getSetting('recaptcha') == 0){
            $validate = 'recaptcha|sometimes';
        }else{
            $validate = 'recaptcha|required';
        }
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => $validate,
        ]);
    }
    // custom logout function
    // redirect to login page
    public function logout(Request $request)
    {
        //Make Log
        makeLog($activity = "Logout", $ip = $request->ip());
        if (authRole() == 'Admin') {
            $redirect = 'login';
        } else {
            $redirect = '/';
        }
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect($redirect);
    }
}
