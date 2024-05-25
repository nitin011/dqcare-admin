<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $user_kycs->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $user_kycs->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $user_kycs->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $user_kycs->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Details</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_kycs.print') }}"  data-rows="{{json_encode($user_kycs) }}" class="btn btn-primary btn-sm">Print</a>
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
                            User    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_id"></i></div></th>
                                                    <th class="col_2">
                            Status <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="status"></i><i class="ik ik ik-arrow-down desc" data-val="status"></i></div></th>
                                                    <th class="col_3">
                            Details <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="details"></i><i class="ik ik ik-arrow-down desc" data-val="details"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($user_kycs->count() > 0)
                                                    @foreach($user_kycs as  $user_kyc)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.user_kycs.edit', $user_kyc->id) }}" title="Edit User Kyc" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.user_kycs.destroy', $user_kyc->id) }}" title="Delete User Kyc" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                    <td class="col_1">{{fetchFirst('App\User',$user_kyc->user_id,'name','--')}}</td>
                                  <td class="col_2">{{$user_kyc->status }}</td>
                                  <td class="col_3">{{$user_kyc->details }}</td>
                                  
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
            {{ $user_kycs->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($user_kycs->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $user_kycs->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $user_kycs->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
