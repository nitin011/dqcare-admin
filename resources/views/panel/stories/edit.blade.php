@extends('backend.layouts.main-ws')
@section('title', 'Story')
@section('content')
@php
    $breadcrumb_arr = [
        ['name'=>'Edit Story', 'url'=> "javascript:void(0);", 'class' => '']
    ]
@endphp
<!-- push external head elements to head -->
@push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/dist/summernote-bs4.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error {
            color: red;
        }
        .sticky {
            position: sticky !important;
            top: 80px;
            height: 75vh;
        }
        .border {
            border-radius: 10px;
            border: 1px dotted #007bff !important;
        }
        .add-btn {
            position: absolute;
            right: 25px !important;
            top: 35px;
        }
        .chart-card {
            /* overflow-x: scroll; */
        }
        .wrapper .header-top {
            padding-left: 0px !important;
        }
        .progress{
            display: block;
            text-align: center;
            width: 0;
            height: 3px;
            background: red;
            transition: width .3s;
        }
        .progress.hide {
            opacity: 0;
            transition: opacity 1.3s;
        }
        .card .nav-pills.custom-pills.bg-light-green .nav-link.active { color: #08671e;font-weight: bold; opacity: 1; background-color: transparent; border-bottom: 2px solid #08671e; }
        .card .nav-pills.custom-pills.bg-light-red.nav-link.active { color: #08671e;font-weight: bold; opacity: 1; background-color: transparent; border-bottom: 2px solid #08671e; }
    </style>
@endpush

{{-- <div id="progressDialog">
    <progress id="progress" value="32" style="width: -webkit-fill-available;" max="100"> 32% </progress>
</div> --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto"id="mapDiv">
            @if($story->type == 0)
            <div class="alert alert-warning">
                This mode allows HealthDetails' internal team to work on stories internally without affecting Patient Stories in Live Mode. Upon completion of story creation, the backend team needs to mark it as <i>reviewed</i> and then select <strong>Merge Dev to Live</strong> from Action.
            </div>
            @else 
            <div class="alert alert-warning">
                Using this mode, the HealthDetails team can work directly on the patient's live story and make <strong>changes in realtime</strong> that can be applied immediately to the patient's app. In case of a mishap, <i>Live story can also be rolled back to development.</i>
            </div>
            @endif
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
         <div class="card">
              <div class="">
                <div class="d-flex justify-content-between @if($story->type == 0) bg-light-red @elseif($story->type == 1) bg-light-green @else bg-primary @endif">
                    <div>
                        <ul class="nav nav-pills custom-pills @if($story->type == 0) bg-light-red @elseif($story->type == 1) bg-light-green @else bg-primary @endif" id="pills-tab" role="tablist" >
                            <li class="nav-item">
                                <a data-active="summary" class="nav-link active-swicher @if(request()->has('active') && request()->get('active') == "summary" || !request()->has('active')) active @endif" data-type="summary" id="pills-summary-tab" data-toggle="pill"
                                    href="#summary" role="tab" aria-controls="pills-summary"
                                    aria-selected="false">{{ __(' Summary') }}</a>
                            </li>
                            <li class="nav-item">
                                <a data-active="journey" class="nav-link active-swicher @if(request()->has('active') && request()->get('active') == "journey") active @endif" data-type="journey" id="pills-journey-tab" data-toggle="pill"
                                    href="#journey" role="tab" aria-controls="pills-journey"
                                    aria-selected="false">{{ __(' Detail Journey') }}</a>
                            </li>
                            <li class="nav-item">
                                <a data-active="chart" class="nav-link active-swicher @if(request()->has('active') && request()->get('active') == "chart") active @endif" data-type="chart" id="pills-chart-tab" data-toggle="pill" href="#chart"
                                    role="tab" aria-controls="pills-chart"
                                    aria-selected="true">{{ __('Charts') }}</a>
                            </li>
                            </li>
                            <li class="loader-ajax"style="position: fixed; right: 15px; bottom: 15px; z-index: 999999; font-weight: 800; background-color: rgb(188 246 190 / 66%); padding: 5px; border-radius: 10px; font-size: small; width: 120px; text-align: center;">
                                <div class="pt-5">
                                    <i class="fa fa-spin fa-spinner text-success fa-lg"></i> Saving
                                </div>
                            </li> 
                        </ul>
                    </div>
                    {{-- @dd($story->status) --}}
                    @can('story_staff_btn')
                        @if($story->status == 0)
                        <div class="p-2">
                            <a href="{{route('panel.stories.story-status',[$story->id,'status'=> 1])}}" class="btn btn-primary">Pass For Review</a>
                        </div>
                        @elseif($story->status == 1)
                        <div class="p-3">
                            {{-- <a href="{{route('panel.stories.story-status',[$story->id,'status'=> 2])}}" class="btn btn-success">Review</a> --}}
                            <label for="">Status:</label>
                            <span class="badge badge-{{getStoryStatus($story->status)['color']}}">
                                {{getStoryStatus($story->status)['name']}}
                            </span>
                        </div>
                        @elseif($story->status == 2)
                        <div class="p-3">
                            <label for="">Status:</label>
                            {{-- <a href="{{route('panel.stories.story-status',[$story->id,'status'=> 2])}}" class="btn btn-success">Review</a> --}}
                            <span class="badge badge-{{getStoryStatus($story->status)['color']}}">
                                {{getStoryStatus($story->status)['name']}}
                            </span>
                        </div>
                        @endif
                    @endcan
                    
                    @if (AuthRole() == "Admin")
                    <div class="p-2 d-flex development-mode" style="
                    ">
                        <div class="d-flex">
                            <div class="p-2">
                                @if($story->type == 0)
                                    <span class="text-danger fw-700"id="devlopment">Development Mode</span>
                                @else
                                    <span class="text-live fw-700">Live Mode</span>
                                @endif
                            </div>
                            <div class="dropdown p-1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    @if($story->type == 0)
                                        <a href="{{ route('panel.stories.edit', $storyLive->id) }}" title="Switch to Live" class="dropdown-item "><li class="p-0">Switch to Live</li></a>
                                    @else
                                        <a href="{{route('panel.stories.edit',$storyTemp->id) }}" title="Switch to Development" class="dropdown-item "><li class="p-0">Switch to Development</li></a>
                                    @endif

                                    @if($story->type == 0 && $story->status == 2 )
                                        <a href="{{route('panel.stories.story-live-update',$story->id)}}" title="Merge Dev to Live" class="dropdown-item switch-confirm"><li class=" p-0 fw-800 text-danger">Merge Dev to Live</li></a>
                                    @endif
                                    @if($story->type == 1)
                                        <a href="{{route('panel.stories.story-live-update',$story->id)}}" title="Merge Live to Dev" class="dropdown-item switch-confirm"><li class=" p-0 fw-800 text-danger">Merge Live to Dev</li></a>
                                    @endif
                                </ul>
                            </div> 
                        </div>
                        @if($story->type == 0)
                            <form action="{{route('panel.stories.update-status',$story->id)}}" method="get" id="updateProposalStatus">
                                <select class="form-control  select2"  aria-label="Default select example" id="changeProposalStatus" name="proposal_status">
                                    @foreach (getStoryStatus() as $status)
                                        <option  @if($story->status == $status['id']) selected @endif value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                        <button class="btn btn-info ml-2 mt-1" id="sidebar-hide-btn">Expand</button>
                    </div>
                    @endif
                </div>
                <form action="{{ route('panel.stories.update', $story->id) }}" method="post" enctype="multipart/form-data" id="StoryForm" class="tab-content" id="pills-tabContent">
                    {{-- Summary --}}
                    @include('panel.stories.includes.summary')

                    {{-- Detail Journey --}}
                    @include('panel.stories.includes.detailed-journey')

                    {{-- Chart --}}
                    @include('panel.stories.includes.chart')
                </form>
             </div>
         </div>
    </div>
        <div class="col-md-4 mx-auto sticky"id="sidebar">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 p-0">Documents</h6>
                </div>
                <div class="card-body mt-1 p-2" style="overflow: scroll;height: 75vh;">
                        {{-- @forelse($patientFiles as $k => $patientFile)
                            <p>{{ $patientFile->name }}</p>
                            <ul class="list-unstyled p-0">
                                @foreach($patientFile->patientFiles as $key => $file)
                                    <li class="px-4 py-2 mb-1 bg-light round">{{ collect(explode('/', $file->file))->last() }}</li>
                                @endforeach
                            </ul>
                        @empty    
                            <div class="p-5 m-5 mx-auto text-center text-muted">
                                
                                <div class="mt-5 pt-5">
                                    <i class="fa fa-file"></i>
                                    No Docs Uploaded!
                                </div>
                            </div>
                        @endforelse --}}
                    @forelse($document_dates as $k => $document_date)
                 
                        <div id="accordion">
                            <div class="accordion-header mb-3" id="group-{{ $k }}">
                                <button class="btn accordion-button " data-toggle="collapse"
                                    data-target="#groupcollaps-{{ $k }}" aria-expanded="true"
                                    aria-controls="groupcollaps-{{ $k }}">

                                    <span style="font-weight: 500; font-size: 1rem;">
                                        <i class="ik ik-calendar mt-1 mb-1"> </i>
                                        {{ \Carbon\Carbon::parse($document_date)->format('d M, Y') }}
                                    </span>
                                </button>
                                <div id="groupcollaps-{{ $k }}" class="collapse @if($k == 0) show @endif"
                                    aria-labelledby="group-{{ $k }}" data-parent="#accordion">
                                    <div class="accordion-body pt-3">
                                        @php
                                            $document_categories =
                                            App\Models\PatientFile::whereDate('date',$document_date)->whereUserId($story->user_id)->groupBy('category_id')->pluck('category_id');
                                        @endphp
                                        @foreach($document_categories as $document_category)
                                            <div class="">
                                                <h6 class="font-weight-bold text-muted">
                                                    {{ getCategoryNameById($document_category)->name ?? '' }}
                                                </h6>
                                                <ul class="list-unstyled">
                                                    @php
                                                        $document_docs =
                                                        App\Models\PatientFile::whereDate('date',$document_date)->whereCategoryId($document_category)->whereUserId($story->user_id)->get();
                                                    @endphp
                                                    @foreach($document_docs as $document_doc)
                                                  
                                                        <li class="bg-light w-100 p-2 mt-1 ">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <div class=""
                                                                        style="font-size: .9rem; font-weight: 600;">
                                                                        @if($document_doc->title)
                                                                          {{ $document_doc->title }}
                                                                        @else
                                                                          {{ getUserPrefix($document_doc->id) }}
                                                                        @endif
                                                                        @if((\Carbon\Carbon::parse($storyLive->updated_at)) < (\Carbon\Carbon::parse($document_doc->created_at)))
                                                                            <small class="text-warning" title="Document Uploaded after last merge"><i class="fa fa-sm fa-star fa-spin"></i></small>
                                                                        @endif
                                                                    </div>
                                                                    <span class="text-muted">
                                                                        <i class="ik ik-clock"></i>
                                                                        {{ $document_doc->created_at->diffForHumans() }}
                                                                    </span>
                                                                </div>

                                                                <div class="d-flex">
                                                                    <a target="_blank"
                                                                        href="{{ route('panel.patient_files.edit', $document_doc->id) }}"
                                                                        class="btn btn-icon btn-sm m-0 p-0 text-warning mx-1"><i
                                                                            class="ik ik-edit"></i></a>
                                                                    <a target="_blank"
                                                                        href="{{ route('panel.patient_files.view',$document_doc->id) }}"
                                                                        class="btn btn-icon btn-sm m-0 p-0 text-info "><i
                                                                            class="ik ik-sm ik-eye "></i></a>
                                                                </div>
                                                            </div>
                                                            @if($document_doc->comment != null)
                                                                <div>
                                                                    <p class="text-muted p-0 mt-1">
                                                                        {{ $document_doc->comment }}
                                                                    </p>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty    
                        <div class="p-5 m-5 mx-auto text-center text-muted">
                            
                            <div class="mt-5 pt-5">
                                <i class="fa fa-file"></i>
                                No Docs Uploaded!
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- push external js -->

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        
        $('#StoryForm').validate();
        // ajax form update..
        var _type = 'btn_click';
        $(document).on('change', '.story_data', function () {
            _type = 'change';
            dataForm()
        });


        $('.loader-ajax').hide();
        $(document).on('change','input, textarea',function(){
            $('.loader-ajax').show();
        });

        $('.save_btn').on('click', function () {
            _type = 'btn_click';
            dataForm()
        })

        $(document).on('click', '.btn-danger', function () {
            setTimeout(() => {
                dataForm();
            }, 1000);
        });

        function dataForm() {
            for ( instance in CKEDITOR.instances )
            {
               $('.loader-ajax').show();
                CKEDITOR.instances[instance].updateElement();
            }
            
            var formdata = $('#StoryForm').serialize();
            var url = $('#StoryForm').attr('action');
       
            $.ajax({
                type: "POST",
                url: url,
                data: formdata, // serializes form input
                success: function (data) {
                    if (data.showToast == 1) {
                        $('.loader-ajax').hide();
                    }

                }
            });
        }
        var _type = 'btn_click';
        $(document).on('change', 'input', function (e) {
            //date chcek
            if($(this).hasClass('check_date')){
                var dateReg = /\d{4}-\d{2}-\d{2}/;             //regex pattern for YY-MM-DD
                if(!dateReg.test(e.target.value)){
                    alert('please Enter YY-MM-DD Pattern')
                }
                else{
                     dataForm()
                }
            }
            if($(this).hasClass('check_number')){
                if(isNaN(e.target.value)){textarea
                    e.target.value = ''
                    alert('only digit accepted')
               }else{
                dataForm()
               }
               
            }
        });

        // check date pattern 
        $(document).on('change', 'textarea', function (e) {
            dataForm()
        });
                   
        //check input type value is NaN

        $(document).on('keyup', '.check_number', function (e) {
            if(isNaN(e.target.value)){
                e.target.value = ''
                 return
            }
        
        });

        $('.submit_btn').on('click', function () {
            _type = 'btn_click';
            dataForm()
        });

        function updateURL(key,val){
        var url = window.location.href;
        var reExp = new RegExp("[\?|\&]"+key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

        if(reExp.test(url)) {
            // update
            var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
            var delimiter = reExp.exec(url)[0].charAt(0);
            url = url.replace(reExp, delimiter + key + "=" + val);
        } else {
            // add
            var newParam = key + "=" + val;
            if(!url.indexOf('?')){url += '?';}

            if(url.indexOf('#') > -1){
                var urlparts = url.split('#');
                url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
            } else {
                url += "?" + newParam;
            }
        }
        window.history.pushState(null, document.title, url);
    }
            $('.active-swicher').on('click', function() {
                var active = $(this).attr('data-active');
                updateURL('active',active);
            });
            $('#changeProposalStatus').on('change', function() {
                $('#updateProposalStatus').submit();
            });
    // code for progress bar//

//     $(function() {
//     $("#client").on("change", function() {
//       var clientid=$("#client").val();
//      //show the loading div here
//     $.ajax({
//             type:"post",
//             url:"clientnetworkpricelist/yourfile.php",
//         data:"title="+clientid,
//         success:function(data){
//              $("#result").html(data);
//           //hide the loading div here
//         }
//     }); 
//     });
// });    
        
        $("#sidebar-hide-btn").click(function() {
            if($('#mapDiv').hasClass('col-md-8')){
                $('#sidebar').hide();
                $('#mapDiv').removeClass('col-md-8');
                $('#mapDiv').addClass('col-md-12');
                $('#sidebar-hide-btn').html('Collaps');
            }else{
                $('#sidebar').show();
                $('#mapDiv').removeClass('col-md-12');
                $('#mapDiv').addClass('col-md-8');
                $('#sidebar-hide-btn').html('Expand');
            }
            
        });
    </script>
@endpush
@endsection
