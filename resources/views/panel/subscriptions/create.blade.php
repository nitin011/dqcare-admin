@extends('backend.layouts.main') 
@section('title', 'Subscription')
@section('content')
@php
/**
 * Subscription 
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
    ['name'=>'Add Subscription', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Subscription</h5>
                            <span>Create a record for Subscription</span>
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
                        <h3>Create Subscription</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.subscriptions.store') }}" method="post" enctype="multipart/form-data" id="SubscriptionForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
                                    </div>
                                </div>
                                                                                                                            
                               
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('duration') ? 'has-error' : ''}}">
                                        <label for="duration" class="control-label">Duration<span class="text-danger">*</span></label>
                                        
                                        {{-- <input required  class="form-control input-group mb-3 input-group-append" name="duration" type="number" id="duration" value="{{old('duration')}}" placeholder="Enter Duration" >
                                         --}}
                                         <div class="input-group mb-2 mr-sm-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">In days</div>
                                                        </div>
                                                    <input type="number"  class="form-control" id="duration" name="duration" min="1" max="1000" value="{{old('duration')}}"placeholder="Enter Duration">
                                        </div>
                                    
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price" class="control-label">Price<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="price" type="number" min="5" id="price" value="{{old('price')}}" placeholder="Enter Price" >
                                    
                                    </div>
                                </div>

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('is_published') ? 'has-error' : ''}}"><br>
                                        <label for="is_published" class="control-label"> Published<span class="text-danger">*</span> </label>
                                        <input    required  class="js-single switch-input" @if(old('is_published'))   @endif name="is_published" type="checkbox" id="is_published" value="1" >
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
        $('#SubscriptionForm').validate();
                                                                                        
    </script>
    @endpush
@endsection
