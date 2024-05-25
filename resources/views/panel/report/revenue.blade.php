@extends('backend.layouts.main') 
@section('title', 'revenue')
@section('content')
@php
/**
 * Follow Up 
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
        ['name'=>'Dr.Revenue ', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Revenue</h5>
                            <span>List of Dr.Revenue</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <form action="{{ route('panel.report.revenue.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                
                <div class="col-md-12">
                    <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h3>Dr.Revenue</h3>
                                    
                                    <div class="d-flex justicy-content-right">
                                        <div class="form-group mb-0 mr-2">
                                                    <span>From</span>
                                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                        </div>
                                        <div class="form-group mb-0 mr-2"> 
                                                    <span>To</span>
                                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                        </div>
                                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.report.revenue.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                    
                                    </div>
                                    
                                </div>
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>
                                     
                                    
                                    <th class="no-export ">Doctor ID</th>
                                    <th class="col_2">Name</th>
                                    <th class="col_3">Amount</th>
                              
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revenues as  $revenue)
                                    <tr>
                                        <td class="col_1">{{getDoctorPrefix($revenue->id)}}</td>
                                        <td class="col_2">{{$revenue->first_name}}</td>
                                        <td class="col_2">{{getRevenue(100)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </form>
    </div>
    
      
</div>
     <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
           
        function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'FollowUpFile.' + type);
            $("#table").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        // $('#reset').click(function(){
        //     var url = $(this).data('url');
        //     getData(url);
        //     window.history.pushState("", "", url);
        //     $('#TableForm').trigger("reset");
        // });
        $('#reset').click(function(){
                getData("{{ route('panel.report.revenue.index') }}");
                window.history.pushState("", "", "{{ route('panel.report.revenue.index') }}");
                $('#TableForm').trigger("reset");  
            });

       
        </script>
    @endpush        
        @endsection