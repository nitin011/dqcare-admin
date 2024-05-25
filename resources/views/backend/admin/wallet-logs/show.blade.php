@extends('backend.layouts.main') 
@section('title', 'Appointment')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Appointment', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('View Appointment')}}</h5>
                            <span>{{ __('View a record for Appointment')}}</span>
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
            <div class="col-md-12 mx-auto">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Appointment</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>VIPA{{ $appointment->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Client Name </th>
                                        <td> {{ NameById($appointment->user_id) }} </td>
                                    </tr>
                                    <tr>
                                        <th> Teacher Name </th>
                                        <td> {{ NameById($appointment->consultant_id) }} </td>
                                    </tr>
                                    <tr>
                                        <th> Course </th>
                                        <td> {{ $appointment->course->title }} </td>
                                    </tr>
                                    <tr>
                                        <th> Lesson </th>
                                        <td> {{ !is_null($appointment->lesson) ? $appointment->lesson->title : '---' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Date and Time. </th>
                                        <td> {{ toLocalTime(\Carbon\Carbon::parse($appointment->date),"jS M, Y") }} -
                                            {{ toLocalTime(\Carbon\Carbon::parse($appointment->time),"h:i A") }} </td>
                                    </tr>
                                    <tr>
                                        <th> Status </th>
                                        <td> {{AppointmentStatus($appointment->status)['name']}} </td>
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
