<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10"{{ $diagnosis->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $diagnosis->perPage() == 25 ? 'selected' : ''}}>25</option>
                    <option value="50"{{ $diagnosis->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $diagnosis->perPage() == 100 ? 'selected' : ''}}>100</option>
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
                    
                </tr>
            </thead>
            <tbody>
                @if($diagnosis->count() > 0)
                @php($k = 1)
                @foreach($diagnosis as  $diag)
                <tr>
                    <td class="no-export">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                <a href="{{ route('panel.diagnosis.edit', $diag->id) }}" title="Edit Diagnosis" class="dropdown-item "><li class="p-0">Edit</li></a>
                                <a href="{{ route('panel.diagnosis.destroy', $diag->id) }}" title="Delete Diagnosis" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                            </ul>
                        </div> 
                    </td>
                    <td  class="text-center no-export"> {{$k }}</td>
                    <td class="col_1">{{$diag->name}}</a></td>
                    

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
        {{ $diagnosis->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if($diagnosis->lastPage() > 1)
        <label for="">Jump To: 
            <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                @for ($i = 1; $i <= $diagnosis->lastPage(); $i++)
                <option value="{{ $i }}" {{ $diagnosis->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </label>
        @endif
    </div>
</div>
