@extends('backend.layouts.empty') 
@section('title', 'Subscriptions')
@section('content')
@php
/**
 * Subscription 
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
                                    <th>Name</th>
                                    <th>Is Published</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($subscriptions->count() > 0)
                                    @foreach($subscriptions as  $subscription)
                                        <tr>
                                            <td>{{$subscription['name'] }}</td>
                                             <td>{{$subscription['is_published'] }}</td>
                                             <td>{{$subscription['duration'] }}</td>
                                             <td>{{$subscription['price'] }}</td>
                                                 
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
