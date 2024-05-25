@extends('backend.layouts.empty') 
@section('title', 'Educations')
@section('content')
@php
/**
 * Education 
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
                                    <th>Degree</th>
                                    <th>College Name</th>
                                    <th>Field Study</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>User  </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($educations->count() > 0)
                                    @foreach($educations as  $education)
                                        <tr>
                                            <td>{{$education['degree'] }}</td>
                                             <td>{{$education['college_name'] }}</td>
                                             <td>{{$education['field_study'] }}</td>
                                             <td>{{$education['start_date'] }}</td>
                                             <td>{{$education['end_date'] }}</td>
                                                 <td>{{fetchFirst('App\User',$education['user_id'],'name','--')}}</td>
                                                 
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
