<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\WalletLog;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet_logs = WalletLog::whereUserId(auth()->id())->simplePaginate(5);
        return view('frontend.customer.wallet',compact('wallet_logs'));
    }
    public function payout()
    {
        $refund_records = Payout::whereUserId(auth()->id())->simplePaginate(5);
        return view('frontend.customer.payout',compact('refund_records'));
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
    public function payoutStore(Request $request)
    {
        $balance = auth()->user()->wallet_balance;
            $this->validate($request, [
                'amount' => 'required|min:1|',
            ]);
         
        $data = new Payout();
        if(auth()->user()->wallet_balance < $request->amount){
            return back()->with('error','Wallet Amount Should be less than Requested Amount!');
        }else{
            $data->amount = $request->amount;
        }
        $data->user_id = auth()->id();
        $data->status = 0;
        $data->type = $request->type;
        $data->save();
        return back()->with('success','We have created a payout request for you, once it is approved you will be notified!');
    }
    
    public function storeWalletLog(Request $request)
    {
        // return $request->all();
        $balance = auth()->user()->wallet_balance;
        $this->validate($request, [
            'amount' => 'required|min:1|',
        ]);
        
        $data = new WalletLog();
        
            $data->amount = $request->amount;
        
        $data->user_id = auth()->id();
        $data->type = $request->type;
        $data->remark = 'You have request for amount '.$request->amount;
        $data->save();
        return back()->with('success','We have created a payout request for you, once it is approved you will be notified!');
        return $request->all();
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
    public function update(Request $request, $id)
    {
        //
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
