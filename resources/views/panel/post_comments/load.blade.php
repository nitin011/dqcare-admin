<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $post_comments->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $post_comments->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $post_comments->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $post_comments->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
                                 {{--
                                    <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                                        --}}
                    
                                     {{--
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Post  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Comment</a></li>                                                
                    </ul>
                                         --}}
                                
                                     {{--
                                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.post_comments.print') }}"  data-rows="{{json_encode($post_comments) }}" class="btn btn-primary btn-sm">Print</a>
                                         --}}
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
                            Post    <div class="table-div"></div></th>
                                                    <th class="col_2">
                            User    <div class="table-div"></div></th>
                                                    <th class="col_3">
                            Comment <div class="table-div"></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($post_comments->count() > 0)
                                                    @foreach($post_comments as  $post_comment)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.post_comments.edit', $post_comment->id) }}" title="Edit Post Comment" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.post_comments.destroy', $post_comment->id) }}" title="Delete Post Comment" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{getPostCommentPrefix($post_comment->id) }}</td>
                                    <td class="col_1">{{fetchFirst('App\Models\Post',$post_comment->post_id,'name','--')}}</td>
                                      <td class="col_2">{{NameById($post_comment->user_id)}}</td>
                                  <td class="col_3">{{$post_comment->comment }}</td>
                                  
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
            {{ $post_comments->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($post_comments->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $post_comments->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $post_comments->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
