<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\PayoutDetail;
use App\User;


class PayoutController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
      
  
        // if(!$request->has('from') && !$request->has('to')){
        //     $start_date = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        //     $end_date = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            // if($request->has('status')){
        //     return
        //     redirect(route('panel.payouts.index')."?status=".$request->get('status'));
        // }
        //     return
        //     redirect(route('panel.payouts.index')."?from=$start_date&to=$end_date");
        // }
    
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $payouts = Payout::query();

        //  if($request->get('search')){
        //     $educations->whereHas('user',function($q){
        //       $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
        //   }) 
        //         ->orWhere('college_name','like','%'.$request->search.'%')
        //         ->orWhere('degree','like','%'.$request->search.'%');

        //  }
           
            if($request->get('search')){
                $payouts->where('id','like','%'.$request->search.'%')
                                ->orWhere('type','like','%'.$request->search.'%')
                                ->orWhere('status','like','%'.$request->search.'%')
                ;
            }
          

            // if($request->has('today_approved') && $request->get('today_approved') !== null){
            //        $payouts->whereDate('created_at',[\Carbon\Carbon::parse($request->today_approved)->format('Y-m-d')]);
            // }

            
            if($request->get('from') && $request->get('to')) 
              $payouts->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);

            if($request->get('asc')){
                $payouts->orderBy($request->get('asc'),'asc');
            }
            if($request->has('status') && $request->get('status') != null){
                $payouts->whereStatus($request->get('status'));
            }
            if($request->get('desc')){
                $payouts->orderBy($request->get('desc'),'desc');
            }
            if($request->has('user') && $request->get('user')){
               
                $payouts->where('user_id',$request->get('user'));
            }
            $payouts = $payouts->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.payouts.load', ['payouts' => $payouts])->render();  
            }
 
        return view('panel.payouts.index', compact('payouts'));
    }

    
        public function print(Request $request){
            $payouts = collect($request->records['data']);
                return view('panel.payouts.print', ['payouts' => $payouts])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.payouts.create');
        }catch(\Exception | \Error $e){           
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'user_id'     => 'required',
            'amount'     => 'required',
            'type'     => 'required',
            'status'     => 'required',
            'approved_by'     => 'required',
            'approved_at'     => 'required',
        ]);
        
        try{
                  
                  
            $payout = Payout::create($request->all());
            return redirect()->route('panel.payouts.index')->with('success','Payout Created Successfully!');
        }catch(\Exception | \Error $e){           
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Payout $payout)
    {
       
        
        try{
           $user = User::where('id',$payout->user_id)->first();
           $payoutDetail = PayoutDetail::where('user_id',$payout->user_id)->first();
           
            return view('panel.payouts.show',compact('payout','user','payoutDetail'));
        }catch(\Exception | \Error $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateStatus(Request $request,Payout $payout)
    {

        
       
       

        try{
            $user = User::where('id', $payout->user_id)->first();
            if($request->status == 1){
                $payout->update([
                    'txn_no' => $request->txn_no
                ]);
               
                $after_balance = $user->wallet_balance - $payout->amount;
                $user->update([
                    'wallet_balance' =>  $after_balance
                ]);
            }else{
                $payout->update([
                    'remark' => $request->remark
                ]);
            }
            $payout->update([
                'approved_by' => Authrole(),
                'approved_at' => now(),
                'status' => $request->status,
                // 'remark' => 'Admin accept your payout request'
            ]);
          
            $this->fcm()
            ->setTokens([$user->fcm_token])
            ->setTitle(config('app.name'))
            ->setBody("Congratulations! Your payout request is approved you will receive amount in your provided payment method within next 24 hours.")
            ->send();
            return back()->with('success','Transaction Updated Successfully');
        }catch(\Exception | \Error $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(Payout $payout)
    {   
        try{
            
            return view('panel.payouts.edit',compact('payout'));
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request,Payout $payout)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'amount'     => 'required',
                        'type'     => 'required',
                        'status'     => 'required',
                        'approved_by'     => 'required',
                        'approved_at'     => 'required',
                    ]);
                
        try{
                              
            if($payout){
                          
                $chk = $payout->update($request->all());

                return redirect()->route('panel.payouts.index')->with('success','Record Updated!');
            }
            return back()->with('error','Payout not found')->withInput($request->all());
        }catch(\Exception | \Error $e){             
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Payout $payout)
    {
        try{
            if($payout){
                                            
                $payout->delete();
                return back()->with('success','Payout deleted successfully');
            }else{
                return back()->with('error','Payout not found');
            }
        }catch(\Exception | \Error $e){ 
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
