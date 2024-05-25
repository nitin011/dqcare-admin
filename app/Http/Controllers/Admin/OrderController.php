<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        //  return $request->all();
        if(!$request->has('from') && !$request->has('to')){
            $start_date = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $end_date = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            return
            redirect(route('panel.orders.index')."?from=$start_date&to=$end_date");
        }
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $orders = Order::query();
         
            if($request->get('search')){
                $orders->where('id','like','%'.$request->search.'%')
                    ->orWhere('txn_no','like','%'.$request->search.'%')
                    ->orWhere('amount','like','%'.$request->search.'%');
            }
          
            
            if($request->get('from') && $request->get('to')) {
                $orders->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $orders->orderBy($request->get('asc'),'asc');
            }
            if($request->has('status') && $request->get('status') != null){
                $orders->where('status',$request->get('status'));
            }
            if($request->get('desc')){
                $orders->orderBy($request->get('desc'),'desc');
            }
            $orders = $orders->paginate($length);

            if ($request->ajax()) {
                return view('backend.admin.orders.load', ['orders' => $orders])->render();  
            }
 
        return view('backend.admin.orders.index', compact('orders'));
    }

    
        public function print(Request $request){
            $orders = collect($request->records['data']);
                return view('backend.admin.orders.print', ['orders' => $orders])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('backend.admin.orders.create');
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
                        'txn_no'     => 'required',
                        'discount'     => 'sometimes',
                        'tax'     => 'sometimes',
                        'sub_total'     => 'required',
                        'total'     => 'required',
                        'status'     => 'sometimes',
                        'payment_gateway'     => 'sometimes',
                        'remarks'     => 'sometimes',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                    ]);
        
        try{
                 $request['status'] = 0;      
                       
            $order = Order::create($request->all());
                            return redirect()->route('panel.orders.index')->with('success','Order Created Successfully!');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        try{
            return view('backend.admin.orders.show',compact('order'));
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
    public function invoice(Order $order)
    {   
        try{
            
            return view('backend.admin.orders.invoice',compact('order'));
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
    public function update(Request $request,Order $order)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'txn_no'     => 'required',
                        'discount'     => 'sometimes',
                        'tax'     => 'sometimes',
                        'sub_total'     => 'required',
                        'total'     => 'required',
                        'status'     => 'sometimes',
                        'payment_gateway'     => 'sometimes',
                        'remarks'     => 'sometimes',
                        'from'     => 'sometimes',
                        'to'     => 'sometimes',
                    ]);
                
        try{
                                   
            if($order){
                $request['status'] = 0;      
                       
                $chk = $order->update($request->all());

                return redirect()->route('panel.orders.index')->with('success','Record Updated!');
            }
            return back()->with('error','Order not found');
        }catch(Exception $e){            
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try{
            if($order){
                foreach($order->items as $item){
                    $item->delete();
                }                           
                $order->delete();
                return back()->with('success','Order deleted successfully');
            }else{
                return back()->with('error','Order not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
