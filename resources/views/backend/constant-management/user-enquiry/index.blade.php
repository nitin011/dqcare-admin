@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Website Enquiry', 'url'=> "javascript:void(0);", 'class' => 'active'],
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <style>
        .daterangepicker.dropdown-menu.ltr.show-calendar.opensright{
            width: 455px !important;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Website Enquiry')}}</h5>
                            <span>{{ __('List of Website Enquiry')}}</span>
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
                    <div class="card-header d-flex justify-content-between align-items-right">
                        <h3>{{ __('Website Enquiry')}}</h3>
                        <div class="d-flex justify-content-right">
                            <form class="d-flex"action="{{route('panel.constant_management.user_enquiry.index')}}" method="get"> 
                                <div class="form-group d-flex mb-0 mr-2">
                                    <span class="mt-2 mx-1">From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group d-flex mb-0 mr-2"> 
                                    <span class="mt-2 mx-1">To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{ request()->get('to')}}"></label> 
                                </div>
                                
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="{{ route('panel.constant_management.user_enquiry.index') }}" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                {{-- <a href="javascript:void(0)"  </a> --}}
                                @can('user_enquiry_create')
                                <a href="{{ route('panel.constant_management.user_enquiry.create') }}" class="btn btn-icon btn-sm btn-outline-primary mr-2" title="Add New User Enquiry"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                                @endcan
                            </form>
                            <form action="{{route('panel.constant_management.user_enquiry.bulk-delete')}}" method="POST" > 
                                @csrf
                                    <input type="hidden" name="ids" id="bulk_ids">
                                    <div class="dropdown d-flex justicy-content-left">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                                class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <button type="submit" id="" class="dropdown-item confirm-action" name="action" value="delete" data-message="You want to delete these items?" data-action="delete">Bulk Delete</button>
                                        </ul>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user_enquiry_table" class="table">
                                <thead>
                                    <tr>
                                       <th class="text-center"><input type="checkbox" class="mr-2 allChecked " name="id" value="">Actions</th>
                                       <th>id</th> 
                                        <th>Name</th>
                                        <th>Subject</th>
                                        <th>Value</th>
                                        <th>Created At</th>
                                         {{-- <th>Status</th>  --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_enq as $item)
                                  
                                        <tr>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <input type="checkbox" class="mr-2 delete_Checkbox text-center" name="id" value="{{$item->id}}">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
      
                                                   
                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        @can('user_enquiry_edit')
                                                            <li class="dropdown-item p-0"><a href="{{  route('panel.constant_management.user_enquiry.edit', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm">Edit</a></li>
                                                        @endcan

                                                        @can('user_enquiry_delete')
                                                            <li class="dropdown-item p-0"><a href="{{  route('panel.constant_management.user_enquiry.delete', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm delete-item">Delete</a></li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><a href="{{  route('panel.constant_management.user_enquiry.show', $item->id) }}" class="btn btn-link">#ENQ{{ $item->id }}</a></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->subject }}</td>
                                            <td >
                                                @if(filter_var($item->type_value, FILTER_VALIDATE_EMAIL)) 
                                                   <a href="mailto:$item->type_value" class="btn btn-link p-0 m-0">{{ $item->type_value }}</a>
                                             
                                                @else 
                                                    <a href="tel:$item->type_value" class="btn btn-link p-0">{{ $item->type_value }}</a>
                                                
                                                @endif
                                            </td>
                                            <td class="">{{ getFormattedDate($item->created_at) }}</td>
                                            {{-- <td>@if ($item->status == 0)
                                                <span class="badge badge-warning">Pending</span>
                                                @elseif($item->status == 1)
                                                <span class="badge badge-success">Solved</span>
                                                @endif
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    @include('backend.include.bulk-script')
        <script>
            $(document).ready(function() {
                $('#filter-btn').click(function(){
                    var url = "{{ route('panel.constant_management.user_enquiry.index') }}";
                    var date = $('#date_filter').val();
                    window.location.href = url+'?date='+date;
                });

                var table = $('#user_enquiry_table').DataTable({
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

            $('#reset').click(function(){
            var url = $(this).data('url');

            getData(url);

            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
        });

        </script>
    @endpush
@endsection
