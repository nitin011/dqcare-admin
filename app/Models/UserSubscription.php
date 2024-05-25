<?php
/**
 * Class UserSubscription
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
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class UserSubscription extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function getAvatarAttribute($value)
    {
        $avatar = !is_null($value) ? asset('storage/backend/users/'.$value) :
        urlencode('https://ui-avatars.com/api/?name='.$this->name.'&background=19B5FE&color=ffffff&v=19B5FE');
        // dd($avatar);
        if(\Str::contains(request()->url(), '/api/vi')){
          return asset($avatar);
        }
        return $avatar;
    }
}
