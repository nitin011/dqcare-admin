<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $follow_ups->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $follow_ups->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $follow_ups->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $follow_ups->perPage() == 100 ? 'selected' : ''}}>100</option>
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
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Doctor  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Remark</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Date</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                                                
                    </ul>
                                         --}}
                                
                                     {{--
                                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.follow_ups.print') }}"  data-rows="{{json_encode($follow_ups) }}" class="btn btn-primary btn-sm">Print</a>
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
                            Doctor    <div class="table-div"></div></th>
                                                    <th class="col_2">
                             Patient    <div class="table-div"></div></th>
                                               <th class="col_3"> 
                            Remark <div class="table-div"></div></th> 
                                                    
                                                    <th class="col_5">
                            Status <div class="table-div"></div></th>
                                    <th class="col_4">
                                Date <div class="table-div"></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($follow_ups->count() > 0)
                         @foreach($follow_ups as  $follow_up)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.follow_ups.edit', $follow_up->id) }}" title="Edit Follow Up" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.follow_ups.destroy', $follow_up->id) }}" title="Delete Follow Up" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{getFollowUpPrefix($follow_up->id)   }}</td>
                                    <td class="col_1"><a class="btn-link-custom"href="{{route('panel.users.show',$follow_up->doctor_id)}}">{{NameById($follow_up->doctor_id)}}</a></td>
                                      <td class="col_2">{{NameById($follow_up->user_id)}}</td>
                                  <td class="col_3">{{$follow_up->remark }}</td>
                                  

                                  <td class="col_5"><span class="badge badge-{{getEnquiryStatus($follow_up->status)['color'] ?? 'primary'}}">
                                    {{getEnquiryStatus($follow_up->status)['name'] }}</td>
                                    <td class="col_4">{{getFormattedDateTime($follow_up->date) }}</td>
                                  
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
            {{ $follow_ups->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($follow_ups->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $follow_ups->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $follow_ups->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
