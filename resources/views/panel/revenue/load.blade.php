<div class="card-body">
	<div class="d-flex justify-content-between mb-2">
		<div>
			<label for="">Show
				<select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
					<option value="10"{{ $revenues->perPage() == 10 ? 'selected' : ''}}>10</option>
					<option value="25"{{ $revenues->perPage() == 25 ? 'selected' : ''}}>25</option>
					<option value="50"{{ $revenues->perPage() == 50 ? 'selected' : ''}}>50</option>
					<option value="100"{{ $revenues->perPage() == 100 ? 'selected' : ''}}>100</option>
				</select>
				entries
			</label>
		</div>
		<div>
			<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
			        aria-expanded="false">Column Visibility
			</button>
			<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
				<li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);" class="btn btn-sm">Doctor ID </a></li>
				<li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);" class="btn btn-sm"> Doctor Name</a></li>
				<li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);" class="btn btn-sm"> Unqiue Scan </a></li>
				<li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);" class="btn btn-sm">Patient Subscribe </a></li>
				<li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);" class="btn btn-sm">Super Bonus </a></li>
			</ul>
		</div>
		<input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
	</div>
	<div class="table-responsive">
		<table id="table" class="table">
			<thead>
			<tr>
				<th class="no-export col_1 ">Doctor ID</th>
				<th class="col_2"> Doctor Name</th>
				<th class="col_3">Unqiue Scans</th>
				<th class="col_4">Patient Subscribe</th>
				<th class="col_5">Super Bonus</th>
			</tr>
			</thead>
			<tbody>
			@if($revenues->count() > 0)
				@foreach($revenues as  $revenue)
					@php
						if(request()->get('from') && request()->get('to')) {
							$scans = \App\Models\WalletLog::whereModel('ScanReward')->whereUserId($revenue->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->whereType('credit')->sum(['id','amount']);
							$patient_subscribe =  \App\Models\WalletLog::whereModel('SubscriptionReward')->whereUserId($revenue->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->sum(['id','amount']);
							$bonus =  \App\Models\WalletLog::whereIn('model', [\App\Models\WalletLog::SCAN_SUPER_BONUS, \App\Models\WalletLog::INVITE_SUPER_BONUS, \App\Models\WalletLog::SUBSCRIPTION_SUPER_BONUS, \App\Models\WalletLog::UPLOAD_BONUS])->whereUserId($revenue->id)->whereBetween('created_at', [\Carbon\Carbon::parse(request()->from)->format('Y-m-d').' 00:00:00',\Carbon\Carbon::parse(request()->to)->format('Y-m-d')." 23:59:59"])->sum(['id','amount']);
						} else {
							$scans = \App\Models\WalletLog::whereModel('ScanReward')->whereUserId($revenue->id)->whereType('credit')->get(['id','amount']);
							$patient_subscribe =  \App\Models\WalletLog::whereModel('SubscriptionReward')->whereUserId($revenue->id)->get(['id','amount']);
							$bonus =  \App\Models\WalletLog::whereIn('model', [\App\Models\WalletLog::SCAN_SUPER_BONUS, \App\Models\WalletLog::INVITE_SUPER_BONUS, \App\Models\WalletLog::SUBSCRIPTION_SUPER_BONUS, \App\Models\WalletLog::UPLOAD_BONUS])->whereUserId($revenue->id)->get(['id','amount']);
						}
					@endphp
					<tr>
						<td class="col_1">{{getRevenuePrefix($revenue->id)}}</td>
						<td class="col_2"><a class="btn-link-custom" href="{{route('panel.users.show',$revenue->id)}}">{{NameById($revenue->id)}}</a></td>
						<td class="col_3">{{format_price($scans->sum('amount'))}} ({{$scans->count()}})</td>
						<td class="col_4">{{format_price($patient_subscribe->sum('amount'))}} ({{$patient_subscribe->count()}})</td>
						<td class="col_5">Points. {{$bonus->sum('amount')}}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td class="text-center" colspan="3"> No records found!</td>
				</tr>
			@endif
			</tbody>
		</table>
	</div>
</div>
<div class="card-footer d-flex justify-content-between">
	<div class="pagination">
		{{ $revenues->appends(request()->except('page'))->links() }}
	</div>
	<div>
		@if($revenues->lastPage() > 1)
			<label for="">Jump To:
				<select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
					@for ($i = 1; $i <= $revenues->lastPage(); $i++)
						<option value="{{ $i }}" {{ $revenues->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
					@endfor
				</select>
			</label>
		@endif
	</div>
</div>
