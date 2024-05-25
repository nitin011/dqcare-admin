<div class="">
    <form action="{{ route('panel.update-user-password', $user->id) }}" method="POST" class="form-horizontal">
        @csrf
        <div class="card-body"> 
            <form>
                <div class="row mt-1">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Last Password<span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="password" class="form-control ps-5"name="password" placeholder="Old password" required="">
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">New Password<span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="password" class="form-control ps-5" name="password" placeholder="New password" required="">
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Re-type New Password<span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <i data-feather="key" class="fea icon-sm icons"></i>
                                <input type="password" class="form-control ps-5" name="confirm_password" placeholder="Re-type New password" required="">
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-12 mt-2 mb-0">
                        <button class="btn btn-primary">Save password</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form>
        </div>
    </form>
</div>