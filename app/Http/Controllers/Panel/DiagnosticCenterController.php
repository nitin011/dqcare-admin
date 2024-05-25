<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DiagnosticCenter;

class DiagnosticCenterController extends Controller
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
         $diagnostic_centers = DiagnosticCenter::query();
         
            if($request->get('search')){
                $diagnostic_centers->whereHas('country',function($qu){
                    $qu->where('name','like', '%'.request()->get('search').'%');
                })->orWhere(function($q){
                    $q->whereHas('state',function($qu){
                        $qu->where('name','like', '%'.request()->get('search').'%');
                    });
                })
                ->orWhere('name','like', '%'.request()->get('search').'%')
                ->orWhere('addressline_1','like','%'.$request->search.'%')
                ->orWhere('district','like','%'.$request->search.'%')
                ->orWhere('addressline_2','like','%'.$request->search.'%');
                
            }
            
            if($request->get('from') && $request->get('to')) {
                $diagnostic_centers->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $diagnostic_centers->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $diagnostic_centers->orderBy($request->get('desc'),'desc');
            }
            if($request->get('state_id')){
                $diagnostic_centers->where('state_id',$request->get('state_id'));
            }
            if($request->get('city_id')){
                $diagnostic_centers->where('city_id',$request->get('city_id'));
            }
            $diagnostic_centers = $diagnostic_centers->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.diagnostic_centers.load', ['diagnostic_centers' => $diagnostic_centers])->render();  
            }
 
        return view('panel.diagnostic_centers.index', compact('diagnostic_centers'));
    }

    
        public function print(Request $request){
            $diagnostic_centers = collect($request->records['data']);
                return view('panel.diagnostic_centers.print', ['diagnostic_centers' => $diagnostic_centers])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.diagnostic_centers.create');
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
        // return $request->all();
        $this->validate($request, [
                        'name'     => 'required',
                        'country_id'     => 'required',
                        'state_id'     => 'required',
                        'city_id'     => 'required',
                        'pincode'     => 'required',
                        'mobile_no'     => 'required',
                        'addressline_1'     => 'required',
                        'addressline_2'     => 'sometimes',
                        'district'     => 'required',
                    ]);
        
        try{
                    
                    
            $diagnostic_center = DiagnosticCenter::create($request->all());
                            return redirect()->route('panel.diagnostic_centers.index')->with('success','Diagnostic Center Created Successfully!');
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
    public function show(DiagnosticCenter $diagnostic_center)
    {
        try{
            return view('panel.diagnostic_centers.show',compact('diagnostic_center'));
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
    public function edit(DiagnosticCenter $diagnostic_center)
    {   
      
        try{
            
            return view('panel.diagnostic_centers.edit',compact('diagnostic_center'));
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
    public function update(Request $request,DiagnosticCenter $diagnostic_center)
    {
        //    return $request all(); 
           
        $this->validate($request, [
                        'name'     => 'required',
                        'country_id'     => 'required',
                        'state_id'     => 'required',
                        'city_id'     => 'required',
                        'pincode'     => 'required',
                        'mobile_no'     => 'required',
                        'addressline_1'     => 'required',
                        'addressline_2'     => 'sometimes',
                        'district'     => 'required',
                    ]);
                
        try{
                             
            if($diagnostic_center){       
                $chk = $diagnostic_center->update($request->all());
                return redirect()->route('panel.diagnostic_centers.index')->with('success','Record Updated!');
            }
            return back()->with('error','Diagnostic Center not found')->withInput($request->all());
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
    public function destroy(DiagnosticCenter $diagnostic_center)
    {
        try{
            if($diagnostic_center){
                                                
                $diagnostic_center->delete();
                return back()->with('success','Diagnostic Center deleted successfully');
            }else{
                return back()->with('error','Diagnostic Center not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
