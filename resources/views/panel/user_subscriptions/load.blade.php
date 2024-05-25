<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $user_subscriptions->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $user_subscriptions->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $user_subscriptions->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $user_subscriptions->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                
         <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
         <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
          <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        
                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Subscriber  </a></li>
                          <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Subscription  </a></li>                        <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Duration</a></li> 
                      
                    </ul>
                                
                     <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_subscriptions.print') }}"  data-rows="{{json_encode($user_subscriptions) }}" class="btn btn-primary btn-sm">Print</a>
                            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"></div></th>             
                                               
                        <th class="col_1"> Subscriber   <div class="table-div"></div></th>
                        <th class="col_2"> Subscription    <div class="table-div"></div></th>
                        <th class="col_3"> Duration <div class="table-div"></div></th>
                        <th class="col_3"> Status <div class="table-div"></div></th>
                     </tr>
                </thead>
                <tbody>
                    @if($user_subscriptions->count() > 0)
                          @foreach($user_subscriptions as  $user_subscription)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            @if($user_subscription->parent_id == null)
                                            <a href="{{ route('panel.user_subscriptions.edit', $user_subscription->id) }}" title="Edit User Subscription" class="dropdown-item "><li class="p-0">Edit</li></a> 
                                            @endif
                                            <a href="{{ route('panel.user_subscriptions.destroy', $user_subscription->id) }}" title="Delete User Subscription" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                        <td  class="text-center no-export">{{ getSubscriberPrefix($user_subscription->id) }}</td>
                                            @if($user_subscription->parent_id == null)
                                                <td class="col_1 ">
                                                    <a href="{{route('panel.users.show',$user_subscription->user_id)}}">
                                                        <div class="fw-700">
                                                            {{NameById($user_subscription->user_id)}}
                                                        </div>
                                                    </a>
                                                </td>
                                            @else 
                                                <td class="col_1 ">
                                                    <a href="{{route('panel.users.show',$user_subscription->user_id)}}">
                                                        <div class="fw-700">
                                                            {{NameById($user_subscription->user_id)}}
                                                        </div>
                                                    </a>

                                                    <span class="text-muted">
                                                        <i class="fa fa-link"></i>
                                                        @if($user_subscription->parent_id == null) - @else  {{NameById($user_subscription->parent_id)}} @endif
                                                    </span>
                                                </td>
                                            @endif
                                        
                                           
                                            <td class="col_2">{{fetchFirst('App\Models\Subscription',$user_subscription->subscription_id,'name','--')}}</td>
                                            <td class="col_3">{{\Carbon\Carbon::parse($user_subscription->from_date)->format('d/m/y')}}-{{\Carbon\Carbon::parse($user_subscription->to_date)->format('d/m/y')}}</td>
                                                {{-- <td class="col_4">{{$user_subscription->to_date }}</td> --}}
                                                @if(now() > ($user_subscription->to_date))
                                                    <td class="col_3"><span class="badge badge-danger m-1">Inactive</span></td>
                                                @else 
                                                    <td class="col_3"><span class="badge badge-success m-1">Active</span></td>
                                                @endif
                                            
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
            {{ $user_subscriptions->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($user_subscriptions->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $user_subscriptions->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $user_subscriptions->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
