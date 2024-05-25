@extends('backend.layouts.main') 
@section('title', 'Mail/Text Templates')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Mail/Text', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>{{ __('Mail/Text Templates')}}</h5>
                            <span>{{ __('List of Mail/text Templates')}}</span>
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
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('Mail/Text Templates')}}</h3>
                        <form class="d-flex" method="get" action="{{ route('panel.constant_management.mail_sms_template.index') }}"id="TableForm">
                            <select name="type" id="" class="form-control select2">
                                <option value="" aria-readonly="true">Select Type</option>
                                <option @if(request()->has('type') && request()->get('type') == 1) selected @endif value="1">Mail</option>
                                <option @if(request()->has('type') && request()->get('type') == 2) selected @endif value="2">SMS</option>
                            </select>
                            <div>
                                <button type="submit" class="btn btn-icon btn-sm mx-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                            </div>
                            <div>
                                <a href="{{ route('panel.constant_management.mail_sms_template.index') }}" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                            </div>
                            <div>
                                <a class="btn btn-icon btn-sm btn-outline-success mr-2" href="#" data-toggle="modal" data-target="#siteModal"><i
                                    class="fa fa-info"></i></a>
                            </div>
                            <div>
                                <a href="{{ route('panel.constant_management.mail_sms_template.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Mail/SMS Template"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="Smstemplates_table" class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Actions</th>
                                        <th>Code</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Variables</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mail_sms as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.mail_sms_template.show', $item->id) }}" title="View Lead Contact" class="btn btn-sm">Show</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.mail_sms_template.edit', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.mail_sms_template.delete', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div>  
                                            </td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td> 
                                                @if($item->type==1)
                                                    <span>Mail</span>
                                                @else
                                                     <span>SMS</span>
                                                @endif   
                                            </td>
                                            <td>{{ $item->variables }}</td>                                       
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

                var table = $('#Smstemplates_table').DataTable({
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
                
            $('#reset').click(function(){
                location.reload();
            });
            });
        </script>
    @endpush
@endsection
