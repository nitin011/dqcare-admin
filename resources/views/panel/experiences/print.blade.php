@extends('backend.layouts.empty') 
@section('title', 'Experiences')
@section('content')
@php
/**
 * Experience 
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
                                    <th>Title</th>
                                    <th>Clinic Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Location</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($experiences->count() > 0)
                                    @foreach($experiences as  $experience)
                                        <tr>
                                            <td>{{$experience['title'] }}</td>
                                             <td>{{$experience['clinic_name'] }}</td>
                                             <td>{{$experience['start_date'] }}</td>
                                             <td>{{$experience['end_date'] }}</td>
                                             <td>{{$experience['location'] }}</td>
                                                 
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
