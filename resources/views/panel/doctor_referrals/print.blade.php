@extends('backend.layouts.empty') 
@section('title', 'Doctor Referrals')
@section('content')
@php
/**
 * Doctor Referral 
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
                                    <th>Party Name</th>
                                    <th>Remark</th>
                                    <th>Date</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($doctor_referrals->count() > 0)
                                    @foreach($doctor_referrals as  $doctor_referral)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$doctor_referral['user_id'],'name','--')}}</td>
                                             <td>{{$doctor_referral['party_name'] }}</td>
                                             <td>{{$doctor_referral['remark'] }}</td>
                                             <td>{{$doctor_referral['date'] }}</td>
                                                 
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
