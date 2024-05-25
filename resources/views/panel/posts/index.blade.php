@extends('backend.layouts.main') 
@section('title', 'Posts')
@section('content')
@php
/**
 * Post Management 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
    $breadcrumb_arr = [
        ['name'=>'Posts', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Posts</h5>
                            <span>List of Posts</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.posts.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="mb-3">Posts</h3>
                              
                            <div class="d-flex justicy-content-right">
                                                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <div class="form-group mr-2 d-flex align-items-center">
                                    <span class="mr-2">Patient</span>
                                    <select name="user_id" id="" class="form-control select2">
                                        <option value="" aria-readonly="true">Select Patient</option>
                                        @foreach (UserList()  as $option)
                                        <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{NameById($option->id)}} - {{getUserPrefix($option->id)}}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                {{--   --}}
                               
                                <div class="form-group mr-2 d-flex align-items-center">
                                    <span class="mr-2">Status</span>
                                    <select name="status" id="" class="form-control select2">
                                        <option value="" aria-readonly="true">Select Status</option>
                                        @foreach (getPostManagementStatus()  as $option)
                                        <option value="{{ $option['id'] }}" >{{$option['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.posts.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                <a href="{{ route('panel.posts.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Post Management"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.posts.load')
                        </div>
                    </div>
                </div>
            </div>
        <form>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
           
        function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'PostManagementFile.' + type);
            $("#table").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        $('#reset').click(function(){
            window.location.href = "{{route('panel.posts.index')}}";
        });

       
        </script>
    @endpush
@endsection
