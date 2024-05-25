<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\WalletLog;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        try{
            $walletLogs = WalletLog::where('user_id', auth()->id())
                ->where('model', '!=', 'ScanSuperBonus')
                ->paginated()
                ->latest()
                ->get();

            return  $this->success($walletLogs);
        } catch (\Exception | \Error $e){
            return $this->errorOk('Something went wrong!', $e->getMessage());
        }
    }
}
