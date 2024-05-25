<div class="card-body">
    <div class="row">
        <div class="col-lg-12">
        <div class="">
            @if(isset($document) && $document->file_name != null)
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex">
                   <div>
                        <strong class="text-muted d-block pt-10">{{ $document->file_name ?? '' }}
                    </strong>
                   </div>
                    <div class="mt-2 ml-2 mr-2">
                        <span class="badge badge-danger">{{$user->verify_doc_status}}</span>
                    </div>
                </div>


                <div class="">
                    <a href="{{ route('panel.user.document.status',[$id,'approved']) }}"
                        class="btn btn-icon btn-sm btn-outline-success confirm"><i class="ik ik-check"></i></a>
                    <a href="{{ asset($document->path) }}"
                        target="_blank" class="btn btn-icon btn-sm btn-outline-info btn-link"><i
                            class="ik ik-eye"></i></a>
                    <a href="{{ route('panel.user.document.status',[$id,'rejected']) }}"
                        class="btn btn-icon btn-sm btn-outline-danger confirm"><i class="ik ik-x "></i></a>
                </div>
            </div>


        </div>
        @else
            <div class="d-flex align-items-center justify-content-center p-5">
                <div>
                    <i class="text-muted text-center fa fa-box-open fa-4x fw-18"></i>
                    <p class="text-muted text-center">No Data !!</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
