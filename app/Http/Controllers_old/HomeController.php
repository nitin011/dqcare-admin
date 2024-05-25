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

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserEnquiry;
use App\Models\Article;
use App\Models\Slider;
use App\Models\Faq;
use App\Models\CategoryType;
use App\Models\Category;
use App\Models\SliderType;
use App\Models\NewsLetter;
use App\Models\WebsitePage;

class HomeController extends Controller
{

    public function index()
    {
    
        return view('frontend.index');
    }
    public function notFound()
    {
        return view('global.error');
    }
    public function maintanance()
    {
        return view('global.maintanance');
    }

    public function page($slug = null)
    {
        if($slug != null){
            $page = WebsitePage::where('slug', '=', $slug)->whereStatus(1)->first();
                if(!$page){
                    abort(404);
                }
        }else{
            $page = null;
        }
        return view('frontend.page',compact('page'));
    }

    public function smsVerification(Request $request)
    {
        if(auth()->check()){
            $user = auth()->user();
        }else{
            $user = User::where('phone', $request->phone)->first();
        }

        if($user->temp_otp != null){
            if($user->temp_otp = $request->verification_code){
                $user->update(['is_verified' => 1,'temp_otp'=>null ]);
                return redirect()->route('panel.dashboard');
                return $request->all();
            }else{
                return back()->with('error','OTP Mismatch');
            }
        }else{
            return back()->with('error','Try Again');
        }
    }
    public function about(Request $request)
    {
        return view('frontend.website.about');
    }
    public function pricing(Request $request)
    {
        return view('frontend.website.pricing');
    }
    public function storeNewsletter(Request $request)
    {
        $news = NewsLetter::create([
            'type' => $request->get('type'),
            'group_id' => $request->get('group_id'),
            'value' => $request->get('value'),
        ]);
        return back()->with('success',"Subscribed Successfully!");
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->url('/');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id

             if(authRole() == "User"){
                $role = "?role=User";
             }else{
                $role = "?role=Admin";
             }
            $admin_id = session()->get('admin_user_id');

            session()->forget('admin_user_id');
            session()->forget('temp_user_id');

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect(route('panel.users.index').$role);
        } else {
            // return 'f';
            session()->forget('admin_user_id');
            session()->forget('temp_user_id');

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect('/');
        }
    }

    public function notifyPatientFollowup()
    {
        try{
            $patientIds = FollowUp::whereDate('date', now())->pluck('user_id')->toArray();

            User::select('id', 'fcm_token')
                ->whereIn('id', $patientIds)
                ->groupBy('fcm_token')
                ->chunk(50, function ($users){
                    foreach ($users as $user){
                        $followUps = FollowUp::whereDate('date', now())->where('user_id', $user->id)->count();

                        if ($followUps > 0) {
                            $this->fcm()
                                ->setTokens([$user->fcm_token])
                                ->setTitle(config('app.name'))
                                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                                ->setBody("Good morning! You have " . $followUps . " followups today.")
                                ->send();
                        }
                    }
                });
        } catch (\Exception | \Error $e){
            info($e->getMessage());
        }
    }

    public function notifyDoctorFollowup()
    {
        try{
            $patientIds = FollowUp::whereDate('date', now())->groupBy('doctor_id')->pluck('doctor_id')->toArray();

            User::select('id', 'fcm_token')
                ->whereIn('id', $patientIds)
                ->groupBy('fcm_token')
                ->chunk(50, function ($users){
                    foreach ($users as $user){
                        $followUps = FollowUp::whereDate('date', now())->where('doctor_id', $user->id)->count();

                        if ($followUps > 0) {
                            $this->fcm()
                                ->setTokens([$user->fcm_token])
                                ->setTitle(config('app.name'))
                                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                                ->setBody("Good morning! You have " . $followUps . " followups today.")
                                ->send();
                        }
                    }
                });
        } catch (\Exception | \Error $e){
            info($e->getMessage());
        }
    }

    public function faq()
    {
        $faqCategoriesId = CategoryType::where('name','faq_categery')->first()->id;
        $faqCategories = Category::where('category_type_id',$faqCategoriesId)->get();
        $faqs =  Faq::all();
        return view('frontend.website.faq',compact('faqs','faqCategories'));
    }
}
