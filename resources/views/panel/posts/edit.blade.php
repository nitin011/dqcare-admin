@extends('backend.layouts.main') 
@section('title', 'Post Management')
@section('content')
@php
/**
* Post Management 
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
    ['name'=>'Edit Post Management', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Post Management</h5>
                            <span>Update a record for Post Management</span>
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
                        <h3>Update Post Management</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.posts.update',$post->id) }}" method="post" enctype="multipart/form-data" id="PostManagementForm">
                            @csrf
                            <div class="row">
                                                            
                                {{-- <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id ">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()   as $option)
                                                <option value="{{ $option->id }}" {{ $post->user_id  ==  $option->id ? 'selected' : ''}}>{{  $option->first_name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select Status</option>
                                            @foreach(getPostManagementStatus() as $option)
                                                <option value="{{  $option['id'] }}"{{   $post->status  ==  $option['id']  ? 'selected' : ''}}>{{ $option['name']}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea  class="form-control" name="description" id="description" placeholder="Enter Description">{{$post->description }}</textarea>
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
        $('#PostManagementForm').validate();
                                                                    
    </script>
    @endpush
@endsection
