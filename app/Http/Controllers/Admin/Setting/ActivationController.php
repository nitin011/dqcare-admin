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

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class ActivationController extends Controller
{
    //
    public function index()
    {
        return view('backend.setting.activation');
    }
   
    public function store(Request $request)
    {
        try {
            $setting = Setting::where('key', '=', $request->key)->first();
            if ($setting) {
                $setting->value = $request->val;
                $setting->group_name = "activation";
                $setting->save();
            }else{
                $data = new setting();
                $data->key = $request->key;
                $data->value = $request->val;
                $data->group_name = "activation";
                $data->save();
            }
      
           return response("Updated!",200);
           
        } catch (\Exception $e) {
            return response($e->getMessage(),200);
        }
    }

    public function env_key_update($data)
    {
        $file = DotenvEditor::load();
        foreach ($data as $key => $item){
            $file->setKey($key, $item);
        }
        $file->save();
    }

}
