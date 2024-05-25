
@extends('backend.layouts.main') 
@section('title', 'Add User')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Add User')}}</h5>
                            <span>{{ __('Create new user, assign roles & permissions')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home" ></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url('panel/users')}}">Users</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Add User')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                @include('backend.include.message')
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{ __('Add User')}}</h3>
                        <a href="javascript"  class="btn btn-icon btn-outline-primary" title="upload user bulk " data-toggle="modal" data-target="#UserBulkUpload"><i class="ik ik-upload"style="line-height: 2;" ></i></a>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('panel.create-user') }}" >
                        @csrf
                            <div class="row" style=" margin-right: 0px;
                            margin-left: 0px;">

                             <div class="col-md-4 d-none" id="salutation_container">
                                <div class="form-group">
                                    <label for="country">{{ __('Salutation')}}<span class="text-red">*</span></label>
                                        <select  name="salutation" id="salutation" class="form-control select2" required>
                                            @foreach (getSalutation() as  $salutation)
                                                <option value="{{ $salutation['name'] }}">{{ $salutation['name'] }}</option>
                                            @endforeach
                                        </select>
                                        
                                    <div class="help-block with-errors"></div>
                                </div>
                              </div>  

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{ __('First Name')}}<span class="text-red">*</span></label>
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name" required>
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
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name" required>
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
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                        <div class="help-block with-errors" ></div>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Assign role & view role permisions -->
                                    <div class="form-group">
                                        <label for="role">{{ __('Assign Role')}}<span class="text-red" required>*</span></label>
                                        {!! Form::select('role', $roles, null,[ 'class'=>'form-control select2', 'placeholder' => 'Select Role','id'=> 'role', 'required'=> 'required']) !!}
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="password">{{ __('Password')}}<span class="text-red">*</span></label>
                                        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" minlength="4" name="password" placeholder="Enter password" required>
                                        <div class="help-block with-errors"></div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt-4">
                                        <button type="button" class="btn btn-info generate_pass">Generate Password</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">{{ __('Gender')}}</label>
                                        <div class="form-radio">
                                            <form>
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="Male">
                                                        <i class="helper"></i>{{ __('Male')}}
                                                    </label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="Female">
                                                        <i class="helper"></i>{{ __('Female')}}
                                                    </label>
                                                </div>
                                            </form>
                                        </div>                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">{{ __('Contact Number')}}</label>
                                        <input id="phone" type="number" class="form-control" value=""name="phone" placeholder="Enter Contact Number" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dob">{{ __('DOB')}}</label>
                                        <input class="form-control" type="date" name="dob" placeholder="Select your date" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">{{ __('Country')}}</label>
                                        <select  name="country" id="country" class="form-control select2"  required>
                                            <option value="" readonly>{{ __('Select Country')}}</option>
                                            @foreach (\App\Models\Country::all() as  $country)
                                                <option value="{{ $country->id }}"  @if($country->name == 'India') selected @endif>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">{{ __('State')}}</label> 
                                        <select name="state" id="state" class="form-control select2" >
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">{{ __('City')}}</label>
                                        <select name="city" id="city" class="form-control select2" >
                                        </select> 
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="district">{{ __('District')}}<span class="text-red">*</span></label>
                                        <input id="district" type="text" class="form-control @error('name') is-invalid
                                          @enderror" name="district" value="{{ old('district') }}" placeholder="Enter district name" required>
                                        <div class="help-block with-errors"></div>
                                       
                                    </div>
                                </div>   


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pincode">{{ __('Pincode')}}</label>
                                        <input id="pincode" type="number" class="form-control" name="pincode" placeholder="Enter Pincode" >
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{ __('Status')}}<span class="text-red">*</span> </label>
                                        <select required name="status" class="form-control select2">
                                            @foreach (getStatus() as $index => $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="is_verified" class="control-label">Is Verified</label>
                                    <input name="is_verified" id="is_verified" type="checkbox" class="js-single switch-input"data-switchery="true"  value="1"/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">{{ __('Address')}}</label>
                                        <textarea id="address" type="text" class="form-control" name="address"  placeholder="Enter Address" ></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div> 
                                {{-- <div class="col-md-12" id="primaryDoctor">
                                    <div class="form-group">
                                        <label for="">{{ __('Primary Doctor')}}<span class="text-red"></span> </label>
                                        <select  name="doctor_id" id="selectDoctor"class="form-control select2">
                                          
                                            <option class="" value="">Other</option>
                                            @foreach (DoctorList() as $index => $item)
                                                <option value="{{$item->id}}" >{{ NameById($item->id)}}-{{getUserPrefix($item->id)}}</option> 
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                
                                </div> --}}
                                {{-- <div class="col-12">
                                    <hr>
                                </div> --}}
                                {{-- <div class= "border rounded pb-2 other-div mb-3 row d-none">

                                        <div class="col-md-12 other-div d-none mb-2 ">
                                            <label class=" d-block pt-10">{{ __('Primary Doctor Name') }}</label>
                                            <input name="pri_doctor_name"  id="" class="form-control" cols="30" required rows="5" placeholder="Primary Doctor Name" value="">
                                        </div>
                                        <div class="col-md-12 other-div d-none mb-2">
                                            <label class=" d-block pt-10">{{ __('Primary Doctor Phone') }}</label>
                                            <input name="pri_phone_no"  id="" class="form-control" cols="30" rows="5" required placeholder="Primary Doctor Phone" value="">
                                        </div>
                                        <div class="col-md-12 other-div d-none mb-2">
                                            <label class=" d-block pt-10">{{ __('Primary Doctor State') }}</label>
                                            <input name="pri_state"  id="" class="form-control" cols="30" rows="5" required placeholder="Primary Doctor State" value="">
                                        </div>
                                        <div class="col-md-12 other-div d-none mb-2">
                                            <label class=" d-block pt-10">{{ __('Primary Doctor Address') }}</label>
                                            <input name="pri_address"  id="" class="form-control" cols="30" rows="5" required placeholder="Primary Doctor Address" value="">
                                        </div>
                                        <div class="col-md-12 other-div d-none mb-2">
                                            <label class=" d-block pt-10">{{ __('Primary Doctor Pincode') }}</label>
                                            <input name="pri_pincode"  id="" class="form-control" cols="30" rows="5" required placeholder="Primary Doctor Pincode" value="">
                                        </div>
                                </div> --}}
                              
                                    <div class="col-md-12">

                                        <div>
                                            <button type="submit" class="btn btn-primary float-right">{{ __('Submit')}}</button>
                                        </div>
                                       
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="UserBulkUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import/Export User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.constant_management.bulk-user.upload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="alert alert-info" style="padding: 0.75rem 1rem;">
                                <p class="mb-0">First letter of role name should be capital.There are {{ $roles->count() }} Role in our platform.</p> 
                                <ul>
                                    @foreach ($roles as $role)
                                        <li>{{ $role }}</li>
                                    @endforeach
                                </ul> 
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ asset('utility/bulk-user/user-bulk-upload.xlsx') }}" class="btn btn-link" download=""><i class="ik ik-arrow-down"></i> Download Template</a>
                        </div>
                        <div class="form-group">
                            <label for="">Upload Updated Excel Template</label>
                            <input reuired type="file" class="form-control" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                        <button class="btn btn-primary" type="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script') 
 
		<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
   
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
         <!--get role wise permissiom ajax script-->
        <script src="{{ asset('backend/js/get-role.js') }}"></script>
        <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        
  
        <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script>
            $(document).ready(function(){
                // $('#role').on('change', function(){
                //     if ($(this).val() == 5 || $(this).val() == 2 || $(this).val() == 6)
                //      {
                //         $('#primaryDoctor').addClass('d-none'); 
                //         $('.other-div').addClass('d-none'); 
                //     }
                //     else{
                //         $('#primaryDoctor').removeClass('d-none');  
                //         $('.other-div').removeClass('d-none');
                //     }
                // });
                $('#state, #country, #city').css('width','100%').select2();
    
                    if($('#selectDoctor').val() == ""){
                        $('.other-div').removeClass('d-none');
                        
                    }else{
                        $('.other-div').addClass('d-none');
                    }
                $('#selectDoctor').change(function(){
                    if($(this).val() == ""){
                        $('.other-div').removeClass('d-none');
                        
                    }else{
                        $('.other-div').addClass('d-none');
                    }
                });
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
                $('#country').on('change', function(e){
                  getStates($(this).val());
                })


                $('#state').on('change', function(e){
                 getCities($(this).val());
                })
               
                //salutation
                $('#role').on('change', function(e){
                    if($(this).val() == 5){
                        $('#salutation_container').removeClass('d-none')
                    }else{
                        $('#salutation_container').addClass('d-none')
                    }
                  
                })

            });

            $('.generate_pass').on('click',function(){
                var length = 6;
                var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*ABCDEFGHIJKLMNOP1234567890";
                    var pass = "";
                    for (var x = 0; x < length; x++) {
                        var i = Math.floor(Math.random() * chars.length);
                        pass += chars.charAt(i);
                    }
                $('#password').val(pass);
            });
        </script>
    @endpush
@endsection
