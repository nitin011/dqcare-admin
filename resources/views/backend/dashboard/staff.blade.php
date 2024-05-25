@php

    $statistics_1 = [
    [ 'a' => route('panel.stories.index'),'name'=>'Total Stories Created','bg_color'=>'bg-teal',"count"=>App\Models\Story::count(), "icon"=>"<i
        class='ik ik-book f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.stories.index'),'name'=>' Underworking Stories','bg_color'=>'bg-cream',"count"=>App\Models\Story::where('status',0)->count(), "icon"=>"<i
        class='ik ik-book f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.stories.index'),'name'=>' Review Needed Stories ','bg_color'=>'bg-coffee',"count"=>App\Models\Story::where('status',1)->count(), "icon"=>"<i
        class='ik ik-book f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.stories.index'),'name'=>' Review Stories ','bg_color'=>'bg-brown',"count"=>App\Models\Story::where('status',2)->count(), "icon"=>"<i
        class='ik ik-book f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.patient_files.index','role=User'),'name'=>'Total Patients','bg_color'=>'bg-dark-coffee', "count"=>App\User::role('User')->count(),
"icon"=>"<i class='ik ik-users f-24'></i>" ,'col'=>'3', 'color'=> '#e1fae3'],
   ];

@endphp

<div class="row clearfix">
    @foreach ($statistics_1 as $item_1)
    <a class="@if($loop->iteration==5) col-12  
        @else col-lg-3 col-md-4 col-sm-12 @endif"href="{{ $item_1['a'] }}">
       
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
   