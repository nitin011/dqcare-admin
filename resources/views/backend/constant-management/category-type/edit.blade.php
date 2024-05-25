@extends('backend.layouts.main') 
@section('title', 'Category Group')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Category Group', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Category Group')}}</h5>
                            <span>{{ __('Update a record for Category Group')}}</span>
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
            <div class="col-md-6 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update Category Type')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.category_type.update', $category_type->id) }}" method="post">
                            @csrf
                            <div class="row">
                                    <div class="col-md-6">   
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                            <label for="name" class="control-label">{{ ' Display Name' }}<span class="text-red">*</span></label>
                                            <input class="form-control" name="name" type="text" id="name" value="{{ isset($category_type->name) ? $category_type->name : ''}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">   
                                        <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                                            <label for="code" class="control-label">{{ 'Code' }}<span class="text-red">*</span></label>
                                            <input class="form-control" name="code" type="text" id="code" placeholder="code" value="{{ $category_type->code }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">   
                                        <div class="form-group {{ $errors->has('allowed_level') ? 'has-error' : ''}}">
                                            <label for="allowed_level">{{ __('Allowed Level')}}<span class="text-red">*</span></label>
                                            <select required name="allowed_level" id="allowed_level" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Allowed Level')}}</option>
                                                <option value="1" {{ $category_type->allowed_level == 1 ? 'selected' : ''}}>{{ __('1 - One Level')}}</option> 
                                                <option value="2" {{ $category_type->allowed_level == 2 ? 'selected' : ''}}>{{ __('2 - Two Level')}}</option>
                                                <option value="3" {{ $category_type->allowed_level == 3 ? 'selected' : ''}}>{{ __('3 - Three Level')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">     
                                        <div class="form-group {{ $errors->has('permission') ? 'has-error' : ''}}">
                                            <label for="permission">{{ __('Permission')}}<span class="text-red">*</span></label>
                                            <select  required name="permission_id" id="permission" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Permission')}}</option>
                                                @foreach (getAllPermission() as $permission)
                                                    <option @if($category_type->permission_id == $permission->id) selected @endif value="{{ $permission->id }}">{{ $permission->name }}</option> 
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-12">  
                                        <div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
                                            <label for="remark" class="control-label">{{ 'Remark' }}</label>
                                            <input class="form-control" rows="5" name="remark" type="textarea" id="remark" value="{{ isset($category_type->remark) ? $category_type->remark : ''}}" required>
                                        </div>
                                    </div>

                                      <div class="form-group mx-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
