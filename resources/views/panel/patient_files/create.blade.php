@extends('backend.layouts.main') 
@section('title', 'Patient File')
@section('content')
@php
/**
 * Patient File 
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
    ['name'=>'Add Patient File', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Patient File</h5>
                            <span>Create a record for Patient File</span>
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
                        <h3>Create Patient File</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.patient_files.store') }}" method="post" enctype="multipart/form-data" id="PatientFileForm">
                            @csrf
                            <div class="row">
                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{$option->id}}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{NameById($option->id)}}- {{getUserPrefix($option->id)}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                        <label for="title" class="control-label">Title<span class="text-danger">*</span> </label>
                                        <input required  maxlength="30" class="form-control" name="title" type="text" id="title" value="{{old('title')}}" placeholder="Enter Title" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
                                        <label for="date" class="control-label">Document Date<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="date" type="date" id="date" value="{{old('date')}}" placeholder="Enter Date" >
                                    </div>
                                </div>
                                                                                            
                                                                                                           
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="category_id">Category <span class="text-danger">*</span></label>
                                        <select required name="category_id" id="category_id" class="form-control select2">
                                            <option value="" readonly>Select Category </option>
                                            @foreach(App\Models\Category::where('category_type_id',16)->get()  as $option)
                                                <option value="{{ $option->id }}" {{  old('category_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                                        <label for="file" class="control-label">File<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="file_file" type="file" id="file" value="{{old('file')}}" >
                                        {{-- <img id="file_file" class="d-none mt-2" style="border-radius: 10px;width:100px;height:80px;"/> --}}
                                    </div>
                                </div>
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="comment" class="control-label">Comment </label>
                                        <textarea  class="form-control" name="comment" id="comment" placeholder="Enter Comment">{{ old('comment')}}</textarea>
                                    </div>
                                </div>
                                                     
                                                            
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
        $('#PatientFileForm').validate();
                                                                                                    
            document.getElementById('file').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                $('#file_file').removeClass('d-none');
                document.getElementById('file_file').src = src
            }
                    
    </script>
    @endpush
@endsection
