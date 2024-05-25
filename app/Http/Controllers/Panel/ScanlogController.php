<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Scanlog;

class ScanlogController extends Controller
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
         $scanlogs = Scanlog::query();
         
            if($request->get('search')){
                $scanlogs->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                }) 
                             ->orWhere('doctor_id','like','%'.$request->search.'%')
                                ->orWhere('user_id','like','%'.$request->search.'%');
                
            }
            
            if($request->get('from') && $request->get('to')) {
                $scanlogs->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $scanlogs->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $scanlogs->orderBy($request->get('desc'),'desc');
            }
            if($request->get('user_id')){
                $scanlogs->where('user_id',$request->get('user_id'));
            }
            if($request->get('doctor_id')){
                $scanlogs->where('doctor_id',$request->get('doctor_id'));
            }
            $scanlogs = $scanlogs->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.scanlogs.load', ['scanlogs' => $scanlogs])->render();  
            }
 
        return view('panel.scanlogs.index', compact('scanlogs'));
    }

    
        public function print(Request $request){
            $scanlogs = collect($request->records['data']);
                return view('panel.scanlogs.print', ['scanlogs' => $scanlogs])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.scanlogs.create');
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
                        'doctor_id'     => 'required',
                        'user_id'     => 'required',
                        'interval'     => 'required',
                    ]);
        
        try{
               
               
            $scanlog = Scanlog::create($request->all());
                            return redirect()->route('panel.scanlogs.index')->with('success','Scanlog Created Successfully!');
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
    public function show(Scanlog $scanlog)
    {
        try{
            return view('panel.scanlogs.show',compact('scanlog'));
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
    public function edit(Scanlog $scanlog)
    {   
        try{
            
            return view('panel.scanlogs.edit',compact('scanlog'));
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
    public function update(Request $request,Scanlog $scanlog)
    {
        
        $this->validate($request, [
                        'doctor_id'     => 'required',
                        'user_id'     => 'required',
                        'interval'     => 'required',
                    ]);
                
        try{
                           
            if($scanlog){
                       
                $chk = $scanlog->update($request->all());

                return redirect()->route('panel.scanlogs.index')->with('success','Record Updated!');
            }
            return back()->with('error','Scanlog not found')->withInput($request->all());
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
    public function destroy(Scanlog $scanlog)
    {
        try{
            if($scanlog){
                                      
                $scanlog->delete();
                return back()->with('success','Scanlog deleted successfully');
            }else{
                return back()->with('error','Scanlog not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
