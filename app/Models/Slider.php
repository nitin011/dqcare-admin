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

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        $image = !is_null($value) ? asset('storage/backend/constant-management/sliders/'.$value) :
        'https://ui-avatars.com/api/?name='.$this->name.'&background=19B5FE&color=ffffff&v=19B5FE';
        // dd($image);
        if(\Str::contains(request()->url(), '/api/vi')){
          return asset($image);
        }
        return $image;
    }
}
