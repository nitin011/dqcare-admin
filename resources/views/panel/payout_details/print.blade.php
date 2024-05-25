@extends('backend.layouts.empty') 
@section('title', 'Payout Details')
@section('content')
@php
/**
 * Payout Detail 
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
                                    <th>Type</th>
                                    <th>Payload</th>
                                    <th>Is Active</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($payout_details->count() > 0)
                                    @foreach($payout_details as  $payout_detail)
                                        <tr>
                                            <td>{{$payout_detail['user_id'] }}</td>
                                             <td>{{$payout_detail['type'] }}</td>
                                             <td>{{$payout_detail['payload'] }}</td>
                                             <td>{{$payout_detail['is_active'] }}</td>
                                                 
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
