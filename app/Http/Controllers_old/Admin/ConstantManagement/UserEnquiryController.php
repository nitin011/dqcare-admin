<?php 
/**
 *
 * @category zStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */

namespace App\Http\Controllers\Admin\ConstantManagement;

use App\Http\Controllers\Controller;
use App\Models\UserEnquiry;
use Illuminate\Http\Request;

class UserEnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request  )
    {
        if(!$request->has('from') && !$request->has('to')){
            $start_date = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $end_date = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            return redirect(route('panel.constant_management.user_enquiry.index')."?from=$start_date&to=$end_date");
        }
        if($request->get('search')){
            $user_enquiries->where('first_name','like','%'.$request->get('search').'%');
               
        }
        try {
            
            if($request->has('from') && $request->has('to')){
                // return explode(' - ', $request->get('date')) ;
                $user_enq = UserEnquiry::whereBetween('created_at', [$request->get('from'),$request->get('to')])->latest()->get();
            }else{
                $user_enq = UserEnquiry::latest()->get();
            }
        return view('backend.constant-management.user-enquiry.index', compact('user_enq'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.constant-management.user-enquiry.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        try {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $data = new UserEnquiry();
            $data->name=$request->name;
        
            $data->status=0;
            $data->subject=$request->subject;
            $data->type=$request->type;
            $data->type_value=$request->type_value;
            $data->description=$request->description;
            $data->save();

            if($data->description != null){
                // Push On Site Notification
                $data_notification = [
                    'title' => "Admin added a new enquiry",
                    'notification' => $data->description,
                    'link' => "#",
                    'user_id' => $data->id,
                ];
                pushOnSiteNotification($data_notification);
                // End Push On Site Notification
            }
            return redirect()->route('panel.constant_management.user_enquiry.index')->with('success', 'User Enquiry created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserEnquiry  $userEnquiry
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user_enq = UserEnquiry::whereId($id)->first();
        return view('backend.constant-management.user-enquiry.show', compact('user_enq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserEnquiry  $userEnquiry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user_enq = UserEnquiry::whereId($id)->first();
        return view('backend.constant-management.user-enquiry.edit', compact('user_enq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserEnquiry  $userEnquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        try {
            $data = UserEnquiry::whereId($id)->first();
            $data->name=$request->name;
            $data->status=$request->status;
            $data->subject=$request->subject;
            $data->description=$request->description;
            $data->type=$request->type;
            $data->type_value=$request->type_value;
            $data->save();
            return redirect(route('panel.constant_management.user_enquiry.index'))->with('success', 'User Enquiry update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function BulkAction(Request $request)
    {
        // return $request->all();
        try{
            $ids = explode(',',$request->ids);
            foreach($ids as $id) {
                if($id != null){
                    UserEnquiry::where('id', $id)->delete();
                }
            }
            if($ids == [""]){
                return back()->with('error', 'There were no rows selected by you!');
            }else{
                return back()->with('success', 'UserEnquiry Deleted Successfully!');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }





    
    public function destroy($id)
    {
        //
        $chk = UserEnquiry::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'User Enquiry Deleted Successfully!');
        }
    }
}
