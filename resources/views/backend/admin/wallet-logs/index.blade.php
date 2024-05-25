@extends('backend.layouts.main')
@section('title', 'Wallet Logs')
@section('content')
    @php
    $breadcrumb_arr = [['name' => 'Wallet Logs', 'url' => 'javascript:void(0);', 'class' => 'active']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>Wallet Logs of {{NameById($id)}}</h5>
                            <span>List of Wallet Logs</span>
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
                        <h3>Wallet Logs</h3>
                        <div class="d-flex">
                            {{-- type filter state --}}
                            {{-- <form class="d-flex align-items-center" method="GET" action="{{ route('panel.wallet_logs.index',$id) }}">
                            </form> --}}
                            {{-- type filter end --}}

                            {{-- date filter start --}}
                            <form class="d-flex align-items-center" method="GET" action="{{ route('panel.wallet_logs.index',$id) }}">
                                <div class="form-group mr-2 mt-3 d-flex align-items-center" style="min-width:200px">
                                    <span class="mr-2">Type</span>
                                   
                                    <select name="model" id="" class="form-control select2">
                                        <option value="" aria-readonly="true">Select Type</option>
                                        @foreach (WalletlogModels() as $model_list)
                                           @dump($model_list)
                                           <option value="{{ $model_list['name']  }}" @if(request()->has('model') && request()->get('model') == $model_list['name']) {{__('selected')}}  @endif>{{ $model_list['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <label for="" class="mb-0" style="width: 132px;"> Date</label> --}}
                                <input type="date" name="date" class="form-control" @if(request()->has('date')) value="{{ request()->get('date') }}" @endif id="filterByDate">
                                <div class="d-flex">
                                    <button class="btn btn-outline-primary btn-icon ml-2" type="submit"><i class="fas fa-search"></i></button>
                                    <a href="{{ request()->url() }}" class="btn btn-outline-danger btn-icon ml-2"><i class="fa fa-undo"></i></a>
                                </div>
                            </form>
                            {{-- date filter end --}}
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="walletLogsTable" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Amount</th>
                                        {{-- <th>After Balance</th> --}}
                                        <th>Remark</th>
                                        <th>Created At</th>
                                         <th>Type</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wallet_logs as $wallet_log)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
{{--                                             <td><span style="line-height: 12px;" class="badge badge-{{ $wallet_log->type == 'credit' ? 'primary' : 'danger' }}">{{ ucfirst($wallet_log->type).'ed' }}</span></td> --}}

                                            
                                               
                                                @if($wallet_log->model == 'ScanSuperBonus' ||
                                                $wallet_log->model == 'SubscriptionSuperBonus' ||
                                                $wallet_log->model == 'InviteSuperBonus' ||
                                                $wallet_log->model == 'UploadBonus')
                                                  <td class="font-weight-bold">
                                                    {{ $wallet_log->type == 'credit' ? '+' : '-' }}
                                                    {{$wallet_log->amount}} Point 
                                                   </td>
                                                @else
                                                <td class="{{ $wallet_log->type == 'credit' ? 'text-success' : 'text-danger' }} font-weight-bold">
                                                    {{ $wallet_log->type == 'credit' ? '+' : '-' }}
                                                    {{ format_price($wallet_log->amount) }}
                                                </td>
                                                @endif
                                                
                                           
                                            {{-- <td>
                                                
                                                
                                                    @if($wallet_log->model == 'ScanSuperBonus' ||
                                                    $wallet_log->model == 'SubscriptionSuperBonus' ||
                                                    $wallet_log->model == 'InviteSuperBonus' ||
                                                    $wallet_log->model == 'UploadBonus')
                                                     {{$wallet_log->after_balance}} Point 
                                                    @else
                                                      {{ format_price($wallet_log->after_balance) }}
                                                    @endif
                                                 
                                                 
                                                
                                            </td> --}}
                                            <td>{{ $wallet_log->remark }}</td>
                                            <td>{{ getFormattedDate($wallet_log->created_at) }}</td>
                                            <td><span class="badge badge-warning">{{$wallet_log->model}}</span></td>
                                            {{-- <td>
                                                <div class="badge badge-{{ getWalletStatus($wallet_log->status)['color']}}">{{ getWalletStatus($wallet_log->status)['name']}}</div>
                                            </td> --}}
                                            {{-- <td>
                                                @if($wallet_log->status == 0)
                                                <a href="{{ route('panel.wallet_logs.status',[$wallet_log->id,1]) }}" class="btn btn-success">Accept</a>
                                                <a href="{{ route('panel.wallet_logs.status',[$wallet_log->id,2]) }}" class="btn btn-danger">Decline</a>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script>
            $(document).ready(function() {
                var table = $('#walletLogsTable').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': true,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [{
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
