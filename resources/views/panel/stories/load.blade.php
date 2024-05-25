<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $stories->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $stories->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $stories->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $stories->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Patient  </a></li> 
                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Created By </a></li>
                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Date</a></li> 
                          <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                                                
                     </ul>
                                
                        <a href="javascript:void(0);" id="print" data-url="{{ route('panel.stories.print') }}"  data-rows="{{json_encode($stories) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>                              
                        <th class="col_1"> Patient<div class="table-div"></div></th>
                        <th class="col_2">Created By <div class="table-div"></div></th> 
                        <th class="col_3">Date <div class="table-div"></div></th>
                        <th class="col_4">Status <div class="table-div"></div></th>
                        <th class="col_5">Created At<div class="table-div"></div></th> 
                        <th class="col_6">Updated At<div class="table-div"></div></th> 
                      
                                                    
                          </tr>
                </thead>
                <tbody>
                    @if($stories->count() > 0)
                                                    
                    @foreach($stories as  $story)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.stories.edit', $story->id) }}" title="Edit Story" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.stories.destroy', $story->id) }}" title="Delete Story" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"><a href="{{ route('panel.stories.edit', $story->id) }}"> {{ getStoryPrefix($story->id) }}</a></td>
                                    <td class="col_1"><a class="btn-link-custom"href="{{route('panel.users.show',$story->user_id)}}">{{NameById($story->user_id)}}</a>
                                        @if($story->type == 1)
                                            <span title="Published" class="text-success"><i class="fa fa-check"></i></span>
                                        @endif
                                    </td>
                                    <td class="col_2">{{fetchFirst('App\User',$story->created_by,'name','--')}}</td>
                                   <td class="col_3">{{getFormattedDateTime($story->date) }}</td>  
                                  <td class="col_4">
                                    
                                    <span class="badge badge-{{getStoryStatus($story->status)['color'] ?? 'primary'}}">
                                    {{getStoryStatus($story->status)['name'] }}
                                    
                                    </td>

                                    <td class="col_5">{{getFormattedDateTime($story->created_at) }}</td>
                                    <td class="col_6">{{getFormattedDateTime($story->updated_at) }}</td>
                                   
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
            {{ $stories->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($stories->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $stories->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $stories->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
