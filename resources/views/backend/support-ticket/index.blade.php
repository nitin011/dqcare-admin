@extends('backend.layouts.main') 
@section('title', 'Support Ticket')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Support Ticket', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Support Ticket')}}</h5>
                            <span>{{ __('List of Support Ticket')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{ __('Support Ticket')}}</h3>
                        <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#raiseTicketModal">Raise a ticket</a>
                    
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="supportTicketTable" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Reply</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supports as $index => $support)
                                        @php
                                            $reply_exist = App\Models\SupportTicket::whereUserId(auth()->id())
                                                ->whereReply($support->reply)
                                                ->first();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $support->subject }}</td>
                                            <td>{{ Str::limit($support->message, 50) }}</td>
                                            <td>{{ $support->created_at->format('d M Y') }}</td>
                                            <td>{{ $support->reply ?? '--' }}</td>
                                            <td>
                                                @if($support->status == 0)
                                                    <span class="badge badge-secondary">Pending</span>
                                                @elseif($support->status== 2)
                                                    <span class="badge badge-danger">Rejected</span>
                                                @else
                                                    <span class="badge badge-success">Resolved</span>
                                                @endif
                                            </td>
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
    @include('backend.brand.include.modal.raise-ticket')
    <!-- push external js -->
    @push('script')
    @include('backend.include.bulk-script')
        <script>
            $(document).ready(function() {
                var table = $('#supportTicketTable').DataTable({
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
                        {
                            extend: 'colvis',
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
