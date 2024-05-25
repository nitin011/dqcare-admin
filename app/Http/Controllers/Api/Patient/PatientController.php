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

namespace App\Http\Controllers\Api\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Slider;
use App\Models\FollowUp;
use App\Models\PatientFile;
use App\Models\UserSubscription;
use App\Models\Category;
use App\User;
use App\Models\Scanlog;
use App\Models\WalletLog;

class PatientController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function patientHome(Request $request)
    {
        try {
            $homeSliders['first_slider'] = Slider::where('slider_type_id', 7)->where('status',1)->get();
            $homeSliders['second_slider'] = Slider::where('slider_type_id', 8)->where('status',1)->get();
            $user = User::whereId(auth()->id())->first();
            $userSubs = UserSubscription::where('user_id', auth()->id())->latest()->first();
            
            if($userSubs) {
                if ($user && $userSubs->subscription_id == 1) {
                    if ($userSubs->to_date > now() && $userSubs->subscription_id == 1) {
                        $userSubs['subscription_status_trial'] = 'Trial';
                    } elseif ($userSubs->to_date < now()) {
                        $userSubs['subscription_status_trial'] = 'Expired';
                    } else {
                        $userSubs['subscription_status_trial'] = 'Upgrade';
                    }
                }
                if ($user && $userSubs->subscription_id != 1) {
                    if ($userSubs->to_date > now() && $userSubs->subscription_id != 1) {
                        $userSubs['subscription_status_paid'] = 'Paid';
                    } elseif ($userSubs->to_date < now() && $userSubs->subscription_id != 1) {
                        $userSubs['subscription_status_paid'] = 'Expired';
                    } else {
                        $userSubs['subscription_status_paid'] = 'Renew';
                    }
                }
                if ($user && $userSubs->subscription_id != 1) {
                    if ($userSubs->parent_id == auth()->id() || $userSubs->user_id == auth()->id()) {
                        $userSubs['unlink_user'] = 'Unlink';
                    }
                }
            }
            return $this->success(['sliders' => $homeSliders, 'user_subscription' => $userSubs]);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientSecondHomeSlider(Request $request)
    {
        try {
            $homeSliders = Slider::where('slider_type_id', 8)->where('status',1);
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


    public function myFollowup(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $myFollowups = FollowUp::where('user_id', auth()->id())->with('doctor')->latest()->limit($limit)
                ->offset(($page - 1) * $limit);
            if ($myFollowups->exists()) {
                $myFollowups = $myFollowups->get();
                return $this->success($myFollowups);
            } else {
                return $this->errorOk('No Followup available yet!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function doctorLists(Request $request)
    {
        try {
            $doctors = User::query();
            if ($request->get('state')) {
                $doctors->where('state', 'like', '%' . request()->get('state') . '%');
            }
            if ($request->get('city')) {
                $doctors->where('city', 'like', '%' . request()->get('city') . '%');
            }
            if ($request->get('pincode')) {
                $doctors->where('pincode', 'like', '%' . request()->get('pincode') . '%');
            }
            $doctors = $doctors->select('id', 'first_name', 'last_name', 'avatar', 'address', 'pincode', 'country', 'state', 'city','is_verified','salutation')->with(['countryData' => function ($q) {
                $q->select('id', 'name');
            }, 'stateData' => function ($q) {
                $q->select('id', 'name');
            }, 'cityData' => function ($q) {
                $q->select('id', 'name');
            }])
                ->where('is_verified', 1)
                ->role('Doctor')->latest()
                ->paginated()
                ->get();
            foreach ($doctors as $key => $doctor) {
                $doctor->is_primary = $doctor->id == User::whereId(auth()->id())->value('doctor_id');
            }
            $data['doctors'] = $doctors;
            if ($data) {
                return $this->success($data);
            } else {
                return $this->errorOk('Doctor Data not found!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function uploadDocument(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);
        try {
            $category = Category::where('id', $request->category_id)->exists();
            if ($category) {
                foreach ($request->file('file') as $patientfile) {
                    $file = $this->uploadFile($patientfile, "patient_files")->getFilePath();
                    PatientFile::create([
                        'file' => $file,
                        'date' => null,
                        'category_id' => $request->category_id,
                        'user_id' => auth()->id(),
                    ]);
                }
                return $this->successMessage('The document was successfully uploaded!');
            } else {
                return $this->errorOk('You need to select any one these categories before uploading!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function uploadDocumentList(Request $request)
    {
        try {
            $category = Category::where('category_type_id', 16);
            if ($category->exists()) {
                $category = $category->select('id', 'name')->get();
                return $this->success($category);
            } else {
                return $this->errorOk('This category id does\'t exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Something went wrong.");
        }
    }

    public function patientUpdate(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
        ]);
        try {
            $user = User::whereId(auth()->id())->first();
            if ($user) {
                if ($request->file('avatar')) {
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
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'pincode' => $request->pincode,
                    'dob' => $request->dob,
                    'height' => $request->height,
                    'weight' => $request->weight,
                    'state' => $request->state,
                    'city' => $request->city,
                    'avatar' => $imageName,
                ]);
                return $this->successMessage('Patient Profile Updated Successfully!');
            } else {
                return $this->errorOk('You can\'t update this Patient profile!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }
    public function getRelation(Request $request)
    {
        try {
            $categories = Category::where('category_type_id', 18);
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
    
    public function rewards(Request $request)
    {
        try {
            $dateArr = [];
            $monthArr = [];
            $monthNamesArr = [];
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
                
                $scans_reward = WalletLog::where('user_id', auth()->id())
                    ->whereIn('model', ['UploadBonus', 'ScanBonus'])
                    ->whereMonth('created_at', \Carbon\Carbon::parse($dateArr[$key] . "-01")->format('m'))->whereYear('created_at', date('Y'))->get(['id', 'amount']);

              $data[] = [
                    'month' => $monthIntArray[$key],
                    'month_name' => $value,
                    'year' => $dateYear[$key],
                    'points' => $scans_reward->sum('amount'),
                ];
            }
            $data = collect($data)->sortByDesc('month')->sortByDesc('year')->toArray();


            $dd = [];
            foreach ($data as $d) {
                $dd[] = $d;
            }

            return $this->success($dd);
        } catch (\Exception $e) {
            return $this->error("Something went wrong." . $e);
        }
    }

}
