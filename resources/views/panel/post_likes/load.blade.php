<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $post_likes->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $post_likes->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $post_likes->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $post_likes->perPage() == 100 ? 'selected' : ''}}>100</option>
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
                                               
                        <th class="col_1">
                            User    <div class="table-div"></div></th>
                                                    <th class="col_2">
                            Post    <div class="table-div"></div></th>
                                                    <th class="col_3">
                            Created_At    <div class="table-div"></div></th>
                                                                        
                        
                        </tr>
                </thead>
                <tbody>
                    @if($post_likes->count() > 0)
                          @foreach($post_likes as  $post_like)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            {{-- <a href="{{ route('panel.post_likes.edit', $post_like->id) }}" title="Edit Post Like" class="dropdown-item "><li class="p-0">Edit</li></a> --}}
                                            <a href="{{ route('panel.post_likes.destroy', $post_like->id) }}" title="Delete Post Like" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export">{{getPostLikePrefix($post_like->id)}}</td>
                                    <td class="col_1">{{NameById($post_like->user_id)}}</td>
                                      <td class="col_2">{{fetchFirst('App\Models\Post',$post_like->post_id,'name','--')}}</td>
                                      <td class="col_3">{{getFormattedDateTime($post_like->created_at)}}</td>
                                  
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
            {{ $post_likes->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($post_likes->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $post_likes->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $post_likes->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
