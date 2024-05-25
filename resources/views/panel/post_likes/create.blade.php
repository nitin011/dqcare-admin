@extends('backend.layouts.main') 
@section('title', 'Post Like')
@section('content')
@php
/**
 * Post Like 
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
    ['name'=>'Add Post Like', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Post Like</h5>
                            <span>Create a record for Post Like</span>
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
                        <h3>Create Post Like</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.post_likes.store') }}" method="post" enctype="multipart/form-data" id="PostLikeForm">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ request()->get('post_id') }}">
                            <div class="row">                                                     
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{NameById($option->id)}} - {{getUserPrefix($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                {{-- <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="post_id">Post <span class="text-danger">*</span></label>
                                        <select required name="post_id" id="post_id" class="form-control select2">
                                            <option value="" readonly>Select Post </option>
                                            @foreach(App\Models\PostManagement::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('post_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                                            
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
        $('#PostLikeForm').validate();
                                                
    </script>
    @endpush
@endsection
