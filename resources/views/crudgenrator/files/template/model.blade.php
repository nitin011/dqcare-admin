<{{ $data['wildcard'] }}php
/**
 * Class {{ $data['model'] }}
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
@if(isset($data['softdelete']))
use Illuminate\Database\Eloquent\SoftDeletes;
@endif

class {{ $data['model'] }} extends Model
{
    use HasFactory;
    @if(isset($data['softdelete']))use SoftDeletes;
    @endif

    protected $guarded = ['id'];
}
