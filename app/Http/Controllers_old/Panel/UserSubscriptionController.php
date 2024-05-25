<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserSubscription;

class UserSubscriptionController extends Controller
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
         $user_subscriptions = UserSubscription::query();
         
            if($request->get('search')){
                $user_subscriptions->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                })->orWhere('subscription_id','like','%'.$request->search.'%');
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_subscriptions->whereDate('from_date', '>=', \Carbon\Carbon::parse($request->from)->format('Y-m-d'))->whereDate('to_date', '<=', $request->to);
            }

            if($request->get('asc')){
                $user_subscriptions->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_subscriptions->orderBy($request->get('desc'),'desc');
            }
            $user_subscriptions = $user_subscriptions->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_subscriptions.load', ['user_subscriptions' => $user_subscriptions])->render();  
            }
 
        return view('panel.user_subscriptions.index', compact('user_subscriptions'));
    }

    
        public function print(Request $request){
            $user_subscriptions = collect($request->records['data']);
                return view('panel.user_subscriptions.print', ['user_subscriptions' => $user_subscriptions])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
       
        try{
            return view('panel.user_subscriptions.create');
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
                        'subscription_id'     => 'required',
                        'from_date'     => 'required|date|after:date_of_start',
                        'to_date'     => 'required|date|after_or_equal:from_date',
                        // 'parent_id'     => 'sometimes',
                    ]);
        
        try{
                 
            $parent_subscription = UserSubscription::where('user_id',$request->parent_id)->first();
            if ($parent_subscription && $parent_subscription->subscription_id != $request->subscription_id) {
               return back()->with('error',' Unmatched Package');
            }
            $user_subscription = UserSubscription::create($request->all());
                            return redirect()->route('panel.user_subscriptions.index')->with('success','User Subscription Created Successfully!');
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
    public function show(UserSubscription $user_subscription)
    {
        try{
            return view('panel.user_subscriptions.show',compact('user_subscription'));
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
    public function edit(UserSubscription $user_subscription)
    {   
       
        try{
            
            return view('panel.user_subscriptions.edit',compact('user_subscription'));
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
    public function update(Request $request,UserSubscription $user_subscription)
    {
        
        
        $this->validate($request, [
                        // 'user_id'     => 'required',
                         'subscription_id'     => 'required',
                        'from_date'     => 'required|date|after:date_of_start',
                        'to_date'     => 'required|date|after_or_equal:from_date',
                        // 'parent_id'     => 'required',
                    ]);
                
        try{
                             
            if($user_subscription){
                // return $request->all();    
                $chk = $user_subscription->update($request->all());

                return redirect()->route('panel.user_subscriptions.index')->with('success','Record Updated!');
            }
            return back()->with('error','User Subscription not found')->withInput($request->all());
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
    public function destroy(UserSubscription $user_subscription)
    {
    
        try{
            if($user_subscription){
                $child_user_subscription = UserSubscription::whereParentId($user_subscription->user_id)->delete();
                $user_subscription-> delete();
                // $user_subscription = UserSubscription::whereParentId($user_subscription->id)->delete();
                return back()->with('success','User Subscription deleted successfully');
            }else{
                return back()->with('error','User Subscription not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }

      
    }

    public function getUserSubscriptionData(Request $request)
   {
     $user_subscription = UserSubscription::where('user_id',$request->id)->first();
     if ($user_subscription) {
        return response($user_subscription,200);
     }
     return response(404);
   } 
}
