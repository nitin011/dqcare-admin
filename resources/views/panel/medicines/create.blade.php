@extends('backend.layouts.main') 
@section('title', 'Medicines')
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
        ['name'=>'Add Medicines', 'url'=> "javascript:void(0);", 'class' => '']
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
                                <h5>Add Medicines</h5>
                                <span>Create a record for Medicines</span>
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
                            <h3>Add Medicines</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panel.medicines.store') }}" method="post" enctype="multipart/form-data" id="MedicineForm">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Medicine Name <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="medicine_name" type="text" name="medicine_name" value="{{old('name')}}"placeholder="Enter Medicine Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Company Name <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="company_name" type="text" name="company_name" value="{{old('company_name')}}"placeholder="Enter Company Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Content Name <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="content_name" type="text" name="content_name" value="{{old('content_name')}}"placeholder="Enter Medicine Content">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Medicine Type <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="types" type="text" name="types" value="{{old('types')}}"placeholder="Enter Medicine Types">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">ABC <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="abc" type="text" name="abc" value="{{old('abc')}}"placeholder="Enter ABC">
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
