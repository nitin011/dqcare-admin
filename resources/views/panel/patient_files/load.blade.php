<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $patient_files->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $patient_files->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $patient_files->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $patient_files->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                     <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                            <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Patient</a></li>                       
                            <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Date</a></li>                       
                            <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Comment</a></li>                       
                            <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Category  </a></li>                       
                            <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">File</a></li>                                                
                    </ul>
                
                </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                                               
                        <th class="col_1"> Patient   <div class="table-div"></div></th>

                        <th class="col_2">Date <div class="table-div"></div></th>
                          
                        <th class="col_4">Category<div class="table-div"></div></th>
                        <th class="col_4">Title<div class="table-div"></div></th>
                        <th class="col_3"> Comment <div class="table-div"></div></th>
                          <th class="col_5"> File <div class="table-div"></div></th>
                          <th class="col_6"> Created At <div class="table-div"></div></th>
                          <th class="col_7"> Updated At <div class="table-div"></div></th>
                    </tr>
                </thead>
                <tbody>
                    @if($patient_files->count() > 0)
                      @foreach($patient_files as  $patient_file)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.patient_files.edit', $patient_file->id) }}" title="Edit Patient File" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            @can('patient_file_delete')
                                            <a href="{{ route('panel.patient_files.destroy', $patient_file->id) }}" title="Delete Patient File" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                            @endcan 
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"><a class="btn-link-custom"href="{{route('panel.patient_files.edit',$patient_file->id)}}">{{getPatientFilePrefix($patient_file->id) }}</a></td>
                                    <td class="col_1"><a class="btn-link-custom"href="{{route('panel.users.show',$patient_file->user_id)}}">{{NameById($patient_file->user_id)}}</a></td>
                                    
                                  <td class="col_2">
                                    @if(isset($patient_file->date))
                                      {{\Carbon\Carbon::parse($patient_file->date)->format('d M Y')}}
                                    @else
                                      {{__('--')}}
                                    @endif
                                   
                                  </td>
                                  
                                  <td class="col_4">{{fetchFirst('App\Models\Category',$patient_file->category_id,'name','--')}}</td>
                                  <td class="col_4">{{$patient_file->title ?? 'N/A'}}</td>
                                  <td class="col_3">{{Str::limit($patient_file->comment,10,'....' ?? '--') }}</td>
                                  <td class="col_5"><a href="{{ route('panel.patient_files.view',$patient_file->id) }}" target="_blank" class="btn-link">Preview</a></td>
                                  <td class="col_6">{{getFormattedDateTime($patient_file->created_at)}}</td>
                                  <td class="col_7">{{getFormattedDateTime($patient_file->updated_at)}}</td>
                                 
                                  
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
            {{ $patient_files->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($patient_files->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $patient_files->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $patient_files->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
