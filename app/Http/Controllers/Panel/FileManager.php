<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class FileManager extends Controller
{
    public function index(Request $request)
    {
        try{
            // if(AuthRole() == "Admin"){
            //     putenv("AllowPrivateFolder=false");
            //     putenv("AllowMultiUser=false");
            // }else{
            //     putenv("AllowPrivateFolder=true");
            //     putenv("AllowMultiUser=true");
            // }
           return view('backend.file-manager.index');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
