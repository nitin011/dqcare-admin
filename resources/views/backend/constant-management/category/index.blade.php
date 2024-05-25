@extends('backend.layouts.main') 
@section('title', 'Category')
@section('content')
    @php

     if($level == 1){ $page_title = 'Categories';  $arr = null;}
     elseif($level == 2){ $page_title = 'Sub Categories'; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name','--'), 'url'=> route('panel.constant_management.category.index',$type_id), 'class' => ''];}
     elseif($level == 3){$page_title = 'Sub Sub Categories'; $pre = request('parent_id')-1; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name','--'), 'url'=> url('panel/constant-management/category/view/'.$type_id.'?level='.'2'.'&parent_id='.$pre), 'class' => ''];}
    $breadcrumb_arr = [
        ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=> ucwords(str_replace('_',' ',fetchFirst('App\Models\CategoryType',$type_id,'name','--'))) , 'url'=> route("panel.constant_management.category_type.index"), 'class' => 'active'],
        $arr,
            // ,
        ['name'=> $page_title, 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>
                               {{$page_title}} 
                            </h5>
                            <span>{{ __('List of')}} {{$page_title}} </span>
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
                        <h3>@if($level == 1) Category @elseif($level == 2) Sub Category @elseif($level == 3) Sub Sub Category  @endif </h3>
                        <a href="{{ route('panel.constant_management.category.create',[$type_id,$level,request('parent_id')]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Smstemplate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table id="category_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Category Type</th>
                                        <th>Parent Category</th>
                                        @if(fetchFirst('App\Models\CategoryType',$type_id,'allowed_level','1') > $level)
                                        <th>Child Category Count</th> 
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category as $item)
                                  
                                        <tr>
                                            <td class="text-center">MC{{ $item->id }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        {{-- <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.show', $item->id)  }}" title="View Lead Contact" class="btn btn-sm">Show</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.edit', $item->id)  }}" title="Edit Lead Contact" class="btn btn-sm">Edit</a></li>
                                                        @if($item->category_type_id !== 16)
                                                         <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Edit Lead Contact" class="btn btn-sm delete-item">Delete</a></li>
                                                        @endif 
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->level }}</td>
                                            <td><a href="javascript:void(0);">{{ ucwords(str_replace('_',' ',fetchFirst('App\Models\CategoryType',$item->category_type_id,'name','--'))) }}</a></td>
                                            <td>{{ fetchFirst('App\Models\Category',$item->parent_id,'name','--') }}</td>
                                            
                                            @if(fetchFirst('App\Models\CategoryType',$type_id,'allowed_level','1') > $level)
                                                <td>
                                                    @if($nextlevel <= 3)
                                                    <a class="btn btn-link"href="{{url('panel/constant-management/category/view/'.$item->category_type_id.'?level='.$nextlevel.'&parent_id='.$item->id)}}">
                                                        {{ fetchGetData('App\Models\Category',['category_type_id','level','parent_id'],[$item->category_type_id,$nextlevel,$item->id])->count() }}
                                                    </a>
                                                    @else 
                                                    ---
                                                    @endif
                                                </td>
                                            @endif
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
    
        <script>
            $(document).ready(function() {

                var table = $('#category_table').DataTable({
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
