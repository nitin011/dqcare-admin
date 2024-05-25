@extends('backend.layouts.empty') 
@section('title', 'User Addres')
@section('content')
@php
/**
 * User Addre 
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
                                    <th>Details</th>
                                    <th>Is Primary</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_addres->count() > 0)
                                    @foreach($user_addres as  $user_addre)
                                        <tr>
                                            <td>{{$user_addre['user_id'] }}</td>
                                             <td>{{$user_addre['details'] }}</td>
                                             <td>{{$user_addre['is_primary'] }}</td>
                                                 
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
