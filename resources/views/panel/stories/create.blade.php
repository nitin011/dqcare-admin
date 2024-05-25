@extends('backend.layouts.main') 
@section('title', 'Story')
@section('content')
@php
/**
 * Story 
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
    ['name'=>'Add Story', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Story</h5>
                            <span>Create a record for Story</span>
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
                        <h3>Create Story</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.stories.store') }}" method="post" enctype="multipart/form-data" id="StoryForm">
                            @csrf
                            <div class="row">
                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>
                                                   {{NameById($option->id )}} - {{getUserPrefix($option->id)}}
                                                </option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12 d-none"> 
                                    
                                    <div class="form-group ">
                                        <label for="created_by">Created By<span class="text-danger">*</span></label>
                                        {{-- <select required name="created_by" id="created_by" class="form-control select2">
                                            <option value="" readonly>Select  Patient</option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('created_by') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select> --}}
                                        <input class="form-group" name="created_by" id="" value ="{{auth()->id()}}">
                                        

                                        
                                    </div>
                                </div>
                                
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
                                        <label for="date" class="control-label">Start Date<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="date" type="date" id="date" value="{{old('date')}}" placeholder="Enter Date" >
                                    </div>
                                </div>
                                                                                            
                                {{-- <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="detail" class="control-label">Detail <span class="text-danger"></span> </label>
                                        <textarea     class="form-control" name="detail" id="detail" placeholder="Enter Detail">{{ old('detail')}}</textarea>
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
        $('#StoryForm').validate();
                                                                                        
    </script>
    @endpush
@endsection
