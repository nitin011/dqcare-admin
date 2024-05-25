@extends('frontend.layouts.assets')
@if(getSetting('recaptcha') == 1)
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
@endif

@section('meta_data')
    @php
		$meta_title = 'Forbidden | '.getSetting('app_name');		
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
                <div class="card form-signin p-4 rounded shadow" style="max-width: fit-content;margin-top:30px;" >
                    <div class="card-body">
                        <h1 style="color: #1969d3;font-weight:500 ; font-family: system-ui; margin-top: -10px;">403</h1>
                       
                    <h2 style="font-weight: 400;font-family: system-ui;">Sorry! Access denied :( </h2>
                    <h6>You don't have permission to open this page. If you're a new user or were recently assigned credentials, please wait 15 minutes and try again.<br><br>
                    You're still signed in . If you want to sign out, use this link below.</h6>
                    <a href="{{ route('index') }}" class="btn-outline-primary p-2 rounded mt-2">Go Back to Home page</a>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</section>
@endsection