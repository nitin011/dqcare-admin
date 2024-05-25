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

namespace App\Http\Controllers\Api\patient\share;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ShareController extends Controller
{
    public function shareIndex(Request $request)
    {
        // return 's';
        // Try
        try {
           

            // response
            return $this->successMessage('share index succesfully!'); 
        } catch (\Exception $e) {
            return $this->error("Sorry! Failed to data! ".$th->getMessage());
        }
    }
  
   
   
   

}
