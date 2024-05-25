@extends('backend.layouts.main') 
@section('title', 'Tests')
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
        ['name'=>'Add Tests', 'url'=> "javascript:void(0);", 'class' => '']
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
                                <h5>Add Tests</h5>
                                <span>Create a record for Tests</span>
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
                            <h3>Add Tests</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panel.tests.store') }}" method="post" enctype="multipart/form-data" id="TestsForm">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="doctor_id">Tests Name <span class="text-danger">*</span></label>
                                            <input required class="form-control" id="name" type="text" name="name" value="{{old('name')}}"placeholder="Enter Tests Name">
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
$('#TestsForm').validate();

        </script>
        @endpush
        @endsection
