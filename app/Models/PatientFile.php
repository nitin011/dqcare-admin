<?php
/**
 * Class PatientFile
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

class PatientFile extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];
  
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function getFileAttribute($value)
    {
        $file = !is_null($value) ? $value : asset('storage/backend/img/placeholder.jpg');
        // dd($avatar);
        if(\Str::contains(request()->url(), '/api/v1')){
          return asset($file);
        }
        return $file;
    }
}
