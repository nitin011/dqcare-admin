<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PostLike;

class PostLikeController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
     public function index(Request $request)
     {
        if(!request()->has('post_id')){
            return redirect(route('panel.post_likes.index',['post_id' ,request()->get('post_id')]));
        }
         $length = 10;
         if(request()->get('length')){
             $length = $request->get('length');
         }
         $post_likes = PostLike::query();
         
            if($request->get('search')){
                $post_likes->whereHas('user',function($q){
                    $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
                }) 
                                ->orWhere('user_id','like','%'.$request->search.'%')
                                ->orWhere('post_id','like','%'.$request->search.'%')
                ;
            }
            
            if($request->get('from') && $request->get('to')) {
                $post_likes->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }

            if($request->get('asc')){
                $post_likes->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $post_likes->orderBy($request->get('desc'),'desc');
            }

            $post_likes = $post_likes->where('post_id',request()->get('post_id'))->latest()->paginate($length);

            if ($request->ajax()) {
                return view('panel.post_likes.load', ['post_likes' => $post_likes])->render();  
            }
 
        return view('panel.post_likes.index', compact('post_likes'));
    }

    
        public function print(Request $request){
            $post_likes = collect($request->records['data']);
                return view('panel.post_likes.print', ['post_likes' => $post_likes])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.post_likes.create');
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
                        'post_id'     => 'required',
                    ]);
        
        try{ 
               
            $post_like = PostLike::create($request->all());
                            return redirect()->route('panel.post_likes.index',['post_id' => $post_like->post_id])->with('success','Post Like Created Successfully!');
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
    public function show(PostLike $post_like)
    {
        try{
            return view('panel.post_likes.show',compact('post_like'));
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
    public function edit(PostLike $post_like)
    {   
        try{
            
            return view('panel.post_likes.edit',compact('post_like'));
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
    public function update(Request $request,PostLike $post_like)
    {
        
        $this->validate($request, [
                        'user_id'     => 'required',
                        'post_id'     => 'required',
                    ]);
                
        try{
                          
            if($post_like){
                      
                $chk = $post_like->update($request->all());

                return redirect()->route('panel.post_likes.index')->with('success','Record Updated!');
            }
            return back()->with('error','Post Like not found')->withInput($request->all());
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
    public function destroy(PostLike $post_like)
    {
        try{
            if($post_like){
                                    
                $post_like->delete();
                return back()->with('success','Post Like deleted successfully');
            }else{
                return back()->with('error','Post Like not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
