@extends('backend.layouts.empty') 
@section('title', 'Access Doctors')
@section('content')
@php
/**
 * Access Doctor 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
@endphp
   

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">                     
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>                                      
                                    <th>User Id</th>
                                    <th>Doctor Id</th>
                                    <th>Assign By</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($access_doctors->count() > 0)
                                    @foreach($access_doctors as  $access_doctor)
                                        <tr>
                                            <td>{{$access_doctor['user_id'] }}</td>
                                             <td>{{$access_doctor['doctor_id'] }}</td>
                                             <td>{{$access_doctor['assign_by'] }}</td>
                                                 
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="8">No Data Found...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
