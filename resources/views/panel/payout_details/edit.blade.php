@extends('backend.layouts.main')
@section('title', 'Payout Detail')
@section('content')
    @php
        /**
         * Payout Detail
         *
         * @category  zStarter
         *
         * @ref  zCURD
         * @author    Defenzelite <hq@defenzelite.com>
         * @license  https://www.defenzelite.com Defenzelite Private Limited
         * @version  <zStarter: 1.1.0>
         * @link        https://www.defenzelite.com
         */
        $breadcrumb_arr = [['name' => 'Edit Payout Detail', 'url' => 'javascript:void(0);', 'class' => '']];
        $details = $payout_detail->payload;
       
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
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
                            <h5>Edit Payout Detail</h5>
                            <span>Update a record for Payout Detail</span>
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
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                @if ($payout_detail->type == 0)
                    <div class="card">
                        <div class="card-header d-flex justify-content-between ">
                            <h3>Payout Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="table">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>UPI Holder Name </th>
                                            <td>{{ $details->upi_holder_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>UPI Id</th>
                                            <td>{{ $details->upi_id }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header d-flex justify-content-between ">
                            <h3>Payout Bank</h3>
                        </div>
                        <div class="card-body">
                            <div class="table">
                                <table class="table">
                                    {{-- @dd($payout_detail); --}}
                                    <tbody>
                                        <tr>
                                            <th>Account Holder Name </th>
                                            <td>{{ $details->account_holder_name }}</td>
                                        </tr>
                                        <tr>

                                            <th>Account Number</th>
                                            <td>{{ $details->account_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>IFSC Code</th>
                                            <td>{{ $details->ifsc_code }}</td>
                                        </tr>
                                        <tr>

                                            <th>Branch</th>
                                            <td>{{ $details->branch }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Payout Detail</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.payout_details.update', $payout_detail->id) }}" method="post"
                            enctype="multipart/form-data" id="PayoutDetailForm">
                            @csrf
                            <div class="row">


                                {{-- <label for="user_id" class="control-label">User</label>
                                        <input type="text" class="form-control" id="user_id" name="user_id"value="{{NameById($payout_detail->user_id)}}"> --}}
                                <input type="hidden"class="form-control" id="user_id" name="user_id"
                                    value="{{ $payout_detail->user_id }}">
                                    <input type="hidden"class="form-control" id="type" name="type"
                                    value="{{ $payout_detail->type }}">
                                @if ($payout_detail->type == 0)
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">UPI Holder Name</label>
                                            <input type="text" class="form-control" name="upi_holder_name" type="text"
                                                id="upi_holder_name"value="{{ $details->upi_holder_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">UPI Id</label>
                                            <input type="text" class="form-control" name="upi_id" type="text"
                                                id="upi_id"value="{{ $details->upi_id }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">Account Holder Name</label>
                                            <input type="text" class="form-control" name="account_holder_name"
                                                type="text"
                                                id="account_holder_name"value="{{ $details->account_holder_name }}">
                                        </div>
                                        {{-- {"upi_holder_name":"bzhsh","upi_id":"yshdbhd"}  --}}
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">Account Number</label>
                                            <input type="text" class="form-control" name="account_number" type="text"
                                                id="account_number"value="{{ $details->account_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc_code" type="text"
                                                id="ifsc_code"value="{{ $details->ifsc_code }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
                                            <label for="" class="control-label">Branch</label>
                                            <input type="text" class="form-control" name="branch" type="text"
                                                id="branch"value="{{ $details->branch }}">
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}"><br>
                                        <label for="is_active" class="control-label">Is Active</label>
                                        <input class="js-single switch-input"
                                            @if ($payout_detail->is_active) checked @endif name="is_active"
                                            type="checkbox" id="is_active" value="1">
                                    </div>
                                </div>
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- push external js -->
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#PayoutDetailForm').validate();
    </script>
@endpush
