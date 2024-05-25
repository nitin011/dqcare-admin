@extends('backend.layouts.main') 
@section('title', 'Tests')
@section('content')
@php
/**
* Scanlog 
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
        ['name'=>'Tests', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                                <h5>Tests</h5>
                                <span>List of Tests</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @include("backend.include.breadcrumb")
                    </div>
                </div>
            </div>

            <form action="{{ route('panel.tests.index') }}" method="GET" id="TableForm">
                <div class="row">
                    <!-- start message area-->
                    <!-- end message area-->

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h3 class="mb-3">Tests</h3>

                                <div class="d-flex justicy-content-right">
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.tests.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                    <a href="{{ route('panel.tests.create') }}" class="btn btn-icon btn-sm btn-outline-primary mr-2" title="Add New Tests"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <a href="{{ route('panel.tests.import') }}" class="btn btn-sm btn-outline-secondary mr-2" title="Import Sheet"><i class="fa fa-file-import" aria-hidden="true"></i> Import</a>
                                    <a href="{{URL::to('')}}/storage/files/samples/tests.csv" class="btn btn-sm btn-outline-success" title="Download Sample"><i class="fa fa-file-download" aria-hidden="true"></i> Download Sample</a>
                                </div>
                            </div>
                            <div id="ajax-container">
                                @include('panel.tests.load')
                            </div>
                        </div>
                    </div>
                </div>
                <form>
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
                XLSX.write(file, {bookType: type, bookSST: true, type: 'base64'});
                XLSX.writeFile(file, 'TestsFile.' + type);
                $("#table").html(table_core.html());

            }

            $(document).on('click', '#export_button', function () {
                html_table_to_excel('xlsx');
            })


            $('#reset').click(function () {
                window.location.href = "{{route('panel.tests.index')}}";
            });


                    </script>
                    @endpush
                    @endsection
