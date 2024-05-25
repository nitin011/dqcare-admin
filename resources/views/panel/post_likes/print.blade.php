@extends('backend.layouts.empty') 
@section('title', 'Post Likes')
@section('content')
@php
/**
 * Post Like 
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
                                    <th>Post  </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($post_likes->count() > 0)
                                    @foreach($post_likes as  $post_like)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$post_like['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\PostManagement',$post_like['post_id'],'name','--')}}</td>
                                                 
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
