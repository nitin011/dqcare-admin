<?php


namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class QRController extends Controller
{
    public function index(Request $request)
    {
        try{
           return view('backend.qr.index');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function map(Request $request)
    {
        try{
           return view('backend.map_location.index');
        }catch(Exception $e){
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
