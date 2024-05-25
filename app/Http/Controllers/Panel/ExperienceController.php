<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Experience;

class ExperienceController extends Controller
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
         $experiences = Experience::query();
         
            if($request->get('search')){
                  $experiences->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                }) 
                    ->orwhere('id','like','%'.$request->search.'%')
                    ->orWhere('clinic_name','like','%'.$request->search.'%')
                    ->orWhere('title','like','%'.$request->search.'%');
                
            }
            
            if($request->get('from') && $request->get('to')) {
                $experiences->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $experiences->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $experiences->orderBy($request->get('desc'),'desc');
            
            }
            if($request->has('doctor_id') && $request->get('doctor_id')){
                $experiences->where('user_id',$request->get('doctor_id'));
            }
            $experiences = $experiences->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.experiences.load', ['experiences' => $experiences])->render();  
            }
 
        return view('panel.experiences.index', compact('experiences'));
    }

    
        public function print(Request $request){
            $experiences = collect($request->records['data']);
                return view('panel.experiences.print', ['experiences' => $experiences])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.experiences.create');
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
                        'title'     => 'required',
                        'clinic_name'     => 'sometimes',
                        'location'     => 'sometimes',
                        'start_date'    => 'required|date|after_or_equal:date_of_joining',
                        'end_date' => 'required|date|after_or_equal:start_date',
                    ]);
        
        try{
                 
                 
            $experience = Experience::create($request->all());
                            return redirect()->route('panel.experiences.index')->with('success','Experience Created Successfully!');
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
    public function show(Experience $experience)
    {
        try{
            return view('panel.experiences.show',compact('experience'));
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
    public function edit(Experience $experience)
    {   
        try{
            
            return view('panel.experiences.edit',compact('experience'));
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
    public function update(Request $request,Experience $experience)
    {
        
        $this->validate($request, [
                        'title'     => 'required',
                        'clinic_name'     => 'sometimes',
                        'location'     => 'sometimes',
                        'start_date'    => 'required|date|after_or_equal:date_of_joining',
                        'end_date' => 'required|date|after_or_equal:start_date',
                    ]);
                
        try{
                             
            if($experience){
                         
                $chk = $experience->update($request->all());

                return redirect()->route('panel.experiences.index')->with('success','Record Updated!');
            }
            return back()->with('error','Experience not found')->withInput($request->all());
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
    public function destroy(Experience $experience)
    {
        try{
            if($experience){
                                          
                $experience->delete();
                return back()->with('success','Experience deleted successfully');
            }else{
                return back()->with('error','Experience not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
