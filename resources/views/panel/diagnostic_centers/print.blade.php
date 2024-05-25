@extends('backend.layouts.empty') 
@section('title', 'Diagnostic Centers')
@section('content')
@php
/**
 * Diagnostic Center 
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
                                    <th>Countory  </th>
                                    <th>State  </th>
                                    <th>City  </th>
                                    <th>Pincode</th>
                                    <th>Addressline 1</th>
                                    <th>Addressline 2</th>
                                    <th>Destrict</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($diagnostic_centers->count() > 0)
                                    @foreach($diagnostic_centers as  $diagnostic_center)
                                        <tr>
                                            <td>{{$diagnostic_center['name'] }}</td>
                                                 <td>{{fetchFirst('App\Models\Country',$diagnostic_center['countory_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\State',$diagnostic_center['state_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\City',$diagnostic_center['city_id'],'name','--')}}</td>
                                             <td>{{$diagnostic_center['pincode'] }}</td>
                                             <td>{{$diagnostic_center['addressline_1'] }}</td>
                                             <td>{{$diagnostic_center['addressline_2'] }}</td>
                                             <td>{{$diagnostic_center['destrict'] }}</td>
                                                 
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
