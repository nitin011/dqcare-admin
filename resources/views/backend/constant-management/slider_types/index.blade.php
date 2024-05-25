@extends('backend.layouts.main') 
@section('title', 'Slider Group')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Slider Group', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Slider Group</h5>
                            <span>List of Slider Group</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Slider Group</h3>
                        <div>
                            <a class="btn btn-icon btn-sm btn-outline-success" href="#" data-toggle="modal" data-target="#siteModal"><i
                                class="fa fa-info"></i></a>
                            <a href="{{ route('backend.constant-management.slider_types.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Slider Type"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>                                            
                                        <th>Headline</th>
                                        {{-- <th>Total Sliders</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($slider_types as  $slider_type)
                                        <tr>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.slider_types.edit', $slider_type->id) }}" title="Edit Slider Type" class="btn btn-sm">Edit</a></li>
                                                        {{-- <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.slider_types.destroy', $slider_type->id) }}" title="Delete Slider Type" class="btn btn-sm delete-item">Delete</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.sliders.index')."?slidertype=".$slider_type->id }}" title="Manage Slider Type" class="btn btn-sm">Manage</a></li>
                                                      </ul>
                                                </div> 
                                            </td>
                                            <td><a href="{{ route('backend.constant-management.sliders.index')."?slidertype=".$slider_type->id }}" class="btn btn-link">{{$slider_type->title }}</a></td>
                                             {{-- <td><a href="{{ route('backend.constant-management.sliders.index')."?slidertype=".$slider_type->id }}" class="text-primary">{{$slider_type->sliders->count() }}</a></td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {

                var table = $('#table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
        </script>
    @endpush
@endsection
