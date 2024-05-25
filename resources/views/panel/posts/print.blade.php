@extends('backend.layouts.empty') 
@section('title', 'Post Managements')
@section('content')
@php
/**
 * Post Management 
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
                                    <th>Description</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($post_managements->count() > 0)
                                    @foreach($post_managements as  $post_management)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$post_management['user_id'],'name','--')}}</td>
                                             <td>{{$post_management['status'] }}</td>
                                             <td>{{$post_management['description'] }}</td>
                                                 
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
