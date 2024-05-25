<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $scanlogs->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $scanlogs->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $scanlogs->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $scanlogs->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
                  <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                   <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Doctor  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Patient  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Interval</a></li>                                                
                    </ul>
                                
                   <a href="javascript:void(0);" id="print" data-url="{{ route('panel.scanlogs.print') }}"  data-rows="{{json_encode($scanlogs) }}" class="btn btn-primary btn-sm">Print</a>
                            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                                               
                        <th class="col_1"> Doctor <div class="table-div"></div></th>
                       <th class="col_2"> Patient <div class="table-div"></div></th>
                       <th class="col_2"> Status <div class="table-div"></div></th>
                      <th class="col_3">  Interval <div class="table-div"></div></th>
                      <th class="col_3">  Created At <div class="table-div"></div></th>
                    </tr>
                </thead>
                <tbody>
                    @if($scanlogs->count() > 0)
                         @foreach($scanlogs as  $scanlog)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            {{-- <a href="{{ route('panel.scanlogs.edit', $scanlog->id) }}" title="Edit Scanlog" class="dropdown-item "><li class="p-0">Edit</li></a> --}}
                                            <a href="{{ route('panel.scanlogs.destroy', $scanlog->id) }}" title="Delete Scanlog" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{getScanLogPrefix($scanlog->id) }}</td>
                                    <td class="col_1"><a class="btn-link-custom" href="{{route('panel.users.show',$scanlog->doctor_id)}}">{{NameById($scanlog->doctor_id)}}</a></td>
                                    <td class="col_2"><a href="{{route('panel.users.show',$scanlog->user_id)}}">{{NameById($scanlog->user_id)}}</a></td>
                                    @if(10<now()->diffInMinutes($scanlog->created_at))
                                        <td class="col_3"><span class="badge badge-danger m-1">Inactive</span></td>
                                    @else 
                                        <td class="col_3"><span class="badge badge-success m-1">Active</span></td>
                                    @endif
                                  <td class="col_3">{{$scanlog->interval }} minutes</td>
                                  <td class="col_3">{{getFormattedDateTime($scanlog->created_at) }}</td>
                                  
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
            {{ $scanlogs->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($scanlogs->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $scanlogs->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $scanlogs->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
