@extends('backend.layouts.empty') 
@section('title', 'Follow Ups')
@section('content')
@php
/**
 * Follow Up 
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
                                    <th>Doctor  </th>
                                    <th>User  </th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($follow_ups->count() > 0)
                                    @foreach($follow_ups as  $follow_up)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$follow_up['doctor_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$follow_up['user_id'],'name','--')}}</td>
                                             <td>{{$follow_up['remark'] }}</td>
                                             <td>{{$follow_up['date'] }}</td>
                                             <td>{{$follow_up['status'] }}</td>
                                                 
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
