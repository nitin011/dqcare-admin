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
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revenueIndex(Request $request)
    {
        $length = 10;
        $revenues = User::query();
        // $revenues = $revenues->role('Doctor')->get();
        // return view('panel.revenue.index',compact('revenues'));
        if ($request->get('search')) {
            $revenues->where(function ($q) use ($request) {
                $q->where(\DB::raw("concat(first_name,' ',last_name)"), "like", '%' . $request->get('search') . '%');
            });
        }


        $revenues = $revenues->role('Doctor')->latest()->paginate($length);
        if ($request->ajax()) {
            return view('panel.revenue.load', ['revenues' => $revenues])->render();
        }

        return view('panel.revenue.index', compact('revenues'));

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
        ;

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
