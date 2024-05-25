<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $payouts->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $payouts->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $payouts->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $payouts->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>
                      <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Amount</a></li> 
                        {{-- <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Type</a></li>    --}}
                        <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li> 
                         <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li> 
                       <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Approved At</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.payouts.print') }}"  data-rows="{{json_encode($payouts) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                        <th class="col_1">
                            User
                        </th>
                        <th class="col_2">
                            Amount
                        </th>
                        <th class="col_4">
                            Status
                        </th>
                        <th class="col_6">
                            Approved At
                        </th>
                        <th class="col_5">
                            Created At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($payouts->count() > 0)
                        @foreach($payouts as  $payout)
                            <tr>
                                {{-- <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.payouts.show', $payout->id) }}" title="Edit Payout" class="dropdown-item "><li class="p-0">Show</li></a>
                                            
                                        </ul>
                                    </div> 
                                </td> --}}
                                <td  class="text-center"><a style="" class="text-primary" href="{{ route('panel.payouts.show', $payout->id) }}">#POUT{{  getPrefixZeros($payout->id) }}</a></td>
                   
                                    <td class="col_1">
                                        
                                        {{fetchFirst('App\User',$payout->user_id,'first_name','--')}}
                                    </td>
                                  <td class="col_2">{{ format_price($payout->amount) }}</td>
                                  <td class="col_4"><span class="badge badge-{{ getPayoutStatus($payout->status)['color'] }}">{{ getPayoutStatus($payout->status)['name'] }}</span></td>
                                  <td class="col_6">{{ getFormattedDate($payout->approved_at) }}</td>
                                  <td class="col_5">{{ getFormattedDate($payout->created__at) }}</td>
                                  
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
            {{ $payouts->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($payouts->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $payouts->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $payouts->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
