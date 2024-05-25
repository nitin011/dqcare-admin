<div class="">
    <div class="card-body">
{{--        <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST" class="form-horizontal">--}}
{{--            @csrf--}}
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center mb-3">
                        <span class="font-weight-bold d-block mr-1">Name: </span>
                        <span>{{ $user->first_name . ' ' . $user->last_name }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="font-weight-bold d-block mr-1">Email: </span>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <span class="font-weight-bold d-block mr-1">Phone: </span>
                        <span>{{ $user->phone }}</span>
                    </div>
                    {{-- <div class="d-flex align-items-center mb-3">
                        <span class="font-weight-bold d-block mr-1">Phone: </span>
                        <span>{{ $user->phone }}</span>
                    </div> --}}
                    <div class="d-flex align-items-center mb-3">
                        <span class="font-weight-bold d-block mr-1">Date Of Birth: </span>
                        <span>{{ $user->dob }}</span>
                    </div>
                </div>
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="name">{{ __('First Name')}}<span class="text-red">*</span></label>--}}
{{--                        <input type="text" placeholder="First Name" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}">--}}
{{--                    </div>  --}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="lname">{{ __('Last Name')}}<span class="text-red">*</span></label>--}}
{{--                        <input type="text" placeholder="Last Name" class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}">--}}
{{--                    </div>  --}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>--}}
{{--                        <input type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">--}}
{{--                    </div>  --}}
{{--                </div>--}}

{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="phone">{{ __('Phone No')}}</label>--}}
{{--                        <input type="number" placeholder="123 456 7890" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="dob">{{ __('Date of birth')}}</label>--}}
{{--                        <input class="form-control" type="date" name="dob" placeholder="Select your date" value="{{$user->dob}}" />--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="">{{ __('Status')}} </label>--}}
{{--                        <select required name="status" class="form-control select2"  >--}}
{{--                            <option value="" readonly>{{ __('Select Status')}}</option>--}}
{{--                            @foreach (getStatus() as $index => $item)--}}
{{--                                <option value="{{ $item['id'] }}" {{ $user->status == $item['id'] ? 'selected' :'' }}>{{ $item['name'] }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="country">{{ __('Country')}}</label>--}}
{{--                        <select name="country" id="country" class="form-control select2">--}}
{{--                            <option value="" readonly>{{ __('Select Country')}}</option>--}}
{{--                            @foreach (\App\Models\Country::all() as  $country)--}}
{{--                                <option value="{{ $country->id }}" @if($user->country != null) {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name == 'India') selected @endif>{{ $country->name }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="state">{{ __('State')}}</label>--}}
{{--                        <select name="state" id="state" class="form-control select2">--}}
{{--                            @if($user->state != null)--}}
{{--                                <option  required value="{{ $user->state }}" selected>{{ fetchFirst('App\Models\State', $user->state, 'name') }}</option>--}}
{{--                            @endif--}}
{{--                        </select>--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="city">{{ __('City')}}</label>--}}
{{--                        <select name="city" id="city" class="form-control select2">--}}
{{--                            @if($user->city != null)--}}
{{--                                <option required value="{{ $user->city }}" selected>{{ fetchFirst('App\Models\City', $user->city, 'name') }}</option>--}}
{{--                            @endif--}}
{{--                        </select>--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="pincode">{{ __('Pincode')}}</label>--}}
{{--                        <input id="pincode" type="number" class="form-control" name="pincode" placeholder="Enter Pincode" value="{{ $user->pincode ?? old('pincode') }}" >--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                {{-- @if ($user->roles[0]->name == "User")
                <div class="col-md-3">
                    <div class="form-group">
                            <label for="doctor">{{ __('Primary Doctor')}}</label>
                        <select required name="doctor_id" id="selectDoctor"class="form-control  select2">
                                <option readonly value="">Select Doctor</option>
                                <option class="" value="" @if ($user->doctor_id == '') selected @endif>Other</option>
                                @foreach (DoctorList() as $index => $item)
                                    <option value="{{$item->id}}" @if ($user->doctor_id == $item->id) selected @endif>{{NameById($item->id)}}</option>
                                @endforeach
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                @endif --}}
                {{-- <div class="col-md-12 other-div d-none mb-2">
                    <textarea name="pri_dr_note" id="" class="form-control" cols="30" rows="5" placeholder="Primary Doctor Detail">{{$user->pri_dr_note}}</textarea>
                </div> --}}

{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="">Gender</label>--}}
{{--                        <div class="form-radio">--}}
{{--                                <div class="radio radio-inline">--}}
{{--                                    <label>--}}
{{--                                        <input type="radio" name="gender"  value="Male" {{ $user->gender == 'Male' ? 'checked' : '' }}>--}}
{{--                                        <i class="helper"></i>{{ __('Male')}}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <div class="radio radio-inline">--}}
{{--                                    <label>--}}
{{--                                        <input type="radio" name="gender" value="Female" {{ $user->gender == 'Female' ? 'checked' : '' }}>--}}
{{--                                        <i class="helper"></i>{{ __('Female')}}--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                        </div>--}}
{{--                        <div class="help-block with-errors"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <div class="form-group" style="margin-top: 20px;">--}}
{{--                        <div class="form-check mx-sm-2">--}}
{{--                            <label class="custom-control custom-checkbox">--}}
{{--                                <input type="checkbox" name="is_verified" class="custom-control-input" value="1" {{ $user->is_verified == 1 ? 'checked' : '' }}>--}}
{{--                                <span class="custom-control-label">&nbsp; Verified Profile</span>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}


                {{-- <div class="col-md-3">
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="form-check mx-sm-2">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="{{ now() }}" @if($user->email_verified_at != null)  checked @endif name="email_verified_at">
                                <span class="custom-control-label">&nbsp; Email verified</span>
                            </label>
                        </div>
                    </div>
                </div> --}}

{{--                <div class="col-md-12">--}}
{{--                    <div class="form-group">--}}
{{--                        <label for="address">{{ __('Address')}}</label>--}}
{{--                        <textarea name="address" name="address" rows="3" class="form-control">{{ $user->address }}</textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}


           </div>


{{--            <button type="submit" class="btn btn-success"  >Update Profile</button>--}}
{{--        </form>--}}
    </div>
</div>
