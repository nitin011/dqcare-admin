@extends('backend.layouts.empty') 
@section('title', 'Payouts')
@section('content')
@php
/**
 * Payout 
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
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Approved By</th>
                                    <th>Approved At</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($payouts->count() > 0)
                                    @foreach($payouts as  $payout)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$payout['user_id'],'name','--')}}</td>
                                             <td>{{$payout['amount'] }}</td>
                                             <td>{{$payout['type'] }}</td>
                                             <td>{{$payout['status'] }}</td>
                                             <td>{{$payout['approved_by'] }}</td>
                                             <td>{{$payout['approved_at'] }}</td>
                                                 
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
