@extends('backend.layouts.main') 
@section('title', 'Access Docttor')
@section('content')
@php
/**
 * Patient File 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
    $breadcrumb_arr = [
        ['name'=>'Access Docttor', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush
<style>
    .dataTables_filter{
        margin-left: -80px;
    }
    .dt-buttons{
        margin-right: 120px;
    }
</style>
    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>Access Docttors</h5>
                            <span>{{ __('list of your and Access Docttors')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('User')}}</a>
                            </li>
                           

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <input type="hidden" class="userId" name="user_id" value="{{$id}}">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Access Doctors</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">   
                            <div class="col-md-12">
                                <table id="simple_table" class="table" >
                                    <thead class="text-center">
                                        <tr>
                                            <th class="col_1">{{ __('Access')}}</th>
                                            <th class="col_2">{{ __('ID')}}</th>
                                            <th class="col_6">{{ __('Doctor Name')}}</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody class="no-data text-center">
                                        @foreach ($doctors as $doctor)
                                            @php
                                                $doctorChk = App\Models\AccessDoctor::where('doctor_id', $doctor->id)->where('user_id',$id)->first();
                                                $name = $doctor->first_name.' '.$doctor->last_name;
                                            @endphp
                                                
                                                <tr>
                                                    <td class="col_1 w-20">
                                                        <input type="checkbox" name="assessment_ids" value="{{ $doctor->id}}" @if($doctorChk && $doctorChk->doctor_id == $doctor->id) checked @endif
                                                        class="mr-1 mt-2 assignDoctor">
                                                    </td>
                                                    <td class="col_2">{{ getAccessDoctorPrefix($doctor->id) }}</td>
                                                    <td class="col_3">{{ $name ? ucfirst($name) : 'N/A'}}</td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>  
                        </div>
                        <div class="load-more text-right">
                            {{-- <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a> --}}
                            {{ $doctors->appends(request()->input())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script') 
    
    <script>
            $('.assignDoctor').on('click',function(){
                    var chk = '';
                    if($(this).is(':checked') == true){
                        chk = 'checked';
                    }
                    var val = $(this).val();
                    var user_id = $('.userId').val();
                    $.ajax({
                        type:"POST",
                        url: "{{route('panel.access.doctor.store')}}",
                        data: {
                            doctor_id: val,
                            user_id: user_id,
                            chk: chk,
                        },
                        success: function(data) {
                        }
                    });
                })

           $(document).ready(function() {
            var table = $('#simple_table').DataTable({
                responsive: true,
                fixedColumns: true,
                fixedHeader: true,
                scrollX: false,
                 bPaginate :false,
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
