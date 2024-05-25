@extends('backend.layouts.main') 
@section('title', 'Country')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Country', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create New Country')}}</h5>
                            <span>{{ __('Add a new record for Country')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                @include('backend.include.message')
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add Country')}}</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('panel.constant_management.location.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('Name') ? 'has-error' : ''}}">
                                                <label for="Name" class="control-label">{{ 'Country Name' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="name" type="text" id="Name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('Name') ? 'has-error' : ''}}">
                                                <label for="Name" class="control-label">{{ 'Capital' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="capital" type="text" id="capital" value="{{ old('capital') }}" placeholder="Enter capital" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('Code') ? 'has-error' : ''}}">
                                                <label for="Code" class="control-label">{{ 'Country Code' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="iso2" type="text" id="code" value="{{ old('iso2') }}" maxlength="2" placeholder="Enter Code" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('Currency') ? 'has-error' : ''}}">
                                                <label for="Currency" class="control-label">{{ 'Country Currency' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="currency" type="text" id="Currency" value="{{ old('currency') }}" placeholder="Enter Currency" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('region') ? 'has-error' : ''}}">
                                                <label for="region" class="control-label">{{ 'Region' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="region" type="text" id="region" value="{{ old('region') }}" placeholder="Enter Region" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('Emoji') ? 'has-error' : ''}}">
                                                <label for="Emoji" class="control-label">{{ 'Emoji Code' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="emoji" type="text" id="Emoji" value="{{ old('emoji') }}" placeholder="Enter Emoji Code" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('phonecode') ? 'has-error' : ''}}">
                                                <label for="phonecode" class="control-label">{{ 'Phone Code' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="phonecode" type="text" id="phonecode" value="{{ old('phonecode') }}" placeholder="Enter Phone Code" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary float-right">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
      {{-- normal editor js --}}
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>

      <script>
        
          var options = {
                  filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                  filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                  filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                  filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
              };
              $(window).on('load', function (){
                  CKEDITOR.replace('description', options);
              });
      </script>
    @endpush
    @push('script')
		<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
		<script src="{{ asset('backend/js/form-advanced.js') }}"></script>
		<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
		<script>
				function slugFunction() {
					var x = document.getElementById("slugInput").value;
					document.getElementById("slugOutput").innerHTML = "{{ url('/article/') }}/" + x;
				}
				function convertToSlug(Text)
				{
					return Text
						.toLowerCase()
						.replace(/ /g,'-')
						.replace(/[^\w-]+/g,'')
						;
				}
			$(window).on('load', function (){
				CKEDITOR.replace('content', options);
			});
			$('#title').on('keyup', function (){
                $('#slugInput').val(convertToSlug($('#title').val()));
				slugFunction();
			});
		</script>
	@endpush
@endsection
 

