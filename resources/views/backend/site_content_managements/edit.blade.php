@extends('backend.layouts.main') 
@section('title', 'Paragraph Content Management')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Paragraph Content Management', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Paragraph Content </h5>
                            <span>Update a record for Paragraph Content </span>
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
                        <h3>Update Paragraph Content </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.site_content_managements.update',$site_content_management->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                                                                                            
                                    <div class="form-group ">
                                        <label for="code" class="control-label">Code <span class="text-red">*</span></label>
                                        <input required readonly  class="form-control" name="code" type="text" id="name" value="{{$site_content_management->code }}">
                                    </div>
                                </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="value" class="control-label">Type <span class="text-red">*</span></label>
                                           <select name="type" id="remarkType" class="form-control select2" required>
                                            <option value="">Select Type</option>
                                            <option value="plain" @if($site_content_management->type == 'plain') selected @endif>Plain Text</option>
                                            <option value="ck_editor" @if($site_content_management->type == 'ck_editor') selected @endif>Rich Text</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="value" class="control-label">Value</label>
                                            <textarea  required class="form-control" name="value" placeholder="Value" id="txt_area" >{{ $site_content_management->value }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="remark" class="control-label">Remark</label>
                                            <textarea  class="form-control" name="remark" placeholder="Remark" id="" >{{ $site_content_management->remark }}</textarea>
                                        </div>
                                    </div>
                                        
                                    <div class="col-md-12">
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
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
         var options = {
                  filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                  filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                  filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                  filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
              };
        $(document).ready(function(){
            var type = "{{ $site_content_management->type }}";
            if(type == 'ck_editor'){
                CKEDITOR.replace('value', options);
            }else{

            }
        });
        $('#remarkType').on('change',function(){
            var type = $(this).val();
            if(type == 'ck_editor'){
                CKEDITOR.replace('txt_area');
            }else{
                CKEDITOR.instances.txt_area.destroy();
            }
        });

    </script>
    @endpush
@endsection
