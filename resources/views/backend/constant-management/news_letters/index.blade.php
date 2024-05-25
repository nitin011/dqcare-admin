@extends('backend.layouts.main') 
@section('title', 'Newsletters')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Newsletters', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>Newsletters</h5>
                            <span>List of Newsletters</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Newsletters</h3>
                        <div class="d-flex">
                            <form class="d-flex" action="{{route('backend/constant-management.news_letters.index')}}" method="get" > 
                                {{-- <div class="form-group d-flex mb-0 mr-2">
                                    <span class="mt-2 mr-2">From</span>
                                    <label for=""><input type="date" name="from" class="form-control mx-1" value="2022-08-01"></label>
                                </div>
                                <div class="form-group d-flex mb-0 mr-2"> 
                                    <span class="mt-2 mr-2">To</span>
                                        <label for=""><input type="date" name="to" class="form-control mx-1" value="2022-08-31"></label> 
                                </div> --}}
                                <select required name="type" id="type" class="form-control select2"> 
                                    <option value=""> Select Type</option> 
                                    <option value="1" {{request()->get('type') == 1 ? 'selected' : ''}}>{{ 'Email' }}</option> 
                                    <option value="2" {{request()->get('type') == 2 ? 'selected' : ''}}>{{ 'Number' }}</option> 
                                </select>
                                <div class=" dropdown d-flex">
                                    <button type="submit" class="btn btn-icon btn-sm mx-2 btn-outline-warning mr-2" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                     <a href="{{ route('backend/constant-management.news_letters.create') }}" class="btn btn-icon btn-sm btn-outline-primary mr-1" title="Add New NewsLetter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <a href="{{ route('backend/constant-management.news_letters.launchcampaign.show') }}" class="btn btn-icon btn-sm btn-outline-success mr-1" title="Launch Campaign"><i class="ik ik-send" aria-hidden="true"></i></a>
                                </div>
                            </form>
                            <form action="{{route('backend/constant-management.news_letters.bulk-delete')}}" method="POST">
                                @csrf
                                    <input type="hidden" name="ids" id="bulk_ids">
                                    <div class="dropdown d-flex">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                                class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <button type="submit" id="" class="dropdown-item confirm-action" name="action" value="delete" data-message="You want to delete these items?" data-action="delete">Bulk Delete</button>
                                        </ul>
                                    </div>
                            </form>
                        </div>
                       
                               
                       
                           
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" class="mr-2 allChecked " name="id" value="">Actions</th> 
                                        <th class="text-center">#</th>
                                        {{-- <th>Group</th>  --}}
                                        <th>Name</th>                                           
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Created At</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news_letters as  $news_letter)
                                        <tr>
                                            
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <div class="dropdown  ">
                                                        <input type="checkbox" class="mr-2 delete_Checkbox text-center" name="id" value="{{$news_letter->id}}">
                                                        
                                                     <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.news_letters.edit', $news_letter->id) }}" title="Edit NewsLetter" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.news_letters.destroy', $news_letter->id) }}" title="Delete NewsLetter" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div> 
                                            </td>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>{{$news_letter->name }}</td>
                                            <td>
                                                @if ($news_letter->type == 1)
                                                    {{ 'Email' }}
                                                @else
                                                    {{ 'Number' }}
                                                @endif
                                            </td>
                                            <td>{{$news_letter->value }}</td>
                                            <td>{{getFormattedDate( $news_letter->created_at) }}</td>
                                         
                                             
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    @include('backend.include.bulk-script')
        <script>
            $(document).ready(function() {

                var table = $('#table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
        </script>
    @endpush
@endsection
