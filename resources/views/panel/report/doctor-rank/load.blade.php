<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Doctor ID  </a></li>                       
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm"> Doctor Name</a></li>                       
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm"> Qr Scan  </a></li>                                                  
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Patient Added </a></li>                                                  
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Total Points</a></li>                                                  
            </ul>
        </div>
         <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export col_1 ">Rank</th>
                    <th class="no-export col_1 ">Doctor ID</th>
                    <th class="col_2"> Doctor Name</th>
                    <th class="col_3">QR Scan</th>
                    <th class="col_4">Patient Subscribed</th>
                    <th class="col_5">Patient Added</th>
                    <th class="col_5">Total</th>
                </tr>
            </thead>
            <tbody>
                    @if($doctor_ranks->count() > 0)
                    @foreach($doctor_ranks as $key => $doctor_rank)

                    @php
                        $total = $doctor_rank->total;
                        $doctor_rank = \App\User::whereId($doctor_rank->user_id)->first();
                        if(!$doctor_rank){
                            continue;
                        }
                        if(request()->get('from') && request()->get('to')) {
                            $scans = \App\Models\WalletLog::whereModel('ScanSuperBonus')->whereUserId($doctor_rank->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->whereType('credit')->get(['id','amount'])->sum('amount');
                            $patient_subscribe =  \App\Models\WalletLog::whereModel('SubscriptionSuperBonus')->whereUserId($doctor_rank->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->get(['id','amount'])->sum('amount');
                            $patient_invited =  \App\Models\WalletLog::whereModel('InviteSuperBonus')->whereUserId($doctor_rank->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->get(['id','amount'])->sum('amount');
                            $total = $scans+$patient_subscribe+$patient_invited;
                        }else{
                            $scans = \App\Models\WalletLog::whereModel('ScanSuperBonus')->whereUserId($doctor_rank->id)->whereType('credit')->get(['id','amount'])->sum('amount');
                            $patient_subscribe =  \App\Models\WalletLog::whereModel('SubscriptionSuperBonus')->whereUserId($doctor_rank->id)->get(['id','amount'])->sum('amount');
                            $patient_invited =  \App\Models\WalletLog::whereModel('InviteSuperBonus')->whereUserId($doctor_rank->id)->get(['id','amount'])->sum('amount');
                            $total = $scans+$patient_subscribe+$patient_invited;
                        }
                    @endphp
                <tr>
                    
                <td class="col_1">{{$key}}</td>
                <td class="col_1">{{getDoctorRankPrefix($doctor_rank->id)}}</td>
                    <td class="col_2"><a class="btn-link-custom"href="{{route('panel.users.show',$doctor_rank->id)}}">{{NameById($doctor_rank->id)}}</a></td>
                    <td class="col_3">{{$scans ??'--'}} Points</td>
                    <td class="col_4">{{$patient_subscribe ??'--' }} Points</td>
                    <td class="col_5">{{$patient_invited ?? '--' }} Points</td>
                    <td class="col_5">{{$total ?? '--' }} Points</td>
                  
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="7"> No records found!</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    
</div>
