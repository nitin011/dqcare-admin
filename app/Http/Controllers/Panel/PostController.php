<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
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
         $posts = Post::query();
         
            if($request->get('search')){ 
                $posts->whereHas('user',function($q){
                $q->where(\DB::raw("concat(first_name,' ',last_name)"),"like",'%'.request()->get('search').'%');
            }) 
                                ->orWhere('user_id','like','%'.$request->search.'%')
                                ->orWhere('description','like','%'.$request->search.'%') ;
                           
            }
            
            if($request->get('from') && $request->get('to')) {
                $posts->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse($request->to)->format('Y-m-d')." 23:59:59"]);
            }
            //status
            if($request->has('status') && $request->get('status') !==null) {
                $posts->where('status', $request->get('status'));
            }

            if($request->get('asc')){
                $posts->orderBy($request->get('asc'),'asc');
            }
            if($request->get('desc')){
                $posts->orderBy($request->get('desc'),'desc');
            }
            if($request->get('user_id')){
                $posts->where('user_id',$request->get('user_id'));
            }

            $posts = $posts->latest()->withCount('Like','Comment')->paginate($length);

            if ($request->ajax()) {
                return view('panel.posts.load', ['posts' => $posts])->render();  
            }
 
        return view('panel.posts.index', compact('posts'));
    }

    
        public function print(Request $request){
            $posts = collect($request->records['data']);
                return view('panel.posts.print', ['posts' => $posts])->render();  
           
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return view('panel.posts.create');
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
        // return $request->all();
        $this->validate($request, [
                        'user_id'     => 'required',
                          'status'     => 'required',
                        'description'     => 'sometimes',
                    ]);
        
        try{
               
               
            $post = Post::create($request->all());
                            return redirect()->route('panel.posts.index')->with('success','Post Management Created Successfully!');
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
    public function show(Post $post)
    {
        try{
            return view('panel.posts.show',compact('post'));
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
    public function edit(Post $post)
    {   
        try{
            
            return view('panel.posts.edit',compact('post'));
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
    public function update(Request $request,Post $post)
    {
        
        $this->validate($request, [
                        // 'user_id'     => 'required',
                          'status'     => 'required',
                        'description'     => 'sometimes',
                    ]);
                
        try{
                           
            if($post){
                       
                $chk = $post->update($request->all());

                return redirect()->route('panel.posts.index')->with('success','Record Updated!');
            }
            return back()->with('error','Post Management not found')->withInput($request->all());
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
    public function destroy(Post $post)
    {
        try{
            if($post){
                                      
                $post->delete();
                return back()->with('success','Post Management deleted successfully');
            }else{
                return back()->with('error','Post Management not found');
            }
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
