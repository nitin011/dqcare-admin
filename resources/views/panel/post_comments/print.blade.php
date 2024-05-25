@extends('backend.layouts.empty') 
@section('title', 'Post Comments')
@section('content')
@php
/**
 * Post Comment 
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
                                    <th>Post  </th>
                                    <th>User  </th>
                                    <th>Comment</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($post_comments->count() > 0)
                                    @foreach($post_comments as  $post_comment)
                                        <tr>
                                                <td>{{fetchFirst('App\Models\PostManagement',$post_comment['post_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$post_comment['user_id'],'name','--')}}</td>
                                             <td>{{$post_comment['comment'] }}</td>
                                                 
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
