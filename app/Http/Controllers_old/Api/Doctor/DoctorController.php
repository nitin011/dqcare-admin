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
use App\Models\WalletLog;
use App\Traits\CanSendFCMNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Models\Scanlog;
use App\Models\State;
use App\Models\City;
use App\Models\Experience;
use App\Models\Education;
use App\Models\UserEnquiry;
use App\Models\UserSubscription;
use App\Models\Media;
use App\Models\Slider;
use \Carbon\Carbon;
use App\Models\DoctorReferral;
use App\Models\FollowUp;
use App\Models\Category;

class DoctorController extends Controller
{
    use CanSendFCMNotification;

    protected $now;
    private $resultLimit = 20;

    public function __construct()
    {
        $this->now = Carbon::now();
    }


    public function index(Request $request)
    {
        try {
            $data['todayVisitsCount'] = Scanlog::where('doctor_id', auth()->id())->whereDate('created_at', $this->now)->count();
            $data['todayReferralsCount'] = DoctorReferral::where('doctor_id', auth()->id())->whereDate('date', $this->now)->count();
            $data['todayFollowUpCount'] = FollowUp::where('doctor_id', auth()->id())->whereDate('date', $this->now)->count();
            $data['homeSliders'] = Slider::where('slider_type_id', 9)->where('status',1)->get();
            // response
            if ($data) {
                return $this->success($data);
            } else {
                return $this->errorOk('Data not found!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $th->getMessage());
        }
    }

    public function patientIndex(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $userids = Scanlog::where('doctor_id', auth()->id())->pluck('user_id')->toArray();
            $patients = User::query();

            $patients->select('id', 'doctor_id', 'gender', 'first_name', 'last_name', 'phone', 'avatar', 'created_at');

            $patients->where(function ($q) use ($userids) {
                $q->whereIn('id', $userids)
                    ->orWhere('doctor_id', auth()->id());
            });

            if ($request->get('search')) {
                $patients->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('phone', 'like', '%' . $request->get('search') . '%');
                });
            }

            if ($request->has('gender') && $request->get('gender') != null) {
                $patients->where('gender', $request->get('gender'));
            }

            if ($request->has('from') && !is_null($request->has('to')) && $request->get('from') && !is_null($request->get('to'))) {
                if ($request->get('from') == $request->get('to'))
                    $patients->whereDate('created_at', $request->get('from'));
                else
                    $patients->whereDate('created_at', '>=', $request->get('from'))->whereDate('created_at', '<=', $request->get('to'));
            }

            $patients = $patients->latest()
                ->limit($limit)->offset(($page - 1) * $limit)
                ->latest()
                ->get();

            //response
            if ($patients) {
                return $this->success($patients);
            } else {
                return $this->errorOk('Patient Data Does not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric',
        ]);
        // Try
        try {
            if (auth()->user()->phone == $request->phone) {
                return $this->errorOk('You can not use own number as patient');
            }
            $phone = User::where('phone', $request->phone)->first();
            if (!$phone) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'email' => $request->phone . '@gmail.com',
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'dob' => isset($request->dob)? date('Y-m-d', strtotime($request->dob)) : NULL,
                    'salutation' => $request->salutation,
                    'doctor_id' => auth()->id(),
                    'invited_by' => auth()->id(),
                    'gender' => $request->gender,
                ]);
                //assinging user role
                $user->syncRoles(3);

                $subs_bonus = getSetting('subscription_bonus');

                WalletLog::create([
                    'user_id' => $user->invited_by,
                    'type' => 'credit',
                    'model' => 'InviteSuperBonus',
                    'amount' => $subs_bonus,
                    'remark'=>'To Invite '.NameById($user->id)
                ]);
                $user_data = User::where('id', $user->id)->first();

                callWhatsappNotification($user->phone, "Dr. " . auth()->user()->name . " added you in HealthDetails. Now tracking family's health, managing medical documents and getting your health related updates easier than never before. Download HealthDetails app today https://healthdetails.in .");
            } else {
                return $this->errorOk('This patient is already using Health Details. Please use patient QR code from app to add this patient.');
            }
            return $this->success($user_data);
        } catch (\Exception | \Error $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientView(Request $request, $id)
    {
        try {
            
            $user = User::where('id', $id)->with(['countryData' => function ($q) {
                $q->select('id', 'name');
            }, 'stateData' => function ($qa) {
                $qa->select('id', 'name');
            }, 'cityData' => function ($qa) {
                $qa->select('id', 'name');
            }, 'speciality' => function ($qa) {
                $qa->select('id', 'name');
            }])->with('schedules')
            ->first();
            if ($user) {
                $pdn = json_decode($user->pri_dr_note, true);
                if ($pdn != null) {
                    $nPdn = $pdn;
                    if (isset($nPdn->state) && $nPdn->state != null) {
                        $nPdn->state = State::where('id', $pdn->state)->value('name');
                    }
                    if (isset($nPdn->city) && $nPdn->city) {
                        $nPdn->city = City::where('id', $pdn->city)->value('name');
                    }
                    $user['pri_dr_note'] = $nPdn;
                } else {
                    $user['pri_dr_note'] = json_decode($user->pri_dr_note);
                }

                $user['experience'] = Experience::where('user_id', $user->id)->get();
                $user['qualification'] = Education::where('user_id', $user->id)->get();

                return $this->success($user);
            } else {
                return $this->errorOk('This Record does not exist!');
            }
        } catch (\Exception | \Error $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientUpdate(Request $request, User $user)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'phone' => 'required|numeric|unique:users,phone',
        ]);
        try {
            if ($user) {
                $user->update([
                    'first_name' => $request->first_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                ]);
                return $this->successMessage('Patient Data Updated Successfully!');
            } else {
                return $this->errorOk('This Patient does not Exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function doctorProfile(Request $request, $id)
    {
        try {
            $user = User::role('Doctor')->select('id', 'gender', 'first_name', 'last_name', 'phone', 'avatar', 'dob')->where('id', $id)->first();
            if ($user) {
                return $this->success($user);
            } else {
                return $this->error('Doctor is not found!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function userDataScan(Request $request, $id, $scanLogId = null)
    {
        try {
            $user = User::select('id', 'avatar', 'first_name', 'last_name', 'gender', 'height', 'weight', 'wallet_balance', 'fcm_token')->where('id', $id)->first();

            if (!$user) {
                return $this->error('Invalid QR or User not found!');
            }

            if (auth()->user()->id == $id) {
                return $this->error('You can not use your own number as patient');
            }

            $userData = User::where('id', $id);
            if ($scanLogId == null) {
                if ($userData->exists()) {
                    if ($userData->where('status', 1)->first()) {
                        if (UserRole($userData->first()->id)->name == 'User') {
                            $scanLog = Scanlog::where('user_id', $user->id)
                                ->where('doctor_id', auth()->id())
                                ->whereDate('created_at', now()->format('Y-m-d'));

                            $active_log = 0;
                            // If Scanned Already
                            if ($scanLog->exists()) {
                                $difference = now()->diffInMinutes($scanLog->latest()->first()->created_at, true);
                                if($difference <= 10){
                                    $active_log = 1;
                                }
                            }

                            if($active_log == 1){
                                $scanLog = $scanLog->latest()->first();
                            }else {
                                // Scan Reward
                                $is_rewarded = getScanBonusPatient($user->id, auth()->id());

                                // Scan Bonous
                                getScanBonusAlways($user->id, auth()->id());


                                // Access Granted
                                $scanLog = Scanlog::create([
                                    'doctor_id' => auth()->id(),
                                    'user_id' => $user->id,
                                    'interval' => 10,
                                    'is_rewarded' => $is_rewarded,
                                ]);

                                if($is_rewarded == 1){
                                    $this->fcm()
                                        ->setTokens([auth()->user()->fcm_token])
                                        ->setTitle(config('app.name'))
                                        ->setBody("You got 100 bonus points & ₹".getSetting('scan_bonus')." reward for Scanning " . NameById($user->id))
                                        ->send();
                                }else{
                                    $this->fcm()
                                        ->setTokens([auth()->user()->fcm_token])
                                        ->setTitle(config('app.name'))
                                        ->setBody("You got 100 bonus points for Scanning " . NameById($user->id))
                                        ->send();
                                } 
                            }

                            // Fetch Data
                            $scanLog = Scanlog::where('id', $scanLog->id)->with(['user' => function ($q) {
                                $q->select('id', 'avatar', 'first_name', 'last_name', 'gender','height','weight','dob');
                            }])->first();

                        } else {
                            return $this->error('You cann\'t access this user data beacuse this is non patient account');
                        }
                    } else {
                        return $this->error('This User is Inactive!');
                    }
                } else {
                    return $this->errorOk('This user does not exist!');
                }
            } else {
                $scanLog = Scanlog::where('id', $scanLogId)->with(['user' => function ($q) {
                    $q->select('id', 'avatar', 'first_name', 'last_name', 'gender','height','weight','dob');
                }])->first();

                if (!$scanLog) {
                    return $this->error('The patient has not been found!');
                }
            }

            // foreach($scanLogs as $scanLog){
            $createdDate = strtotime($scanLog->created_at->addMinutes(10));
            $currentDate = strtotime(now());
            $scanLog['scan_difference'] = round(($createdDate - $currentDate)) < 0 ? 0 : round(($createdDate - $currentDate));
            // $user['scan_difference'] = 100;
            // }

            $followUp = FollowUp::where('doctor_id', auth()->id())->where('user_id', $id)->whereDate('date', now());
            $data['scanLog'] = $scanLog;
			$dob = $data['scanLog']['user']['dob'];
			if($dob == NULL)
			{
			$data['scanLog']['user']['age'] = NULL;	
			} else {
			$age = (date('Y') - date('Y',strtotime($dob)));
            $data['scanLog']['user']['age'] = $age;
			}
            if ($followUp->exists()) {
                $data['followup'] = $followUp->latest()->first();
            } else {
                $data['followup'] = null;
            }

            $this->fcm()
                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                ->setTokens([$user->fcm_token])
                ->setTitle(config('app.name'))
                ->setBody(auth()->user()->salutation . ' ' . auth()->user()->name . ' has accessed your medical details just now.')
                ->send(); 

            return $this->success($data);

        } catch (\Exception | \Error $e) {
            return $this->error("Sorry! Failed to data! " . $e);
        }
    }

    public function doctorProfileUpdate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'first_name' => 'required',
            'salutation' => 'required',
        ]);
        try {
            $user = User::whereId(auth()->id())->first();
            if ($user) {
                if ($request->hasFile('avatar')) {
                    if ($user->avatar != null) {
                        unlinkfile(storage_path() . '/app/public/backend/users', $user->avatar);
                    }
                    $image = $request->file('avatar');
                    $path = storage_path() . '/app/public/backend/users/';
                    $imageName = 'profile_image_' . $user->id . rand(000, 999) . '.' . $image->getClientOriginalExtension();
                    $image->move($path, $imageName);
                } else {
                    $imageName = collect(explode('/', $user->avatar))->last();
                }
                $user->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'salutation' => $request->salutation,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'speciality' => $request->speciality,
                    'avatar' => $imageName,
                ]);
                return $this->successMessage('Your Profile Updated Successfully!');
            } else {
                return $this->errorOk('The doctor\'s profile can\'t be updated!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function doctorVisit(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $scanLogs = Scanlog::query();

            if ($request->get('from') && $request->get('to')) {
                // $scanLogs->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
                $scanLogs->whereDate('created_at', '>=', $request->get('from'))
                    ->whereDate('created_at', '<=', $request->get('to'));
            }
            $scanLogs = $scanLogs->where('doctor_id', auth()->id());
            if ($scanLogs->exists()) {
                $scanLogs = $scanLogs->with(['user' => function ($q) {
                    $q->select('id', 'avatar', 'first_name', 'last_name');
                }])
                    ->latest()
                    ->limit($limit)
                    ->offset(($page - 1) * $limit)
                    ->get();

                foreach ($scanLogs as $scanLog) {
                    $createdDate = strtotime($scanLog->created_at->addMinutes(10));
                    $currentDate = strtotime(now());
                    $scanLog['difference'] = round(($createdDate - $currentDate)) < 0 ? 0 : round(($createdDate - $currentDate));
                }
                return $this->success($scanLogs);
            } else {
                return $this->success([]);
            }
            //response
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function doctorLeaderboard(Request $request)
    {
        try {
            $doctors = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'doctor_id', 'progress', 'speciality')
                ->role('Doctor')
                ->where('first_name','!=',null)
                ->withCount(['score' => function ($q) {
                    $q->whereIn('model', ['InviteSuperBonus', 'SubscriptionSuperBonus', 'ScanSuperBonus'])
                        ->whereMonth('created_at',now()->format('m'))->whereYear('created_at',now()->format('Y'));
                }])
                ->orderBy('score_count', 'DESC')
                ->take(10)
                ->get();


            foreach ($doctors as $doctor) {
                $scans = WalletLog::where('user_id', $doctor->id)
                    ->where('model', 'ScanSuperBonus')
                    ->whereMonth('created_at',now()->format('m'))
                    ->whereYear('created_at',now()->format('Y'))
                    ->sum('amount');

                $invites = WalletLog::where('user_id', $doctor->id)
                    ->whereIn('model', ['InviteSuperBonus', 'SubscriptionSuperBonus'])
                    ->whereMonth('created_at',now()->format('m'))
                    ->whereYear('created_at',now()->format('Y'))
                    ->sum('amount');

                $doctor['scan_count'] = $doctor->score_count;
                $doctor['scan_points'] = $scans;
                $doctor['patient_points'] = $invites;
                $doctor['total_points'] = $scans + $invites;
            }

            // Self

            $self = User::select('id', 'first_name', 'last_name', 'email', 'phone', 'doctor_id', 'progress', 'speciality')
                ->where('id', auth()->id())
                ->withCount(['score' => function ($q) {
                    $q->whereIn('model', ['InviteSuperBonus', 'SubscriptionSuperBonus', 'ScanSuperBonus'])
                        ->whereMonth('created_at',now()->format('m'))->whereYear('created_at',now()->format('Y'));
                }])
                ->first();

            $scans = WalletLog::where('user_id', auth()->id())
                ->where('model', 'ScanSuperBonus')
                ->whereMonth('created_at',now()->format('m'))
                ->whereYear('created_at',now()->format('Y'))
                ->sum('amount');
            $invites = WalletLog::where('user_id', auth()->id())
                ->whereIn('model', ['InviteSuperBonus', 'SubscriptionSuperBonus'])
                ->whereMonth('created_at',now()->format('m'))
                ->whereYear('created_at',now()->format('Y'))
                ->sum('amount');

            $my_scanlogs['scan_count'] = $self->score_count ?? 0;
            $my_scanlogs['scan_points'] = $scans;
            $my_scanlogs['patient_points'] = $invites;
            $my_scanlogs['total_points'] = $scans + $invites;
            $doctors = collect($doctors)->sortByDesc('total_points')->toArray();
            $docs = [];
            foreach ($doctors as $doctor) {
                $docs[] = $doctor;
            }

            if (count($docs) > 0) {
                return $this->success(['leaderboards' => $docs, 'my_scan' => $my_scanlogs]);
            } else {
                return $this->errorOk('Leaderboard not prepared!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong." . $e);
        }
    }

    public function revenueIndex(Request $request)
    {
        try {
            $dateArr = [];
            $monthArr = [];
            $monthNamesArr = [];
            foreach (ScanLog::where('doctor_id', auth()->id())->pluck('created_at') as $key => $m) {
                $dateArr[] = $m;
            }

            foreach (DoctorReferral::where('user_id', auth()->id())->pluck('created_at') as $key => $m) {
                $dateArr[] = $m;
            }
            foreach (WalletLog::where('user_id', auth()->id())->pluck('created_at') as $key => $m) {
                $dateArr[] = $m;
            }

            foreach ($dateArr as $key => $mm) {
                $month = explode('T', $mm)[0];
                array_push($monthArr, (object)['m' => \Carbon\Carbon::parse(explode(' ', $month)[0])->format('m'), 'month' => \Carbon\Carbon::parse(explode(' ', $month)[0])->format('Y-m-d'), 'name' => \Carbon\Carbon::parse(explode(' ', $month)[0])->format('M'), 'year' => \Carbon\Carbon::parse(explode(' ', $month)[0])->format('Y'),]);
            }

            $dateArr = [];
            $dateYear = [];
            $monthIntArray = [];
            foreach ($monthArr as $key => $value) {
                $monthNamesArr[] = $value->name;
                $monthIntArray[] = $value->m;
                $mArr = explode('-', $value->month);
                $dateArr[] = $mArr[0] . "-" . $mArr[1];
                $dateYear[] = $value->year;
            }
            $monthNamesArr = array_unique($monthNamesArr);
            $dateArr = array_unique($dateArr);

            $data = [];
            foreach ($monthNamesArr as $key => $value) {
                $superBonus = WalletLog::where('user_id', auth()->id())
                    ->whereIn('model', ['InviteSuperBonus', 'SubscriptionSuperBonus', 'ScanSuperBonus'])
                    ->whereMonth('created_at', \Carbon\Carbon::parse($dateArr[$key] . "-01")->format('m'))->whereYear('created_at', date('Y'))->sum('amount');

                $patient_subscribed_reward = WalletLog::where('user_id', auth()->id())
                    ->where('model', 'SubscriptionReward')
                    ->whereMonth('created_at', \Carbon\Carbon::parse($dateArr[$key] . "-01")->format('m'))->whereYear('created_at', date('Y'))->get(['id', 'amount']);

                $scans_reward = WalletLog::where('user_id', auth()->id())
                    ->where('model', 'ScanReward')
                    ->whereMonth('created_at', \Carbon\Carbon::parse($dateArr[$key] . "-01")->format('m'))->whereYear('created_at', date('Y'))->get(['id', 'amount']);


                $data[] = [
                    'm' => $monthIntArray[$key],
                    'month' => $value,
                    'year' => $dateYear[$key],
                    'scans_count' => $scans_reward->count(),
                    'scans_amount' => round($scans_reward->sum('amount')),
                    'patient_subscribed_count' => $patient_subscribed_reward->count(),
                    'patient_subscribed_amount' => round($patient_subscribed_reward->sum('amount')),
                    'super_bonus' => round($superBonus),
                    'total' => round($scans_reward->sum('amount') + $patient_subscribed_reward->sum('amount')),
                ];
            }
            $data = collect($data)->sortByDesc('m')->sortByDesc('year')->toArray();

            $dd = [];
            foreach ($data as $d) {
                $dd[] = $d;
            }

            return $this->success($dd);
        } catch (\Exception $e) {
            return $this->error("Something went wrong." . $e);
        }
    }

    // public function revenueIndex(Request $request)
    // {
    //     try {
    //         $scan_logs_months = ScanLog::where('doctor_id',auth()->id())->select(\DB::raw('count(id) as `data`'),\DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
    //         ->groupby('year','month')
    //         ->pluck('month')->toArray();
    //         $referals_months = DoctorReferral::where('user_id',auth()->id())->select(\DB::raw('count(id) as `data`'),\DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
    //                 ->groupby('year','month')
    //                 ->pluck('month')->toArray();
    //                 $months =   array_unique(array_merge($scan_logs_months,$referals_months));
    //         $scan_logs = ScanLog::where('doctor_id',auth()->id())->select(\DB::raw('count(id) as `data`'),\DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
    //                 ->groupby('year','month')
    //                 ->get();
    //         $referals = DoctorReferral::where('user_id',auth()->id())->select(\DB::raw('count(id) as `data`'),\DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
    //                 ->groupby('year','month')
    //                 ->get();
    //                 $carbonObj = new \Carbon\Carbon();
    //         $arr = [];
    //      foreach($scan_logs as $scan){
    //          $arr[$scan->month] =  [
    //              'month' => $carbonObj->parse('01-'.$scan->month.'-'.$scan->year)->format('M'),
    //              'year' => $scan->year,
    //              'scans' => $scan->data*10,
    //              'referrals' => 0,
    //              'total' => $scan->data*10,
    //          ];
    //      }
    //      foreach($referals as $ref){
    //          if(array_key_exists($ref->month,$arr)){
    //          $temp = $arr[$ref->month];
    //              $arr[$ref->month] =  [
    //                  'month' => $carbonObj->parse('01-'.$ref->month.'-'.$ref->year)->format('M'),
    //                  'year' => $ref->year,
    //                  'scans' => $temp['scans'],
    //                  'referrals' => $ref->data *15,
    //                  'total' => ($ref->data*15)+$temp['total'],
    //              ];
    //          }else{
    //              $arr[$ref->month] =  [
    //                  'month' => $carbonObj->parse('01-'.$ref->month.'-'.$ref->year)->format('M'),
    //                  'year' => $ref->year,
    //                  'scans' => 0,
    //                  'referrals' => $ref->data *15,
    //                  'total' => $ref->data*15,
    //              ];
    //          }
    //      }
    //     return $this->success((array)$arr);
    //     } catch (\Exception $e) {
    //         return $this->error("Something went wrong." . $e);
    //     }
    // }

    public function getMyPatient(Request $request)
    {
        try {
            $userids = Scanlog::where('doctor_id', auth()->id())->pluck('user_id');
            $users = User::query();
            if ($request->get('gender')) {
                $users->where('gender', $request->get('gender'));
            }
            if ($request->get('from') && $request->get('to')) {
                $users->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
            }
            $users = $users->select('id', 'first_name', 'last_name', 'avatar', 'email', 'salutation', 'speciality', 'status', 'gender', 'progress', 'doctor_id')
                ->whereIn('id', $userids)
                ->orWhere('doctor_id', auth()->id())
                ->get();
            if ($users) {
                return $this->success($users);
            } else {
                return errorOk('Users not Found!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function getMyReferral(Request $request)
    {
        try {
            $my_referrals = DoctorReferral::where('doctor_id', auth()->id());
            if ($my_referrals->exists()) {
                $my_referrals = $my_referrals->with(['user' => function ($q) {
                    $q->select('id', 'first_name', 'avatar', 'email', 'salutation', 'speciality', 'status', 'gender', 'progress');
                }])->groupBy('party_name')->get();
                return $this->success($my_referrals);
            } else {
                return $this->errorOk('Refferal Data is not exists!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function getSpecilities(Request $request)
    {
        try {
            $categories = Category::where('category_type_id', 17);
            if ($categories->exists()) {
                $categories->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->get('name') . '%');
                });
                $categories = $categories->get();
                return $this->success($categories);
            } else {
                return $this->errorOk('Category Data is not available!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientLists(Request $request)
    {
        try {
            //    $userids = Scanlog::where('doctor_id',auth()->id())->pluck('user_id');
            //    $users = User::whereIn('id',$userids)->orWhere('doctor_id',auth()->id())->select('id','first_name','last_name')->get();

            $patients = User::query();
            if ($request->get('search'))
                $patients->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->get('search') . '%')
                        ->orWhere('phone', 'like', '%' . $request->get('search') . '%');
                });
            if ($request->has('gender')) {
                if ($request->has('gender') && $request->get('gender') == 'all') {
                    $patients->whereIn('gender', ['male', 'Female']);
                } else {
                    $patients->where('gender', $request->get('gender'));
                }
            }

            if ($request->get('from') && $request->get('to')) {
                $patients->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
            }

            $patients = $patients->role('User')->select('id', 'doctor_id', 'gender', 'first_name', 'last_name', 'phone', 'avatar', 'created_at')->get();
            //response
            if ($patients) {
                return $this->success($patients);
            } else {
                return $this->errorOk('Patient Data Does not exist!');
            }

        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function doctorHomeSlider(Request $request)
    {
        try {
            $homeSliders = Slider::where('slider_type_id', 9)->where('status',1);
            if ($homeSliders->exists()) {
                $homeSliders->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->get('title') . '%');
                });
                $homeSliders = $homeSliders->get();
                return $this->success($homeSliders);
            } else {
                return $this->errorOk('Slider Data is not available!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $th->getMessage());
        }
    }

    public function doctorRegistrationCertificate(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        try {
            $document = $request->file('file');
            $img = $this->uploadFile($document, "doctorDocument")->getFilePath();
            $filename = $document->getClientOriginalName();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            Media::create([
                'type' => 'Doctor',
                'type_id' => auth()->id(),
                'file_name' => $filename,
                'path' => $img,
                'extension' => $extension,
                'file_type' => "Document",
            ]);

            auth()->user()->update([
                'verify_doc_status' => 'pending'
            ]);

            return $this->successMessage('Your registration completed successfully !');
        } catch (\Exception $e) {

            return $this->error("Something went wrong." . $e->getMessage());
        }
    }

    public function userEnquiry(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required',
        ]);
        try {

            $enquiry = UserEnquiry::create([
                'name' => $request->name,
                'type_value' => $request->number,
                'subject' => $request->message,
            ]);

            $admin = User::where('id', 2)->first();
            if($admin && $admin != null){
                pushSMSNotification($admin->phone, "Dear" . $admin->name . " there is a new enquiry from" . $request->name .
                    "Reference id: #ENQID". $enquiry->id .
                    "From:" . $request->name .
                    "Summary:" . $request->message
                );
            }

            if(auth()->user() && auth()->user()->fcm_token && auth()->user()->fcm_token != null){
                $this->fcm()
                    ->setTokens([auth()->user()->fcm_token])
                    ->setTitle(config('app.name'))
                    ->setBody("Your enquiry has been submitted successfully.")
                    ->send();
            }

            return $this->successMessage('Thanks for contacting us! A member of our team will get in touch with you shortly');
        } catch (\Exception | \Error $e) {
            return $this->error("Something went wrong." . $e->getMessage());
        }
    }

    public function getPatient($patientId)
    {
        try{
            $user = User::where('id', $patientId)->first();
            $user['pri_dr_note'] = json_decode($user->pri_dr_note);
            $subscription = UserSubscription::where('user_id', $patientId);
            $user['followup'] = FollowUp::where('doctor_id', $patientId)->whereDate('created_at', \Carbon\Carbon::today())->count();

            if ($subscription->exists()) {
                $user['subscription'] = $subscription->latest()->first();
            } else {
                $user['subscription'] = null;
            }
            return $this->success($user);
        } catch (\Exception | \Error $e){
            return $this->errorOk('Something went wrong!');
        }
    }

}



