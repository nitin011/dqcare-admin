@extends('backend.layouts.main') 
@section('title', 'FAQ')
@section('content')
@php
$index =  route('backend/constant-management.faqs.index');
$create = route('backend/constant-management.faqs.create');
$breadcrumb_arr = [
    ['name'=>'Faq', 'url'=> "$index", 'class' => ''],
    ['name'=>'Add', 'url'=> "$create", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add FAQ</h5>
                            <span>Create a record for FAQ</span>
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
                        <h3>Create FAQ</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.faqs.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">   
                                    <div class="form-group ">
                                        <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                            <label for="category_id">{{ __('Category')}} <span class="text-danger">*</span> </label>
                                            
                                            <select required name="category_id" id="category_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Category')}}</option>
                                                
                                                @foreach  (getFaqCategoyName('faq_categery') as $item)
                                                <option value="{{ $item->id }}" {{  old('category_id') == $item->id ? 'Selected' : '' }}>{{$item->name}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                         
                                    <div class="form-group">
                                        <label for="title" class="control-label">Title <span class="text-danger">*</span></label>
                                        <input required  placeholder="Enter Title" class="form-control" name="title" type="text" id="name" value="{{old('title')}}">
                                    </div>
                                </div>
                                <div class="col-md-12">                              
                                    <div class="form-group ">
                                        <label for="description" class="control-label">Description<span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="5" name="description" type="textarea" id="name" placeholder="Enter remark here..." value="{{old('description')}}"></textarea>
                                    </div>
                                </div>       
                                <div class="col-md-6 text-left mb-2">
                                    <div class="form-group {{ $errors->has('is_publish') ? 'has-error' : ''}}">
                                        <label for="is_publish" class="control-label">Publish</label><br>
                                        <input  checked  name="is_publish" type="checkbox" id="is_publish" class="js-single switch-input" value="1">
                                    </div>
                                </div>
                                <div class="col-md-12">
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
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    @endpush
@endsection
