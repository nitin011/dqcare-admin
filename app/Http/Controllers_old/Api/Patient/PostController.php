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

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;

class PostController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function PostsIndex(Request $request)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $posts = Post::query();
            //response

            if($posts->exists()){
               $posts = $posts->where('status',1)->with(['user'=>function($q){
                   $q->select('id', 'avatar', 'first_name', 'last_name');
               }])
               ->withCount('Comment','Like')->latest()
               ->limit($limit)
               ->offset(($page - 1) * $limit)->get();
                return $this->success($posts); 
            }
            else{
                return $this->errorOk('Post not exist!'); 
            }
        } catch (\Exception $th) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
  
    public function storePostComment(Request $request,$id)
    {
        try {
            $post = Post::whereId($id)->exists();
            if($post){
                $postComment = PostComment::where('post_id',$id)->with(['user'=>function($q){
                    $q->select('id', 'avatar', 'first_name', 'last_name');
                }]);
               if($postComment->exists()){
                $postComment = $postComment->get();
                   return $this->success($postComment); 
               }else{
                   return $this->errorOk('This Record is not exists!');
               }
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function storePostLike(Request $request)
    {
        try {
            $post = Post::where('id',$request->get('post_id'))->exists();
            $postLike = PostLike::where('user_id',auth()->id())->where('post_id',$request->get('post_id'));
            if($post){
               if(!$postLike->exists()){
                    $postLike = PostLike::create([
                        'user_id' => auth()->id(),
                        'post_id' => $request->get('post_id'),
                    ]);
                   return $this->successMessage('Post Like Data Created Successfully!'); 
               }else{
                   $postLike->delete();
                   return $this->successMessage('Post Like Data Deleted Successfully!');
                }
            }else{
               return $this->errorOk('Post id does\'t exist!');
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function PostLikeIndex(Request $request,$id)
    {
        try {
          $post = Post::where('id',$id)->exists();
          $postLikes = PostLike::where('post_id',$id)->with('User',function($q){
              $q->select('id', 'first_name', 'last_name', 'avatar', 'address', 'pincode', 'country', 'state', 'city','is_verified','salutation');
          });
          if($post){
              if($postLikes->exists()){
                $postLikes = $postLikes->get();
                return $this->success($postLikes);
              }else{
                return $this->errorOk('This post Like Data does\'t exist!');
              }
          }else{
              return $this->errorOk('This post id is does\'t exist plz enter valid post id!');
          }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function postStore(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'description'     => 'required',
        ]);
        
        try {
            $post = Post::create([
                'user_id' => auth()->id(),
                'description'=> $request->description,
            ]);
            return $this->successMessage('Post created successfully!'); 
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
    public function postCommentStore(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'comment'     => 'required',
        ]);
        
        $post_exist = Post::where('id',$request->get('post_id'))->exists();
        try {
            if($post_exist){
                $post = PostComment::create([
                    'user_id' => auth()->id(),
                    'post_id' => $request->get('post_id'),
                    'comment'=> $request->comment,
                ]);
                return $this->successMessage('Post Comment Created Successfully!'); 
            }else{
                return $this->errorOk('This Post id is not exist!'); 

            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function postDestroy(Request $request,$id)
    {
        try {
            $post = Post::where('id',$id)->first();
               if($post){
                $post->delete();
                   return $this->successMessage('The post has been successfully deleted!'); 
               }else{
                   return $this->errorOk('This Record is not exists!');
               }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function postCommentDestroy(Request $request,$id)
    {
        try {
            $postComment = PostComment::where('id',$id)->first();
               if($postComment){
                $postComment->delete();
                   return $this->successMessage('post Comment Deleted Successfully!'); 
               }else{
                   return $this->errorOk('This Record is not exists!');
               }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }
   

}
