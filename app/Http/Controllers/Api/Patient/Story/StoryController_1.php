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

namespace App\Http\Controllers\Api\patient\story;

use App\Http\Controllers\Controller;
use App\Traits\CanSendFCMNotification;
use Illuminate\Http\Request;
use App\User;
use App\Models\UserSubscription;
use App\Models\Story;
use App\Models\PatientFile;
use Auth;
use Carbon\Carbon;

class StoryController extends Controller
{
    use CanSendFCMNotification;
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function storyIndex(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $stories = Story::query();
            if ($request->has('from') && $request->has('to') && $request->get('from') && $request->get('to')) {
                $stories->whereBetween('created_at', [$request->get('from'), $request->get('to')]);
            }

            $stories = $stories->with(['user' => function ($q) {
                $q->select('id', 'gender', 'first_name', 'phone', 'avatar', 'dob','updated_at');
            }, 'createdBy' => function ($q) {
                $q->select('id', 'first_name','updated_at');
            }])->where('user_id', auth()->id())->where('type', 1)->latest()->limit($limit)
                ->offset(($page - 1) * $limit)->first();
            if ($stories) {

                $stories['detail'] = json_decode($stories['detail']);
                $stories['chart'] = json_decode($stories['chart']);

                return $this->success($stories);
            }
            return $this->success([]);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function mySummaryIndex(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $stories = Story::select('id', 'user_id', 'date', 'name', 'age', 'dob', 'detail', 'is_organize', 'type', 'created_at','updated_at','remark')->with(['user' => function ($q) {
                $q->select('id', 'gender', 'first_name', 'phone', 'avatar', 'dob','updated_at');
            }])->where('user_id', auth()->id())->where('type', 1)->latest()->limit($limit)
                ->offset(($page - 1) * $limit)->first();
            if ($stories) $stories['detail'] = json_decode($stories['detail']);
            return $this->success($stories);

        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function myJourneyIndex(Request $request)
    {
        try {
            $stories = Story::where('user_id', auth()->id())->where('type', 1)->latest()->first();
            return $this->success($stories);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function myBloodReport(Request $request)
    {
        try {
            $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
            $charts = json_decode($stories['chart']);
            $stories['blood'] = $charts->blood;
            return $this->success($charts->blood);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function myChartIndex(Request $request,$id = null)
    {
        try {
            if($id == null){
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
            }else{
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
            }
            if ($stories) $stories['chart'] = json_decode($stories['chart']);
            return $this->success($stories);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function myInsite(Request $request, $id = null)
    {
        
        try {
            $year = now()->format('Y');
            if ($id == null) {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
            } else {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
            }
            if ($stories) {
                $stories['chart'] = json_decode($stories['chart']);
                $insights = [];

                foreach ($stories['chart'] as $key => $value) {
                    $insights[$key]['Jan'] = 0;
                    $insights[$key]['Feb'] = 0;
                    $insights[$key]['Mar'] = 0;
                    $insights[$key]['Apr'] = 0;
                    $insights[$key]['May'] = 0;
                    $insights[$key]['Jun'] = 0;
                    $insights[$key]['Jul'] = 0;
                    $insights[$key]['Aug'] = 0;
                    $insights[$key]['Sep'] = 0;
                    $insights[$key]['Oct'] = 0;
                    $insights[$key]['Nov'] = 0;
                    $insights[$key]['Dec'] = 0;
                }

                foreach ($stories['chart'] as $key => $value) {
                    foreach ($value as $child_value) {
                        if (isset($child_value->date) && \Carbon\Carbon::parse($child_value->date)->format('Y') == $year) {
                            $m = \Carbon\Carbon::parse($child_value->date)->format('M');
                            $insights[$key][$m] += 1;
                        }
                    }

                }

                return $this->success($insights);
            } else {
                return $this->errorOk('Chart data is not found!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function insiteChart(Request $request, $id = null)
    {
        try {
            $year = now()->format('Y');
            if ($id != null) {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
            } else {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
            }
            if ($stories) {
                $chartBlood = $stories['chart'] != null ? json_decode($stories['chart'])->blood : null;
                $chartLiver = $stories['chart'] != null ?  json_decode($stories['chart'])->liver : null;
                $chartKidney = $stories['chart'] != null ? json_decode($stories['chart'])->kidney : null;
                $chartLipid = $stories['chart'] != null ? json_decode($stories['chart'])->lipid : null;
                $chartThyroid = $stories['chart'] != null ? json_decode($stories['chart'])->thyroid : null;
                $chartDiabetes = $stories['chart'] != null ? json_decode($stories['chart'])->diabetes : null;
                $chartUrineTest = $stories['chart'] != null ? json_decode($stories['chart'])->urineTest : null;
                $blood = [];
                $liver = [];
                $kidney = [];
                $lipid = [];
                $thyroid = [];
                $diabetes = [];
                $urineTest = [];
                $chart = null;


                $d = [];
                if ($chartLiver != null) {
                    $dates = collect($chartLiver)->pluck('date');
                    foreach ($dates as $key => $date) {
                        foreach ($chartLiver[0] as $j => $liverItem) {
                            
                            if ($j != 'date') {
                                $liver[$j][$date] = collect($chartLiver)->pluck($j)[$key] ?? 0;
                            } else {
                                $liver[$j][$date] = [];
                            }
                        }
                    }
                    
                    $liverData = [];
                    foreach ($liver as $key => $val) {
                         foreach($val as $index => $value){
                            if($value != 0){
                                if ($key !== 'date') {
                                    $liverData[$key][$index] = $value;
                                }
                            }
                        }
                   
                    }
                    $liverData = count($liverData) <= 0 ? null : $liverData;
                    $chart[] = ['name' => 'liver', 'items' => $liverData];
                }

                if ($chartBlood != null) {
                    $dates = collect($chartBlood)->pluck('date');
                    foreach ($dates as $key => $date) {
                            foreach ($chartBlood[0] as $j => $bloodItem) {
                                
                                if ($j != 'date') {
                                    $blood[$j][$date] = collect($chartBlood)->pluck($j)[$key] ?? 0;
                                } else {
                                    $blood[$j][$date] = [];
                                }
                            }
                        }
                    $bloodData = [];
                    foreach ($blood as $key => $val) {
                        foreach($val as $index => $value){
                            if($value != 0){
                                if ($key !== 'date') {
                                    $bloodData[$key][$index] = $value;
                                }
                            }
                        }
                    }
                    $bloodData = count($bloodData) <= 0 ? null : $bloodData;
                    $chart[] = ['name' => 'blood', 'items' => $bloodData];
                } 

                if ($chartKidney != null) {
                    $dates = collect($chartKidney)->pluck('date');
                    foreach ($dates as $key => $date) {
                        foreach ($chartKidney[0] as $j => $kidneyItems) {
                            
                            if ($j != 'date') {
                                $kidney[$j][$date] = collect($chartKidney)->pluck($j)[$key] ?? 0;
                            } else {
                                $kidney[$j][$date] = [];
                            }
                        }
                    }
                    $kidneyData = [];
                    foreach ($kidney as $key => $val) {
                         foreach($val as $index => $value){
                            if($value != 0){
                                if ($key !== 'date') {
                                   $kidneyData[$key][$index] = $value;
                                }
                            }
                        }
                    }
                    $kidneyData = count($kidneyData) <= 0 ? null : $kidneyData;
                    $chart[] = ['name' => 'kidney', 'items' => $kidneyData];
                }

                if ($chartLipid != null) {
                    $dates = collect($chartLipid)->pluck('date');
                     foreach ($dates as $key => $date) {
                        foreach ($chartLipid[0] as $j => $lipidItems) {
                            
                            if ($j != 'date') {
                                $lipid[$j][$date] = collect($chartLipid)->pluck($j)[$key] ?? 0;
                            } else {
                                $lipid[$j][$date] = [];
                            }
                        }
                    }
                    $lipidData = [];
                    foreach ($lipid as $key => $val) {
                        foreach($val as $index => $value){
                            if($value != 0){
                                if ($key !== 'date') {
                                  $lipidData[$key][$index] = $value;
                                }
                            }
                        }
                        
                         
                    }
                    $lipidData = count($lipidData) <= 0 ? null : $lipidData;
                    $chart[] = ['name' => 'lipid', 'items' => $lipidData];
                }

                if ($chartThyroid != null) {
                    $dates = collect($chartThyroid)->pluck('date');
                    foreach ($dates as $key => $date) {
                        foreach ($chartThyroid[0] as $j => $thyroidItems) {
                            
                            if ($j != 'date') {
                                $thyroid[$j][$date] = collect($chartThyroid)->pluck($j)[$key] ?? 0;
                            } else {
                                $thyroid[$j][$date] = [];
                            }
                        }
                    }
                    $thyroidData = [];
                    foreach ($thyroid as $key => $val) {
                        foreach($val as $index => $value){
                            
                            if($value != 0){
                                if ($key !== 'date') {
                                   $thyroidData[$key][$index] = $value;
                                }
                            }
                        }
                        
                    }
                    $thyroidData = count($thyroidData) <= 0 ? null : $thyroidData;
                    $chart[] = ['name' => 'thyroid', 'items' => $thyroidData];
                }
                if ($chartDiabetes != null) {
                    $dates = collect($chartDiabetes)->pluck('date');
                    foreach ($dates as $key => $date) {
                        foreach ($chartDiabetes[0] as $j => $diabetesItems) {
                            
                            if ($j != 'date') {
                                $diabetes[$j][$date] = collect($chartDiabetes)->pluck($j)[$key] ?? 0;
                            } else {
                                $diabetes[$j][$date] = [];
                            }
                        }
                    }
                    $diabetesData = [];
                    foreach ($diabetes as $key => $val) {
                        foreach($val as $index => $value){
                            if($value != 0){
                                if ($key !== 'date') {
                                   $diabetesData[$key][$index] = $value;
                                }
                            }
                        }
                       
                    }
                    $diabetesData = count($diabetesData) <= 0 ? null : $diabetesData;
                    $chart[] = ['name' => 'diabetes', 'items' => $diabetesData];
                }
                return $this->success(['has_story' => $stories != null,'updated_at' => $stories->updated_at, 'chart' => $chart]);
            } else {
                return $this->success([]);
            }
        } catch (\Exception | \Error $e) {
            return $this->error("Sorry! Failed to data! " . $e);
        }
    }

    public function insiteChartone(Request $request, $id = null){
            try{
                $year = now()->format('Y');
                if ($id != null) {
                    $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
                } else {
                    $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at','remark')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
                }
                if($stories){
                    $chartBlood = $stories['chart'] != null ? json_decode($stories['chart'])->blood : null;
                    $chartLiver = $stories['chart'] != null ?  json_decode($stories['chart'])->liver : null;
                    $chartKidney = $stories['chart'] != null ? json_decode($stories['chart'])->kidney : null;
                    $chartLipid = $stories['chart'] != null ? json_decode($stories['chart'])->lipid : null;
                    $chartThyroid = $stories['chart'] != null ? json_decode($stories['chart'])->thyroid : null;
                    $chartDiabetes = $stories['chart'] != null ? json_decode($stories['chart'])->diabetes : null;
                    $chartUrineTest = $stories['chart'] != null ? json_decode($stories['chart'])->urineTest : null;
                    $blood = [];
                    $liver = [];
                    $kidney = [];
                    $lipid = [];
                    $thyroid = [];
                    $diabetes = [];
                    $urineTest = [];
                    $chart = null; 

                    $d = [];

                    if ($chartBlood != null) {
                        foreach ($chartBlood as $i => $bloodItems) {
                            if ($bloodItems->date == null || trim($bloodItems->date) == '') {
                                continue;
                            }
                            foreach ($bloodItems as $j => $bloodItem) {
                                return $j->$bloodItem;
                                $blood[$j] = $bloodItem ?? 0;
                            }
    
                        }
                       return $chart[] = ['name' => 'blood', 'items' => $blood];
                    }
                }
            }catch (\Exception | \Error $e) {
                return $this->error("Sorry! Failed to data! " . $e);
            }
    }


    public function storyOrganizeRequest(Request $request)
    {
        try {
            //response
            $storyRecord = Story::where('user_id', auth()->id())->where('type', 1)->first();  //LIVE
            $storyDev = Story::where('user_id', auth()->id())->where('type', 0)->first(); // DEV
            $patientFile = PatientFile::where('user_id', auth()->id())->latest()->first(); // DEV
            //check user subscription
            if(isset($storyRecord) && $storyRecord && $storyRecord->updated_at != null){
                if((\Carbon\Carbon::parse($storyRecord->created_at)) >= (\Carbon\Carbon::parse($patientFile->created_at))){
                    return $this->errorOk('You can not perform this action as there are no new documents uploaded. Your story is up to date.');
                }
            }
            if(isset($storyRecord) && $storyRecord && $storyRecord->updated_at){
                if((\Carbon\Carbon::parse($storyRecord->updated_at)) >= (\Carbon\Carbon::parse($patientFile->created_at))){
                    return $this->errorOk('You can not perform this action as there are not new document uploaded. Your story is up to date.');
                }
            }
            //check user subscription
            $userSubs = UserSubscription::where('user_id', auth()->id());
            //    if($user){
            if ($userSubs->latest()->exists()) {
                if ($userSubs->where('to_date', '>=', now())->latest()->first()) {
                    if (!$storyRecord) {
                        Story::create([
                            'user_id' => auth()->id(),
                            'date' => now(),
                            'dob' => auth()->user()->dob,
                            'age' => Carbon::parse(auth()->user()->dob)->age,
                            'status' => 0,
                            'type' => 0,
                            'is_organize' => 0,
                        ]);
                        Story::create([
                            'user_id' => auth()->id(),
                            'date' => now(),
                            'dob' => auth()->user()->dob,
                            'age' => Carbon::parse(auth()->user()->dob)->age,
                            'status' => 2,
                            'type' => 1,
                            'is_organize' => 0,
                        ]);
                        $this->fcm()
                            ->setTokens([auth()->user()->fcm_token])
                            ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                            ->setTitle(config('app.name'))
                            ->setBody("Your organize my reports request has been taken. Our team of doctors will start analyzing and writing your story and deliver it to you shortly.")
                            ->send();
                        return $this->successMessage('Your request to organise reports submitted successfully.');
                    } else {
                        if($storyDev){
                            $storyDev->update([
                                'dob' => auth()->user()->dob,
                                'age' => Carbon::parse(auth()->user()->dob)->age,
                                'is_organize' => 0,
                            ]);
                            $this->fcm()
                                ->setTokens([auth()->user()->fcm_token])
                                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                                ->setTitle(config('app.name'))
                                ->setBody("Your organize my reports request has been taken. Our team of doctors will start analyzing and writing your story and deliver it to you shortly.")
                                ->send();
                        }
                        return $this->successMessage('Your request to organise reports submitted successfully.');
                    }
                } else {
                    $authName = NameById(auth()->user()->id);
                    $this->fcm()
                            ->setTokens([auth()->user()->fcm_token])
                            ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                            ->setTitle(config('app.name'))
                            ->setBody("Dear $authName your package is expiring soon please re-new it before <date of expiry> to continue using premium benefits.")
                            ->send();
                    return $this->errorOk('Your subscription has expired, please buy a new one!');
                }
            } else {
                return $this->errorOk('You don\'t have subscription to organize your report! Kindly subscribe');
            }
            //    }else{
            //        return $this->errorOk('This User is does\'t exists!');
            //    }
        } catch (\Exception | \Error $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientSummaryIndex(Request $request, $id)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $stories = Story::select('id', 'user_id', 'date', 'name', 'age', 'dob', 'detail', 'is_organize', 'type', 'created_at','remark')->with(['user' => function ($q) {
                $q->select('id', 'gender', 'first_name', 'phone', 'avatar', 'dob','updated_at');
            }])->where('user_id', $id)->where('type', 1)->latest()->first();
            if ($stories) {
                $stories['detail'] = json_decode($stories['detail']);
                return $this->success($stories);
            } else {
                return $this->success([]);
            }

        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientJourneyIndex(Request $request, $id)
    {
        try {
            $stories = Story::select('id', 'user_id', 'journey','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
            return $this->success($stories);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function patientChartIndex(Request $request, $id)
    {
        try {
            $stories = Story::select('id', 'user_id', 'chart','updated_at','remark')->where('user_id', $id)->where('type', 1)->latest()->first();
            if ($stories) $stories['chart'] = json_decode($stories['chart']);
            return $this->success($stories);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

}



