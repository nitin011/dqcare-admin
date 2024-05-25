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

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Education;
use Auth;

class EducationController extends Controller
{
    public function educationIndex(Request $request)
    {
        try {
           $education = Education::where('user_id',auth()->id())->with(['user'=>function($q){
            $q->select('id', 'avatar', 'first_name', 'last_name');
        }])->get();
           if($education){
               return $this->success($education); 
           }else{
               return $this->errorOk('Record is not exists!');
           }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }

    public function educationStore(Request $request)
    {
        $this->validate($request, [
            'degree'     => 'required',
        ]);
        // Try
        try {
            $education = Education::create([
                'degree'=> $request->degree,
                'college_name'=> $request->college_name,
                'field_study'=>$request->field_study,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'user_id'=>auth()->id(),
            ]);
           
        return $this->successMessage('Education created successfully!'); 
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function educationUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'degree'   => 'required',
        ]);
        try {
            $education = Education::whereId($id)->whereUserId(auth()->id())->first();
            if($education){
                $education->update([
                    'degree'=> $request->degree,
                    'college_name'=> $request->college_name,
                    'field_study'=>$request->field_study,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                    'user_id'=>auth()->id(),
                ]);
                return $this->successMessage('Education Data Updated Succesfully!'); 
            }else{
                return $this->errorOk('This Record is not available!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function educationDelete(Request $request,$id)
    {
        try {
            $education = Education::whereId($id)->whereUserId(auth()->id())->first();
            if($education){
                $education->delete();
                return $this->successMessage('Education Data Deleted Succesfully!'); 
            }else{
                return $this->errorOk('This Record is not available!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

}
