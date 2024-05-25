<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Education;
use App\User;

class EducationController extends Controller
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
         $educations = Education::query();
         
         if($request->get('search')){
            $educations->whereHas('user',function($q){
              $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
          }) 
                ->orWhere('college_name','like','%'.$request->search.'%')
                ->orWhere('degree','like','%'.$request->search.'%');

         }
           
            
            if($request->get('from') && $request->get('to')) {
                $educations->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $educations->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $educations->orderBy($request->get('desc'),'desc');
            }
            if($request->has('doctor_id') && $request->get('doctor_id')){
                $educations->where('user_id',$request->get('doctor_id'));
            }
            $educations = $educations->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.educations.load', ['educations' => $educations])->render();  
            }
 
        return view('panel.educations.index', compact('educations'));
    }

    
        public function print(Request $request){
            $educations = collect($request->records['data']);
                return view('panel.educations.print', ['educations' => $educations])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.educations.create');
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
                        'degree'     => 'required',
                        'college_name'     => 'sometimes',
                        'field_study'     => 'sometimes',
                        // 'start_date'     => 'sometimes',
                        // 'end_date'     => 'sometimes',
                        'user_id'     => 'required',
                        'start_date'    => 'required|date|after_or_equal:date_of_joining',
                       'end_date' => 'required|date|after_or_equal:start_date',
                    ]);
        
        try{
                  
                  
            $education = Education::create($request->all());
                            return redirect()->route('panel.educations.index')->with('success','Education Created Successfully!');
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
    public function show(Education $education)
    {
        try{
            return view('panel.educations.show',compact('education'));
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
    public function edit(Education $education)
    {   
        try{
            
            return view('panel.educations.edit',compact('education'));
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
    public function update(Request $request,Education $education)
    {
        
        $this->validate($request, [
                        'degree'     => 'required',
                        'college_name'     => 'sometimes',
                        'field_study'     => 'sometimes',
                        // 'start_date'     => 'sometimes',
                        // 'end_date'     => 'sometimes',
                        'user_id'     => 'required',
                        'start_date'    => 'required|date|after_or_equal:date_of_joining',
                        'end_date' => 'required|date|after_or_equal:start_date',
                    ]);
                
        try{
                              
            if($education){
                          
                $chk = $education->update($request->all());

                return redirect()->route('panel.educations.index')->with('success','Record Updated!');
            }
            return back()->with('error','Education not found')->withInput($request->all());
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
    public function destroy(Education $education)
    {
        try{
            if($education){
                                            
                $education->delete();
                return back()->with('success','Education deleted successfully');
            }else{
                return back()->with('error','Education not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
