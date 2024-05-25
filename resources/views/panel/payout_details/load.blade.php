<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $payout_details->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $payout_details->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $payout_details->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $payout_details->perPage() == 100 ? 'selected' : ''}}>100</option>
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
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User Id</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Type</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Payload</a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Is Active</a></li>                                                
                    </ul>
                                         --}}
                                
                                     {{--
                                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.payout_details.print') }}"  data-rows="{{json_encode($payout_details) }}" class="btn btn-primary btn-sm">Print</a>
                                         --}}
                            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class=" no-export"># <div class="table-div"></div></th>                            
                        <th class="col_1"> User Name <div class="table-div"></div></th>
                         <th class="col_2"> Type <div class="table-div"></div></th>
                           
                     </tr>
                </thead>
                <tbody>
                    @if($payout_details->count() > 0)
                       @foreach($payout_details as  $payout_detail)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.payout_details.edit', $payout_detail->id) }}" title="Edit Payout Detail" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.payout_details.destroy', $payout_detail->id) }}" title="Delete Payout Detail" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                               <td  class=" no-export"> {{getUserPrefix ($payout_detail->id) }}</td>
                               <td class="col_1">{{NameById($payout_detail->user_id) }}</td>
                               <td>
                               @if($payout_detail->type  == 0 )
                               <span  class="badge badge-info">UPI</span> 
                             @else
                              <span class="badge badge-warning">Bank</span> 
                             @endif
                               </td>
                                  {{-- <td class="col_2">{{$payout_detail->type }}</td> --}}
                               
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
            {{ $payout_details->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($payout_details->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $payout_details->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $payout_details->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
