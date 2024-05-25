<style>
    .border {
        border-radius: 10px;
        border: 1px black !important;
        width: 651px;
        padding-bottom: 30px;


    }
</style>
@extends('backend.layouts.main')
@section('title', $user->name)
@section('content')
	<!-- push external head elements to head -->
	@push('head')
		<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
	@endpush


	<div class="container-fluid">
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<i class="ik ik-user-plus bg-blue"></i>
						<div class="d-inline">
							<h5>{{ __('Edit User')}}</h5>
							<span>{{ __('Create new user, assign roles & permissions')}}</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<nav class="breadcrumb-container" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="{{url('/')}}"><i class="ik ik-home"></i></a>
							</li>
							<li class="breadcrumb-item">
								<a href="#">{{ __('User')}}</a>
							</li>
							<li class="breadcrumb-item">
								<!-- clean unescaped data is to avoid potential XSS risk -->
								{{ clean($user->name, 'titles')}}
							</li>

						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="row">
			<!-- start message area-->
		@include('backend.include.message')
		<!-- end message area-->
			<div class="col-md-8 mx-auto">
				<div class="card">
					<div class="card-body">
						<form class="forms-sample" method="POST" action="{{ route('panel.update-user', $user->id) }}">
							@csrf
							<input type="hidden" name="id" value="{{$user->id}}">
							<div class="row" style=" margin-right: 0px;
                            margin-left: 0px;">
                              @if($user->roles[0]->name == "Doctor")
								<div class="col-md-4" id="salutation_container">
									<div class="form-group">
										<label for="country">{{ __('Salutation')}}<span class="text-red">*</span></label>
											<select  name="salutation" id="salutation" class="form-control select2" required>
												@foreach (getSalutation() as  $salutation)
													<option value="{{ $salutation['name'] }}" 
													 @if($user->salutation !== null && $salutation['name'] == $user->salutation) {{__('Selected')}} @endif>{{ $salutation['name'] }}</option>
												@endforeach
											</select>
											
										<div class="help-block with-errors"></div>
									</div>
								</div> 
                              @endif
								<div class="col-md-4">
									<div class="form-group">
										<label for="name">{{ __('First Name')}}<span class="text-red">*</span></label>
										<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name"
										       value="{{ $user->first_name }}" placeholder="Enter first name" required>
										<div class="help-block with-errors"></div>
										@error('name')
										<span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
										@enderror
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="name">{{ __('Last Name')}}<span class="text-red">*</span></label>
										<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name"
										       value="{{ $user->last_name }}" placeholder="Enter last name" required>
										<div class="help-block with-errors"></div>
										@error('name')
										<span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
										@enderror
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required
										       value="{{ clean($user->email, 'titles')}}" required>
										<div class="help-block with-errors"></div>

										@error('email')
										<span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
										@enderror
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">

										<label for="phone">{{ __('Contact Number')}}<span class="text-red">*</span></label>
										<input id="phone" type="number" class="form-control" name="phone" placeholder="Enter Contact Number" required
										       value="{{ $user->phone }}">

										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="password">{{ __('Password')}}</label>
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
										       placeholder="Enter password">
										<div class="help-block with-errors"></div>

										@error('password')
										<span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
										@enderror
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="password-confirm">{{ __('Confirm Password')}}</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation"
										       placeholder="Retype password">
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="gender">{{ __('Gender')}}<span class="text-red">*</span></label>
										<div class="form-radio">
											<form>
												<div class="radio radio-inline">
													<label>
														<input type="radio" name="gender" value="Male"{{ $user->gender == 'Male' ? 'checked' : '' }}>
														<i class="helper"></i>{{ __('Male')}}
													</label>
												</div>
												<div class="radio radio-inline">
													<label>
														<input type="radio" name="gender" value="Female"{{ $user->gender == 'Female' ? 'checked' : '' }}>
														<i class="helper"></i>{{ __('Female')}}
													</label>
												</div>
											</form>
										</div>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								{{-- user role start--}}
								  <input type="hidden" name="role" value="{{$user_role->id ?? ''}}" />
								{{-- user role end--}}
								{{-- <div class="col-md-4">
									<div class="form-group">
										<label for="role" required>{{ __('Assign Role')}}<span class="text-red">*</span></label>
										{!! Form::select ('role', $roles, $user_role->id??'' ,[ 'class'=>'form-control select2', 'placeholder' => 'Select Role','id'=> 'role', 'required'=>'required']) !!}
									</div>
								</div> --}}
								<div class="col-md-4">
									<div class="form-group">
										<label for="dob">{{ __('DOB')}}</label>
										<input class="form-control" type="date" name="dob" placeholder="Select your date" value="{{ $user->dob }}">
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="country">{{ __('Country')}}<span class="text-red">*</span></label>
										<select name="country" id="country" class="form-control select2" required>
											<option value="" readonly>{{ __('Select Country')}}</option>
											@foreach (\App\Models\Country::all() as  $country)
												<option value="{{ $country->id }}"
												        @if($user->country != null) {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name == 'India') selected @endif>{{ $country->name }}</option>
											@endforeach
										</select>

										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="state">{{ __('State')}}<span class="text-red">*</span></label>
										<select name="state" id="state" class="form-control select2" required>
											@if($user->state != null)
												<option value="{{ $user->state }}" selected>{{ fetchFirst('App\Models\State', $user->state, 'name') }}</option>
											@endif
										</select>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="city">{{ __('City')}}<span class="text-red">*</span></label>
										<select name="city" id="city" class="form-control select2" required>
											@if($user->city != null)
												<option value="{{ $user->city }}" selected>{{ fetchFirst('App\Models\City', $user->city, 'name') }}</option>
											@endif
										</select>
										<div class="help-block with-errors"></div>
									</div>
								</div>

								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">{{ __('District')}}<span class="text-red">*</span></label>
                                        <input id="district" type="text" value="{{$user->district}}" class="form-control @error('name') is-invalid
                                          @enderror" name="district" value="{{ old('district') }}" placeholder="Enter district name" required>
                                        <div class="help-block with-errors"></div>
                                       
                                    </div>
                                </div>  
								
								<div class="col-md-4">
									<div class="form-group">
										<label for="pincode">{{ __('Pincode')}}<span class="text-red">*</span></label>
										<input id="pincode" type="number" class="form-control" name="pincode" placeholder="Enter Pincode" required
										       value="{{ $user->pincode }}">
										<div class="help-block with-errors"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">{{ __('Status')}}<span class="text-red">*</span> </label>

										<select required name="status" class="form-control select2">
											<option value="" readonly>{{ __('Select Status')}}</option>
											@foreach (getStatus() as $index => $item)
												<option value="{{ $item['id'] }}" {{ $user->status == $item['id'] ? 'selected' :'' }}>{{ $item['name'] }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="is_verified" class="control-label">Is Verified</label>
									<input @if($user->is_verified == 1)  checked @endif  name="is_verified" id="is_verified" type="checkbox"
									       class="js-single switch-input" data-switchery="true" value="1"/>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label for="address">{{ __('Address')}}<span class="text-red">*</span></label>
										<textarea id="address" type="text" class="form-control" name="address" required
										          placeholder="Enter Address">{{ $user->address }}  </textarea>
										<div class="help-block with-errors"></div>
									</div>
								</div>
								@if ($user->roles[0]->name == "User")
									<div class="col-md-12" id="primaryDoctor">
										<div class="form-group">
											<label for="">{{ __('Primary Doctor')}}<span class="text-red"></span> </label>
											<select name="doctor_id" id="selectDoctor" class="form-control select2">
												<option readonly value="">Select Doctor</option>
												<option class="" value="" @if ($user->doctor_id == '') selected @endif>Other</option>
												@foreach (DoctorList() as $index => $item)
													<option value="{{$item->id}}"
															@if ($user->doctor_id == $item->id) selected @endif>{{NameById($item->id)}}</option>
												@endforeach
											</select>
											<div class="help-block with-errors"></div>
										</div>
									</div>
								@endif

								@if ($user->roles[0]->name == "User")
									@php
										$priDrNot = [];
										if(isset($user->pri_dr_note) && $user->pri_dr_note != null){
											$priDrNot = json_decode($user->pri_dr_note);
										}
									@endphp

									<div class="px-3 other-div d-none">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor Name') }}</label>
													<input name="pri_doctor_name" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor Name"
														value="{{@$priDrNot->doctor_name}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor Phone') }}</label>
													<input name="pri_phone_no" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor Phone"
														value="{{@$priDrNot->phone_no}}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor State') }}</label>
													<input name="pri_state" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor State"
														value="{{@$priDrNot->state}}">
												</div>
											</div>
											{{-- <div class="col-md-6">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor State') }}</label>
													<input name="pri_state" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor State"
														value="{{@$priDrNot->city}}">
												</div>
											</div> --}}
											<div class="col-md-6">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor Pincode') }}</label>
													<input name="pri_pincode" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor Pincode"
														value="{{@$priDrNot->pincode}}">
												</div>
											</div>
											{{-- @dd($priDrNot->address); --}}
											<div class="col-md-12">
												<div class="form-group">
													<label class=" d-block pt-10">{{ __('Primary Doctor Address') }}</label>
													<textarea name="pri_address" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor Address"
															value="">{{@$priDrNot->address}}</textarea>
												</div>
											</div>
										
										</div>
									</div>
								@endif
								
									
						
								@if($user->roles[0]->name == "Doctor")
									@php
										if(isset($user->pri_dr_note) && $user->pri_dr_note != null){
											$clinic_info = json_decode($user->pri_dr_note);
										}
									@endphp
									    <div class="px-3">
                                            <div class="row mt-1">
												<div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Name Of Clinic<span class="text-danger">*</span></label>
														<div class="form-icon position-relative">
															<i data-feather="key" class="fea icon-sm icons"></i>
															<input type="text" class="form-control ps-5" value="{{$clinic_info->name_of_clinic ?? ''}}" name="name_of_clinic" placeholder="Enter clinic name" required>
														</div>
													</div>
												</div><!--end col-->
								
												<div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Clinic Contact No.<span class="text-danger">*</span></label>
														<div class="form-icon position-relative">
															<i data-feather="key" class="fea icon-sm icons"></i>
															<input type="number" class="form-control ps-5" value="{{$clinic_info->clinic_contact_no ?? ''}}" name="clinic_contact_no" placeholder="Enter Contact no" required>
														</div>
													</div>
												</div><!--end col-->
								
												
								
												<div class="col-lg-12">
													<div class="form-group">
														<label for="state">{{ __('Name Of Clinic State')}}</label> 
														
														<select name="clinic_state" id="clinicInfoState" class="form-control select2" required>
															@if(isset($clinic_info->state))
																@if($clinic_info->state != null)
																	<option value="{{ $clinic_info->state }}" selected>{{ fetchFirst('App\Models\State', $clinic_info->state, 'name') }}</option>
																@endif
                                                            @else
															  @foreach (\App\Models\Country::all() as  $country)
																<option value="{{ $country->id }}"  @if($country->name == 'India') selected @endif>{{ $country->name }}</option>
															  @endforeach
															@endif
															
														</select>
														<div class="help-block with-errors"></div>
													</div>
												</div>
								
								
												<div class="col-lg-12">
													<div class="form-group">
														<label for="city">{{ __('Name Of Clinic City')}}</label>
														{{-- <select name="clinic_city" id="clinicInfoCity" class="form-control select2" >
														</select>  --}}
														<select name="clinic_city" id="clinicInfoCity" class="form-control select2" required>
															@if(isset($clinic_info->city))
																@if($clinic_info->city != null)
																	<option value="{{ $clinic_info->city }}" selected>{{ fetchFirst('App\Models\City', $clinic_info->city, 'name') }}</option>
																@endif
														    @endif 
															
														</select>
														<div class="help-block with-errors"></div>
													</div>
												</div>
								
								
												<div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Clinic Address<span class="text-danger">*</span></label>
														<div class="form-icon position-relative">
															<i data-feather="key" class="fea icon-sm icons"></i>
															<textarea name="clinic_address" class="form-control ps-5" placeholder="Enter Address">{{$clinic_info->address ?? ''}}
															</textarea>
														</div>
													</div>
												</div><!--end col-->
								
												{{-- <div class="col-lg-12">
													<div class="mb-3">
														<label class="form-label">Phone no.<span class="text-danger">*</span></label>
														<div class="form-icon position-relative">
															<i data-feather="key" class="fea icon-sm icons"></i>
															<input type="number" class="form-control ps-5" value="{{$clinic_info->phone_no  ?? ''}}" name="clinic_phone_no" placeholder="Enter phone no" required>
														</div>
													</div>
												</div><!--end col--> --}}
								
												
											</div><!--end row-->
										</div>
											
										
							
								@endif


								<div class="col-md-12">
									<div class="form-group d-flex justify-content-end">
										<button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
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
		<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>

		<script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
		<!--get role wise permissiom ajax script-->
		<script src="{{ asset('backend/js/get-role.js') }}"></script>
		<script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
		<script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
		<script src="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.min.js') }}"></script>
		<script src="{{ asset('backend/plugins/datedropper/datedropper.min.js') }}"></script>
		<script src="{{ asset('backend/js/form-picker.js') }}"></script>
		<script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
		<script>
            $(document).ready(function () {
                if ($('#role').val() == 5 || $('#role').val() == 2 || $('#role').val() == 6) {
                    $('#primaryDoctor').addClass('d-none');
                    $('.other-div').addClass('d-none');
                } else {
                    $('#primaryDoctor').removeClass('d-none');
                }
                $('#role').on('change', function () {
                    if ($(this).val() == 5 || $('#role').val() == 2 || $('#role').val() == 6) {
                        $('#primaryDoctor').addClass('d-none');
                    } else {
                        $('#primaryDoctor').removeClass('d-none');
                    }
                });

				//salutation
                $('#role').on('change', function(e){
                    if($(this).val() == 5){
						
                        $('#salutation_container').removeClass('d-none')
                    }else{
                        $('#salutation_container').addClass('d-none')
                    }
                  
                })
            });
            if ($('#selectDoctor').val() == "") {
                $('.other-div').removeClass('d-none');
            } else {
                $('.other-div').addClass('d-none');
            }
            $('#selectDoctor').change(function () {
                if ($(this).val() == "") {
                    $('.other-div').removeClass('d-none');

                } else {
                    $('.other-div').addClass('d-none');
                }
            });
            
            
            $('#country').change(function () {
              getStateAsync($(this).val());
				
            });
            getStateAsync(101);
			

            $('#state').change(function () {
                getCityAsync($(this).val());
            });


            getClinicState(101);
			@if($user->roles[0]->name == "Doctor")
			    @php
					if(isset($user->pri_dr_note) && $user->pri_dr_note != null){
						$clinic_info = json_decode($user->pri_dr_note);
					}
			    @endphp
			   

				$('#clinicInfoState').change(function () {
                  	getClinicCity($(this).val());
               	});

			   @if(isset($clinic_info))

					setTimeout(() => {
						$('#clinicInfoState').val("{{$clinic_info->state}}").change();
					}, 500);

					setTimeout(() => {
						$('#clinicInfoCity').val("{{$clinic_info->city}}").change();
					}, 1000);
					
					//getCities('{{$clinic_info->state}}');
               @endif 
			@endif
			

			
          
			
           


			{{--function getStates(countryId = 101) {--}}
			{{--	$.ajax({--}}
			{{--		url: '{{ route("world.get-states") }}',--}}
			{{--		method: 'GET',--}}
			{{--		data: {--}}
			{{--			country_id: countryId--}}
			{{--		},--}}
			{{--		success: function(res) {--}}
			{{--			$('#state').html(res).css('width', '100%').select2();--}}
			{{--		}--}}
			{{--	})--}}
			{{--}--}}

			{{--function getCities(stateId) {--}}
			{{--	$.ajax({--}}
			{{--		url: '{{ route("world.get-cities") }}',--}}
			{{--		method: 'GET',--}}
			{{--		data: {--}}
			{{--			state_id: stateId--}}
			{{--		},--}}
			{{--		success: function(res) {--}}
			{{--			$('#city').html(res).css('width', '100%').select2();--}}
			{{--		}--}}
			{{--	})--}}
			{{--}--}}

            // Country, City, State Code
            // $('#state, #country, #city').css('width', '100%').select2();
            //
            // $('#country').on('change', function (e) {
            //     getStates($(this).val());
            // })
            //
            // $('#state').on('change', function (e) {
            //     getCities($(this).val());
            // })

            // this functionality work in edit page
            function getStateAsync(countryId = 101) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route("world.get-states") }}',
                        method: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function (data) {
                            $('#state').html(data);
                            $('.state').html(data);
                            resolve(data)
                        },
                        error: function (error) {
                            reject(error)
                        },
                    })
                })
            }

            function getClinicState(countryId = 101) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route("world.get-states") }}',
                        method: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function (data) {
                            $('#clinicInfoState').html(data);
                             
                            resolve(data)
                        },
                        error: function (error) {
                            reject(error)
                        },
                    })
                })
            }

            function getClinicCity(stateId) {
                if (stateId !== "") {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route("world.get-cities") }}',
                            method: 'GET',
                            data: {
                                state_id: stateId
                            },
                            success: function (data) {
                                $('#clinicInfoCity').html(data);
                               
                                resolve(data)
                            },
                            error: function (error) {
                                reject(error)
                            },
                        })
                    })
                }
            }

            function getCityAsync(stateId) {
                if (stateId !== "") {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route("world.get-cities") }}',
                            method: 'GET',
                            data: {
                                state_id: stateId
                            },
                            success: function (data) {
                                $('#city').html(data);
                                $('.city').html(data);
                                resolve(data)
                            },
                            error: function (error) {
                                reject(error)
                            },
                        })
                    })
                }
            }

            $(document).ready(function () {
                var country = "{{ $user->country ?? 101 }}";
                var state = "{{ $user->state }}";
                var city = "{{ $user->city }}";

                if (state != '') {
                    getStateAsync(country).then(function (data) {
                        $('#state').val(state).change();
                        $('#state').trigger('change');
                    });
                }
                if (city != '') {
                    $('#state').on('change', function () {
                        if (state == $(this).val()) {
                            getCityAsync(state).then(function (data) {
                                $('#city').val(city).change();
                                $('#city').trigger('change');
                            });
                        }
                    });
                }

				
            });

		</script>
	@endpush
@endsection
