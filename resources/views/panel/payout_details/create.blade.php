@extends('backend.layouts.main') 
@section('title', 'Payout Detail')
@section('content')
@php
/**
 * Payout Detail 
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
    ['name'=>'Add Payout Detail', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Payout Detail</h5>
                            <span>Create a record for Payout Detail</span>
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
                        <h3>Create Payout Detail</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.payout_details.store') }}" method="post" enctype="multipart/form-data" id="PayoutDetailForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                        <label for="user_id" class="control-label">User Id</label>
                                        <input  class="form-control" name="user_id" type="hidden" id="user_id" value="{{old('user_id')}}" placeholder="Enter User Id" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                        <label for="type" class="control-label">Type</label>
                                        <input  class="form-control" name="type" type="hidden" id="type" value="{{old('type')}}" placeholder="Enter Type" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('payload') ? 'has-error' : ''}}">
                                        <label for="payload" class="control-label">Payload</label>
                                        <input  class="form-control" name="payload" type="text" id="payload" value="{{old('payload')}}" placeholder="Enter Payload" >
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}"><br>
                                        <label for="is_active" class="control-label">Is Active</label>
                                        <input    class="js-single switch-input" @if(old('is_active'))  checked  @endif name="is_active" type="checkbox" id="is_active" value="1" >
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
        $('#PayoutDetailForm').validate();
                                                                                        
    </script>
    @endpush
@endsection
