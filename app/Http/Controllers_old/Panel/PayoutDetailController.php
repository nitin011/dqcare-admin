<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PayoutDetail;

class PayoutDetailController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $payout_details = PayoutDetail::query();

            if($request->get('search')){
                $payout_details->where('id','like','%'.$request->search.'%')
                                ->orWhere('payload','like','%'.$request->search.'%');
            }

            if($request->get('from') && $request->get('to')) {
                $payout_details->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $payout_details->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $payout_details->orderBy($request->get('desc'),'desc');
            }
            $payout_details = $payout_details->paginate($length);

            if ($request->ajax()) {
                return view('panel.payout_details.load', ['payout_details' => $payout_details])->render();
            }

        return view('panel.payout_details.index', compact('payout_details'));
    }


        public function print(Request $request){
            $payout_details = collect($request->records['data']);
                return view('panel.payout_details.print', ['payout_details' => $payout_details])->render();

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.payout_details.create');
        }catch(Exception $e){
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
                        'user_id'     => 'sometimes',
                        'type'     => 'sometimes',
                        'payload'     => 'sometimes',
                        'is_active'     => 'sometimes',
                    ]);

        try{

            if(!$request->has('is_active')){
                $request['is_active'] = 0;
            }


            $payout_detail = PayoutDetail::create($request->all());
                            return redirect()->route('panel.payout_details.index')->with('success','Payout Detail Created Successfully!');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(PayoutDetail $payout_detail)
    {
        try{
            return view('panel.payout_details.show',compact('payout_detail'));
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(PayoutDetail $payout_detail)
    {
        
        try{
            return view('panel.payout_details.edit', compact('payout_detail'));
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
    public function update(Request $request,PayoutDetail $payout_detail)
    {
        // return $request->all();
        $this->validate($request, [
            'user_id'     => 'sometimes',
            'type'     => 'sometimes',
            'is_active'     => 'sometimes',
        ]);
        
        

       
        // $details = $payout_detail->payload;
        try{
            // return $request->all();  
            
            if(!$request->has('is_active')){
                $request['is_active'] = 0;
            }
            
            if($payout_detail){
                if ($request->get('type') == PayoutDetail::TYPE_BANK) {
                    $payload['account_holder_name'] = $request->get('account_holder_name');
                    $payload['account_number'] = $request->get('account_number');
                    $payload['ifsc_code'] = $request->get('ifsc_code');
                    $payload['branch'] = $request->get('branch');
                } else {
                    $payload['upi_holder_name'] = $request->get('upi_holder_name');
                    $payload['upi_id'] = $request->get('upi_id');
                }
            //   $payload['upi_holder_name'] = explode(' , ', $request->upi_holder_name);
            //   $payload['account_holder_name'] = explode(' , ', $request->account_holder_name);
            //   $payload['ifsc_code'] = explode(' , ', $request->ifsc_code);
            //   $payload['branch'] = explode(' , ', $request->branch);

                $payout_detail->update([
                    'payload' => json_encode($payload),
                ]);

                return redirect()->route('panel.payout_details.index')->with('success','Record Updated!');
            }
            return back()->with('error','Payout Detail not found')->withInput($request->all());
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(PayoutDetail $payout_detail)
    {
        try{
            if($payout_detail){

                $payout_detail->delete();
                return back()->with('success','Payout Detail deleted successfully');
            }else{
                return back()->with('error','Payout Detail not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
