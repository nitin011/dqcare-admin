<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\FollowUp;

class FollowUpController extends Controller
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
         $follow_ups = FollowUp::query();
         
            if($request->get('search')){
                $follow_ups->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                })->orWhere('remark','like','%'.$request->search.'%')
                ->orWhere(function($q){
                 $q->wherehas('doctor',function($p){
                        $p->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                    });
                });
            }


            
            if($request->get('from') && $request->get('to')) {
                $follow_ups->whereBetween('date', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $follow_ups->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $follow_ups->orderBy($request->get('desc'),'desc');
            }
            if($request->get('user_id')){
                $follow_ups->where('user_id',$request->get('user_id'));
            }
            if($request->get('doctor_id')){
                $follow_ups->where('doctor_id',$request->get('doctor_id'));
            }
            $follow_ups = $follow_ups->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.follow_ups.load', ['follow_ups' => $follow_ups])->render();  
            }
 
        return view('panel.follow_ups.index', compact('follow_ups'));
    }

    
        public function print(Request $request){
            $follow_ups = collect($request->records['data']);
                return view('panel.follow_ups.print', ['follow_ups' => $follow_ups])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.follow_ups.create');
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
                        'remark'     => 'required',
                        'date'     => 'required',
                        'status'     => 'required',
                    ]);
        
        try{
                 
                 
            $follow_up = FollowUp::create($request->all());
                            return redirect()->route('panel.follow_ups.index')->with('success','Follow Up Created Successfully!');
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
    public function show(FollowUp $follow_up)
    {
        try{
            return view('panel.follow_ups.show',compact('follow_up'));
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
    public function edit(FollowUp $follow_up)
    {   
        try{
            
            return view('panel.follow_ups.edit',compact('follow_up'));
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
    public function update(Request $request,FollowUp $follow_up)
    {
        
        $this->validate($request, [
                        'doctor_id'     => 'required',
                        'user_id'     => 'required',
                        'remark'     => 'required',
                        'date'     => 'required',
                        'status'     => 'required',
                    ]);
                
        try{
                             
            if($follow_up){
                         
                $chk = $follow_up->update($request->all());

                return redirect()->route('panel.follow_ups.index')->with('success','Record Updated!');
            }
            return back()->with('error','Follow Up not found')->withInput($request->all());
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
    public function destroy(FollowUp $follow_up)
    {
        try{
            if($follow_up){
                                          
                $follow_up->delete();
                return back()->with('success','Follow Up deleted successfully');
            }else{
                return back()->with('error','Follow Up not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
