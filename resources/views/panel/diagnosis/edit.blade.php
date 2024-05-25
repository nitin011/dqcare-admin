@extends('backend.layouts.main') 
@section('title', 'Diagnosis')
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
        ['name'=>'Edit Symptoms', 'url'=> "javascript:void(0);", 'class' => '']
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
                                <h5>Edit Diagnosis</h5>
                                <span>Update a record for Diagnosis</span>
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
                            <h3>Update Diagnosis</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panel.diagnosis.update',$diagnosis->id) }}" method="post" enctype="multipart/form-data" id="DiagnosisForm">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Diagnosis Name <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="name" type="text" name="name" value="{{$diagnosis->name}}" placeholder="Enter Diagnosis Name">
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
    $('#DiagnosisForm').validate();

        </script>
        @endpush
        @endsection
