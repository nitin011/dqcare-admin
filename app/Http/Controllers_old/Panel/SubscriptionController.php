<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
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
         $subscriptions = Subscription::query();
         
            if($request->get('search')){
                $subscriptions->where('name','like', '%'.request()->get('search').'%')->orWhere('name','like','%'.$request->search.'%')
                ->orWhere('is_published','like','%'.$request->search.'%')
                ->orWhere('duration','like','%'.$request->search.'%');;
            }
            
            if($request->get('from') && $request->get('to')) {
                $subscriptions->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $subscriptions->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $subscriptions->orderBy($request->get('desc'),'desc');
            }
            $subscriptions = $subscriptions->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.subscriptions.load', ['subscriptions' => $subscriptions])->render();  
            }
 
        return view('panel.subscriptions.index', compact('subscriptions'));
    }

    
        public function print(Request $request){
            $subscriptions = collect($request->records['data']);
                return view('panel.subscriptions.print', ['subscriptions' => $subscriptions])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.subscriptions.create');
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
                        'name'     => 'required',
                        // 'is_published'     => 'required',
                        'duration'     => 'required',
                        'price'     => 'required',
                    ]);
        
        try{
                        
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }
               
                
            $subscription = Subscription::create($request->all());
                            return redirect()->route('panel.subscriptions.index')->with('success','Subscription Created Successfully!');
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
    public function show(Subscription $subscription)
    {
        try{
            return view('panel.subscriptions.show',compact('subscription'));
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
    public function edit(Subscription $subscription)
    {   
        try{
            
            return view('panel.subscriptions.edit',compact('subscription'));
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
    public function update(Request $request,Subscription $subscription)
    {
        
        $this->validate($request, [
                        'name'     => 'required',
                        // 'is_published'     => 'required',
                        'duration'     => 'required',
                        'price'     => 'required',
                    ]);
                
        try{
                        
            if(!$request->has('is_published')){
                $request['is_published'] = 0;
            }
                           
            if($subscription){
                        
                $chk = $subscription->update($request->all());

                return redirect()->route('panel.subscriptions.index')->with('success','Record Updated!');
            }
            return back()->with('error','Subscription not found')->withInput($request->all());
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
    public function destroy(Subscription $subscription)
    {
        try{
            if($subscription){
                                        
                $subscription->delete();
                return back()->with('success','Subscription deleted successfully');
            }else{
                return back()->with('error','Subscription not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
