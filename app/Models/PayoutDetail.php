<?php
/**
 * Class PayoutDetail
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

use App\Traits\HasPagination;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayoutDetail extends Model
{

    use HasFactory, HasPagination;

    protected $guarded = ['id'];

    public const TYPE_UPI = 0;
    public const TYPE_BANK = 1;

    public function getPayloadAttribute($value)
    {
        return json_decode($value);
    }
}
