@extends('backend.layouts.empty') 
@section('title', 'User Subscriptions')
@section('content')
@php
/**
 * User Subscription 
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
                                    <th>Subscription  </th>
                                    <th>From-date</th>
                                    <th>To-date</th>
                                    <th>Parent  </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_subscriptions->count() > 0)
                                    @foreach($user_subscriptions as  $user_subscription)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$user_subscription['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Subscription',$user_subscription['subscription_id'],'name','--')}}</td>
                                             <td>{{$user_subscription['from-date'] }}</td>
                                             <td>{{$user_subscription['to-date'] }}</td>
                                                 <td>{{fetchFirst('App\User',$user_subscription['parent_id'],'name','--')}}</td>
                                                 
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
