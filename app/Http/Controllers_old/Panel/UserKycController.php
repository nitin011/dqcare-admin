<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserKyc;

class UserKycController extends Controller
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
         $user_kycs = UserKyc::query();
         
            if($request->get('search')){
                $user_kycs->where('id','like','%'.$request->search.'%')
                                ->orWhere('user_id','like','%'.$request->search.'%')
                                ->orWhere('details','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_kycs->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $user_kycs->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_kycs->orderBy($request->get('desc'),'desc');
            }
            $user_kycs = $user_kycs->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_kycs.load', ['user_kycs' => $user_kycs])->render();  
            }
 
        return view('panel.user_kycs.index', compact('user_kycs'));
    }

    
        public function print(Request $request){
            $user_kycs = collect($request->records['data']);
                return view('panel.user_kycs.print', ['user_kycs' => $user_kycs])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.user_kycs.create');
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
                        'status'     => 'required',
                        'details'     => 'required',
                    ]);
        
        try{
               
               
            $user_kyc = UserKyc::create($request->all());
                            return redirect()->route('panel.user_kycs.index')->with('success','User Kyc Created Successfully!');
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
    public function show(UserKyc $user_kyc)
    {
        try{
            return view('panel.user_kycs.show',compact('user_kyc'));
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
    public function edit(UserKyc $user_kyc)
    {   
        try{
            
            return view('panel.user_kycs.edit',compact('user_kyc'));
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
    public function update(Request $request,UserKyc $user_kyc)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'status'     => 'required',
                        'details'     => 'required',
                    ]);
                
        try{
                           
            if($user_kyc){
                       
                $chk = $user_kyc->update($request->all());

                return redirect()->route('panel.user_kycs.index')->with('success','Record Updated!');
            }
            return back()->with('error','User Kyc not found')->withInput($request->all());
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
    public function destroy(UserKyc $user_kyc)
    {
        try{
            if($user_kyc){
                                      
                $user_kyc->delete();
                return back()->with('success','User Kyc deleted successfully');
            }else{
                return back()->with('error','User Kyc not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
