<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10"{{ $medicines->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $medicines->perPage() == 25 ? 'selected' : ''}}>25</option>
                    <option value="50"{{ $medicines->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $medicines->perPage() == 100 ? 'selected' : ''}}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>

            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th> 
                    <th  class="text-center no-export"># <div class="table-div"></div></th>             

                    <th class="col_1"> Name <div class="table-div"></div></th>
                    <th class="col_2"> Company Name <div class="table-div"></div></th>
                    <th class="col_3"> Content Name <div class="table-div"></div></th>
                    <th class="col_4">  Types <div class="table-div"></div></th>
                    <th class="col_5">  ABC <div class="table-div"></div></th>
                </tr>
            </thead>
            <tbody>
                @if($medicines->count() > 0)
                @php($k = 1)
                @foreach($medicines as  $medicine)
                <tr>
                    <td class="no-export">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                <a href="{{ route('panel.medicines.edit', $medicine->id) }}" title="Edit Medicines" class="dropdown-item "><li class="p-0">Edit</li></a>
                                <a href="{{ route('panel.medicines.destroy', $medicine->id) }}" title="Delete Medicines" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                            </ul>
                        </div> 
                    </td>
                    <td  class="text-center no-export"> {{$k }}</td>
                    <td class="col_1"><a class="btn-link-custom" href="{{route('panel.medicines.show',$medicine->id)}}">{{$medicine->name}}</a></td>
                    <td class="col_2">{{$medicine->company_name}}</td>
                    <td class="col_3">{{$medicine->content_name }}</td>
                    <td class="col_4">{{$medicine->types }}</td>
                    <td class="col_5">{{$medicine->abc }}</td>

                </tr>
                @php($k++)
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
        {{ $medicines->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if($medicines->lastPage() > 1)
        <label for="">Jump To: 
            <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                @for ($i = 1; $i <= $medicines->lastPage(); $i++)
                <option value="{{ $i }}" {{ $medicines->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </label>
        @endif
    </div>
</div>
