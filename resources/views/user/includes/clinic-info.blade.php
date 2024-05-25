<div class="">
    @php
      $clinic_info = json_decode($user->pri_dr_note);
    @endphp
    <div class="card-body">
        
         {{-- @dd($clinic_info) --}}
        <form method="post" action="{{ route('panel.update-clinic',$user->id) }}">
            @csrf
            <div class="row mt-1">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Name of clinic<span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="key" class="fea icon-sm icons"></i>
                            <input type="text" class="form-control ps-5" value="{{$clinic_info->name_of_clinic ?? ''}}" name="name_of_clinic" placeholder="Enter clinic name" required>
                        </div>
                    </div>
                </div><!--end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Contact no.<span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="key" class="fea icon-sm icons"></i>
                            <input type="number" class="form-control ps-5" value="{{$clinic_info->clinic_contact_no ?? ''}}" name="clinic_contact_no" placeholder="Enter Contact no" required>
                        </div>
                    </div>
                </div><!--end col-->

                

                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="state">{{ __('State')}}</label> 
                        {{-- <select name="clinic_state" id="clinicInfoState" class="form-control select2" >
                              
                        </select> --}}
                        <select name="clinic_state" id="clinicInfoState" class="form-control select2" required>
                            @if($clinic_info->state != null)
                                <option value="{{ $clinic_info->state }}" selected>{{ fetchFirst('App\Models\State', $clinic_info->state, 'name') }}</option>
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="city">{{ __('City')}}</label>
                        {{-- <select name="clinic_city" id="clinicInfoCity" class="form-control select2" >
                        </select>  --}}
                        <select name="clinic_city" id="clinicInfoCity" class="form-control select2" required>
                            @if($clinic_info->city != null)
                                <option value="{{ $clinic_info->city }}" selected>{{ fetchFirst('App\Models\City', $clinic_info->city, 'name') }}</option>
                            @endif
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Address<span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="key" class="fea icon-sm icons"></i>
                            <textarea name="clinic_address" class="form-control ps-5" placeholder="Enter Address">{{$clinic_info->address ?? ''}}
                            </textarea>
                        </div>
                    </div>
                </div><!--end col-->

                <div class="col-lg-12">
                    <div class="mb-3">
                        <label class="form-label">Phone no.<span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <i data-feather="key" class="fea icon-sm icons"></i>
                            <input type="number" class="form-control ps-5" value="{{$clinic_info->phone_no  ?? ''}}" name="clinic_phone_no" placeholder="Enter phone no" required>
                        </div>
                    </div>
                </div><!--end col-->

                <div class="col-lg-12 mt-2 mb-0">
                    <button class="btn btn-primary">Update</button>
                </div><!--end col-->
            </div><!--end row-->
        </form>
       
        

    </div>
</div>

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
        
        $('#clinicInfoState').change(function () {
            getClinicCity($(this).val());
        });
        getClinicState(101);
        @if(isset($clinic_info))
            setTimeout(() => {
                $('#clinicInfoState').val("{{$clinic_info->state}}").change();
            }, 500);

            setTimeout(() => {
                $('#clinicInfoCity').val("{{$clinic_info->city}}").change();
            }, 1000);
            
            getCities('{{$clinic_info->state}}');
        @endif 

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
    });

  
</script>
@endpush
