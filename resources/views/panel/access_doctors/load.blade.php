<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $access_doctors->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $access_doctors->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $access_doctors->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $access_doctors->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
                                    <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                    
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User Id</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Doctor Id</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Assign By</a></li>                                                
                    </ul>
                                
                                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.access_doctors.print') }}"  data-rows="{{json_encode($access_doctors) }}" class="btn btn-primary btn-sm">Print</a>
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
                            Doctor Id <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="doctor_id"></i><i class="ik ik ik-arrow-down desc" data-val="doctor_id"></i></div></th>
                                                    <th class="col_3">
                            Assign By <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="assign_by"></i><i class="ik ik ik-arrow-down desc" data-val="assign_by"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($access_doctors->count() > 0)
                                                    @foreach($access_doctors as  $access_doctor)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.access_doctors.edit', $access_doctor->id) }}" title="Edit Access Doctor" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.access_doctors.destroy', $access_doctor->id) }}" title="Delete Access Doctor" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">{{$access_doctor->user_id }}</td>
                                  <td class="col_2">{{$access_doctor->doctor_id }}</td>
                                  <td class="col_3">{{$access_doctor->assign_by }}</td>
                                  
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
            {{ $access_doctors->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($access_doctors->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $access_doctors->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $access_doctors->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
