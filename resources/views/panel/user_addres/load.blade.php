<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $user_addres->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $user_addres->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $user_addres->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $user_addres->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User Id</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Details</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Is Primary</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_addres.print') }}"  data-rows="{{json_encode($user_addres) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">
                            User Id <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_id"></i></div></th>
                                                    <th class="col_2">
                            Details <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="details"></i><i class="ik ik ik-arrow-down desc" data-val="details"></i></div></th>
                                                    <th class="col_3">
                            Is Primary <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="is_primary"></i><i class="ik ik ik-arrow-down desc" data-val="is_primary"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($user_addres->count() > 0)
                                                    @foreach($user_addres as  $user_addre)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.user_addres.edit', $user_addre->id) }}" title="Edit User Addre" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.user_addres.destroy', $user_addre->id) }}" title="Delete User Addre" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">{{$user_addre->user_id }}</td>
                                  <td class="col_2">{{$user_addre->details }}</td>
                                  <td class="col_3">{{$user_addre->is_primary }}</td>
                                  
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
            {{ $user_addres->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($user_addres->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $user_addres->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $user_addres->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
