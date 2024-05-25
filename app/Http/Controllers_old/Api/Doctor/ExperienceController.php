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
use App\Models\Experience;
use Auth;

class ExperienceController extends Controller
{
    public function experienceIndex(Request $request)
    {
        try {
           $experience = Experience::where('user_id',auth()->id())->with(['user'=>function($q){
            $q->select('id', 'avatar', 'first_name', 'last_name');
        }])->get();
           if($experience){
               return $this->success($experience); 
           }else{
               return $this->errorOk('Record is not exists!');
           }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }

    public function experienceStore(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
        ]);
        // Try
        try {
            $education = Experience::create([
                'title'=> $request->title,
                'clinic_name'=> $request->clinic_name,
                'location'=>$request->location,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'user_id'=>auth()->id(),
            ]);
           
        return $this->successMessage('Experience created successfully!'); 
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function ExperienceUpdate(Request $request,$id)
    {
        $this->validate($request, [
            'title'   => 'required',
        ]);
        try {
            $experience = Experience::whereId($id)->whereUserId(auth()->id())->first();
            if($experience){
                $experience->update([
                    'title'=> $request->title,
                    'clinic_name'=> $request->clinic_name,
                    'location'=>$request->location,
                    'start_date'=>$request->start_date,
                    'end_date'=>$request->end_date,
                ]);
                return $this->successMessage('Experience Data Updated Succesfully!'); 
            }else{
                return $this->errorOk('This Record is not available!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

    public function experienceDelete(Request $request,$id)
    {
        try {
            $experience = Experience::whereId($id)->whereUserId(auth()->id())->first();
            if($experience){
                $experience->delete();
                return $this->successMessage('Experience Data Deleted Succesfully!'); 
            }else{
                return $this->errorOk('This Record is not available!'); 
            }
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$e->getMessage());
        }
    }

}
