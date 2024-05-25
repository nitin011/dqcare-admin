@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Website Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Website Enquiry')}}</h5>
                            <span>{{ __('Update a record for Website Enquiry')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update Website Enquiry')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.user_enquiry.update', $user_enq->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $user_enq->category_id }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="name" readonly type="text" id="name" value="{{ @$user_enq->name }}" placeholder="Enter Your Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                                <label for="status">{{ __('Status')}}<span class="text-red">*</span></label>
                                                <select required name="status" id="status" class="form-control select2">
                                                    <option value="0" {{ $user_enq->status == 0 ? 'selected' : ''}} >{{ __('Pending')}}</option>
                                                    <option value="1" {{ $user_enq->status == 1 ? 'selected' : ''}} >{{ __('Solved')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                                <label for="type" class="control-label">{{ 'Type' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="type" type="text" id="type" value="{{ @$user_enq->type_value }}" placeholder="Enter Type" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('type_value') ? 'has-error' : ''}}">
                                                <label for="type_value" class="control-label">{{ 'Type Value' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="type_value" type="text" id="type_value" value="{{ @$user_enq->type_value }}" placeholder="Enter Email id or Contact number" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                                <label for="subject">{{ __('Subject')}}<span class="text-red">*</span></label>
                                                <input class="form-control" name="subject" type="text" id="subject" value="{{ @$user_enq->subject }}" placeholder="Enter Your subject" readonly required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}<span class="text-red">*</span></label>
                                                <textarea class="form-control" name="description" readonly type="text" id="description" value="" placeholder="Enter Description" required>{{ @$user_enq->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Update</button>
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
