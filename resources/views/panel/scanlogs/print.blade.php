@extends('backend.layouts.empty') 
@section('title', 'Scanlogs')
@section('content')
@php
/**
 * Scanlog 
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
                                    <th>Interval</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($scanlogs->count() > 0)
                                    @foreach($scanlogs as  $scanlog)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$scanlog['doctor_id'],'first_name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$scanlog['user_id'],'first_name','--')}}</td>
                                             <td>{{$scanlog['interval'] }}</td>
                                                 
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
