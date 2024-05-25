<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UserAddres;
use Illuminate\Support\Facades\Session;

class UserAddresController extends Controller
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
         $user_addres = UserAddres::query();
         
            if($request->get('search')){
                $user_addres->where('id','like','%'.$request->search.'%')
                                ->orWhere('details','like','%'.$request->search.'%')
                                ->orWhere('user_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $user_addres->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $user_addres->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $user_addres->orderBy($request->get('desc'),'desc');
            }
            $user_addres = $user_addres->paginate($length);

            if ($request->ajax()) {
                return view('panel.user_addres.load', ['user_addres' => $user_addres])->render();  
            }
 
        return view('panel.user_addres.index', compact('user_addres'));
    }

    
        public function print(Request $request){
            $user_addres = collect($request->records['data']);
                return view('panel.user_addres.print', ['user_addres' => $user_addres])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.user_addres.create');
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
            'user_id' => 'required',
            'type' => 'required',
        ]);
        if(Session::has('last_pay_attempt')){
            $last_attempt = Session::get('last_pay_attempt');
            $difference = $last_attempt->diffInMinutes(\Carbon\Carbon::now());
            $seconds = 120-$last_attempt->diffInSeconds(\Carbon\Carbon::now());
            if($difference < 2){
                return redirect()->back()->with('error', "Hold on, Please try after $seconds seconds.")->withInput($request->all());
            }
        }
        Session::put('last_pay_attempt', \Carbon\Carbon::now());

        try {
                $data = new UserAddres();
                $data->user_id = auth()->id();
                $data->is_primary = $request->is_primary ?? 0;
                $arr = [
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'type' => $request->type,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city
                ];
                $data->details = json_encode($arr);
                $data->save();
                return redirect()->route('customer.setting',['active' => 'address_info'])->with('success', 'Address added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customer.setting',['active' => 'address_info'])->with('error', 'Error: ' . $e->getMessage());
        }
    } 

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(UserAddres $user_addre)
    {
        try{
            return view('panel.user_addres.show',compact('user_addre'));
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
    public function edit(UserAddres $user_addre)
    {   
        try{
            
            return view('panel.user_addres.edit',compact('user_addre'));
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
    public function update(Request $request)
    {
        // return $request->all();
        $address = UserAddres::whereId($request->id)->first();
        try {
            $arr = [
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'country' => $request->country,
                'type' => $request->type,
                'state' => $request->state,
                'city' => $request->city
            ];
            $details = json_encode($arr);
            $address->update([
                'details'=> $details
            ]);
            // return $request->all();
                return redirect()->route('customer.setting',['active' => 'address_info'])->with('success', 'updated added successfully!');            } catch (\Exception $e) {
                return redirect()->route('customer.setting',['active' => 'address_info'])->with('error', 'Error: ' . $e->getMessage());
            }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_address = UserAddres::find($id);
        if($user_address){
            $user_address->delete();
             return redirect()->route('customer.setting',['active' => 'address_info'])->with('success', 'Address deleted successfully!'); 
        }else{
            return redirect()->route('customer.setting',['active' => 'address_info'])->with('error', 'Record not found!'); 
        }
    }
}
