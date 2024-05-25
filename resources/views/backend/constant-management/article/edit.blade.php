@extends('backend.layouts.main') 
@section('title', 'Article')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Article', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit Article')}}</h5>
                            <span>{{ __('Update a record for Article')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update Article')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.article.update', $article->id) }}" method="post" id="article-blog" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                                <label for="title" class="control-label">{{ 'Title' }}<span class="text-danger">*</span></label>
                                                <input class="form-control" name="title" type="text" id="title" value="{{ @$article->title }}" placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category')}}<span class="text-danger">*</span></label>
                                                <select  required name="category_id" id="category_id" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Category')}}</option>
                                                    @foreach (\App\Models\Category::whereCategoryTypeId(20)->get() as $item)
                                                        <option value="{{ $item->id }}" {{ $article->category_id == $item['id'] ? 'selected' :'' }}>{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-sm-3 col-from-label" for="name">{{('Slug')}} <span class="text-red">*</span>
                                        </label>
                                        <div class="col-sm-12">
                                            <div class="input-group d-block d-md-flex">
                                                <input type="hidden" class="form-control w-100 w-md-auto" id="slugInput" oninput="slugFunction()" placeholder="{{ ('Slug') }}" name="slug" >
                                                <div class="input-group-prepend"><span class="input-group-text flex-grow-1" style="overflow: auto" id="slugOutput">{{ url('/page/'). '/' .@$article->title  }}</span><span id="slugOutput"></span></div>
                                                {{-- <small class="form-text text-muted">{{ ('Use character, number, hypen only') }}</small> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}} <span class="text-red">*</span>
                                                </label>
                                                <div class="text-danger d-none" id="desc_error">This field is required!</div>
                                                <textarea class="form-control ckeditor" name="description" type="text" id="description" value="" placeholder="Enter Description" required> {{ @$article->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="description_banner" class="col-md-3">{{ __('Banner')}}<span class="text-danger">*</span></label>
                                                <input type="file" name="description_banner" class="form-control">
                                            </div>
                                         </div>
                                         <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('seo_title') ? 'has-error' : ''}}">
                                                <label for="seo_title" class="control-label">{{ 'Meta Title' }}</label>
                                                <input class="form-control" name="seo_title" type="text" id="seo_title" value="{{ @$article->seo_title }}" placeholder="Enter Meta Title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="left">
                                            <img src="{{ ($article && $article->description_banner) ? asset($article->description_banner) : '' }}" class="" width="180" style="object-fit:cover; width: 320px; height: 120px" />
                                    </div><br>
                                        <div class="row">   
                                        <div class="col-6">
                                            <div class="form-group {{ $errors->has('seo_keywords') ? 'has-error' : ''}}">
                                                <label for="seo_keywords">{{ __('Meta Keywords')}}</label>
                                                <input type="text" id="tags" name="seo_keywords" class="form-control" value="{{ $article->seo_keywords }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-left mb-2">
                                            <div class="form-group {{ $errors->has('is_publish') ? 'has-error' : ''}}">
                                                <label for="is_publish" class="control-label">Publish</label><br>
                                                <input @if($article->is_publish == 1)  checked  @endif name="is_publish" type="checkbox" id="is_publish" class="js-single switch-input" value="1">
                                            </div>
                                         </div>
                                        <div class="col-12">
                                            <div class="form-group {{ $errors->has('short_description') ? 'has-error' : ''}}">
                                                <label for="short_description">{{ __('Meta Description')}}</label>
                                                <textarea class="form-control" name="short_description" type="text" id="short_description" value="" placeholder="Enter Meta Description">{{ @$article->short_description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
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
    @push('script')
    {{-- normal editor js --}}
      <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
      <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
      <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

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


    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
      <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
      <script>
           $('#tags').tagsinput('items');

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

          $('#article-blog').submit(function(e){
            //  e.preventDefault()
            if(CKEDITOR.instances['description'].getData().length > 0){
                $(this).submit()
            }else{
                e.preventDefault()
                $('#desc_error').removeClass('d-none')
            }
            
        })
      </script>
  @endpush

    
    @endpush
 
@endsection

