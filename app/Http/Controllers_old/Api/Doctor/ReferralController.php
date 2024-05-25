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
use Auth;
use App\Models\DoctorReferral;
use App\User;

class ReferralController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function referralIndex(Request $request,$id = null)
    {
        // try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $doctorReferrals = DoctorReferral::query();

            if ($request->has('party_name') && $request->get('party_name')) {
                $doctorReferrals->where('party_name', $request->get('party_name'));
            }

            if ($request->has('from') && $request->has('to') && $request->get('from') && $request->get('to')) {
                $doctorReferrals->whereDate('date', '>=', $request->get('from'))
                    ->whereDate('date', '<=', $request->get('to'));
            }
            $month = \Carbon\Carbon::now()->format('M');
            if($id == null){
                
                $doctorReferrals = $doctorReferrals->where('doctor_id', auth()->id())
                    ->with(['user' => function ($q) {
                        $q->select('id', 'avatar', 'first_name', 'last_name');
                    }])
                    ->latest()
                    ->limit($limit)
                    ->offset(($page - 1) * $limit)
                    ->get();
                    // $date = now();
                    // $doctorReferrals['now'] = $doctorReferrals->whereDate('created_at',$date);
                    
                    $jan['month'] = '01';
                    $jan['month_label'] = "Jan";
                    $jan['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','01')->count();
                    
                    $feb['month'] = '02';
                    $feb['month_label'] = "Feb";
                    $feb['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','02')->count();
                    
                    $mar['month'] = '03';
                    $mar['month_label'] = "Mar";
                    $mar['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','03')->count();
                    
                    $apr['month'] = '04';
                    $apr['month_label'] = "Apr";
                        $apr['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','04')->count();
                    
                    $may['month'] = '05';
                    $may['month_label'] = "May";
                        $may['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','05')->count();
                    
                    $jun['month'] = '06';
                    $jun['month_label'] = "Jun";
                        $jun['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','06')->count();
                    
                    $jul['month'] = '07';
                    $jul['month_label'] = "Jul";
                        $jul['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','07')->count();
                    
                    $aug['month'] = '08';
                    $aug['month_label'] = "Aug";
                        $aug['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','08')->count();
                    
                    $sep['month'] = '09';
                    $sep['month_label'] = "Sep";
                    $sep['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','09')->count();
                    
                    $oct['month'] = '10';
                    $oct['month_label'] = "Oct";
                    $oct['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','10')->count();
                    
                    $nov['month'] = '11';
                    $nov['month_label'] = "Nov";
                    $nov['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','11')->count();
                    
                    $dec['month'] = '12';
                    $dec['month_label'] = "Dec";
                    $dec['count'] = DoctorReferral::where('doctor_id', auth()->user()->id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','12')->count();
                }else{
                    $doctorReferrals = DoctorReferral::where('user_id', $id)
                        ->with(['user' => function ($q) {
                            $q->select('id', 'avatar', 'first_name', 'last_name');
                        }])
                        ->where('doctor_id', auth()->user()->id)
                        ->latest()
                        ->limit($limit)
                        ->offset(($page - 1) * $limit)
                    ->get();
                    
                   
                   $jan['month'] = '01';
                    $jan['month_label'] = "Jan";
                    $jan['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','01')->count();
                    
                    $feb['month'] = '02';
                    $feb['month_label'] = "Feb";
                    $feb['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','02')->count();
                    
                    $mar['month'] = '03';
                    $mar['month_label'] = "Mar";
                    $mar['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','03')->count();
                    
                    $apr['month'] = '04';
                    $apr['month_label'] = "Apr";
                        $apr['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','04')->count();
                    
                    $may['month'] = '05';
                    $may['month_label'] = "May";
                        $may['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','05')->count();
                    
                    $jun['month'] = '06';
                    $jun['month_label'] = "Jun";
                        $jun['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','06')->count();
                    
                    $jul['month'] = '07';
                    $jul['month_label'] = "Jul";
                        $jul['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','07')->count();
                    
                    $aug['month'] = '08';
                    $aug['month_label'] = "Aug";
                        $aug['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','08')->count();
                    
                    $sep['month'] = '09';
                    $sep['month_label'] = "Sep";
                    $sep['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','09')->count();
                    
                    $oct['month'] = 10;
                    $oct['month_label'] = "Oct";
                    $oct['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','10')->count();
                    
                    $nov['month'] = 11;
                    $nov['month_label'] = "Nov";
                    $nov['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','11')->count();
                    
                    $dec['month'] = 12;
                    $dec['month_label'] = "Dec";
                    $dec['count'] = DoctorReferral::where('doctor_id', $id)
                    ->whereYear('date',\Carbon\Carbon::now()->format('Y'))->whereMonth('date','12')->count();
                }

            //response
            return $this->success([
                'doctor_referrals'=>$doctorReferrals,
                'jan'=>$jan,
                'feb'=>$feb,
                'mar'=>$mar,
                'apr'=>$apr,
                'may'=>$may,
                'jun'=>$jun,
                'jul'=>$jul,
                'aug'=>$aug,
                'sep'=>$sep,
                'oct'=>$oct,
                'nov'=>$nov,
                'dec'=>$dec,
            ]);
        // } catch (\Exception $th) {
        //     return $this->error("Sorry! Failed to data! " . $th->getMessage());
        // }
    }

    public function referralCreate(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'party_name' => 'required',
            'date' => 'required|date',
        ]);
        // Try
        try {
            $user = User::where('id', $request->user_id)->exists();
            if ($user) {
                $doctorReferral = DoctorReferral::create([
                    'party_name' => $request->party_name,
                    'remark' => $request->remark,
                    'date' => $request->date,
                    'user_id' => $request->user_id,
                    'doctor_id' => auth()->id(),
                ]);

                return $this->successMessage('Referral created successfully!');
            } else {
                return $this->errorOk('This User is not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

    public function referralUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'party_name' => 'required',
            'remark' => 'required',
            'date' => 'required|date',
        ]);
        try {
            $referral = DoctorReferral::whereId($id)->first();
            $user = User::where('id', $request->user_id)->exists();
            if ($user) {
                if ($referral) {
                    $referral->update([
                        'party_name' => $request->party_name,
                        'remark' => $request->remark,
                        'date' => $request->date,
                        'user_id' => $request->date,
                    ]);
                    return $this->successMessage('Referral Updated succesfully!');
                } else {
                    return $this->errorOk('This Record is not exist!');
                }
            } else {
                return $this->errorOk('This User is not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }
    public function referralDelete(Request $request, $id)
    {
        try {
            $referral = DoctorReferral::whereId($id)->first();
            if ($referral) {
                $referral->delete();
                return $this->successMessage('Referral Deleted succesfully!');
            } else {
                return $this->errorOk('This Referral Record is not exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }

}
