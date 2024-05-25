<?php
/**
 * Class Education
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

class Education extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = "educations";
    protected $guarded = ['id'];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
