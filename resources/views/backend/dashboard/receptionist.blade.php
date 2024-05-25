<style>
    .wrapper .page-wrap .main-content{
        padding-left: 6px;
        margin-top: 30px;
    }
   .wrapper .page-wrap .footer {
    padding-left: 22px;
    }
    .wrapper .header-top {
        padding-left: 0;
    }
</style>
 @php
    $doctors = App\Models\AccessDoctor::where('user_id',auth()->id())->with('doctor')->get();   
@endphp
<div class="row">
    @forelse( $doctors as $doctor)
        <div class="col-3">
            {{-- @dd($doctor->doctor->working_avilabitlity); --}}
            <div class="card">
                <div class="card-body">
                    <div class="badge badge-{{ getWorkingUpdateStatus($doctor->doctor->working_availability)['color']}} badge-sm p-1" style="position: absolute; right: 15px;"> 
                        <small>{{ getWorkingUpdateStatus($doctor->doctor->working_availability)['name'] }}</small>
                     </div>
                    <div class="text-center"> 
                        <div class="mx-auto">
                            <img src="{{ ($doctor && $doctor->avatar) ? $doctor->avatar: asset('backend/default/default-avatar.png') }}" class="rounded-circle mb-5" width="95" style="object-fit: cover; width: 95px; height: 95px" />
                        </div>
                        
                        <h4 class="card-title mt-5 mb-0">
                            {{NameById($doctor->doctor_id)}}
                        </h4>
                        <a href="" class="text-warning fw-600">
                            <i class="ik ik-phone" title="Call"></i>
                            {{$doctor->doctor->phone}}
                        </a>

                        <div class="text-center text-muted" title="Last Updated At">
                            <i class="ik ik-clock" ></i>
                            {{$doctor->doctor->updated_at->diffForHumans()}}
                        </div>

                        @if($doctor->doctor->updated_at->diffInMinutes() > 10)
                            <div class="alert mt-2 alert-secondary p-1 text-center fw-700 text-danger" style="background-color: #eee; border-color: #eee;">
                                <i class="fas fa-hourglass fa-sm mr-3 fa-spin"></i>  Update Required
                            </div>
                        @endif    
                        
                        <hr>
                        <a href="{{route('panel.access.index',$doctor->doctor_id)}}" class="btn btn-outline-danger btn-block">Manage Availability</a>
                    </div>
                   
                </div>
            </div> 
        </div>
    @empty
        <div class="col-12 p-5">
            <div class="fw-600 text-center m-5 p-5">
                <i class="fa fa-stethoscope text-muted fa-2x"></i>
               <br> 
                <div class="mt-2">
                    No Doctor Assigned Yet!
                </div>
                
            </div>
        </div>
    @endforelse
</div>


@push('script')
    <script>
        window.setTimeout(function(){
                window.location.reload();
            },10000);
    </script>
@endpush