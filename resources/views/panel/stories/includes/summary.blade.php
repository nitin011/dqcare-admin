<style>
    [data-repeater-item]:first-child [data-repeater-delete] { display: none; }
</style>

<div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "summary" || !request()->has('active')) show active @endif" id="summary" role="tabpanel" aria-labelledby="pills-summary-tab">
    <div class="card-body">
            <div class="row no-gutters">
                <div class="col-12 mb-2">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="d-flex justify-content-center align-items-center ">
                                <img src="{{ ($story && $story->avatar) ? $user->avatar : asset('backend/default/default-avatar.png') }}" class="rounded-circle" width="150" style=" margin-top:0px;object-fit: cover; width: 75px; height: 75px"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="pt-1">
                                <label class="text-muted m-0 p-0" for="">Patient</label>
                                <div class="d-flex ">
                                    <small class="text-muted d-block mt-1"><i class="fa fa-user" aria-hidden="true"></i> </small>
                                    <h6 class=" mx-2 text-muted fw-800">{{NameById($story->user_id ?? '')}}</h6>
                                </div>
                                <div class="d-flex">
                                    <small class="text-muted d-block mt-1"><i class="fa fa-envelope" aria-hidden="true"></i> </small>
                                    <h6 class=" mx-2 text-muted d-block">{{ $story->user->email ??''}}</h6>
                                </div> 
                                
                                <div class="d-flex" >
                                    <small class="text-muted d-block mt-1 "><i class="fa fa-phone" aria-hidden="true"></i></small>
                                    <h6 class=" mx-2 text-muted d-block"><a href="tel:+{{ $story->user->phone}}">{{(isset($story->user) && $story->user->phone !=null) ? $story->user->phone : '--' }}</a></h6> 
                                </div>
                            </div>
                        </div>
                        @php
                        if($story->user_id){
                            $user = App\User::where('id',$story->user_id)->first();
                            $priDrNot = json_decode($user->pri_dr_note);
                        }else{
                            $priDrNot = "No parimary doctor yet!";
                        }
                        @endphp
                        <div class="col-lg-3">
                            <div class="pt-1">
                                <label class="text-muted m-0 p-0" for="">Primary Doctor</label>
                                <div class="d-flex ">
                                    <small class="text-muted d-block mt-1"><i class="fa fa-user" aria-hidden="true"></i></small>
                                   <h6 class=" mx-2 text-muted d-block ml-2"> {{$priDrNot->doctor_name ?? ''}}</h6>  
                                </div>
                                <div class="d-flex">
                                    <small class="text-muted d-block mt-1 "><i class="fa fa-phone" aria-hidden="true"></i> </small>
                                    <h6 class=" mx-2 text-muted d-block ml-2">{{$priDrNot->phone_no ?? ''}}</h6>
                                </div> 
                                {{-- <div class="d-flex">
                                    <small class="text-muted d-block mt-1"><i class="fa fa-envelope" aria-hidden="true"></i> </small>
                                    <h6 class=" mx-2 text-muted d-block">{{ $story->user->email }}</h6>
                                </div> 
                                <div class="d-flex" >
                                    <small class="text-muted d-block mt-1 "><i class="fa fa-phone" aria-hidden="true"></i></small>
                                    <h6 class=" mx-2 text-muted d-block"><a href="tel:+{{ $story->user->phone}}">{{ $story->user->phone }}</a></h6> 
                                </div> --}}
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <span>Updates</span>
                            <div class="text-muted ">
                                <strong>By:</strong>
                                {{NameById($story->updated_by)}}
                            </div>
                            <div class="text-muted ">
                                <strong>At:</strong>
                                {{$story->updated_at}}
                            </div>
                        </div>
                    </div>

                    <hr>
                </div>
            
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 col-12 d-none ">
                            <div class="form-group">
                                <label for="user_id">User <span class="text-danger">*</span></label>
                                <input type="" name='user_id' id='user_id' value={{ NameById($story->user_id) }}>
                            </div>
                        </div>

                        <div class="col-md-3 col-12 d-none">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name" class="control-label"> Name<span class="text-danger">*</span> </label>
                                <input class="form-control story_data" name="name" type="text" id="name"
                                    value="{{ $story->name }}" placeholder="Enter Your Name">
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                                <label for="dob" class="control-label">DOB<span class="text-danger">*</span> </label>
                                <input required class="form-control story_data" name="dob" type="date" id="date"
                                    value="{{ $story->dob ?? $story->user->dob  }}">
                            </div>
                            <div class="form-group {{ $errors->has('Age') ? 'has-error' : '' }}">
                                <label for="age" class="control-label"> Age<span class="text-danger">*</span> </label>
                                <input required class="form-control story_data" name="age" type="number" id="age"
                                    value="{{ $story->age ?? \Carbon\Carbon::parse($story->dob ?? $story->user->dob)->age  }}"placeholder="Enter Your Age">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="alert alert-info">
                                We only use Publish Date for internal purposes.
                            </div>
                            <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                                <label for="date" class="control-label"> Publish Date<span class="text-danger">*</span>
                                </label>
                                <input required class="form-control story_data" name="date" type="date" id="date"
                                    value="{{ \Carbon\Carbon::parse($story->date)->format('Y-m-d') }}">
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-12 m-0 p-0">
                    <div class="alert alert-info mt-2">
                        The information is only used for display purposes. <strong> It is necessary to have at least one row per key.</strong> <i>Keep it blank</i> if the story does not require any key information.
                    </div>
                </div>
            
                <div class="col-md-12 mb-3">

                    <div class="knownCase_Repeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label"> Known Cases Of<span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="known_cases">
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <textarea name="known_text"
                                             class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder="Enter Known Case of"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="familyRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Family History<span class="text-danger">*</span>
                            </label>
                        </div>
                        <div data-repeater-list="family_history">
                            <div data-repeater-item>
                                <div class="row">
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="family_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder="Enter Family History"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="operativeRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label"> Operative History<span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="operative_history">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="operative_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder="Enter Operative History"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="habitRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label"> Habit History<span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="habit_history">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="habit_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder=" Enter Habit History"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button"><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="allergyRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Any Allergy<span class="text-danger">*</span>
                            </label>
                        </div>
                        <div data-repeater-list="any_allergy">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="allergy_text" class="form-control story_data" id="" cols="30" rows="1"
                                                placeholder=" Enter Any Allergy"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button  class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="medicationRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Current Medication<span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="current_medication">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="current_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder="Enter Current Medication"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="vaccination_Repeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Vaccination History <span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="vaccination_history">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="vaccination_history" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder=" Enter Vaccination History"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button"><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="opdRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Last OPD Visit <span
                                    class="text-danger">*</span> </label>
                        </div>
    
                        <div data-repeater-list="opd_visit">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="opd_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder=" Enter OPD Visit"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="admittedRepeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Last Admitted <span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="last_admitted">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
    
                                        <div class="form-group">
                                            <textarea name="last_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder=" Enter Last Admitted"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button  class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="bloodGroup_Repeater border p-2">
                        <div class="col-12" style="padding-left: 5px;">
                            <label for="date" class="control-label">Blood Group<span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div data-repeater-list="bloodGroup">
                            <div data-repeater-item>
                                <div class="row">
    
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <textarea name="bloodGroup_text" class="form-control story_data" id="" cols="30"
                                                rows="1"placeholder=" Enter Blood Group History"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon"><i
                                                class="ik ik-trash-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button  class="summary-create-btn btn btn-icon btn-success" data-repeater-create type="button" ><i
                                class="ik ik-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" id="" class="btn btn-primary save_btn">Save</button>
                    </div>
                </div>
            </div>
    </div>
</div>

@push('script')

    <script>
        $(document).ready(function() {
            var known_cases = $('.knownCase_Repeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })
            @if (isset($detail) && count($detail) > 0)
                setTimeout(() => {
                 @if (isset($detail['known_cases']) != null)
                   known_cases.setList([
                          
                                @foreach ($detail['known_cases'] as $list)
                              
                                    {
                                        'known_text': '{{ $list['known_text'] }}',

                                    },
                                @endforeach
                            ]);
                   
                 @endif
                }, 1000);
               
            @endif

            var family_history = $('.familyRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })

            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['family_history']) != null)
                    family_history.setList([
                           
                                @foreach ($detail['family_history'] as $list)
                                    {
                                        'family_text': '{{ $list['family_text'] }}',

                                    },
                                @endforeach
                            ]);
                    @endif

                }, 1000);
            @endif

            var operative_history = $('.operativeRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })

            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['operative_history']) != null)
                    operative_history.setList([
                           
                                @foreach ($detail['operative_history'] as $list)
                                    {
                                        'operative_text': '{{ $list['operative_text'] }}',

                                    },
                                @endforeach
                            ]);
                    @endif

                }, 1000);
            @endif
            var habit_history = $('.habitRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })

            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['habit_history']) != null)
                    habit_history.setList([
                           
                                @foreach ($detail['habit_history'] as $list)
                                    {
                                        'habit_text': '{{ $list['habit_text'] }}',

                                    },
                                @endforeach
                            ]);
                    @endif

                }, 1000);
            @endif
            
            var any_allergy = $('.allergyRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })

            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['any_allergy']) != null)
                    any_allergy.setList([
                           
                                @foreach ($detail['any_allergy'] as $list)
                                    {
                                        'allergy_text': '{{ $list['allergy_text'] }}',

                                    },
                                @endforeach
                            ]);
                    @endif

                }, 1000);
            @endif

            var current_medication = $('.medicationRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })
            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['current_medication']) != null)
                    current_medication.setList([
                           
                                @foreach ($detail['current_medication'] as $list)
                                    {
                                        'current_text': '{{ $list['current_text'] }}',

                                    },
                                @endforeach
                               ]);
                         @endif

                }, 1000);
            @endif

    var vaccination_history = $('.vaccination_Repeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })
            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    @if (isset($detail['vaccination_history']) != null)
                    vaccination_history.setList([
                           
                                @foreach ($detail['vaccination_history'] as $list)
                                    {
                                        'vaccination_history': '{{ $list['vaccination_history'] }}',

                                    },
                                @endforeach
                               ]);
                         @endif

                }, 1000);
            @endif

            var opd_visit = $('.opdRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
             })
             @if (isset($detail) && count($detail) > 0)
            setTimeout(() => {
               
                @if (isset($detail['opd_visit']) != null)
               
                opd_visit.setList([
              
                    
                            @foreach ($detail['opd_visit'] as $list)
                                {
                                    'opd_text': '{{ $list['opd_text'] }}',

                                },
                            @endforeach
                        ]);
                    @endif

            }, 1000);
            @endif

            
             var last_admitted = $('.admittedRepeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            })
          
            @if (isset($detail) && count($detail) > 0)
            setTimeout(() => {
               
                @if (isset($detail['last_admitted']) != null)
               
                last_admitted.setList([
              
                    
                            @foreach ($detail['last_admitted'] as $list)
                                {
                                    'last_text': '{{ $list['last_text'] }}',

                                },
                            @endforeach
                        ]);
                    @endif

            }, 1000);
            @endif
            
            var bloodGroup = $('.bloodGroup_Repeater').repeater({
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {
                   
                },
                isFirstItemUndeletable: true
            });

            @if (isset($detail) && count($detail) > 0)

                setTimeout(() => {
                    bloodGroup.setList([
                        @if (isset($detail['bloodGroup']) != null)
                            @foreach ($detail['bloodGroup'] as $list)
                                {
                                    'bloodGroup_text': "{{ $list['bloodGroup_text'] }}",

                                },
                            @endforeach
                        @endif
                    ]);


                }, 1000);
            @endif

        // age jscript

            function getAge(dateString) {
                var today = new Date();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                return age;
            }
            $(document).ready(function() {
                $('#date').on('change', function() {
                    var age = getAge($(this).val());
                    $('#age').val(age);
                });
            });



        });
    </script>
@endpush
