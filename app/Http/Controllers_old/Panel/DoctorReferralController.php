<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DoctorReferral;

class DoctorReferralController extends Controller
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
         $doctor_referrals = DoctorReferral::query();
         
            if($request->get('search')){
                $doctor_referrals->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                }) 
                                ->orWhere('user_id','like','%'.$request->search.'%')
                                ->orWhere('party_name','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $doctor_referrals->whereBetween('date', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $doctor_referrals->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $doctor_referrals->orderBy($request->get('desc'),'desc');
            }
            if($request->get('user_id')){
                $doctor_referrals->where('user_id',$request->get('user_id'));
            }
            $doctor_referrals = $doctor_referrals->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.doctor_referrals.load', ['doctor_referrals' => $doctor_referrals])->render();  
            }
 
        return view('panel.doctor_referrals.index', compact('doctor_referrals'));
    }

    
        public function print(Request $request){
            $doctor_referrals = collect($request->records['data']);
                return view('panel.doctor_referrals.print', ['doctor_referrals' => $doctor_referrals])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.doctor_referrals.create');
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
                        'user_id'     => 'required',
                        'party_name'     => 'required',
                        'remark'     => 'required',
                        'date'     => 'required',
                    ]);
        
        try{
                
                
            $doctor_referral = DoctorReferral::create($request->all());
                            return redirect()->route('panel.doctor_referrals.index')->with('success','Doctor Referral Created Successfully!');
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
    public function show(DoctorReferral $doctor_referral)
    {
        try{
            return view('panel.doctor_referrals.show',compact('doctor_referral'));
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
    public function edit(DoctorReferral $doctor_referral)
    {   
        try{
            
            return view('panel.doctor_referrals.edit',compact('doctor_referral'));
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
    public function update(Request $request,DoctorReferral $doctor_referral)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'party_name'     => 'required',
                        'remark'     => 'required',
                        'date'     => 'required',
                    ]);
                
        try{
                            
            if($doctor_referral){
                        
                $chk = $doctor_referral->update($request->all());

                return redirect()->route('panel.doctor_referrals.index')->with('success','Record Updated!');
            }
            return back()->with('error','Doctor Referral not found')->withInput($request->all());
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
    public function destroy(DoctorReferral $doctor_referral)
    {
        try{
            if($doctor_referral){
                                        
                $doctor_referral->delete();
                return back()->with('success','Doctor Referral deleted successfully');
            }else{
                return back()->with('error','Doctor Referral not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
