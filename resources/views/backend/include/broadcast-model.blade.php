
@php
  $allDoctor = App\User::role('Doctor')->where('fcm_token',"!=",null)->get();
  $allPatient = App\User::role('User')->where('fcm_token',"!=",null)->get();
@endphp
<div class="modal fade" id="addBrodcast" tabindex="-1" role="dialog" aria-labelledby="addBrodcast" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBrodcast">Broadcast</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('panel.broadcast.index')}}" method="post">
              <div class="modal-body">
                @csrf
                <div class="form-group">
                    <div class="alert alert-primary" role="alert">
                        Make sure you know what you're doing. This broadcast cannot be rolled back. Ensure content integrity according to HealthDetails Communication Policy before broadcasting anything.
                    </div>
                </div>
                <div class="form-group">
                    <label for="brodcast">{{ __('Your Message') }}</label>
                    <textarea id="brodcast" type="text-area" class="form-control" name="brodcast"
                        placeholder="Enter "></textarea>
                    <div class="help-block with-errors"></div>
                </div>
                <div class="form-group">
                    <div class="form-radio">
                        <div class="radio radio-inline">
                            {{-- <label>
                                <input type="radio" id="doctor" name="nofification_user" value="doctor">
                                <i class="helper"></i>{{ __('All Doctor') }}
                            </label> --}}
                            <label>
                                <input type="radio" id="doctor" name="nofification_user" value="doctor"  required>
                                <i class="helper"></i>{{ __('Doctor') }}
                            </label>
                        </div>
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" id="patient" name="nofification_user" value="user"  required>
                                <i class="helper"></i>{{ __('Patient') }}
                            </label>
                        </div>
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" id="both" name="nofification_user" value="both" required>
                                <i class="helper"></i>{{ __('Both') }}
                            </label>
                        </div>
                    </div>
                    @if($allDoctor->count() > 0)
                        <div class="selected_user d-none" id="doctor_selected">
                                <div class="form-group"  data-select2-id="23" >
                                    <label for="">Select the doctor</label>
                                        <select class="form-control select2" name="doctor_selected[]" multiple="" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                            @foreach ($allDoctor as $doctor_list)
                                              <option value="       {{$doctor_list->id}}" data-select2-id="{{$doctor_list->id}}">{{$doctor_list->name}} #ID{{$doctor_list->id}}</option> <option value="{{$doctor_list->id}}" data-select2-id="{{$doctor_list->id}}">{{$doctor_list->name}} #ID{{$doctor_list->id}}</option>
                                            @endforeach
                                        </select> 
                                  </div>
                          
                        </div>
                    @else
                      <span class="text-danger">No Doctor Yet!</span>
                    @endif
                    
                    @if($allPatient->count() > 0)
                        <div class="selected_user d-none" id="patient_selected">
                            <div class="form-group "  data-select2-id="24" >
                                <label for="">Select the patient</label>
                                    <select class="form-control select2" name="user_selected[]" multiple="" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                        @foreach ($allPatient as $patient_list)
                                          <option value="{{$patient_list->id}}" data-select2-id="{{$patient_list->id}}">{{$patient_list->name}} #ID{{$patient_list->id}}</option>
                                        @endforeach
                                    </select> 
                            </div>
                        </div>
                    @else
                      <span class="text-danger">No Doctor Yet!</span>
                    @endif

                    <div class="help-block with-errors"></div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary ">Send To All</button>
                </div>
              </div>
             
            </form>
        </div>
    </div>
</div>
