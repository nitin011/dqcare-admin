@extends('backend.layouts.main') 
@section('title', 'User Addre')
@section('content')
@php
/**
* User Addre 
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
    ['name'=>'Edit User Addre', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit User Addre</h5>
                            <span>Update a record for User Addre</span>
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
                        <h3>Update User Addre</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_addres.update',$user_addre->id) }}" method="post" enctype="multipart/form-data" id="UserAddresForm">
                            @csrf
                            <div class="row">
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                        <label for="user_id" class="control-label">User Id<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="user_id" type="number" id="user_id" value="{{$user_addre->user_id }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="details" class="control-label">Details<span class="text-danger">*</span> </label>
                                        <textarea  required   class="form-control" name="details" id="details" placeholder="Enter Details">{{$user_addre->details }}</textarea>
                                    </div>
                                </div>
                                                                                             

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('is_primary') ? 'has-error' : ''}}"><br>
                                        <label for="is_primary" class="control-label">Is Primary<span class="text-danger">*</span> </label>
                                        <input  required  class="js-single switch-input" @if($user_addre->is_primary) checked @endif name="is_primary" type="radio" id="is_primary" value="1">
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
        $('#UserAddresForm').validate();
                                                                    
    </script>
    @endpush
@endsection
