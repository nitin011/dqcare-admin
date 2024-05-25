<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $experiences->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $experiences->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $experiences->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $experiences->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Doctor Name</a></li> 
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Title</a></li> 
                         <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Clinic Name</a></li> 
                          <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Start Date</a></li> 
                       <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">End Date</a></li>
                         <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Location</a></li>                                                
                    </ul>
                                
                                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.experiences.print') }}"  data-rows="{{json_encode($experiences) }}" class="btn btn-primary btn-sm">Print</a>
                            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                                               
                        <th class="col_6"> Doctor Name <div class="table-div"></div></th>
                        <th class="col_1"> Title <div class="table-div"></div></th>
                        <th class="col_2"> Clinic Name <div class="table-div"></div></th>
                        <th class="col_3">Start Date <div class="table-div"></div></th>
                         <th class="col_4"> End Date <div class="table-div"></div></th>
                         <th class="col_5">  Location <div class="table-div"></div></th>
                         <th class="col_7"> Created At <div class="table-div"></div></th>
                         <th class="col_8"> Updated At <div class="table-div"></div></th>
                     </tr>
                </thead>
                <tbody>
                    @if($experiences->count() > 0)
                    @foreach($experiences as  $experience)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.experiences.edit', $experience->id) }}" title="Edit Experience" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.experiences.destroy', $experience->id) }}" title="Delete Experience" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{getExperiencePrefix($experience->id) }}</td>
                                <td class="col_1">{{NameById($experience->user_id) }}</td>
                                <td class="col_1">{{$experience->title }}</td>
                                  <td class="col_2">{{$experience->clinic_name }}</td>
                                  <td class="col_3">{{$experience->start_date }}</td>
                                  <td class="col_4">{{$experience->end_date }}</td>
                                  <td class="col_5">{{$experience->location }}</td>
                                  <td class="col_5">{{getFormattedDateTime($experience->created_at) }}</td>
                                  <td class="col_5">{{getFormattedDateTime($experience->updated_at) }}</td>
                                  
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
            {{ $experiences->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($experiences->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $experiences->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $experiences->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
