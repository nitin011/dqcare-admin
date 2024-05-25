<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\AccessDoctor;
use App\User;
use Carbon\Carbon;

class AvailabilityController extends Controller
{
    public function index(Request $request,$id){
         $access_doctor = AccessDoctor::where('doctor_id',$id)->first();
        //  $doctor = AccessDoctor::where('user_id',$id)->where('id',$id)->first(); 
        $doctor_data = User::where('id',$id)->first();
        return view('backend.doctor-schedule.index',compact('access_doctor','doctor_data','id'));
    }

    public function store(Request $request,$id){
       
        // return $request->all();
        $request->validate([
            'from_time' => 'required' 
        ]);
        // return $id;
        $availability = Availability::where('user_id', $id)
        ->where('day', strtolower($request->get('day')))
        ->first();
        
        $payloadNew = [
            "from" => Carbon::parse($request->get('from_time'))->format("H:i"),
            "to" => Carbon::parse($request->get('to_time'))->format("H:i"),
        ];
        
        if ($availability) {
            foreach ($availability->schedules as $schedule) {
                // if (strtotime($schedule->from) < strtotime($payloadNew['from'])
                //     &&
                //     strtotime($schedule->to) > strtotime($payloadNew['from'])
                //     ) {
                //         return back()->with('error', 'This time slot is already acquired, Please choose another time slot');
                //     }
                }
                $payloadArr = $availability->schedules;
                array_push($payloadArr, $payloadNew);
                $availability->schedules = $payloadArr;
                $availability->save();
            } else {
                Availability::create([
                    "user_id" => $id,
                    "day" => $request->get('day'),
                    "schedules" => [$payloadNew],
                ]);
            }

     return back()->with('success', 'Schedule updated successfully!');

}
   
    public function destroy(Request $request)
    {
        // return $request->all();
        $availability = Availability::where('user_id', $request->id)->where('day', '=', $request->get('day'))->first();
        $payload = $availability->schedules;
        array_splice($payload, $request->get('index'), 1);
        $availability->schedules = $payload;
        $availability->save();
       
        return back()->with('success', 'Scheduled deleted successfully!');
    }
}

