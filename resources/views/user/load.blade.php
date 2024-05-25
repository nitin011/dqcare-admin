
    
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $users->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $users->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $users->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $users->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">S No.</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Action</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">User</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Role</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Email</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"  class="btn btn-sm">Balance</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Join At</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.users.print') }}" data-rows="{{ json_encode($users) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="user_table" class="table p-0">
                <thead>
                    <tr>
                        <th class="col_2 no-export"><input type="checkbox" class="mr-2 allChecked " name="id" value="">Actions</th>                                         
                        <th class="col_1 text-center no-export">{{ __('S No.')}}</th>
                        <th class="col_3">{{ request()->get('role') ?? ''}} Name</th>
                        <th class="col_4">{{ __('Role')}}</th>
                        <th class="col_5">{{ __('Email')}}</th>
                        @if(request()->has('role') && request()->get('role')=='Staff')

                        @else
                            @if(getSetting('wallet_activation') == 1)
                              <th class="col_8">{{ __('Balance')}}</th>
                            @endif   
                        @endif
                       
                        <th class="col_6">{{ __('Status')}}</th>
                        <th class="col_7">{{ __('Join At')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                        @foreach ($users as $item)
                        <tr>
                            <td class="col_2 no-export"> 

                                @if(Auth::user()->can('manage_user') && $item->name != 'Super Admin')
                                <div class="dropdown d-flex">
                                    <input type="checkbox" class="mr-2 delete_Checkbox text-center" name="id" value="{{$item->id}}">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action<i class="ik ik-chevron-right"></i>
                                        </button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            @can('edit_user')
                                            <a href="{{ url('panel/user/'.$item->id)}}"><li class="dropdown-item">Edit</li></a>
                                            @endcan
                                            @if(authRole() == "Admin" ||authRole()=="Staff")
                                                <a class="delete-item" href="{{ url('panel/user/delete/'.$item->id)}}"><li class="dropdown-item">Delete</li></a>
                                                @if ($item->roles[0]->name == "Admin"||$item->roles[0]->name == "Staff" || $item->roles[0]->name =="Receptionist")
                                                    <a href="{{ url('panel/user/login-as/'.$item->id)}}"><li class="dropdown-item">Login As</li></a>
                                                @endif
                                                @if($item->roles[0]->name == "Receptionist")
                                                    <a href="{{route('panel.access.doctor',$item->id)}}" class=" dropdown-item">Access Doctors</a>
                                                @endif
                                                @if(getSetting('wallet_activation') == 1)
                                                    <a href="javascript:void(0);" class="walletLogButton dropdown-item" data-id="{{$item->id}}">Balance C/D </a>
                                                @endif
                                            @endif
                                            
                                            <li class="dropdown-submenu">
                                                <a  class="dropdown-item" tabindex="-1" href="#">Status</a>
                                                <ul class="dropdown-menu">
                                                    @if ($item->status != 0)
                                                    <a tabindex="-1" href="{{ route('panel.user.status.update',[$item->id,0])}}"><li class="dropdown-item">Inactive</li></a>
                                                    @endif
                                                    @if($item->status != 1)
                                                    <a tabindex="-1" href="{{ route('panel.user.status.update',[$item->id,1])}}"><li class="dropdown-item">Active</li></a>
                                                    @endif
                                                </ul>
                                            </li>
                                        </ul>
                                </div>
                                @endif
                            </td>
                            <td class="col_1 text-center no-export">{{ getUserPrefix($item->id) }}</td>
                            <td class="col_3"><a 
                                 href="{{ route('panel.users.show', $item->id) }}">
                                    {{ucfirst($item->first_name.' '.$item->last_name)}}
                                 @if($item->is_verified == 1)
								<img src="{{ asset('backend/img/icon-verified.png') }}" title="Verified Doctor" style="width: 16px;" alt="">
							@endif
                            @if($item->doctor_id != null ) 
                                <i class="fa fa-stethoscope text-muted" aria-hidden="true"></i> 
                            @endif
                            </a></td>
                            <td class="col_4">{{ implode(' , ', $item->getRoleNames()->toArray()) }}</td>
                            <td class="col_5">{{ $item->email ?? '--' }}</td>
                            @if(request()->has('role') && request()->get('role')=='Staff')

                            @else
                                @if(getSetting('wallet_activation') == 1)
                                    <td class="col_5">
                                        <a href="{{ route('panel.wallet_logs.index',$item->id) }}" class="btn btn-link">
                                           
                                            {{ format_price($item->wallet_balance) }}
                                        </a>
                                    </td>
                                @endif
                            @endif
                           
                            <td class="col_6"><span class="badge badge-{{ getStatus($item->status)['color']}} m-1">{{ getStatus($item->status)['name']}}</span> </td>
                            <td class="col_7">{{ getFormattedDate($item->created_at) }}</td>
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
 
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($users->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $users->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
{{-- <i class="fa fa-stethoscope text-muted" aria-hidden="true"></i> --}}