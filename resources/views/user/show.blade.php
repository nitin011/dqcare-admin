@extends('backend.layouts.main')
@section('title', 'Show User')
@section('content')

    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    @endpush

    <style>
        .customer-buttons {
            margin-bottom: 15px;
        }

        .note-toolbar-wrapper {
            height: 50px !important;
            overflow-x: auto;
        }

        .dgrid {
            display: grid !important;
        }

        .modal-content {
            height: 350px !important;
            width: 400px;
        }
    </style>
    @php
        $statistics = [['a' => '#!', 'name' => 'Total Enquiry', 'count' => '2476', 'icon' => "<i class='fas fa-cube f-24 text-mute'></i>", 'col' => '3', 'color' => 'primary'], ['a' => '#!', 'name' => 'Total Ticket', 'count' => '2476', 'icon' => "<i class='fas fa-cube f-24 text-mute'></i>", 'col' => '3', 'color' => 'primary'], ['a' => '#!', 'name' => 'Total Lead', 'count' => '2476', 'icon' => "<i class='fas fa-cube f-24 text-mute'></i>", 'col' => '3', 'color' => 'primary'], ['a' => '#!', 'name' => 'Total Article', 'count' => '2476', 'icon' => "<i class='fas fa-user f-24 text-mute'></i>", 'col' => '3', 'color' => 'red']];
    @endphp

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-user bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ $user->name ?? '' }}</h5>
                            <span>User Name</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Patient') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>

        @include('backend.include.message')
        
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <div style="width: 150px; height: 150px; position: relative" class="mx-auto">
                                <img src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                    class="rounded-circle" width="150"
                                    style="object-fit: cover; width: 150px; height: 150px" />
                                <button class="btn btn-dark rounded-circle position-absolute"
                                    style="width: 30px; height: 30px; padding: 8px; line-height: 1; top: 0; right: 0"
                                    data-toggle="modal" data-target="#updateProfileImageModal"><i
                                        class="ik ik-camera"></i></button>

                            </div>
                            @if (getSetting('wallet_activation') == 1)
                                <div class=" d-flex mt-4 justify-content-center">
                                    <a class="text-muted" href="{{ route('panel.wallet_logs.index', $user->id) }}">
                                        <i class="fa fa-wallet"></i>
                                        {{ $user->wallet_balance }}
                                    </a>
                                </div>
                                <div>
                                    <div class="alert alert-success p-2 mb-0 mt-2" role="alert">
                                        <span class="text-dark " >
                                           Active OTP
                                            @if(isset($user->temp_otp) && $user->temp_otp !=="")
                                              {{ $user->temp_otp }}
                                            @else
                                              {{ __('0') }}
                                            @endif
                                        </span>
                                    </div>
                                    
                                </div>
                                @if($user->roles[0]->name == 'Doctor')
                                    @php
                                      $education = App\Models\Education::where('user_id',$user->id)->first();
                                      $experience_date = App\Models\Experience::where('user_id',$user->id)->first();
                                      if($experience_date){
                                        $date1=date_create($experience_date->start_date);
                                        $date2=date_create($experience_date->end_date);
                                        $diff=date_diff($date1,$date2);
                                        $experience =$diff->format('%R%y years %m months');
                                      }
                                      
                                    
                                    @endphp
                                    <div class=" d-flex mt-4 justify-content-center">
                                        <a class="text-muted mx-2" href="{{ route('panel.educations.index','doctor_id='.$user->id) }}">
                                            <i class="fa fa-school"></i>
                                            {{ $education->degree ?? 'N/A'}}
                                        </a>
                                        <a class="text-muted mx-2" href="{{ route('panel.experiences.index','doctor_id='.$user->id) }}">
                                            <i class="fa fa-book"></i>
                                            {{ $experience ?? 'N/A' }}
                                        </a>
                                    </div>
                                @endif
                               
                            @endif
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="card-body">
                        <small class="text-muted d-block pt-10">{{ __('Full Name') }} </small>
                        <h6>
                            {{ $user->first_name . ' ' . $user->last_name }}
                            <small class="mt-2 text-muted">({{ $user->roles[0]->name }})</small>
                        </h6>
                        <small class="text-muted d-block">{{ __('Email address') }} </small>
                        <h6>{{ $user->email ?? '' }}</h6>
                        <small class="text-muted d-block pt-10">{{ __('Phone Number') }}</small>
                        <h6>{{ $user->phone ?? '' }}</h6>
                        <small class="text-muted d-block pt-10">{{ __('Created At') }}</small>
                        <h6>{{ getFormattedDate($user->created_at) ?? '' }}</h6>
                        @if ($user->roles[0]->name == 'User')
                            @php
                                $priDrNot = [];
                                if ($user->pri_dr_note) {
                                    $priDrNot = json_decode($user->pri_dr_note, true);
                                }
                            @endphp
                            <small class="text-muted d-block pt-10">{{ __('Primary Doctor') }}</small>
                            <h6>
                                @if (isset($user->doctor_id) && $user->doctor_id != null)
                                    {{ NameById($user->doctor_id) }}
                                @else
                                    {{ $priDrNot != null ? 'Other(' . $priDrNot["doctor_name"] . ')' : '---' }}
                                @endif
                            </h6>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-7">

                {{-- tab start --}}
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="nav nav-pills custom-pills " id="pills-tab" role="tablist">
                            {{-- <li class="nav-item ">
                                <a class="nav-link active" id="pills-activity-tab" data-toggle="pill" href="#profile-tab"
                                    role="tab" aria-controls="pills-activity" aria-selected="true">{{ __('Profile') }}</a>
                            </li> --}}
                            {{-- <li class="nav-item">
                                <a class="nav-link " id="pills-note-tab" data-toggle="pill" href="#kyc-tab" role="tab" aria-controls="pills-note" aria-selected="false">{{ __('Kyc')}}</a>
                            </li> --}}
                            
                            {{-- @if ($user->roles[0]->name == 'Doctor')
                                <li class="nav-item">
                                    <a class="nav-link " id="pills-clinic-tab" data-toggle="pill" href="#clinic-tab" role="tab" aria-controls="pills-clinic" aria-selected="false">{{ __('Clinic Info')}}</a>
                                </li>
                            @endif --}}
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-password-tab" data-toggle="pill" href="#password-tab"
                                    role="tab" aria-controls="pills-password"
                                    aria-selected="false">{{ __('Change Password') }}</a>
                            </li>
                            @if($user->roles[0]->name == 'Doctor')
                                <li class="nav-item">
                                    <a class="nav-link " id="pills-document-tab" data-toggle="pill" href="#document-tab"
                                        role="tab" aria-controls="pills-document"
                                        aria-selected="false">{{ __(' Document') }}</a>
                                </li>
                            @endif
                        </ul>
                        <a href="{{url('panel/user/'.$user->id)}}" class="btn btn-outline-primary mx-2 px-2">
                            <i class="fa fa-edit m-0" aria-hidden="true"></i>
                        </a>
                    </div>
                    
                    <div class="tab-content" id="pills-tabContent">
                        {{-- <div class="tab-pane fade" id="kyc-tab" role="tabpanel" aria-labelledby="pills-note-tab">
                            @include('user.includes.kyc')
                        </div> --}}
                       
                        {{-- <div class="tab-pane fade show active" id="profile-tab" role="tabpanel"
                            aria-labelledby="pills-setting-tab">
                            @include('user.includes.details')
                        </div> --}}
                        
                        {{-- @if ($user->roles[0]->name == 'Doctor')
                            <div class="tab-pane fade" id="clinic-tab" role="tabpanel" aria-labelledby="pills-clinic-tab">
                                @include('user.includes.clinic-info')
                            </div>
                        @endif  --}}

                        <div class="tab-pane fade show active" id="password-tab" role="tabpanel" aria-labelledby="pills-setting-tab">
                            @include('user.includes.change-password')
                        </div>

                        <div class="tab-pane fade" id="document-tab" role="tabpanel" aria-labelledby="pills-document-tab">
                            @include('user.includes.doctor-document')
                        </div>


                    </div>
                </div>
            </div>
            {{-- tab end --}}
            {{-- Modals Start --}}

            <div class="modal fade" id="updateProfileImageModal" data-backdrop="static" data-keyboard="false"
                tabindex="-1" aria-labelledby="updateProfileImageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="{{ route('panel.update-profile-img', $user->id) }}" method="POST"
                        enctype="multipart/form-data" onsubmit="return checkCoords();">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateProfileImageModalLabel">Update profile image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center py-">
                                @csrf
                                <img src="{{ $user && $user->avatar ? asset($user->avatar) : asset('backend/default/default-avatar.png') }}"
                                    class="img-fluid w-50 mx-auto d-block" alt="" id="avatar_file">

                                <div class="form-group mt-5">
                                    <label for="avatar" class="form-label">Select profile image</label> <br>
                                    <input type="file" name="avatar" id="avatar"
                                        accept="image/jpg,image/png,image/jpeg">
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                <button type="submit" class="btn btn-success" id="w">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Modals End --}}

        </div>

    </div>
    </div>

    @push('script')
        <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
        <script src="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}">
        </script>
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/datedropper/datedropper.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-picker.js') }}"></script>

        <script>
            document.getElementById('avatar').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#avatar_file').removeClass('d-none');
                document.getElementById('avatar_file').src = src
            }

            function updateCoords(im, obj) {
                $('#x').val(obj.x1);
                $('#y').val(obj.y1);
                $('#w').val(obj.width);
                $('#h').val(obj.height);
            }

            function checkCoords() {
                if (parseInt($('#w').val())) return true;
                alert('Please select a crop region then press submit.');
                return false;
            }

            function getStates(countryId = 101) {
                $.ajax({
                    url: '{{ route('world.get-states') }}',
                    method: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(res) {
                        $('#state').html(res).css('width', '100%').select2();
                    }
                })
            }

            function getCities(stateId = 101) {
                $.ajax({
                    url: '{{ route('world.get-cities') }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(res) {
                        $('#city').html(res).css('width', '100%').select2();
                    }
                })
            }

            // Country, City, State Code
            $('#state, #country, #city').css('width', '100%').select2();

            $('#country').on('change', function(e) {
                getStates($(this).val());
            })

            $('#state').on('change', function(e) {
                getCities($(this).val());
            })

            // this functionality work in edit page
            function getStateAsync(countryId) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route('world.get-states') }}',
                        method: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(data) {
                            $('#state').html(data);
                            $('.state').html(data);
                            resolve(data)
                        },
                        error: function(error) {
                            reject(error)
                        },
                    })
                })
            }

            function getCityAsync(stateId) {
                if (stateId != "") {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: '{{ route('world.get-cities') }}',
                            method: 'GET',
                            data: {
                                state_id: stateId
                            },
                            success: function(data) {
                                $('#city').html(data);
                                $('.city').html(data);
                                resolve(data)
                            },
                            error: function(error) {
                                reject(error)
                            },
                        })
                    })
                }
            }
            $(document).ready(function() {
                $('.accept').on('click', function() {
                    $('#status').val(1)
                });
                $('.reject').on('click', function() {
                    $('#status').val(2)
                });
                $('.reset').on('click', function() {
                    $('#status').val(0)
                });
                var country = "{{ $user->country }}";
                var state = "{{ $user->state }}";
                var city = "{{ $user->city }}";

                if (state) {
                    getStateAsync(country).then(function(data) {
                        $('#state').val(state).change();
                        $('#state').trigger('change');
                    });
                }
                if (city) {
                    $('#state').on('change', function() {
                        if (state == $(this).val()) {
                            getCityAsync(state).then(function(data) {
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
