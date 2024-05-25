<div class="">
    @php
        $kyc_record = null;
        if($user_kyc && isset($user_kyc->details) && $user_kyc->details != null){
            $kyc_record = json_decode($user_kyc->details,true);
        }
    @endphp
    <div class="card-body">
        {{-- Status --}}
        @if(isset($user_kyc) && $user_kyc->status == 0)
           <div class="alert alert-info">
               eKyc Request isn't submitted yet!
           </div>
       @elseif(isset($user_kyc) && $user_kyc->status == 1)
           <div class="alert alert-success">
               User eKyc Request has been verified!
           </div>
       @elseif(isset($user_kyc) && $user_kyc->status == 2)
           <div class="alert alert-danger">
               User eKyc Request has been rejected!
           </div>
       @elseif(isset($user_kyc) && $user_kyc->status == 3)
          <div class="alert alert-warning">
               User submited eKyc Request, Please validate and take appropriated action.
           </div>
       @else 
            <div class="alert alert-info">
                eKyc Request isn't submitted yet!
            </div>    
       @endif

        <form action="{{ route('panel.update-ekyc-status') }}" method="POST" class="form-horizontal">
         @csrf
            <input id="status" type="hidden" name="status" value="">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="row">
                <div class="col-md-6 col-6"> <label>{{ __('Document Type')}}</label>
                    <br>
                    <h5 class="strong text-muted">{{ $kyc_record['document_type'] ?? '--' }}</h5>
                </div>
                <div class="col-md-6 col-6"> <label>{{ __('Document Number')}}</label>
                    <br>
                    <h5 class="strong text-muted">{{ $kyc_record['document_number']  ?? '--'}}</h5>
                </div>
                <div class="col-md-6 col-6"> <label>{{ __('Document Front Image')}}</label>
                    <br>
                        @if ($kyc_record != null && $kyc_record['document_front'] != null)
                            <a href="{{ asset($kyc_record['document_front']) }}" target="_blank" class="btn btn-outline-danger">View Attachment</a>
                        @else 
                            <button disabled class="btn btn-secondary">Not Submitted</button>    
                        @endif
                </div>
                <div class="col-md-6 col-6"> <label>{{ __('Document Back Image')}}</label>
                    <br>
                    @if ($kyc_record != null && $kyc_record['document_back'] != null)
                        @if ($kyc_record != null && $kyc_record['document_back'] != null)
                            <a href="{{ asset($kyc_record['document_back']) }}" target="_blank" class="btn btn-outline-danger">View Attachment</a>
                        @else 
                            <button disabled class="btn btn-secondary">Not Submitted</button>    
                        @endif
                    @else 
                        <button disabled class="btn btn-secondary">Not Submitted</button>    
                    @endif
                </div>


                <hr class="m-2">

                @if(AuthRole() == 'Admin')
                    @if(isset($user_kyc) && $user_kyc->status == 1)
                        <div class="col-md-12 col-12 mt-5"> 
                            <label>{{ __('Note')}}</label>
                            <textarea class="form-control" name="remark" type="text" >{{ $ekyc['admin_remark'] ?? '' }}</textarea>
                            <button type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                        </div>
                    @elseif(isset($user_kyc) && $user_kyc->status == 2)
                        <div class="col-md-12 col-12 mt-5"> 
                            <button type="submit" class="btn btn-warning mt-2 btn-lg reset">Reset</button>
                        </div>
                    @elseif(isset($user_kyc) && $user_kyc->status == 3)
                        <div class="col-md-12 col-12 mt-5"> <label>{{ __('Rejection Reason (If Any)')}}</label>
                            <textarea class="form-control" name="remark" type="text" >{{ $kyc_record['admin_remark'] ?? '' }}</textarea>
                            <button  type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                            <button type="submit" class="btn btn-success accept ml-5 accept mt-2 btn-lg">Accept</button>
                        </div>
                    @endif
                @endif    
            </div>
        </form>
    </div>
</div>