@extends('backend.layouts.main') 
@section('title', 'Paragraph Content Management')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Paragraph Content Management', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Paragraph Content </h5>
                            <span>Create a record for Paragraph Content </span>
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
                        <h3>Create Paragraph Content </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.site_content_managements.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">                                                     
                                    <div class="form-group ">
                                        <label for="code" class="control-label">Code <span class="text-red">*</span> </label>
                                        <input readonly   class="form-control" name="code" type="text" id="name" placeholder="Enter Code" value="{{ $code }}">
                                    </div>
                                                                                                                                                
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="value" class="control-label">Type <span class="text-red">*</span></label>
                                       <select name="type" id="remarkType" class="form-control select2" required>
                                        <option value="">Select Type</option>
                                        <option value="plain">Plain Text</option>
                                        <option value="ck_editor">Rich Text</option>
                                        <option value="webpage_link">Webpage Link</option>
                                        <option value="image_link">Image Link</option>
                                        <option value="document_link">Document Link</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="value" class="control-label">Value</label>
                                        <textarea  required class="form-control" name="value" placeholder="Value" id="txt_area" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="remark" class="control-label">Remark</label>
                                        <textarea  class="form-control" name="remark" placeholder="Remark" id="" ></textarea>
                                    </div>
                                </div>
                                                                
                               <div class="col-12">
                                    <div class="form-group">
                                        <button  type="submit" class="btn btn-primary">Create</button>
                                    </div>
                               </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
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
              $('#remarkType').on('change',function(){
                var type = $(this).val();
                if(type == 'ck_editor'){
                    CKEDITOR.replace('txt_area');
                }else{
                    if(CKEDITOR.instances.txt_area != undefined){
                        CKEDITOR.instances.txt_area.destroy();
                    }
                }
        });
        </script>
@endpush

