@extends('backend.layouts.main') 
@section('title', 'Scanlog')
@section('content')
@php
/**
 * Scanlog 
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
    ['name'=>'Add Scanlog', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Scanlog</h5>
                            <span>Create a record for Scanlog</span>
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
                        <h3>Create Scanlog</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.scanlogs.store') }}" method="post" enctype="multipart/form-data" id="ScanlogForm">
                            @csrf
                            <div class="row">
                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                                        <select required name="doctor_id" id="doctor_id" class="form-control select2">
                                            <option value="" readonly>Select Doctor </option>
                                            @foreach(DoctorList() as $option)
                                                <option value="{{ $option->id }}" {{  old('doctor_id') == $option->id ? 'Selected' : '' }}>{{ NameById($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{ NameById ($option->id)}} - {{getUserPrefix($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('interval') ? 'has-error' : ''}}">
                                        <label for="interval" class="control-label">Interval<span class="text-danger">*</span> </label>
                                        {{-- <input required  class="form-control" name="interval" type="number" id="interval" value="{{old('interval')}}" placeholder="Enter Interval" > --}}

                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">minutes</div>
                                            </div>
                                        <input required class="form-control" id="interval" type="number" min="0" name="interval" value="{{old('interval')}}"placeholder="Enter Interval">
                            </div>
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
        $('#ScanlogForm').validate();
                                                                    
    </script>
    @endpush
@endsection
