@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Website Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create New Website Enquiry')}}</h5>
                            <span>{{ __('Add a new record for Website Enquiry')}}</span>
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
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add Website Enquiry')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.user_enquiry.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="status" value="0">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="name" type="text" id="name" value="" placeholder="Enter Your Name" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                                <label for="type" class="control-label">{{ 'Type' }}<span class="text-red">*</span></label>
                                                <select required name="type" id="type" class="form-control select2"> 
                                                    <option value="email">{{ 'Email' }}</option> 
                                                    <option value="phone">{{ 'Number' }}</option> 
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('type_value') ? 'has-error' : ''}}">
                                                <label for="type_value" class="control-label">{{ 'Value' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="type_value" type="text" id="type_value" value="" placeholder="Enter Value" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                                <label for="subject">{{ __('Subject')}}<span class="text-red">*</span></label>
                                                <input class="form-control" name="subject" type="text" id="subject" value="" placeholder="Enter Your Subject" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}</label>
                                                <textarea class="form-control" name="description" type="text" id="description" value="" placeholder="Enter Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Create</button>
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
    @endpush
@endsection
