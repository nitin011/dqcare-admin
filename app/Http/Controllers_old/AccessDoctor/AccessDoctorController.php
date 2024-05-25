<?php


namespace App\Http\Controllers\AccessDoctor;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\AccessDoctor;

class AccessDoctorController extends Controller
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
         $access_doctors = AccessDoctor::query();
         
            if($request->get('search')){
                $access_doctors->where('id','like','%'.$request->search.'%')
                                ->orWhere('doctor_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $access_doctors->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $access_doctors->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $access_doctors->orderBy($request->get('desc'),'desc');
            }
            $access_doctors = $access_doctors->paginate($length);

            if ($request->ajax()) {
                return view('panel.access_doctors.load', ['access_doctors' => $access_doctors])->render();  
            }
 
        return view('panel.access_doctors.index', compact('access_doctors'));
    }

    
        public function print(Request $request){
            $access_doctors = collect($request->records['data']);
                return view('panel.access_doctors.print', ['access_doctors' => $access_doctors])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.access_doctors.create');
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
                        'doctor_id'     => 'sometimes',
                        'assign_by'     => 'required',
                    ]);
        
        try{
                        
            if(!$request->has('doctor_id')){
                $request['doctor_id'] = 0;
            }
              
               
            $access_doctor = AccessDoctor::create($request->all());
                            return redirect()->route('panel.access_doctors.index')->with('success','Access Doctor Created Successfully!');
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
    public function show(AccessDoctor $access_doctor)
    {
        try{
            return view('panel.access_doctors.show',compact('access_doctor'));
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
    public function edit(AccessDoctor $access_doctor)
    {   
        try{
            
            return view('panel.access_doctors.edit',compact('access_doctor'));
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
    public function update(Request $request,AccessDoctor $access_doctor)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'doctor_id'     => 'sometimes',
                        'assign_by'     => 'required',
                    ]);
                
        try{
                        
            if(!$request->has('doctor_id')){
                $request['doctor_id'] = 0;
            }
                          
            if($access_doctor){
                       
                $chk = $access_doctor->update($request->all());

                return redirect()->route('panel.access_doctors.index')->with('success','Record Updated!');
            }
            return back()->with('error','Access Doctor not found')->withInput($request->all());
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
    public function destroy(AccessDoctor $access_doctor)
    {
        try{
            if($access_doctor){
                                      
                $access_doctor->delete();
                return back()->with('success','Access Doctor deleted successfully');
            }else{
                return back()->with('error','Access Doctor not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
