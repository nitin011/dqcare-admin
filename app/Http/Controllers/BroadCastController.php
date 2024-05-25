<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class BroadCastController extends Controller
{

// public function index1(Request $request){
  
//     try {
//         // return $request->get('nofification_user');
//         $fcmTokens = User::when($request->has('nofification_user') && !is_null($request->get('nofification_user')), function ($q) use ($request){
//             if($request->get('nofification_user') != 'both'){
//                 $q->role(ucfirst($request->get('nofification_user')));
//                 //user selected
//                 // if($request->get('nofification_user')=='user'){
//                 //       if($request->get('user_selected') !== null){
//                 //           $q->whereIn('id',$request->user_selected);
//                 //       }else{
//                 //         $q->role(ucfirst($request->get('nofification_user')));
//                 //       }
//                 // }
//                 // //doctor selected
//                 // if($request->get('nofification_user')=='doctor'){
//                 //     if($request->get('doctor_selected') !== null){
//                 //         $q->whereIn('id',$request->doctor_selected);
//                 //     }else{
//                 //       $q->role(ucfirst($request->get('nofification_user')));
//                 //     }
//                 // }
                
//             }
//         })->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

//         // return $fcmTokens;
       
        
//         $this->fcm()
//             ->setTitle('Health Details')
//             ->setBody($request->get('brodcast'))
//             ->setTokens($fcmTokens)
//             // ->addData([
//             //     'type' => 'notification',
//             //     'action' => 'room',
//             //     'actionable_id' => $room_id,
//             //     'visible' => 1,
//             // ])
//             ->send();
//             return redirect()->back()->with('success','Successfully notify to the users!');
//         }catch(\Exception $e){ 
//             return back()->with('error', 'Error: ' . $e->getMessage());
//             //throw $th;
//         }
//     }


    public function index(Request $request){
        try {
            $fcmTokens = User::when($request->has('nofification_user') && !is_null($request->get('nofification_user')), function ($q) use ($request){
                // user selected
                if($request->get('nofification_user')=='user'){
                      if($request->get('user_selected') !== null){
                          $q->whereIn('id',$request->user_selected);
                      }else{
                        $q->role(ucfirst($request->get('nofification_user')));
                      }
                }

                //doctor selected
                if($request->get('nofification_user')=='doctor'){
                    if($request->get('doctor_selected') !== null){
                        $q->whereIn('id',$request->doctor_selected);
                    }else{
                      $q->role(ucfirst($request->get('nofification_user')));
                    }
                }
                // if($request->get('nofification_user') != 'both'){
                //     $q->role(ucfirst($request->get('nofification_user')));
                // }
            })->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
           
            if($request->get('nofification_user') == 'doctor'){
                $this->fcm()
                ->setTitle(config('app.name'))
                ->setBody($request->get('brodcast'))
                ->setTokens($fcmTokens)
                ->send();
            }elseif($request->get('nofification_user') == 'user'){
                $this->fcm()
                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                ->setTokens($fcmTokens)
                ->setTitle(config('app.name'))
                ->setBody($request->get('brodcast'))
                ->send();
            }else{

                $this->fcm()
                ->setTitle(config('app.name'))
                ->setBody($request->get('brodcast'))
                ->setTokens($fcmTokens)
                ->send();

                $this->fcm()
                ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                ->setTokens($fcmTokens)
                ->setTitle(config('app.name'))
                ->setBody($request->get('brodcast'))
                ->send();
            }
           
            
                return redirect()->back()->with('success','Successfully notify to the users!');

            } catch (\Exception | \Error $e) {
                // throw $th;
                return back()->with('error', 'Error: ' . $e->getMessage());
            }
        }
    
}

// ALTER TABLE `users` ADD `fcm_token` TEXT NULL AFTER `relation`;
