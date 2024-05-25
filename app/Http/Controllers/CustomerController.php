<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddres;
use App\User;
use App\Models\Notification;
use App\Models\UserKyc;
use App\Models\MailSmsTemplate;
use App\Models\Order;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return view('clear-cache');
    }
    public function account()
    {
        return view('frontend.customer.account');
    }
    public function orderIndex()
    {  
        $orders = Order::whereUserId(auth()->id())->get();
        return view('frontend.customer.order.index',compact('orders'));
    }
    public function address()
    {
        $user = auth()->user();
        return view('frontend.customer.address',compact('user'));
    }
    public function setting()
    {
        $addresses = UserAddres::whereUserId(auth()->id())->get();
        $user = auth()->user();
        // $user_kyc = UserKyc::whereUserId($user->id)->first();
        // if($user_kyc){
        //     $ekyc = json_decode($user_kyc->details,true) ?? 0;
        // }else{
        //     abort(404);
        // }
        return view('frontend.customer.setting',compact('addresses','user'));
    }
    public function notification()
    {
        $notifications = Notification::whereUserId(auth()->id())->paginate(5);
        return view('frontend.customer.notification',compact('notifications'));
    }
    public function invoice($id)
    {
        $order = Order::whereId($id)->first();
        return view('frontend.customer.order.invoice',compact('order'));
    }

    public function ekycVerify(Request $request)
    {
        
        if($request->hasFile("document_front_attachment")){
            $document_front = $this->uploadFile($request->file("document_front_attachment"), "kyc")->getFilePath();
        } else {
            $document_front = null;
        }
        
        // return $request->all();
        if($request->hasFile("document_back_attachment")){
            $document_back = $this->uploadFile($request->file("document_back_attachment"), "kyc")->getFilePath();
        } else {
            $document_back = null;
        }

        $ekyc_info = [
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'document_front' => $document_front,
            'document_back' => $document_back,
            'admin_remark' => null,
        ];
                
        UserKyc::create([
            'user_id' => auth()->id(),
            'details' => json_encode($ekyc_info),
            'status' => 3,
        ]);
      
        $user = auth()->user();
        $mailcontent_data = MailSmsTemplate::where('code','=',"Submit-KYC")->first();
        if($mailcontent_data){
            $arr=[
                '{id}'=> $user->id,
                '{name}'=>NameById( $user->id),
                ];
            $action_button = null;
            TemplateMail($user->name,$mailcontent_data,$user->email,$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);
        }
        // $onsite_notification['user_id'] =  $user->id;
        // $onsite_notification['title'] = "Your eKYC has been submitted succesfully. Our team glad to see you in & we are contact you soon.";
        // $onsite_notification['link'] = route('customer.setting')."?active=account";
        // pushOnSiteNotification($onsite_notification);

        return redirect()->back()->with('success','Your eKYC verification request has been submitted successfully!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccountInfo(Request $request, $id)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9]\d{9}$/|min:10',
            'dob' => 'before:today',
        ]);
        
        $user = User::whereId($id)->first();
        $user->update($request->all());

        return back()->with('success','User Information Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
