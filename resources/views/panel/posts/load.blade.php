<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $posts->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $posts->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $posts->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $posts->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
           </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                                               
                        <th class="col_1"> Patient   <div class="table-div"></div></th>
                     
                                                    
                        <th class="col_2"> Description <div class="table-div"></div></th>
                         <th class="col_3"> Status <div class="table-div"></div></th>
                         <th class="col_3"> 
                            Respect's <div class="table-div"></div></th>
                         <th class="col_3">Comment's <div class="table-div"></div></th>
                                                    
                         <th class="col_4">Created At <div class="table-div"></div></th>
                                                    
                           <th class="col_5"> Updated At <div class="table-div"></div></th>
                                                    
                    </tr>
                </thead>
                <tbody>
                    @if($posts->count() > 0)
                        @foreach($posts as  $post)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.posts.edit', $post->id) }}" title="Edit Post Management" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.posts.destroy', $post->id) }}" title="Delete Post Management" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                            <a href="{{ route('panel.post_likes.index',['post_id' => $post->id])}}" title="post like" class="dropdown-item"><li class=" p-0">Manage 
                                                Respect</li></a>
                                            <a href="{{ route('panel.post_comments.index',['post_id' => $post->id])}}" title="post comment" class="dropdown-item "><li class=" p-0">Manage Comments</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"><a class="btn-link-custom"href="{{route('panel.posts.edit',$post->id)}}">{{getPostPrefix($post->id)}}</a></td>
                                    <td class="col_1"><a class="btn-link-custom"href="{{route('panel.users.show',$post->user_id)}}">{{NameById($post->user_id)}}</a></td>
                                    <td class="col_3">{{Str::limit($post->description, 10,'....') }}</td>
                                    <td class="col_2">
                                    <span class="badge badge-{{getPostManagementStatus($post->status)['color'] ?? 'primary'}}">
                                    {{getPostManagementStatus($post->status)['name'] }}
                                  </span>
                                </td>
                                <td class="col_3">{{$post->like_count}}  <i class="fa fa-thumbs-up text-muted" aria-hidden="true"></i></td>
                                <td class="col_3">{{$post->comment_count}} <i class="fa fa-commenting text-muted" aria-hidden="true"></i></td>

                                  
                                   <td class="col_3">{{getFormattedDateTime($post->created_at) }}</td>
                                   <td class="col_3">{{getFormattedDateTime($post->updated_at) }}</td>
                                  
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
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $posts->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($posts->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $posts->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $posts->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
