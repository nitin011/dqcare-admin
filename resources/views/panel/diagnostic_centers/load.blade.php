<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10"
                        {{ $diagnostic_centers->perPage() == 10 ? 'selected' : '' }}>
                        10</option>
                    <option value="25"
                        {{ $diagnostic_centers->perPage() == 25 ? 'selected' : '' }}>
                        25</option>
                    <option value="50"
                        {{ $diagnostic_centers->perPage() == 50 ? 'selected' : '' }}>
                        50</option>
                    <option value="100"
                        {{ $diagnostic_centers->perPage() == 100 ? 'selected' : '' }}>
                        100</option>
                </select>
                entries
            </label>
        </div>
     <div>

            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>

            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"
                        class="btn btn-sm">Name</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Location </a></li>
               
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"
                        class="btn btn-sm">Addressline 1</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"
                        class="btn btn-sm">Addressline 2</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"
                        class="btn btn-sm">Destrict</a></li>
            </ul>

            <a href="javascript:void(0);" id="print"
                data-url="{{ route('panel.diagnostic_centers.print') }}"
                data-rows="{{ json_encode($diagnostic_centers) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export"># <div class="table-div"></div>
                    </th>

                    <th class="col_1">Name </th>
                    <th class="col_2 text-center">Location </th>
                    <th class="col_8">
                        Created At <div class="table-div"></div>
                    </th>
                    <th class="col_8">
                     Updated At<div class="table-div"></div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if($diagnostic_centers->count() > 0)
                    @foreach($diagnostic_centers as  $diagnostic_center)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.diagnostic_centers.edit', $diagnostic_center->id) }}"
                                            title="Edit Diagnostic Center" class="dropdown-item ">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        <a href="{{ route('panel.diagnostic_centers.destroy', $diagnostic_center->id) }}"
                                            title="Delete Diagnostic Center" class="dropdown-item  delete-item">
                                            <li class=" p-0">Delete</li>
                                        </a>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">{{getDiagnosticCentersPrefix($diagnostic_center->id) }}</td>
                            <td class="col_1"> {{$diagnostic_center->name }}</td>
                            <td class="col_2">{{ fetchFirst('App\Models\State',$diagnostic_center->state_id,'name','--') }} {{fetchFirst('App\Models\City',$diagnostic_center->city_id,'name','--') }} {{ $diagnostic_center->pincode }} {{ $diagnostic_center->district }}</td>
                            {{-- <td class="col_2">{{fetchFirst('App\Models\Country',$diagnostic_center->country_id,'name','--') }}
                            </td>
                            <td class="col_3">
                                {{ fetchFirst('App\Models\State',$diagnostic_center->state_id,'name','--') }}
                            </td>
                            <td class="col_4">
                                {{ fetchFirst('App\Models\City',$diagnostic_center->city_id,'name','--') }}
                            </td> --}}
                            {{-- <td class="col_5">{{ $diagnostic_center->pincode }}</td> --}}
                            {{-- <td class="col_6">{{ $diagnostic_center->addressline_1 }}</td>
                            <td class="col_7">{{ $diagnostic_center->addressline_2 }}</td> --}}
                            {{-- <td class="col_8">{{ $diagnostic_center->district }}</td> --}}
                            <td class="col_8">{{ getFormattedDateTime($diagnostic_center->created_at) }}</td>
                            <td class="col_8">{{getFormattedDateTime ($diagnostic_center->updated_at) }}</td>

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
        {{ $diagnostic_centers->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if($diagnostic_centers->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $diagnostic_centers->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $diagnostic_centers->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
