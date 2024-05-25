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
use App\Models\DiagnosticCenter;

class DiagnosticCenterController extends Controller
{
    protected $now;
    private $resultLimit = 20;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function diagnosticCentersIndex(Request $request)
    {
        // return 's';
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $diagnostic_centers = DiagnosticCenter::query();

            if($request->get('state')){
                $diagnostic_centers->where('state_id','like', '%'.request()->get('state').'%');
            }
            if($request->get('city')){
                $diagnostic_centers->where('city_id','like', '%'.request()->get('city').'%');
            }
            if($request->get('pincode')){
                $diagnostic_centers->where('pincode','like', '%'.request()->get('pincode').'%');
            }
            
            if($request->get('district')){
                $diagnostic_centers->where('district','like', '%'.request()->get('district').'%');
            }
            
            $diagnostic_centers = $diagnostic_centers->with(['country'=>function($q){
                $q->select('id', 'name');
            },'state'=>function($q){
                $q->select('id', 'name');
            },'city'=>function($q){
                $q->select('id', 'name');
            }])
            ->latest()
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get();
           //response
            return $this->success($diagnostic_centers); 
        } catch (\Exception $th) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }

}
