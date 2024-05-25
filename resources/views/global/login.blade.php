@extends('frontend.layouts.assets')
@if(getSetting('recaptcha') == 1)
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
@endif

@section('meta_data')
    @php
		$meta_title = 'Login | '.getSetting('app_name');		
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
<section class="bg-home d-flex align-items-center position-relative" style="background: url('assets/images/shape01.png') center;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card form-signin p-4 rounded shadow">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <a href="{{url('/')}}">
                            <img src="{{ getBackendLogo(getSetting('app_logo')) }}" class="avatar avatar-small mb-4 d-block mx-auto" alt="website-logo" style="height:50%;width: 25%;">
                        </a>
                        <h5 class="mb-3 text-center">Please sign in</h5>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn close text-white" data-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn close text-white" data-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        <div class="form-floating mb-2">
                            <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="floatingInput">Email address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" name="password" required>
                            <label for="floatingPassword">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if(getSetting('recaptcha') == 1)
                            <div class="form-floating mb-3 d-flex justify-content-center">
                                <div class=""> {!! htmlFormSnippet() !!} </div>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="option1" id="flexCheckDefault" name="item_checkbox">
                                    <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                </div>
                            </div>
                            <p class="forgot-pass mb-0">
                                <a href="{{url('password/forget')}}" class="text-dark small fw-bold">Forgot password ?</a></p>
                        </div>
        
                        <button class="btn btn-primary w-100" type="submit">Sign in</button>

                        {{-- <div class="col-12 text-center mt-3">
                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="{{ url('register') }}" class="text-dark fw-bold">Sign Up</a></p>
                        </div><!--end col--> --}}

                        <p class="mb-0 text-muted mt-3 text-center">© <script>document.write(new Date().getFullYear())</script> {{ getSetting('app_name') }}</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection