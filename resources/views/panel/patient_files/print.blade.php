@extends('backend.layouts.empty') 
@section('title', 'Patient Files')
@section('content')
@php
/**
 * Patient File 
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
                                    <th>Date</th>
                                    <th>Comment</th>
                                    <th>Category  </th>
                                    <th>File</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($patient_files->count() > 0)
                                    @foreach($patient_files as  $patient_file)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$patient_file['user_id'],'name','--')}}</td>
                                             <td>{{$patient_file['date'] }}</td>
                                             <td>{{$patient_file['comment'] }}</td>
                                                 <td>{{fetchFirst('App\Models\Category',$patient_file['category_id'],'name','--')}}</td>
                                             <td><a href="{{ asset($patient_file['file']) }}" target="_blank" class="btn-link">{{$patient_file['file'] }}</a></td>
                                                 
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
