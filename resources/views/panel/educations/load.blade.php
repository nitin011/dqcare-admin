<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $educations->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $educations->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $educations->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $educations->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
               <div>
                    <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Doctor Name</a></li>
                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Degree</a></li>
                          <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">College Name</a></li> 
                         <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Field Study</a></li> 
                          <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Start Date</a></li> 
                     <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">End Date</a></li> 
                   {{-- <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                                                 --}}
                    </ul>
                                
                    <a href="javascript:void(0);" id="print" data-url="{{ route('panel.educations.print') }}"  data-rows="{{json_encode($educations) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
                 <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search')}}" style="width:unset;">
          </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                        <th class="col_1">   Doctor Name  <div class="table-div"></div></th>                  
                         <th class="col_2">Degree <div class="table-div"></div></th>
                        <th class="col_3">  College Name <div class="table-div"></div></th>
                        <th class="col_4"> Field Study <div class="table-div"></div></th>
                    <th class="col_5"> Start Date <div class="table-div"></div></th>
                    <th class="col_6"> End Date <div class="table-div"></div></th>
                    <th class="col_7">Created At <div class="table-div"></div></th>
                    <th class="col_8">Updated At<div class="table-div"></div></th>
                       
            </tr>
                </thead>
                <tbody>
                    @if($educations->count() > 0)
                      @foreach($educations as  $education)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.educations.edit', $education->id) }}" title="Edit Education" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.educations.destroy', $education->id) }}" title="Delete Education" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{getEducationPrefix($education->id) }}</td>
                                <td class="col_1">{{NameById($education->user_id)}}</td>
                                <td class="col_2">{{$education->degree }}</td>
                                  <td class="col_3">{{$education->college_name }}</td>
                                  <td class="col_4">{{$education->field_study }}</td>
                                  <td class="col_5">{{$education->start_date }}</td>
                                  <td class="col_6">{{$education->end_date }}</td>
                                  <td class="col_7">{{getFormattedDateTime($education->created_at)}}</td>
                                  <td class="col_8">{{getFormattedDateTime($education->updated_at)}}</td>
                                   
                                  
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
            {{ $educations->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($educations->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $educations->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $educations->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
