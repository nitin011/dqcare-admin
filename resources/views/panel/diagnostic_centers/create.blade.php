@extends('backend.layouts.main') 
@section('title', 'Diagnostic Center')
@section('content')
@php

$breadcrumb_arr = [
    ['name'=>'Add Diagnostic Center', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Diagnostic Center</h5>
                            <span>Create a record for Diagnostic Center</span>
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
                        <h3>Create Diagnostic Center</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.diagnostic_centers.store') }}" method="post" enctype="multipart/form-data" id="DiagnosticCenterForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('pincode') ? 'has-error' : ''}}">
                                        <label for="pincode" class="control-label">Pincode<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="pincode" type="number" id="pincode" value="{{old('pincode')}}" placeholder="Enter Pincode" >
                                    </div>
                                    
                                </div>   

                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="country_id">Country <span class="text-danger">*</span></label>
                                        <select required name="country_id" id="country" class="form-control select2">
                                            <option value="" readonly>Select Country </option>
                                            @foreach(App\Models\Country::all()  as $option)
                                                <option value="{{ $option->id }}" @if ($option->id == 101) selected @endif {{  old('country_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="state_id">State <span class="text-danger">*</span></label>
                                        <select required name="state_id" id="state" class="form-control select2">
                                            <option value="" readonly>Select State </option>
                                            
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="city_id">City <span class="text-danger">*</span></label>
                                        <select required name="city_id" id="city" class="form-control select2">
                                            <option value="" readonly>Select City </option>
                                            
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('district') ? 'has-error' : ''}}">
                                        <label for="district" class="control-label">District<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="district" type="text" id="district" value="{{old('district')}}" placeholder="Enter District" >
                                    </div>
                                </div>

                                 <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                        <label for="mobile" class="control-label">Phone no.<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="mobile_no" type="number" id="mobile" value="{{old('mobile')}}" placeholder="Enter Phone no" >
                                    </div>
                                </div>

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="addressline_1" class="control-label">AddressLine 1 <span class="text-danger">*</span> </label>
                                        <textarea  required   class="form-control" name="addressline_1" id="addressline_1" placeholder="Enter Addressline 1">{{ old('addressline_1')}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="addressline_2" class="control-label">AddressLine 2 </label>
                                        <textarea  class="form-control" name="addressline_2" id="addressline_2" placeholder="Enter Addressline 2">{{ old('addressline_2')}}</textarea>
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
    @endsection
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#DiagnosticCenterForm').validate();
        $(document).ready(function(){
            $('#state, #country, #city').css('width','100%').select2();

            function getStates(countryId =  101) {
                $.ajax({
                url: '{{ route("world.get-states") }}',
                method: 'GET',
                data: {
                    country_id: countryId
                },
                success: function(res){
                    $('#state').html(res).css('width','100%').select2();
                }
                })
            }
            getStates(101);

            function getCities(stateId =  101) {
                $.ajax({
                url: '{{ route("world.get-cities") }}',
                method: 'GET',
                data: {
                    state_id: stateId
                },
                success: function(res){
                    $('#city').html(res).css('width','100%').select2();
                }
                })
            }
            getStates(101);
            $('#country').on('change', function(e){
                getStates($(this).val());
            })

            $('#state').on('change', function(e){
            getCities($(this).val());
            })

        });                                                                                                                                                              
    </script>
    @endpush

