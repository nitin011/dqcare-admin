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
    ['name'=>'Add Education', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Education</h5>
                            <span>Create a record for Education</span>
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
                        <h3>Create Education</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.educations.store') }}" method="post" enctype="multipart/form-data" id="EducationForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('degree') ? 'has-error' : ''}}">
                                        <label for="degree" class="control-label">Degree<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="degree" type="text" id="degree" value="{{old('degree')}}" placeholder="Enter Degree" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('college_name') ? 'has-error' : ''}}">
                                        <label for="college_name" class="control-label">College Name</label>
                                        <input  class="form-control" name="college_name" type="text" id="college_name" value="{{old('college_name')}}" placeholder="Enter College Name" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('field_study') ? 'has-error' : ''}}">
                                        <label for="field_study" class="control-label">Field Study</label>
                                        <input  class="form-control" name="field_study" type="text" id="field_study" value="{{old('field_study')}}" placeholder="Enter Field Study" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
                                        <label for="start_date" class="control-label">Start Date</label>
                                        <input  class="form-control" name="start_date" type="date" id="txtFromDate" value="{{old('start_date')}}" placeholder="Enter Start Date" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
                                        <label for="end_date" class="control-label">End Date</label>
                                        <input  class="form-control" name="end_date" type="date" id="txtToDate" value="{{old('end_date')}}" placeholder="Enter End Date" >
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">Doctor<span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(DoctorList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{NameById($option->id)}}</option> 
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
        $('#EducationForm').validate();

      
                                                                                                                                
    </script>
    @endpush
@endsection
