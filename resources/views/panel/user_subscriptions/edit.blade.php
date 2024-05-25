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
    ['name'=>'Edit User Subscription', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Subscription</h5>
                            <span>Update a record for  Subscription</span>
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
                        <h3>Update  Subscription</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_subscriptions.update',$user_subscription->id) }}" method="post" enctype="multipart/form-data" id="UserSubscriptionForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <input type="text" readonly  id="user_id" class="form-control" value="{{ NameById($user_subscription->user_id)}}" >
                                    </div>
                                </div>

                                {{-- <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User<span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2" disabled="true">
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" @if($option->id == $user_subscription->user_id) {{__('selected')}} @endif>{{ NameById($user_subscription->user_id) }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                              
                                                                                            
                                {{-- <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="subscription_id">Subscription <span class="text-danger">*</span></label>
                                        <input type="text" name="subscription_id" id="subscription_id" class="form-control" value="{{fetchFirst('App\Models\Subscription',$user_subscription->subscription_id ,'name','--')}}" >
                                       
                                    </div>
                                </div> --}}

                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="subscription_id">Subscription <span class="text-danger">*</span></label>
                                        <select required name="subscription_id" id="subscription_id" class="form-control select2">
                                            <option value="" readonly>Select Subscription </option>
                                            @foreach(App\Models\Subscription::all()  as $option)
                                                <option value="{{ $option->id }}" @if($option->id == $user_subscription->subscription_id) {{__('selected')}}  @endif{{  old('subscription_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('from-date') ? 'has-error' : ''}}">
                                        <label for="from-date" class="control-label">From-date<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="from_date" type="date" id="from_date" value="{{\Carbon\Carbon::parse($user_subscription->from_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('to-date') ? 'has-error' : ''}}">
                                        <label for="to-date" class="control-label">To-date<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="to_date" type="date" id="to_date" value="{{\Carbon\Carbon::parse($user_subscription->to_date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                  @if($user_subscription->parent_id != null)
                                  <div class="col-md-6 col-12"> 
                                      <div class="form-group">
                                          <label for="parent_id">Parent <span class="text-danger"></span></label>
                                          <select name="parent_id" id="parent_id" class="form-control select2">
                                              <option value="" readonly>Select Parent </option>
                                              @foreach(App\User::all()  as $option)
                                                  <option value="{{ $option->id }}" {{ $user_subscription->parent_id  ==  $option->id ? 'selected' : ''}}>{{ NameById ($option->id)}}</option> 
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                    
                                  @endif                                                          
                                                            
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
                                                                                                            
    </script>
    @endpush
@endsection
