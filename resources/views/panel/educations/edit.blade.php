@extends('backend.layouts.main') 
@section('title', 'Education')
@section('content')
@php
/**
* Education 
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
    ['name'=>'Edit Education', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Education</h5>
                            <span>Update a record for Education</span>
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
                        <h3>Update Education</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.educations.update',$education->id) }}" method="post" enctype="multipart/form-data" id="EducationForm">
                            @csrf
                            <div class="row">
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('degree') ? 'has-error' : ''}}">
                                        <label for="degree" class="control-label">Degree<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="degree" type="text" id="degree" value="{{$education->degree }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('college_name') ? 'has-error' : ''}}">
                                        <label for="college_name" class="control-label">College Name</label>
                                        <input   class="form-control" name="college_name" type="text" id="college_name" value="{{$education->college_name }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('field_study') ? 'has-error' : ''}}">
                                        <label for="field_study" class="control-label">Field Study</label>
                                        <input   class="form-control" name="field_study" type="text" id="field_study" value="{{$education->field_study }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
                                        <label for="start_date" class="control-label">Start Date</label>
                                        <input   class="form-control" name="start_date" type="date" id="start_date" value="{{$education->start_date }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
                                        <label for="end_date" class="control-label">End Date</label>
                                        <input   class="form-control" name="end_date" type="date" id="end_date" value="{{$education->end_date }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12 d-none"> 
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <input type="text" id="user_id" name="user_id" value="{{ NameById ($education->user_id)}}">
                                        {{-- <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(DoctorList()  as $option)
                                                <option value="{{ $option->id }}" {{ $education->user_id  ==  $option->id ? 'selected' : ''}}>{{ NameById ($option->id)}}</option> 
                                            @endforeach
                                        </select> --}}
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
        $('#EducationForm').validate();
                                                                                                                                
    </script>
    @endpush
@endsection
