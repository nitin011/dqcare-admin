@extends('backend.layouts.main') 
@section('title', 'Doctor Referral')
@section('content')
@php
/**
* Doctor Referral 
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
    ['name'=>'Edit Doctor Referral', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Doctor Referral</h5>
                            <span>Update a record for Doctor Referral</span>
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
                        <h3>Update Doctor Referral</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.doctor_referrals.update',$doctor_referral->id) }}" method="post" enctype="multipart/form-data" id="DoctorReferralForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12 d-none"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        {{-- <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $doctor_referral->user_id  ==  $option->id ? 'selected' : ''}}>{{ NameById($option->id)}}</option> 
                                            @endforeach
                                        </select> --}}
                                        <input type="" name="user_id" id="user_id" value='{{$doctor_referral->user_id}}'>
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('party_name') ? 'has-error' : ''}}">
                                        <label for="party_name" class="control-label">Party Name<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="party_name" type="text" id="party_name" value="{{$doctor_referral->party_name }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
                                        <label for="date" class="control-label">Date<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="date" type="date" id="date" value="{{\Carbon\Carbon::parse($doctor_referral->date)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="remark" class="control-label">Remark<span class="text-danger">*</span> </label>
                                        <textarea  required   class="form-control" name="remark" id="remark" placeholder="Enter Remark">{{$doctor_referral->remark }}</textarea>
                                    </div>
                                </div>
                                                                                                                            
                                
                                                            
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
        $('#DoctorReferralForm').validate();
                                                                                        
    </script>
    @endpush
@endsection