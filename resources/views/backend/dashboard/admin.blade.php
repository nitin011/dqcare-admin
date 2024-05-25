
@php
    $statistics_1 = [
    [ 'a' => route('panel.users.index','?role=User'),'name'=>'Total Patients','bg_color'=>'bg-dark-coffee', "count"=>App\User::role('User')->count(),
    "icon"=>"<i class='ik ik-users f-24'></i>" ,'col'=>'3', 'color'=> '#e1fae3'],

    [ 'a' => route('panel.users.index','?role=Doctor'),'name'=>'Total  Doctors
','bg_color'=>'bg-muted ', "count"=>App\User::role('Doctor')->count(),
    "icon"=>"<i class='fas fa-user-md f-24 text-mute'></i>" ,'col'=>'3',  'color'=> 'primary'],

    [ 'a' => route('panel.stories.index'),'name'=>'Total Stories Created
', 'bg_color'=>'bg-teal',"count"=>App\Models\Story::where('type',0)->count(), "icon"=>"<i
        class='ik ik-book f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.diagnostic_centers.index'),'name'=>'Total Diagnostic Centers
','bg_color'=>'bg-cream', "count"=>App\Models\DiagnosticCenter::count(), "icon"=>"<i
        class='ik ik-archive f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],
    [ 'a' => route('panel.constant_management.article.index',['is_publish' => 1]),'name'=>'Total Blog Published','bg_color'=>'bg-my', "count"=>App\Models\Article::where('is_publish',1)->count(), "icon"=>"<i
        class='ik ik-edit f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],
    [ 'a' => route('panel.posts.index'),'name'=>' Total Patient Posts
','bg_color'=>'bg-coffee', "count"=>App\Models\Post::count(), "icon"=>"<i
        class=' ik ik-image f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],
    [ 'a' => route('panel.scanlogs.index'),'name'=>'Total  Scans','bg_color'=>'bg-lightgreen', "count"=>App\Models\Scanlog::count(), "icon"=>"<i
        class='ik ik-tablet f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],
    [ 'a' => route('panel.user_subscriptions.index'),'name'=>'Total Subscribers
','bg_color'=>'bg-brown', "count"=>App\Models\UserSubscription::count(), "icon"=>"<i
        class=' ik ik-user-check f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],

    [ 'a' => route('panel.follow_ups.index'),'name'=>'Total Followups Created','bg_color'=>'bg-PastelYellow', "count"=>App\Models\FollowUp::count(), "icon"=>"<i
        class='ik ik-calendar f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],

    [ 'a' => route('panel.payouts.index').'?status=1&from='.date('Y-m-d').'&to='.date('Y-m-d'),'name'=>"Todays Payouts",'bg_color'=>'bg-teal', "count"=>App\Models\Payout::where('status', 1)->whereDate('created_at', '=', date('Y-m-d'))->count(), "icon"=>"<i
        class='ik ik-calendar f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],

    [ 'a' => route('panel.payouts.index').'?status=0','name'=>'Pending Payouts','bg_color'=>'bg-warning', "count"=>App\Models\Payout::where('status', 0)->count(), "icon"=>"<i
        class='ik ik-calendar f-24 text-mute'></i>" ,'col'=>'3', 'progress_color' => 'green' , 'color'=> 'red'],

    ['a' => route('panel.constant_management.user_enquiry.index'),'name'=> Carbon\Carbon::now()->format('M').' Enquiry','bg_color'=>'bg-dark-coffee' ,"count"=>App\Models\UserEnquiry::count(),
    "icon"=>"<i class='fa fa-info' ></i>" ,'col'=>'3', 'color'=> 'primary'],
	
	['a' => route('prescription.index'),'name'=> 'Total Prescription Generated','bg_color'=>'bg-dark-red' ,"count"=>App\Models\EPrescription::count(),
    "icon"=>"<i class='fa fa-random' ></i>" ,'col'=>'3', 'color'=> 'primary'],
    
    ['a' => route('prescription.index'),'name'=> 'Total Prescription Download','bg_color'=>'bg-dark-orange' ,"count"=>App\Models\PrescriptionDownload::count(),
    "icon"=>"<i class='fa fa-file-download' ></i>" ,'col'=>'3', 'color'=> 'primary'],
      
    ];

@endphp

{{-- 1st --}}
<div class="row clearfix">
    @foreach ($statistics_1 as $item_1)
        <a class="col-lg-4 col-md-6 col-sm-12" href="{{ $item_1['a'] }}">
            <div class="widget {{ $item_1['bg_color'] }}">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6>{{ $item_1['name'] }}</h6>
                            <h2>{{ $item_1['count'] }}</h2>
                        </div>
                        <div class="icon">
                            {!! $item_1['icon'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

@push('script')
@endpush
