@extends('backend.layouts.main') 
@section('title', 'Post Comment')
@section('content')
@php
/**
* Post Comment 
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
    ['name'=>'Edit Post Comment', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Post Comment</h5>
                            <span>Update a record for Post Comment</span>
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
                        <h3>Update Post Comment</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.post_comments.update',$post_comment->id) }}" method="post" enctype="multipart/form-data" id="PostCommentForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="post_id">Post <span class="text-danger">*</span></label>
                                        <select required name="post_id" id="post_id" class="form-control select2">
                                            <option value="" readonly>Select Post </option>
                                            @foreach(App\Models\Post::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $post_comment->post_id  ==  $option->id ? 'selected' : ''}}>{{ NameById ($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $post_comment->user_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="comment" class="control-label">Comment<span class="text-danger">*</span> </label>
                                        <textarea  required   class="form-control" name="comment" id="comment" placeholder="Enter Comment">{{$post_comment->comment }}</textarea>
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
        $('#PostCommentForm').validate();
                                                                    
    </script>
    @endpush
@endsection
