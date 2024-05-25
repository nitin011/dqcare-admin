@extends('backend.layouts.main') 
@section('title', 'Faq')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Faq', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Faq</h5>
                            <span>Update a record for Faq</span>
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
                        <h3>Update Faq</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.faqs.update',$faq->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">        
                                     <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                            <label for="category_id">{{ __('Category')}} <span class="text-danger">*</span> </label>
                                            <select required name="category_id" id="category_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Category')}}</option>
                                                @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 12) as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == $faq->category_id ? 'selected' : ''}}>{{ $item->name }}</option> 
                                                @endforeach
                                            </select>
                                     </div>
                                </div>
                                <div class="col-md-6">   
                                    <div class="form-group ">
                                        <label for="title" class="control-label">Title<span class="text-danger">*</span></label>
                                        <input required   class="form-control" name="title" type="text" id="name" value="{{$faq->title }}">
                                    </div>
                                </div>
                                <div class="col-md-12"> 
                                    <div class="form-group ">
                                        <label for="description" class="control-label">Description<span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="5" name="description" type="textarea" id="name" placeholder="Enter remark here..." >{{$faq->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group {{ $errors->has('is_publish') ? 'has-error' : ''}}">
                                        <label for="is_publish" class="control-label">Publish</label><br>
                                        <input @if($faq->is_publish == 1)  checked @endif  name="is_publish" type="checkbox" id="is_publish" class="js-single switch-input" value="1">
                                    </div>
                                </div>                                 
                                <div class="form-group col-md-12">
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
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    @endpush
@endsection
