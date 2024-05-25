@extends('backend.layouts.main') 
@section('title', 'User Subscription')
@section('content')
@php
/**
 * User Subscription 
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
    ['name'=>'Add User Subscription', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add User Subscription</h5>
                            <span>Create a record for User Subscription</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create User Subscription</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_subscriptions.store') }}" method="post" enctype="multipart/form-data" id="UserSubscriptionForm">
                            @csrf
                            @php    
                                $userSubsids = App\Models\UserSubscription::where('parent_id',null)->pluck('user_id');
                                $userData = App\User::whereIn('id',$userSubsids)->get();
                            @endphp 
                            {{-- @dd($userData); --}}
                            <div class="row" >
                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">Subscriber<span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{ NameById ($option->id)}} - {{getUserPrefix($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                  
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="subscription_id">Subscription <span class="text-danger">*</span></label>
                                        <select required name="subscription_id" id="subscription_id" class="form-control select2">
                                            <option value="" readonly>Select Subscription </option>
                                            @foreach(App\Models\Subscription::where('is_published',1)->get()  as $option)
                                                <option value="{{ $option->id }}" {{  old('subscription_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('from-date') ? 'has-error' : ''}}">
                                        <label for="from-date" class="control-label">From Date<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="from_date" type="date" id="from_date" value="{{old('from_date')}}" placeholder="Enter From-date" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('to-date') ? 'has-error' : ''}}">
                                        <label for="to-date" class="control-label">To Date<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="to_date" type="date" id="to_date" value="{{old('to_date')}}" placeholder="Enter To-date" >
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="parent_id">Link Subscription With<span class="text-danger"></span></label>
                                        <select name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="" readonly> Self Packages </option>
                                            @foreach($userData  as $option)
                                                <option value="{{ $option->id }}" {{  old('parent_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#UserSubscriptionForm').validate();
        $('#parent_id').change(function(){
            var id = $(this).val();
            if(id){
                $.ajax({
                    url: "{{route('panel.user_subscriptions.get-user-subscription-data')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        id:id
                    },
                    success: function(res){
                        $('#to_date').val(res.to_date);
                        $('#from_date').val(res.from_date);
                        
                        setTimeout(() => {
                            $('#subscription_id').val(res.subscription_id).change();
                        }, 200);

                        $('#to_date').prop('readonly', true);
                        $('#from_date').prop('readonly', true);
                        
                        
                        setTimeout(() => {
                            $('#subscription_id option:not(:selected)').attr('disabled', true);
                        }, 200);

                        // $('#subscription_id option:not(:selected)').attr('disabled', true);
                    }
                })
            }
        })  
    </script>
    @endpush
@endsection
