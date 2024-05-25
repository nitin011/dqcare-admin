<?php
/**
 * Class PostManagement
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Post extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];
    protected $table = 'posts';
    protected $appends = ['is_like'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function Comment() {
        return $this->hasMany(PostComment::class);
    }
    public function Like() {
        return $this->hasMany(PostLike::class);
    }
    public function getIsLikeAttribute() {
      $chk =  PostLike::where('post_id',$this->id)->where('user_id',auth()->id())->first();
      if($chk){
          return true;
      }else{
        return false;
      }
    }
}
