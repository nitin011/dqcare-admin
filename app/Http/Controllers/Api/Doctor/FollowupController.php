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
use App\Traits\CanSendFCMNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Models\FollowUp;
use App\User;
use App\Models\Scanlog;

class FollowupController extends Controller
{
    use CanSendFCMNotification;

    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }


    public function followupIndex(Request $request,$id = null)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $followUps = FollowUp::query();
            if($request->get('search')){
                $followUps->whereHas('user',function($q){
                    $q->where('first_name','like', '%'.request()->get('search').'%');
                });
            }

            if($request->has('status')){
                $ids = [0,1];
                if($request->has('status') && $request->get('status') == 3){
                    $followUps->whereIn('status', $ids);
                }else{
                    $followUps->where('status',$request->get('status'));
                }
            }

            if($request->get('from') && $request->get('to')){
                // $followUps->whereBetween('created_at',[$request->get('from'),$request->get('to')]);
                $followUps->whereDate('date', '>=', $request->get('from'))
                    ->whereDate('date', '<=', $request->get('to'));
            }

            if($request->has('patient_id') && $request->get('patient_id') != "0"){
                $followUps->where('user_id', $request->get('patient_id'));
            }

            if($id == null){
                $followUps =  $followUps->with(['user'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
                },'doctor'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
                }])->where('doctor_id',auth()->id())->orderBy('date', 'DESC')->limit($limit)
                ->offset(($page - 1) * $limit)->get();
            }else{
                $followUps =  $followUps->with(['user'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
                },'doctor'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
                }])->where('user_id',$id)->where('doctor_id', auth()->user()->id)->orderBy('date', 'DESC')->limit($limit)
                ->offset(($page - 1) * $limit)->get();
            }

            return $this->success($followUps);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function followupCreate(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        try {
            FollowUp::create([
                'user_id' => $request->user_id,
                'doctor_id' => auth()->id(),
                'remark' => $request->remark,
                'status' => 0,
                'date' => $request->date,
            ]);

            $user = User::where('id', $request->user_id)->first();
            $doctor = User::where('id', auth()->user()->id)->first();
            $this->fcm()
                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                ->setTokens([$user->fcm_token])
                ->setTitle(config('app.name'))
                ->setBody('You have next followup with '. $doctor->salutation. ' ' .$doctor->first_name.' '.$doctor->last_name . ' on ' . Carbon::parse($request->date)->format('d M, Y'))
                ->send(); 

            return $this->successMessage('Followup Create Successfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function followupView(Request $request,$id)
    {
        try {
            $followUp = FollowUp::whereId($id)->with(['user'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
             },'doctor'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name','phone','email','gender');
             }])->first();
             if($followUp){
                 return $this->success($followUp);
            }else{
                return $this->errorOk('This record is not exist!');
             }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
    public function followupDelete(Request $request,$id)
    {
        try {
            $followUp = FollowUp::whereId($id)->first();
             if($followUp){
                $followUp->delete();
                return $this->successMessage('Followup Deleted Successfully!');
            }else{
                return $this->errorOk('This record is not exist!');
             }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
    public function followupUpdate(Request $request,FollowUp $followUp)
    {
        try {
            $request->validate([
                'user_id' => 'required',
            ]);

                $followUp->update([
                    'user_id' => $request->user_id,
                    'doctor_id' => auth()->id(),
                    'remark' => $request->remark,
                    'date' => $request->date,
                ]);

            return $this->successMessage('followup update succesfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
    public function patientUpdate(Request $request)
    {
        // return 's';
        // Try
        try {
           //response
        return $this->successMessage('patientUpdate succesfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
    public function doctorProfile(Request $request)
    {
        // return 's';
        // Try
        try {
           //response
        return $this->successMessage('doctorProfile show succesfully!');
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try{
            FollowUp::where('id', $id)->update([
                'status' => $request->get('status'),
            ]);
            return  $this->successMessage('Follow UP updated.');
        } catch (\Exception | \Error $e){
            return $this->errorOk('Something went wrong! '. $e->getMessage());
        }
    }

}

