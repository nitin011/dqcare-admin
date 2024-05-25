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

namespace App\Http\Controllers\Api\Patient\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\PatientFile;
use App\Models\Category;
use App\Models\Story;

class ReportController extends Controller
{
    protected $now;
    private $resultLimit = 10;

    public function __construct()
    {
        $this->now = \Carbon\Carbon::now();
    }

    public function myReportIndex(Request $request, $id = null)
    {
        try {
             $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;
            $patientFile = Category::where('category_type_id',16);
            //story date
            if ($id != null) {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at')->where('user_id', $id)->where('type', 1)->latest()->first();
            } else {
                $stories = Story::select('id', 'user_id', 'chart', 'type','updated_at')->where('user_id', auth()->id())->where('type', 1)->latest()->first();
            }
            
            if($id != null){
                $patientFile =  $patientFile->with('patientFiles', function($q) use ($id){
                    $q->where('user_id', $id);
                });
            }else{
                $patientFile =  $patientFile->with('patientFiles', function($q){
                    $q->where('user_id', auth()->id());
                });
            }
            $patientFile = $patientFile->latest()->limit($limit)->offset(($page - 1) * $limit)->get();
            return $this->success(['updated_at' => $stories->updated_at ?? null, 'report' => $patientFile]); 
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e);
        }
    }

    public function patientReportIndex(Request $request, $id)
    {
        try {
            $page = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : $this->resultLimit;

            $patientFile = PatientFile::query();
            $patientFile = $patientFile->where('user_id', $id)->with(['user' => function ($q) {
                $q->select('id', 'first_name', 'salutation', 'email', 'phone', 'avatar', 'progress');
            }, 'category' => function ($q) {
                $q->select('id', 'name');
            }])->groupBy('category_id')->latest()->limit($limit)
                ->offset(($page - 1) * $limit)->get();
            //response
            return $this->success($patientFile);
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! " . $e->getMessage());
        }
    }
}
