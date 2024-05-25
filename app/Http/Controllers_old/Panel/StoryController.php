<?php


namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;

use App\Traits\CanSendFCMNotification;
use App\User;
use Illuminate\Http\Request;
use App\Models\Story;
use App\Models\PatientFile;
use App\Models\Notification;

class StoryController extends Controller
{
    use CanSendFCMNotification;

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = 10;
        if (request()->get('length')) {
            $length = $request->get('length');
        }
        $stories = Story::query();

        if ($request->get('search')) {
            $stories->whereHas('user', function ($q) {
                $q->where(\DB::raw("concat(first_name,' ',last_name)"), "like", '%' . request()->get('search') . '%')
                    ->orWhere('id', 'like', '%' . request()->search . '%')
                    ->orWhere('created_by', 'like', '%' . request()->search . '%');


            });
        }

        if ($request->get('from') && $request->get('to')) {
            $stories->whereBetween('created_at', [\Carbon\Carbon::parse($request->from)->format('Y-m-d') . ' 00:00:00', \Carbon\Carbon::parse($request->to)->format('Y-m-d') . " 23:59:59"]);
        }

        if ($request->get('asc')) {
            $stories->orderBy($request->get('asc'), 'asc');
        }
        if ($request->has('status') && $request->get('status') != null) {
            $stories->whereStatus($request->get('status'));
        }
        if ($request->get('desc')) {
            $stories->orderBy($request->get('desc'), 'desc');
        }
        $stories = $stories->where('type', 0)->latest()->paginate($length);

        if ($request->ajax()) {
            return view('panel.stories.load', ['stories' => $stories])->render();
        }

        return view('panel.stories.index', compact('stories'));
    }

    public function print(Request $request)
    {
        $stories = collect($request->records['data']);
        return view('panel.stories.print', ['stories' => $stories])->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('panel.stories.create');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //    return $request->all();
        $this->validate($request, [
            'user_id' => 'required',
            'date' => 'required',
        ]);

        try {
            $chk = Story::whereUserId($request->user_id)->whereType(1)->whereNull('deleted_at')->first();
            if ($chk) {
                return back()->with('error', 'Story already exists for this user!');
            }
            $story = Story::create([
                'user_id' => $request->user_id,
                'created_by' => $request->created_by,
                'date' => $request->date,
                'type' => 1,
            ]);
            $story = Story::create([
                'user_id' => $request->user_id,
                'created_by' => $request->created_by,
                'date' => $request->date,
                'type' => 0,
            ]);
            return redirect()->route('panel.stories.edit', compact('story'))->with('success', 'Story Created Successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return  \Illuminate\Http\Response
     */
    public function show(Story $story)
    {
        try {
            return view('panel.stories.show', compact('story'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return  \Illuminate\Http\Response
     */
    public function edit(Story $story)
    {
        
        try {
            $storyLive = Story::where('user_id', $story->user_id)->where('type', 1)->first();
            $storyTemp = Story::where('user_id', $story->user_id)->where('type', 0)->first();
            $detail = json_decode($story->detail, true);
            $chart = json_decode($story->chart, true);
            // $story = Story::where()
            $document_dates = PatientFile::whereUserId($story->user_id)->groupBy('date')->pluck('date');
            $patientFiles = \App\Models\Category::where('category_type_id', 16);
            $patientFiles = $patientFiles->with('patientFiles', function ($q) use ($story) {
                $q->where('user_id', $story->user_id);
            });
            $patientFiles = $patientFiles->latest()->get();
            return view('panel.stories.edit', compact('story', 'detail', 'patientFiles', 'chart', 'storyLive', 'storyTemp', 'document_dates'));
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story)
    {
        // return $request->all();
        sleep(4);
        // Cases
        // @dump($detail);
        $detail = [
            'known_cases' => $request->known_cases,
            'family_history' => $request->family_history,
            'operative_history' => $request->operative_history,
            'habit_history' => $request->habit_history,
            'any_allergy' => $request->any_allergy,
            'current_medication' => $request->current_medication,
            'vaccination_history' => $request->vaccination_history,
            'opd_visit' => $request->opd_visit,
            'last_admitted' => $request->last_admitted,
            'bloodGroup' => $request->bloodGroup,
            'summary' => $request->summary,
        ];
        try {
            if ($story) {
                $request['detail'] = json_encode($detail);
                $chart_data = $request->all(['liver', 'kidney', 'lipid', 'diabetes', 'thyroid', 'urineTest', 'other', 'blood']);
                $encode_chart = json_encode($chart_data);
                $journey_data = $request->journey;
                $chk = $story->update([
                    // Summary
                    "dob" => $request->dob,
                    "age" => $request->age,
                    "date" => $request->date,
                    "status" => $request->status,
                    "remark" => $request->note,
                    "detail" => $request['detail'],
                    // Journey
                    "journey" => $journey_data,
                    // Chart Data
                    "chart" => $chart_data
                ]);
                if ($request->ajax()) {
                    return response()->json(['showToast' => 1, 'message' => "Story updated successfully"]);
                } else {
                    return back()->with('success', 'Story updated successfully');

                }
            }
            return back()->with('error', 'Story not found')->withInput($request->all());
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(Story $story)
    {
        try {
            if ($story) {

                $story->delete();
                return back()->with('success', 'Story deleted successfully');
            } else {
                return back()->with('error', 'Story not found');
            }
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function updateStatus(Story $story, Request $request)
    {
        try {
            if ($story) {
                $story->update(['status' => $request->proposal_status, "updated_by" => auth()->id()]);
                return back()->with('success', 'Status updated Successfully');
            }
            return back()->with('error', 'Story Not Found');
        } catch (\Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function storyLiveUpdate(Request $request, $id)
    {
        try {
            $story = Story::where('id', $id)->first();
            if ($story) {
                if ($story->type == 0) {
                    $storyLive = Story::where('user_id', $story->user_id)->where('type', 1)->first();
                    $storyLive->update([
                        'age' => $story->age,
                        'dob' => $story->dob,
                        'detail' => $story->detail,
                        'journey' => $story->journey,
                        'remark' => $story->note,
                        'chart' => $story->chart,
                        'remark' => $story->remark,
                    ]);

                    $user = User::where('id', $story->user_id)->first();
                    if ($user->fcm_token != null)
                        $this->fcm()
                            ->setTokens([$user->fcm_token])
                            ->setFcmServer(env('FCM_SERVER_KEY2'), env('FCM_SENDER_ID2'))
                            ->setTitle(config('app.name'))
                            ->setBody("Your story has been updated.")
                            ->send();

                    return back()->with('success', 'Story Merged to Live Successfully');
                } else {
                    $storyLive = Story::where('user_id', $story->user_id)->where('type', 0)->first();
                    $storyLive->update([
                        'age' => $story->age,
                        'dob' => $story->dob,
                        'detail' => $story->detail,
                        'journey' => $story->journey,
                        'remark' => $story->note,
                        'chart' => $story->chart,
                        'remark' => $story->remark,
                    ]);

                }
                return back()->with('success', 'Story Merged to Dev Successfully');
            }
            return back()->with('error', 'Story Not Found');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }

    public function storyStatus(Story $story, Request $request)
    {
       $admin_arr =  User::role('admin')->pluck('id');
        try {
            if($story) {
            if($admin_arr->count() > 0){
                 foreach($admin_arr as $admin_id){
                    Notification::create([
                        'user_id' => $admin_id,
                        'title' => '#SID'.$story->id.' '.'has been updated by'.' '.NameById($story->user_id),
                        'link' => url('panel/stories/edit',$story->id),
                        'notification' =>'Update to Review',
                        'is_readed' => 0,
                    ]);
                 }
            }
                 
                $story->update(['status' => $request->status]);
                return back()->with('success', 'Status updated Successfully');
            }
           
            return back()->with('error', 'Story Not Found');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
    public function sidebarStatus(Story $story, Request $request)
    {
      
        try {
            if($story) {
                $story->update(['status' => $request->status]);
                return back()->with('success', 'Status Expanded  Successfully');
            }
           
            return back()->with('error', 'Story Not Found');
        } catch (Exception $e) {
            return back()->with('error', 'There was an error: ' . $e->getMessage());
        }
    }
}
