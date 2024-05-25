<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PostComment;

class PostCommentController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        if(! request()->has('post_id')){
            return redirect(route('panel.post_comments.index',['post_id' ,request()->get('post_id')]));

        }

         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $post_comments = PostComment::query();
         
            if($request->get('search')){
                $post_comments->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                }) 
                                ->orWhere('post_id','like','%'.$request->search.'%')
                                ->orWhere('user_id','like','%'.$request->search.'%')
                                ->orWhere('comment','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $post_comments->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $post_comments->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $post_comments->orderBy($request->get('desc'),'desc');
            }

            $post_comments = $post_comments->where('post_id',request()->get('post_id'))->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.post_comments.load', ['post_comments' => $post_comments])->render();  
            }
 
        return view('panel.post_comments.index', compact('post_comments'));
    }

    
        public function print(Request $request){
            $post_comments = collect($request->records['data']);
                return view('panel.post_comments.print', ['post_comments' => $post_comments])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.post_comments.create');
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
                        'post_id'     => 'required',
                        'user_id'     => 'required',
                        'comment'     => 'required',
                    ]);
        
        try{
               
               
            $post_comment = PostComment::create($request->all());
                            return redirect()->route('panel.post_comments.index')->with('success','Post Comment Created Successfully!');
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
    public function show(PostComment $post_comment)
    {
        try{
            return view('panel.post_comments.show',compact('post_comment'));
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
    public function edit(PostComment $post_comment)
    {   
        try{
            
            return view('panel.post_comments.edit',compact('post_comment'));
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
    public function update(Request $request,PostComment $post_comment)
    {
        
        $this->validate($request, [
                        'post_id'     => 'required',
                        'user_id'     => 'required',
                        'comment'     => 'required',
                    ]);
                
        try{
                           
            if($post_comment){
                       
                $chk = $post_comment->update($request->all());

                return redirect()->route('panel.post_comments.index')->with('success','Record Updated!');
            }
            return back()->with('error','Post Comment not found')->withInput($request->all());
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
    public function destroy(PostComment $post_comment)
    {
        try{
            if($post_comment){
                                      
                $post_comment->delete();
                return back()->with('success','Post Comment deleted successfully');
            }else{
                return back()->with('error','Post Comment not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
