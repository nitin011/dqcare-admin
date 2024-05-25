@extends('frontend.layouts.assets')
@if(getSetting('recaptcha') == 1)
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
@endif

@section('meta_data')
    @php
		$meta_title = 'Register | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'Defenzelite';		
		$meta_author_email = '' ?? 'support@defenzelite.com';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection
<style>
    .alert {
        padding: 0px 15px !important;
    }
</style>
@section('content')
    <section class="d-flex align-items-center position-relative" style="background: url('assets/images/shape01.png') center;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card form-signin p-4 rounded shadow mt-5" >
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                                    {{ $error }}
                                    <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            @endforeach
                        @endif
                        <form action="{{ url('register') }}" method="post" class="mt-3">
                            @csrf
                            <a href="{{url('/')}}">
                                <img src="{{ getBackendLogo(getSetting('app_logo')) }}" class="avatar avatar-small mb-4 d-block mx-auto" alt="website-logo" style="height:100%;width:20%;">
                            </a>
                            <h5 class="mb-3 text-center">Register your account</h5>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Enter First Name" name="fname" value="{{ old('fname') }}" required>
                                <label for="floatingInput">First Name</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Enter last Name" name="lname" value="{{ old('lname') }}" required>
                                <label for="floatingInput">Last Name</label>
                            </div>
                        </div>
                    </div>
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com"  name="email" value="{{ old('email') }}" required>
                                <label for="floatingEmail">Email Address</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="number" class="form-control" id="floatingPhone" placeholder="Enter Phone Number"  name="phone" value="{{ old('phone') }}" required>
                                <label for="floatingPhone">Phone</label>
                            </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-group mb-2">
                                <input id="floatingPassword" type="password" class="form-control" placeholder="Password" name="password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                        </div>
                            <div class="col-6">
                                <div class="form-floating form-group mb-2">
                                    <input id="floatingPassword" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                    <label for="floatingPassword">Confirm Password</label>
                                </div>
                            </div>
                           </div>
                            @if(getSetting('recaptcha') == 1)
                                <div class="form-floating mb-3 d-flex justify-content-center align-items-center">
                                    <div class="col-md-12 d-flex justify-content-center"> {!! htmlFormSnippet() !!} </div>
                                </div>
                            @endif
                            <div class="form-check mb-3">
                                <input class="form-check-input" required type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">I've Accept <a href="{{url('page/terms')}}" class="text-primary">Terms & </a><a href="{{url('page/privacy')}}" class="text-primary">Policy</a></label>
                            </div>
            
                            <button class="btn btn-primary w-100" type="submit">Register</button>

                            <div class="col-12 text-center mt-3">
                                <p class="mb-0 mt-3"><small class="text-dark me-2">Already have an account ?</small> 
                                    <a href="{{ url('login') }}" class="text-dark fw-bold">Sign in</a>
                                </p>
                            </div><!--end col-->

                            <p class="mb-0 text-muted mt-3 text-center">© <script>document.write(new Date().getFullYear())</script> {{ getSetting('app_name') }}</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection