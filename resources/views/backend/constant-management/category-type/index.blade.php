@extends('backend.layouts.main') 
@section('title', ' Category Group ')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>' Category Group ', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>{{ __(' Category Group ')}}</h5>
                            <span>{{ __('List of Category Group ')}}</span>
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
                        <h3>{{ __(' Category Group ')}}</h3>
                        <div>
                            <a class="btn btn-icon btn-sm btn-outline-success" href="#" data-toggle="modal" data-target="#siteModal"><i
                                class="fa fa-info"></i></a>
                            {{-- <a href="{{ route('panel.constant_management.category_type.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Smstemplate"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                        </div>
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="category_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category_type as $item)
                                        <tr>
                                            <td class="text-center">MCT{{ $item->id }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        {{-- <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.show', $item->id) }}" title="View Lead Contact" class="btn btn-sm">Show</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.edit', $item->id) }}" title="Edit Category Group" class="btn btn-sm">Edit</a></li>
                                                        {{-- <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.delete', $item->id) }}" title="Delete Category Group" class="btn btn-sm delete-item">Delete</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.index',$item->id) }}" title="Manage Category Group" class="btn btn-sm">Manage</a></li>
                                                      </ul>
                                                </div>
                                            </td>
                                            <td><a class="btn btn-link" href="{{ route('panel.constant_management.category.index',$item->id) }}">{{ ucwords(str_replace('_',' ',$item->name)) ?? '-' }}</a></td>
                                            {{-- <td>{{ $item->name }}</td>
                                            <td>{{ $item->allowed_level }}</td> --}}
                                            {{-- <td><a class="btn btn-link" href="{{ route('panel.constant_management.category.index',$item->id) }}">{{ fetchGetData('App\Models\Category',['category_type_id','level'],[$item->id,1])->count() }}</a></td> --}}
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

                var table = $('#category_table').DataTable({
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
