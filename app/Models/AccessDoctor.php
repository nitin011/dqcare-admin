<?php
/**
 * Class AccessDoctor
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

class AccessDoctor extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
    
    public function User(){
        return $this->belongsTo(User::class);
    }
    
    public function Doctor(){
        return $this->belongsTo(User::class,'doctor_id','id');
    }
}
