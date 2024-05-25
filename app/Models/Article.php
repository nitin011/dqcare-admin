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
use App\User;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'articles';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

     /**
     * Get description_banner attribute with full path
     *
     * @param $value
     * @return string
     */
    public function getDescriptionBannerAttribute($value)
    {
        $description_banner = !is_null($value) ? ('storage/backend/article/'.$value) : asset('storage/backend/img/placeholder.jpg');
        // dd($avatar);
        if(\Str::contains(request()->url(), '/api/v1')){
          return asset($description_banner);
        }
        return $description_banner;
    }
}
