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

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class UniversalController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function FirstRecord($model, $id){
        return $model::whereId($id)->first();
    }
    
    public function getRecords($model){
        return $model::all();
    }
    
    public function getTrashedRecords($model){
        return $model::onlyTrashed()->get();
    }

    public function storeRecord($model, $data){
        return  $rec = $model::create($data);
    }

    public function updateRecord($model, $id, $data){
        $rec = $model::findOrFail($id);
        return $rec->update($data);
    }

    public function deleteRecord($model, $id){
        $rec = $model::findOrFail($id);
            $rec->delete();
    }

    public function restoreRecord($model, $id){
        $data = $model::withTrashed()->findOrFail($id);
        $data->restore();
    }

}

