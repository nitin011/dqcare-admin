@extends('backend.layouts.empty') 
@section('title', 'Storys')
@section('content')
@php
/**
 * Story 
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
                                    <th>User  </th>
                                    <th>Created By </th>
                                    <th>Date</th>
                                    <th>Detail</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($storys->count() > 0)
                                    @foreach($storys as  $story)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$story['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$story['created_by'],'name','--')}}</td>
                                             <td>{{$story['date'] }}</td>
                                             <td>{{$story['detail'] }}</td>
                                                 
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
