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

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\ScanLog;
use App\Models\WalletLog;
use App\Models\DoctorReferral;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function doctorRank(Request $request)
    {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }

        if (request()->get('from') && request()->get('to')) {
            // $doctor_ranks = WalletLog::whereModel('Scan Super Bounus')
            $doctor_ranks = DB::table('wallet_logs')
                ->select('id', 'user_id', DB::raw("SUM(amount) as total"))
                ->whereModel('ScanSuperBonus')
                ->whereBetween('created_at', [\Carbon\Carbon::parse(request()->get('from'))->format('Y-m-d') . ' 00:00:00', \Carbon\Carbon::parse(request()->get('to'))->format('Y-m-d') . " 23:59:59"])
                ->whereType('credit')
                ->groupBy("user_id")
                ->orderBy('total', 'desc')
                ->limit(10)->get();
        } else {
            $doctor_ranks = WalletLog::select('id', 'user_id', \DB::raw("(sum(amount)) as total"))
                ->whereModel('ScanSuperBonus')->groupBy("user_id")
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
        }
        if ($request->ajax()) {
            return view('panel.report.doctor-rank.load', ['doctor_ranks' => $doctor_ranks])->render();
        }

        return view('panel.report.doctor-rank.index', compact('doctor_ranks'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function show($id)
    {
        //
        $article = Article::whereId($id)->first();
        return view('backend.constant-management.article.show', compact('article'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $chk = Article::whereId($id)->delete();
        if ($chk) {
            return back()->with('success', 'Article Deleted Successfully!');
        }
    }
}
