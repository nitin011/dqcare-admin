<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $subscriptions->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $subscriptions->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $subscriptions->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $subscriptions->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li> 
                         <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                          <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Duration</a></li> 
                         <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Price</a></li>                                                
                    </ul>
                                
                    <a href="javascript:void(0);" id="print" data-url="{{ route('panel.subscriptions.print') }}"  data-rows="{{json_encode($subscriptions) }}" class="btn btn-primary btn-sm">Print</a>
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
                            Name <div class="table-div"></div></th>
                                                    <th class="col_2">
                            Status <div class="table-div"></div></th>
                                                    <th class="col_3">
                            Duration <div class="table-div"></div></th>
                                                    <th class="col_4">
                            Price <div class="table-div"></div></th>
                        </tr>
                </thead>
                <tbody>
                    @if($subscriptions->count() > 0)
                        @foreach($subscriptions as  $subscription)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.subscriptions.edit', $subscription->id) }}" title="Edit Subscription" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            @if($subscription->id != 1)
                                                <a href="{{ route('panel.subscriptions.destroy', $subscription->id) }}" title="Delete Subscription" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                            @endif
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{ getSubscriptionsPrefix($subscription->id) }}</td>
                                <td class="col_1">{{$subscription->name }}</td>
                                  <td class="col_2">
                                    @if ($subscription->is_published == 1)
                                      <span class="badge badge-success">Published</span>
                                      @else
                                      <span class="badge badge-danger">Unpublished</span>
                                    @endif
                                </td>
                                  <td class="col_3">{{$subscription->duration }}days</td>
                                  <td class="col_4">{{format_price($subscription->price )}}</td>
                                  
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
            {{ $subscriptions->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($subscriptions->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $subscriptions->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $subscriptions->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
