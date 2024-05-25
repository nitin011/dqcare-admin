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
use App\Models\Article;

class ArticleController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function healthTipsIndex(Request $request)
    {
        // return 's';
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $articles = Article::query();
            if($request->get('category_id') && $request->get('category_id')){
                $articles->where('category_id',$request->get('category_id'));
            }else{

            }
            $articles = $articles->with(['user'=>function($q){
                $q->select('id', 'avatar', 'first_name', 'last_name');
            },'category'=>function($q){
                $q->select('id', 'name','icon');
            }])
            ->whereNotIn('id',FreezedBlogs())
            ->where('is_publish',1)
            ->latest()
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get();
           //response
            return $this->success($articles); 
        } catch (\Exception $th) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
  
    public function healthTipsShowIndex(Request $request,$id)
    {
        try {
           $article = Article::where('id',$id)->where('is_publish',1)->with(['user'=>function($q){
            $q->select('id', 'avatar', 'first_name', 'last_name');
        },'category'=>function($q){
            $q->select('id', 'name','icon');
        }])->first();
           if($article){
               return $this->success($article); 
           }else{
               return $this->errorOk('This Record is not exists!');
           }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
   

}
