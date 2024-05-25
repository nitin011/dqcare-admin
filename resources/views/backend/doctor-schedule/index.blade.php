
@extends('backend.layouts.main') 
@section('title', 'Doctor Schedule')
@section('content')
@php
/**
 * Patient File 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
    $breadcrumb_arr = [
        ['name'=>'Patient Files', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush
    @php
    $arr = [
     ['day'=>'Monday','count' => getScheduleCountByDay('monday', $id), 'is_active'=>'active'],
     ['day'=>'Tuesday','count' => getScheduleCountByDay('tuesday', $id), 'is_active'=>''],
     ['day'=>'Wednesday','count' => getScheduleCountByDay('wednesday', $id), 'is_active'=>''],
     ['day'=>'Thursday','count' => getScheduleCountByDay('thursday', $id), 'is_active'=>''],
     ['day'=>'Friday','count' =>getScheduleCountByDay('friday', $id), 'is_active'=>''],
     ['day'=>'Saturday','count' => getScheduleCountByDay('saturday', $id), 'is_active'=>''],
     ['day'=>'Sunday','count' => getScheduleCountByDay('sunday', $id), 'is_active'=>''],
     ]
  @endphp
  <style>
    .wrapper .page-wrap .main-content{
        padding-left: 6px;
        margin-top: 30px;
    }
   .wrapper .page-wrap .footer {
    padding-left: 22px;
    }
    .wrapper .header-top {
        padding-left: 0;
    }
    .day-tab{
            font-size: medium;
            font-weight: 600;
        }
        .schedule-nav .nav-tabs li a.active {
            background: #f0f0f0;
            border: 1px solid #f0f0f0!important;
            color: #495057;
        }
        .nav-tabs .nav-link:focus, .nav-tabs .nav-link:hover {
            background-color: #eee;
            border-color: transparent;
            color: #272b41;
        }
        .doc-times{
            display: flex;
            flex-wrap: wrap;
        }
        .doc-slot-list {
            background-color: #495057;
            border: 1px solid #495057;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            margin: 10px 10px 0 0;
            padding: 6px 10px;
            font-weight: 700;
        }
        .doc-slot-list a {
            color: #fdfdfd;
            display: inline-block;
            margin-left: 5px;
            font-weight: 700;
        }
</style>
 @php
    $doctor_schedule = App\Models\Availability::where('user_id',$id)->first();
 @endphp

 {{-- @dd($doctor_schedule); --}}
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row">
                <div class="col-lg-3">
                   <div class="card">
                    <div class="card-body">
                        <div class="badge badge-{{ getWorkingUpdateStatus($access_doctor->doctor->working_availability)['color']}} badge-sm p-1" style="position: absolute; right: 15px;"><small>{{ getWorkingUpdateStatus($access_doctor->doctor->working_availability)['name']}}</small>
                         </div>
                         {{-- <span class="badge badge-{{ getStatus($item->status)['color']}} m-1">{{ getStatus($item->status)['name']}}</span>  --}}
                        <div class="text-center"> 
                            <div class="mx-auto">
                                <img src="{{ ($access_doctor && $access_doctor->avatar) ? $access_doctor->avatar: asset('backend/default/default-avatar.png') }}" class="rounded-circle mb-5" width="95" style="object-fit: cover; width: 95px; height: 95px" />
                            </div>
                            
                            <h4 class="card-title mt-5 mb-0">
                                {{NameById($access_doctor->doctor_id)}}
                            </h4>
                            <a href="" class="text-warning fw-600">
                                <i class="ik ik-phone" title="Call"></i>
                                {{$access_doctor->doctor->phone}}
                            </a>

                            <div class="text-center text-muted" title="Last Updated At">
                                <i class="ik ik-clock" ></i>
                                {{$access_doctor->doctor->updated_at->diffForHumans()}}
                            </div>
                            
                            <div id="alertDiv"  style="display: none !important;">
                                <hr>
                                <div class="alert alert-danger text-center mt-2 p-1">
                                   <h6 class="mb-0 fw-600">
                                    <i class="fas fa-hourglass fa-sm mr-3 fa-spin"></i> Kindly Update Information...
                                   </h6>
                                </div>                               
                                <span style="font-size: .6rem;" class="text-muted text-center">
                                 Last Updated At {{$access_doctor->doctor->updated_at}}
                                </span>
                            </div>
                           
                        </div>
                    </div>
                    </div> 
                </div>
                <div class="col-lg-9">
                    <div class="card">
                         <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link  setting-tab {{ (request()->get('type') == "queue" || request()->get('type') == "") ? 'active'  : ""}}" data-type="queue" data-active = "queue" id="pills-queue-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-queue" aria-selected="false">{{ __('General')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link setting-tab {{ request()->get('type') == "schedule" ? "active"  : ""}}" data-type="schedule" id="pills-schedule-tab" data-active = "schedule"  data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-schedule" aria-selected="false">{{ __('Schedule')}}</a>
                            </li>
                         </ul>
                         <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade {{ (request()->get('type') == "queue" || request()->get('type') == "") ? 'show active'  : ""}}" id="last-month" role="tabpanel" aria-labelledby="pills-queue-tab">
                                <form action="{{route('panel.access.appointment.store',$access_doctor->doctor_id)}}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-1">
                                                <h6 class="fw-500 text-primary">
                                                    <i class="fa fa-sliders" aria-hidden="true"></i> Appointment Management
                                                </h6>
                                            </div>
                                            <div class="col-md-6 col-6"> 
                                                <label>
                                                    {{ __('Waiting Period')}}
                                                    <i title="How many patients are sitting in clinic for checkup. Ex: 10" class="fas text-muted fa-info-circle"></i>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" placeholder="Enter Count Here..." class="form-control" name="waiting_period" value="{{$doctor_data->waiting_period}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Patients</span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-6 col-6"> 
                                                <label>
                                                    {{ __('Doctor Availability')}}
                                                    <i title="How many patients are sitting in clinic for checkup. Ex: 10" class="fas text-muted fa-info-circle"></i>
                                                </label>
                                                    <select name="working_availability" id="working_availability" class="form-control">
                                                        <option value="" readonly>Select Availability </option>
                                                        @foreach (getWorkingUpdateStatus() as $item)
                                                        <option value="{{ $item['id'] }}" @if($item['id'] == $doctor_data->working_availability) selected @endif>{{ $item['name'] }}</option>  
                                                        @endforeach
                                                    </select>
                                                    {{-- @if($user->salutation !== null && $salutation['name'] == $user->salutation) {{__('Selected')}} @endif>{{ $salutation['name'] }}</option> --}}
                                                
                                            </div>
                                            
                                            <div class="col-md-12 col-12"> 
                                            <div class="form-group">
                                                <label>{{ __('Clinic Update')}}</label>
                                                <textarea name="working_update" id="summary" class="form-control" placeholder="Enter Remark here..." >{{$doctor_data->working_update}}</textarea>
                                            </div>
                                            </div>
                                     </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            <h6 class="fw-500 text-primary">
                                                <i class="fa fa-cogs" aria-hidden="true"></i> Appointment Setting
                                            </h6>
                                        </div>
                                        <div class="col-md-6 col-6"> 
                                            <label>
                                                {{ __('Single Appointment Period')}}
                                                <i title="How much time doctor need to consult single patient. Ex: 10min" class="fas text-muted fa-info-circle"></i>
                                            </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="appointment_period" value="{{($doctor_data->appointment_period)}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">In minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right mb-2">Save & Update</button>
                                 </div>

                                </form>
                            </div>

                            <div class="tab-pane fade {{ request()->get('type') == "schedule" ? "show active"  : ""}}" id="previous-month" role="tabpanel" aria-labelledby="pills-schedule-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- <div class="card"> --}}
                                            <div class="pt-3 pl-3 mb-1">
                                                <h6 class="fw-500 text-primary">
                                                    <i class="ik ik-calendar pr-2" ></i>Schedule Timings
                                                </h6>
                                                
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="border p-1">
                                                    <div class="schedule-widget mb-0">
                                                        <div class="schedule-nav">
                                                            <ul class="nav nav-tabs nav-justified ">
                                                                @foreach ($arr as $item)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link day-tab {{ $item['is_active'] }}"  data-type="schedule" data-toggle="tab" href="#slot_{{ $item['day'] }}">{{ $item['day'] }}({{ $item['count'] }})</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="tab-content schedule-cont" >
                                                               {{-- @dd($doctor_schedule) --}}
                                                                @foreach ($arr as $item)
                                                                    <div id="slot_{{ $item['day'] }}"class="tab-pane fade show {{ $item['is_active'] }}">
                                                                        <div class="card-title ">
                                                                            <div class="schedule-{{ $item['day'] }}">
                                                                                @if( $item['count'] > 0  && $doctor_schedule->schedules && $doctor_schedule->where('user_id',$doctor_schedule->user_id)->where('day',($item['day']))->first() )
                                                                                    <div class="doc-times">                                                                                 
                                                                                        @foreach( $doctor_schedule->where('user_id',$doctor_schedule->user_id)->where('day', $item['day'])->first()->schedules as $index => $schedule)
                                                                                            <div class="doc-slot-list">
                                                                                                @auth
                                                                                                {{Carbon\Carbon::parse($schedule->from)->format('H:i A') }}
                                                                                                -
                                                                                                {{ Carbon\Carbon::parse($schedule->to)->format('H:i A')}}
                                                                                                @endauth
                                                                                                <a href="{{route('panel.access.destroy',['index' => $index,'day'=>$item['day'],'id' => $doctor_schedule->user_id])}}"
                                                                                                    class="delete_schedule confirm">
                                                                                                    <i class="fa fa-times"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        @endforeach
                            
                                                                                    </div>
                                                                                @else
        
                                                                                    <div class="p-3 mx-auto text-center">
                                                                                        <img width="55px" src="{{ asset('backend/img/schedule/no-schedule.png') }}" alt="no_schedule">
                                                                                        <p class="text-center ">No Schedules yet!</p>
                                                                                    </div>
                                                                                    
                                                                                @endif
                                                                            </div>
                                                                            <div>
                                                                                <button type="button"class="btn btn-secondary add-new-schedule-btn"data-day="{{ $item['day'] }}"style="float: right;
                                                                                position: absolute;
                                                                                right: 11px;
                                                                                top: 20px;"><i class="fas fa-plus"></i>Add New</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
 <!-- Modal -->
 <div class="modal fade" id="addNewScheduleModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
 aria-labelledby="addNewScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('panel.access.store',$id) }}" method="post">
                @csrf
                <input type="hidden" name="day" id="dayInput">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewScheduleModalLabel">Add new schedule for <span id="dayLabel"></span></h5>
                    <button type="button" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="from_time">From</label>
                        <input type="time" class="form-control" name="from_time" id="from_time" required>
                    </div>
                    <div class="form-group">
                        <label for="to_time">to</label>
                        <input type="time" class="form-control" name="to_time" id="to_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- push external js -->
@push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        setTimeout(() => {
            $('#alertDiv').show();
        }, 600000);

        (function($) {
            @foreach ($arr as $item)
            $(".add-schedule-{{ $item['day'] }}").on('click', function () {
                var add_schedule_{{ $item['day'] }} = '<div class="row form-row schedule-{{ $item['day'] }}-cont">' +
                    '<div class="col-12 col-md-10 col-lg-11">' +
                    '<div class="row form-row">' +
                    '<div class="col-md-4 col-lg-4">' +
                    '<div class="form-group">' +
                    '<label>{{ trans('website.schedule.from') }}</label>' +
                    '<input type="time" name="from_datetime[]" class="form-control">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-4 col-lg-4">' +
                    '<div class="form-group">' +
                    '<label>{{ trans('website.schedule.to') }}</label>' +
                    '<input type="time" name="to_datetime[]" class="form-control">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-4 col-lg-4">' +
                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>' +
                    '<a href="#" class="delete-schedule-{{ $item['day'] }} btn btn-danger trash"><i class="far fa-trash-alt"></i></a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                $(".schedule-{{ $item['day'] }}").append(add_schedule);
                ///$(".schedule-{{ $item['day'] }}").append(add_schedule{{ $item['day'] }});
                return false;
            });
    
            $(document).on("click", ".delete-schedule-{{ $item['day'] }}", function () {
                $(this).closest('.schedule-{{ $item['day'] }}-cont').remove();
                return false;
            });
            @endforeach
    
            $(document).on("click", ".add-new-schedule-btn", function () {
                var day = $(this).data('day');
                $("#addNewScheduleModal #dayInput").val(day);
                $("#dayLabel").html("<strong>"+day+"</strong>");
                $("#addNewScheduleModal").modal('show');
            });
    
        })(jQuery);

        $('.nav-link').click(function(){
        updateURLParam('type',$(this).data('type'));
      });
       
      $('#closeBtn').on('click', function(){
        $("#addNewScheduleModal").modal('hide');
      });
    </script>
@endpush
@endsection

