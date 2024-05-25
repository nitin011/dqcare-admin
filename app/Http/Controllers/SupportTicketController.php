<?php

namespace App\Http\Controllers;
use App\Models\SupportTicket;
use App\Models\Media;
use App\Models\TicketConversation;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function AdminIndex(Request $request)
    {
        $support_tickets = SupportTicket::query();
        if($request->get('status') && $request->get('status') == 0){
            $support_tickets->where('status',$request->status);
        }
        if($request->get('from') && $request->get('to')){
            $support_tickets->whereBetween('created_at',[$request->from,$request->to]);
        }
        $support_tickets = $support_tickets->latest()->get();
       return view('backend.admin.support_tickets.index',compact('support_tickets'));
    }
    public function create(Request $request)
    {
       
       return view('backend.admin.support_tickets.create');
    }
    public function AdminShow(Request $request,$id)
    {
        $support_ticket = SupportTicket::whereId($id)->first();
        $medias = Media::whereType('SupportTicket')->whereTypeId($id)->get();
        $receiver = $support_ticket->user_id;
        $sender = auth()->id();
        
       return view('backend.admin.support_tickets.show',compact('support_ticket','receiver','medias','sender'));
    }

    public function addAttachment(Request $request, $id)
    {
        // return $request->all();
        try{
            $support = SupportTicket::whereId($id)->first();
            $filename = null;
            if($request->file_name != null){
                $img = $this->uploadFile($request->file("file_name"), "support-ticket")->getFilePath();
                $filename = $request->file('file_name')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
            }
            if($filename != null){
                Media::create([
                    'type' => 'SupportTicket',
                    'type_id' => $support->id,
                    'file_name' => $filename,
                    'path' => $img,
                    'extension' => $extension,
                    'file_type' => "Image",
                    'tag' => "SupportTicketAttachment",
                ]);
            }
            // return $ticket;

        return back()->with('success', "Attachment Created Successfully!");
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        
    }


    public function reply(Request $request)
    {
        $this->validate($request, [
            'reply' => 'required',
        ]);

        try{
            $support_ticket = SupportTicket::whereId($request->id)->first();

        if($support_ticket){
        $support_ticket->reply = $request->reply;
            $support_ticket->status = 1;
            $support_ticket->save();
            return redirect()->route('panel.constant_management.support_ticket.index')->with('success','Replied
            Successfully!');
        }
            return back()->with('error','SupportTicket not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function updateStatus(Request $request,$id,$status)
    {
        try{
            $support_ticket = SupportTicket::whereId($id)->first();

        if($support_ticket){
            
            $support_ticket->update([
                'status' => $request->status
            ]);
            return back()->with('success','Status Updated Successfully!');
        }
            return back()->with('error','SupportTicket not found');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }


    public function supportTicket()
    {
        $supports = SupportTicket::where('user_id', auth()->id())->get();
        return view('backend.support-ticket.index',compact('supports'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'message' => 'required',
        ]);
       
        try{
          $support = SupportTicket::create([
                'user_id' => auth()->id(),
                'subject' => $request->get('subject'),
                'priority' => $request->get('priority'),
                'message' => $request->get('message'),
                'ticket_type_id'=>$request->get('ticket_type_id'),
                'status' => 0,
            ]);
            
            $filename = null;
            if($request->has('attachment')){
                $img = $this->uploadFile($request->file("attachment"), "support-ticket")->getFilePath();
                $filename = $request->file('attachment')->getClientOriginalName();
                $extension = pathinfo($filename, PATHINFO_EXTENSION);
            }
            if($filename != null){
                    Media::create([
                        'type' => 'SupportTicket',
                        'type_id' => $support->id,
                        'file_name' => $filename,
                        'path' => $img,
                        'extension' => $extension,
                        'file_type' => "Image",
                        'tag' => "SupportTicketAttachment",
                    ]);
                }
            $ticket = TicketConversation::create([
                'type_id' => $support->id,
                'user_id' => $support->user_id,
                'type' => 'Support Ticket',
                'comment' => $support->message
             ]); 
            // return $ticket;

        return redirect(route('panel.constant_management.support_ticket.index'))->with('success', "Ticket raised successfully!");
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
        
    }

    public function bulkAction(Request $request)
    {
        // return $request->all();
        try{
            $ids = explode(',',$request->ids);
            foreach($ids as $id) {
                if($id != null){
                    SupportTicket::where('id', $id)->delete();
                }
            }
            if($ids == [""]){
                return back()->with('error', 'There were no rows selected by you!');
            }else{
                return back()->with('success', 'SupportTicket Deleted Successfully!');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return 's';
         $support_ticket = SupportTicket::whereId($id)->first();
        return view('backend.admin.support_tickets.edit',compact('support_ticket'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = SupportTicket::whereId($id)->first();
            $data->user_id=$request->user_id;
            $data->subject=$request->subject;
            $data->message=$request->message;
            $data->ticket_type_id=$request->ticket_type_id;
            $data->priority=$request->priority;

            $data->save();
            return redirect(route('panel.constant_management.support_ticket.index'))->with('success', 'support_ticket update successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chk = SupportTicket::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'User Enquiry Deleted Successfully!');
        }
    }
}
