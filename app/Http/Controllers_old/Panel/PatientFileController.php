<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PatientFile;
use App\User;
use App\Models\WalletLog;

class PatientFileController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
     
     
        $length = 10;
        if(request()->get('length'))
            $length = $request->get('length');
      
        $patient_files = PatientFile::query();
        if($request->get('search')){
            $patient_files->whereHas('user',function($q){
                $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%')
                    ->orWhere('comment', 'like', '%' . request()->search . '%');
            });
        }

        if($request->get('from') && $request->get('to')) 
            $patient_files->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
        

        if($request->get('asc'))
            $patient_files->orderBy($request->get('asc'),'asc');
        if($request->get('desc'))
            $patient_files->orderBy($request->get('desc'),'desc');
        if($request->get('category'))
            $patient_files->where('category_id',$request->get('category'));
        if($request->get('user_id'))
            $patient_files->where('user_id',$request->get('user_id'));

        $patient_files = $patient_files->latest()->paginate($length);
       
        if ($request->ajax()) 
            return view('panel.patient_files.load', ['patient_files' => $patient_files])->render();  
 
        return view('panel.patient_files.index', compact('patient_files'));
    }

    
        public function print(Request $request){
            $patient_files = collect($request->records['data']);
                return view('panel.patient_files.print', ['patient_files' => $patient_files])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
       
        try{
            return view('panel.patient_files.create');
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
                        // 'user_id'     => 'required',
                        'date'     => 'required',
                        'comment'     => 'sometimes',
                        'category_id'     => 'required',
                        // 'file_file'     => 'required',
                    ]);
        
        try{
                 
                
            if($request->hasFile("file_file")){
                $request['file'] = $this->uploadFile($request->file("file_file"), "patient_files")->getFilePath();
            } else {
                return $this->error("Please upload an file for file");
            }
             
            $patient_file = PatientFile::create($request->all());
            return redirect()->route('panel.patient_files.index')->with('success','Patient File Created Successfully!');
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
    public function show(PatientFile $patient_file)
    {
       
        try{
            return view('panel.patient_files.show',compact('patient_file'));
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
    public function edit(PatientFile $patient_file)
    {   
        try{
            
            return view('panel.patient_files.edit',compact('patient_file'));
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
    public function update(Request $request,PatientFile $patient_file)
    {
        
       
        $this->validate($request, [
                        // 'user_id'     => 'required',
                        'date'     => 'required',
                        'comment'     => 'sometimes',
                        'category_id'     => 'required',
                        // 'file'     => 'required',
                    ]);
                
        try{
            if($request->date != null && $request->date != $patient_file->date){
                    /// Giving 1 point for each file to user for uploading file
                    WalletLog::create([
                        'user_id' => $patient_file->user_id,
                        'type' => 'credit',
                        'model' => 'UploadBonus',
                        'remark' => 'For uploading medical document',
                        'amount' => 1,
                    ]);
            }
                             
            if($patient_file){
                if($request->hasFile("file_file")){
                    $request['file'] = $this->uploadFile($request->file("file_file"), "patient_files")->getFilePath();
                    $this->deleteStorageFile($patient_file->file);
                } else {
                    $request['file'] = $patient_file->file;
                }
                     
                $chk = $patient_file->update($request->all());
                
                

                return redirect()->route('panel.patient_files.index')->with('success','Record Updated!');
            }
            return back()->with('error','Patient File not found')->withInput($request->all());
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
    public function destroy(PatientFile $patient_file)
    {
        try{
            if($patient_file){
                             
                $this->deleteStorageFile($patient_file->file);
                                 
                $patient_file->delete();
                return back()->with('success','Patient File deleted successfully');
            }else{
                return back()->with('error','Patient File not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function preview(PatientFile $patient_file){

      
        return view('panel.patient_files.view', compact('patient_file'));

    }
    





}
