@extends('backend.layouts.empty') 
@section('title', 'User Kycs')
@section('content')
@php
/**
 * User Kyc 
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
                                    <th>Status</th>
                                    <th>Details</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_kycs->count() > 0)
                                    @foreach($user_kycs as  $user_kyc)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$user_kyc['user_id'],'name','--')}}</td>
                                             <td>{{$user_kyc['status'] }}</td>
                                             <td>{{$user_kyc['details'] }}</td>
                                                 
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
