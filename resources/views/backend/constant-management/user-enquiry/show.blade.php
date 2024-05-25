@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Website Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('View Website Enquiry')}}</h5>
                            <span>{{ __('View a record for Website Enquiry')}}</span>
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
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Website Enquiry</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>#ENQ{{ $user_enq->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Name </th>
                                        <td> {{ $user_enq->name }} </td>
                                    </tr>
                                    {{-- <tr>
                                        <th> Type </th>
                                        <td><div class="badge badge-info">{{ $user_enq->type }}</div></td>
                                    </tr> --}}
                                    <tr>
                                        <th> Email </th>
                                        <td>{{ $user_enq->type_value }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th> Subject </th>
                                        <td> {{ $user_enq->subject }} </td>
                                    </tr>
                                    <tr>
                                        <th> Comment </th>
                                        <td> {{ $user_enq->description }} </td>
                                    </tr>
                                  
                                  
                                    <tr>
                                        <th> Created At </th>
                                        <td> {{ getFormattedDate($user_enq->created_at) }}
                                        </td>
                                    </tr>
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
    @endpush
@endsection
