@extends('crudgenrator.layouts.master')

@section('title', 'Crudgen')

{{-- Push Styles --}}
@push('scopedCss')
    <style>
.select2-container--default .select2-selection--single {
    background-color: #282C2F;
    border: 1px solid #282C2F;
    border-radius: 4px;
    color: #fff;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff;
    background-color: #282C2F;
    line-height: 35px;
}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #aaa;
    background-color: #282C2F;
    color: #fff;
}
.select2-container .select2-selection--single{
    height:37px;
}
.select2-dropdown {
    background-color: #282C2F;
    color:#ddd;
    }
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
        background-color: #282C2F;
    color:#ddd;
    }
    </style>
@endpush

{{-- Main Page Content --}}
@section('content')

    <div class="container py-3">

        <form action="{{ route('crudgen.generate')  }}" method="POST" class="repeater" id="crudgen_form" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    {{-- Name --}}
                    <div class="card text-white bg-primary mb-3">
                      <div class="card-header">Crud Details</div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Model Name <span class="text-danger">*</span></label>
                                      <input type="text" class="form-control first-upper" name="model" id="model_name" placeholder="Model Name" required>
                                      <small class="text-muted">Enter model name for the crud e.g: <span class="text-accent">UserContact</span> (<span class="text-danger">Name needs to be in singular</span>)</small>
                                  </div>
                              </div>
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Crud Name <span class="text-danger">*</span></label>
                                      <input type="text" class="form-control lower" name="name" id="name" placeholder="Crud Name" required>
                                      <small class="text-muted">Enter name for the crud e.g: <span class="text-accent">user_contacts</span> (<span class="text-danger">Name needs to be in plural</span>)</small>
                                  </div>
                              </div>
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="view_path">View Path</label>
                                      <input type="text" class="form-control lower" name="view_path " id="view_path" placeholder="View Path">
                                      <small class="text-muted">It will generate views in <code class="text-accent">resources/views/<span id="view_path_preview"></span><span id="crud_name">crud_name</span> </code></small>
                                  </div>
                              </div>
                              <div class="col-12 col-md-4">
                                  {{-- Controller Namespace --}}
                                  <label for="controller_namespace">Controller Namespace</label>
                                  <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">App\Http\Controllers\</span>
                                      </div>
                                      <input type="text" class="form-control first-upper" name="controller_namespace" id="controller_namespace" placeholder="Admin">
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>


                    {{-- Fields --}}
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Fields (Required)</span>
                            <button class="btn btn-accent btn-sm btn-add" type="button" id="addFieldsBtn">+</button>
                        </div>
                        <div class="card-body fields">
                            <div class="row mb-2">
                                <div class="col">
                                    Name
                                </div>
                                <div class="col">
                                   Data Type
                                </div>
                                <div class="col">
                                    Input Type
                                </div>
                                <div class="col">
                                   Options
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center field">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input required type="text" class="form-control" name="fields[name][]" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[type][]" class="form-control select2">
                                            <option value="">--Select Field Type--</option>
                                            <option value="bigIncrements">bigIncrements</option>
                                            <option value="bigInteger">bigInteger</option>
                                            <option value="binary">binary</option>
                                            <option value="boolean">boolean</option>
                                            <option value="char">char</option>
                                            <option value="dateTimeTz">dateTimeTz</option>
                                            <option value="dateTime">dateTime</option>
                                            <option value="date">date</option>
                                            <option value="decimal">decimal</option>
                                            <option value="double">double</option>
                                            <option value="enum">enum</option>
                                            <option value="float">float</option>
                                            <option value="foreignId">foreignId</option>
                                            <option value="geometryCollection">geometryCollection</option>
                                            <option value="geometry">geometry</option>
                                            <option value="id">id</option>
                                            <option value="increments">increments</option>
                                            <option value="integer">integer</option>
                                            <option value="ipAddress">ipAddress</option>
                                            <option value="json">json</option>
                                            <option value="jsonb">jsonb</option>
                                            <option value="lineString">lineString</option>
                                            <option value="longText">longText</option>
                                            <option value="macAddress">macAddress</option>
                                            <option value="mediumIncrements">mediumIncrements</option>
                                            <option value="mediumInteger">mediumInteger</option>
                                            <option value="mediumText">mediumText</option>
                                            <option value="morphs">morphs</option>
                                            <option value="multiLineString">multiLineString</option>
                                            <option value="multiPoint">multiPoint</option>
                                            <option value="multiPolygon">multiPolygon</option>
                                            <option value="nullableMorphs">nullableMorphs</option>
                                            <option value="nullableTimestamps">nullableTimestamps</option>
                                            <option value="nullableUuidMorphs">nullableUuidMorphs</option>
                                            <option value="point">point</option>
                                            <option value="polygon">polygon</option>
                                            <option value="rememberToken">rememberToken</option>
                                            <option value="set">set</option>
                                            <option value="smallIncrements">smallIncrements</option>
                                            <option value="smallInteger">smallInteger</option>
                                            <option value="softDeletesTz">softDeletesTz</option>
                                            <option value="softDeletes">softDeletes</option>
                                            <option value="string">string</option>
                                            <option value="text">text</option>
                                            <option value="timeTz">timeTz</option>
                                            <option value="time">time</option>
                                            <option value="timestampTz">timestampTz</option>
                                            <option value="timestamp">timestamp</option>
                                            <option value="timestampsTz">timestampsTz</option>
                                            <option value="timestamps">timestamps</option>
                                            <option value="tinyIncrements">tinyIncrements</option>
                                            <option value="tinyInteger">tinyInteger</option>
                                            <option value="tinyText">tinyText</option>
                                            <option value="unsignedBigInteger">unsignedBigInteger</option>
                                            <option value="unsignedDecimal">unsignedDecimal</option>
                                            <option value="unsignedInteger">unsignedInteger</option>
                                            <option value="unsignedMediumInteger">unsignedMediumInteger</option>
                                            <option value="unsignedSmallInteger">unsignedSmallInteger</option>
                                            <option value="unsignedTinyInteger">unsignedTinyInteger</option>
                                            <option value="uuidMorphs">uuidMorphs</option>
                                            <option value="uuid">uuid</option>
                                            <option value="year">year</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[input][]" class="form-control select2 fields-type">
                                            <option value="">--Select Input Type--</option>
                                            <option value="text">{{ ucfirst('text') }}</option>
                                            <option value="date">{{ ucfirst('date') }}</option>
                                            <option value="number">{{ ucfirst('number') }}</option>
                                            <option value="email">{{ ucfirst('email') }}</option>
                                            <option value="password">{{ ucfirst('password') }}</option>
                                            <option value="url">{{ ucfirst('url') }}</option>
                                            <option value="file">{{ ucfirst('file') }}</option>
                                            <option value="radio">{{ ucfirst('radio') }}</option>
                                            <option value="checkbox">{{ ucfirst('checkbox') }}</option>
                                            <option value="textarea">{{ ucfirst('textarea') }}</option>
                                            <option value="select">{{ ucfirst('select') }}</option>
                                            <option value="select_via_table">{{ ucfirst('select Via Table') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group d-flex justify-content-around">
                                        <select name="fields[default][]" class="form-control Options">
                                            <option value="1">Required</option>
                                            <option value="2">Nullable</option>
                                            <option value="3">Default 0</option>
                                            <option value="4">Default 1</option>
                                        </select>
                                        <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>
                                        <select name="fields[table][]" class="form-control table d-none">
                                            <option value="User">User</option>
                                            @foreach($tmpFiles as $temp)
                                                <option value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Right Col --}}
                <div class="col-md-8">
                    {{-- Validations --}}
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span> Server Side Validations</span>
                            <button class="btn btn-accent btn-sm btn-add" id="addValidations" type="button">+</button>
                        </div>
                        <div class="card-body validations">
                            <div class="row mb-2">
                                <div class="col">
                                    Field
                                </div>
                                <div class="col">
                                    Rules
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center validation">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="validations[field][]" placeholder="Filed" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="validations[rules][]" placeholder="Rules"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Some Options</span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col text-center">
                                    <label for=""><input type="checkbox" name="softdelete" value="1" /> Soft Delete</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- <div class="col-md-12"> --}}
                    {{-- Relationships --}}
                    {{-- <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Relationships</span>
                            <button class="btn btn-accent btn-sm btn-add" id="addRelationships" type="button">+</button>
                        </div>
                        <div class="card-body relationships">
                            <div class="row mb-2">
                                <div class="col">
                                    Name
                                </div>
                                <div class="col">
                                    Type
                                </div>
                                <div class="col">
                                    Class (Model)
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center relationship">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="relationships[name][]" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="relationships[type][]" placeholder="Type"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">App\</span>
                                        </div>
                                        <input type="text" class="form-control" name="relationships[class][]" placeholder="Models\User">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> --}}
                {{-- </div> --}}
            </div>
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-accent text-grey-800">Generate</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



@endsection

{{-- Push Scripts --}}
@push('scopedJs')
    <script>
        var inputval = 0;
        $(document).ready(function () {
            $(document).on('click', '#addForeignKeys', function () {
                var tmp =   '<div class="row no-gutters align-items-center foreignKey">\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[column][]" placeholder="Column" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[references][]" placeholder="References"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[on][]" placeholder="On"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[onDelete][]" placeholder="onDelete" value="cascade" readonly/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div>';

                $('.foreignKeys').append(tmp);
            });

            $(document).on('click', '#addRelationships', function () {
                var tmp =   '<div class="row no-gutters align-items-center relationship">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="relationships[name][]" placeholder="Name" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="relationships[type][]" placeholder="Type"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +

                            '    <div class="col">\n' +
                            '       <div class="input-group mb-3">\n' +
                            '           <div class="input-group-prepend">\n' +
                            '               <span class="input-group-text">App\</span>\n' +
                            '           </div>\n' +
                            '           <input type="text" class="form-control" name="relationships[class][]" placeholder="Models\User">\n' +
                            '       </div>\n'+
                            '    </div>\n' +

                            '    <div class="col">\n' +
                            '        <div class="form-group">\n' +
                            '            <textarea name="fields[option][]" rows="1" style="resize: none; opacity: 0" class="form-control"></textarea>\n' +
                            '        </div>\n' +
                            '    </div>\n' +

                            '</div>';

                $('.relationships').append(tmp);
            });


            $(document).on('click', '#addValidations', function () {
                var tmp =   '<div class="row no-gutters align-items-center validation">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="validations[field][]" placeholder="Filed" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="validations[rules][]" placeholder="Rules"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div>';

                $('.validations').append(tmp);
            });
            $(document).on('click', '#addFieldsBtn', function () {
                // inputval = 0;
                var html ;
                    html =' <select name="fields[default][]" class="form-control Options" id="">\n'+
                    '    <option value="1">Required</option>\n'+
                    '    <option value="2">Nullable</option>\n'+
                    '    <option value="3">Default 0</option>\n'+
                    '    <option value="4">Default 1</option>\n'+
                    ' </select>\n';
                    html +=      '  <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>\n';
              
                    html += '   <select name="fields[table][]" class="form-control  table d-none" id="">\n'+
                        ' <option value="User">User</option>'+
                        @foreach($tmpFiles as $temp)
                            ' <option value="'+"{{ $temp['filename'] }}"+'">'+"{{ $temp['filename'] }}"+'</option>\n'+
                        @endforeach
                    ' </select>\n' ;
                
                var tmp =   '<div class="row no-gutters align-items-center field">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="fields[name][]" placeholder="Name" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <select name="fields[type][]" class="form-control select2">\n' +
                            '                <option value="">--Select Field Type--</option>\n' +
                                            '<option value="bigIncrements">bigIncrements</option>\n' +
                                            '<option value="bigInteger">bigInteger</option>\n' +
                                            '<option value="binary">binary</option>\n' +
                                            '<option value="boolean">boolean</option>\n' +
                                            '<option value="char">char</option>\n' +
                                            '<option value="dateTimeTz">dateTimeTz</option>\n' +
                                            '<option value="dateTime">dateTime</option>\n' +
                                            '<option value="date">date</option>\n' +
                                            '<option value="decimal">decimal</option>\n' +
                                            '<option value="double">double</option>\n' +
                                            '<option value="enum">enum</option>\n' +
                                            '<option value="float">float</option>\n' +
                                            '<option value="foreignId">foreignId</option>\n' +
                                            '<option value="geometryCollection">geometryCollection</option>\n' +
                                            '<option value="geometry">geometry</option>\n' +
                                            '<option value="id">id</option>\n' +
                                            '<option value="increments">increments</option>\n' +
                                            '<option value="integer">integer</option>\n' +
                                            '<option value="ipAddress">ipAddress</option>\n' +
                                            '<option value="json">json</option>\n' +
                                            '<option value="jsonb">jsonb</option>\n' +
                                            '<option value="lineString">lineString</option>\n' +
                                            '<option value="longText">longText</option>\n' +
                                            '<option value="macAddress">macAddress</option>\n' +
                                            '<option value="mediumIncrements">mediumIncrements</option>\n' +
                                            '<option value="mediumInteger">mediumInteger</option>\n' +
                                            '<option value="mediumText">mediumText</option>\n' +
                                            '<option value="morphs">morphs</option>\n' +
                                            '<option value="multiLineString">multiLineString</option>\n' +
                                            '<option value="multiPoint">multiPoint</option>\n' +
                                            '<option value="multiPolygon">multiPolygon</option>\n' +
                                            '<option value="nullableMorphs">nullableMorphs</option>\n' +
                                            '<option value="nullableTimestamps">nullableTimestamps</option>\n' +
                                            '<option value="nullableUuidMorphs">nullableUuidMorphs</option>\n' +
                                            '<option value="point">point</option>\n' +
                                            '<option value="polygon">polygon</option>\n' +
                                            '<option value="rememberToken">rememberToken</option>\n' +
                                            '<option value="set">set</option>\n' +
                                            '<option value="smallIncrements">smallIncrements</option>\n' +
                                            '<option value="smallInteger">smallInteger</option>\n' +
                                            '<option value="softDeletesTz">softDeletesTz</option>\n' +
                                            '<option value="softDeletes">softDeletes</option>\n' +
                                            '<option value="string">string</option>\n' +
                                            '<option value="text">text</option>\n' +
                                            '<option value="timeTz">timeTz</option>\n' +
                                            '<option value="time">time</option>\n' +
                                            '<option value="timestampTz">timestampTz</option>\n' +
                                            '<option value="timestamp">timestamp</option>\n' +
                                            '<option value="timestampsTz">timestampsTz</option>\n' +
                                            '<option value="timestamps">timestamps</option>\n' +
                                            '<option value="tinyIncrements">tinyIncrements</option>\n' +
                                            '<option value="tinyInteger">tinyInteger</option>\n' +
                                            '<option value="tinyText">tinyText</option>\n' +
                                            '<option value="unsignedBigInteger">unsignedBigInteger</option>\n' +
                                            '<option value="unsignedDecimal">unsignedDecimal</option>\n' +
                                            '<option value="unsignedInteger">unsignedInteger</option>\n' +
                                            '<option value="unsignedMediumInteger">unsignedMediumInteger</option>\n' +
                                            '<option value="unsignedSmallInteger">unsignedSmallInteger</option>\n' +
                                            '<option value="unsignedTinyInteger">unsignedTinyInteger</option>\n' +
                                            '<option value="uuidMorphs">uuidMorphs</option>\n' +
                                            '<option value="uuid">uuid</option>\n' +
                                            '<option value="year">year</option>\n' +

                            '            </select>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' + 
                            '        <div class="form-group mr-1">\n' +
                            '               <select name="fields[input][]" class="form-control select2 fields-type">\n' +
                                            '<option value="">--Select Input Type--</option>>\n' +
                                            '<option value="text">{{ ucfirst("text") }}</option>>\n' +
                                            '<option value="date">{{ ucfirst("date") }}</option>>\n' +
                                            '<option value="number">{{ ucfirst("number") }}</option>>\n' +
                                            '<option value="email">{{ ucfirst("email") }}</option>>\n' +
                                            '<option value="password">{{ ucfirst("password") }}</option>>\n' +
                                            '<option value="url">{{ ucfirst("url") }}</option>>\n' +
                                            '<option value="file">{{ ucfirst("file") }}</option>>\n' +
                                            '<option value="radio">{{ ucfirst("radio") }}</option>>\n' +
                                            '<option value="checkbox">{{ ucfirst("checkbox") }}</option>>\n' +
                                            '<option value="textarea">{{ ucfirst("textarea") }}</option>>\n' +
                                            '<option value="select">{{ ucfirst("select") }}</option>>\n' +
                                            '<option value="select_via_table">{{ ucfirst("select via table") }}</option>>\n' +
                                       ' </select>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                                '<div class="col">\n' +
                                    '<div class="form-group d-flex justify-content-around">\n '+
                                        html
                                    +' </div>\n'+
                               ' </div>\n'+
                            '</div>';
                $('.fields').append(tmp);
                selectRefresh();
            });

            function selectRefresh() {
                $('.select2').select2({
                    //-^^^^^^^^--- update here
                    tags: true,
                    placeholder: "Select an Option",
                    allowClear: true,
                    width: '100%'
                });
            }
            $('.deleteForeignKey').each(function () {
                var _this = $(this);
                $(this).on('click', function () {
                    alert('dsad')
                    _this.parent().parent().parent().fadeOut();
                })
            })

            $(document).on('input', '#view_path', function () {
                if ($(this).val().length <= 0 ){
                    $('#view_path_preview').html('');
                } else{
                    $('#view_path_preview').html($(this).val() + '/');
                }
            })
            $(document).on('input', '#name', function () {
                if ($(this).val().length <= 0 ){
                    $('#crud_name').html('crud_name');
                } else{
                    $('#crud_name').html($(this).val().toLowerCase());
                }
            })
            $(document).on('change', '.fields-type', function () {
                var target = $(this).parent().parent().siblings().children().find('textarea');
                var target1 = $(this).parent().parent().siblings().children().find('.table');
                var target2 = $(this).parent().parent().siblings().children().find('.Options');
                // alert($(this).val());
                console.log(target);
                console.log(target1);
                console.log(target2);
                if ($(this).val() === 'select'){
                    inputval = 1;
                    target2.addClass('d-none');
                    target1.removeClass('select2').addClass('d-none').siblings('.select2').remove();
                    target.removeClass('d-none').removeClass('disabled').css('opacity', '1');
                } else if($(this).val() === 'select_via_table') {
                    inputval = 2;
                    target2.addClass('d-none');
                    target.addClass('d-none').addClass('disabled').css('opacity', '0');
                    target1.addClass('select2').removeClass('d-none');
                } else {
                    target1.removeClass('select2').addClass('d-none').siblings('.select2').remove();
                    target2.removeClass('d-none');
                    target.addClass('d-none').addClass('disabled').css('opacity', '0');
                }
                selectRefresh();
            })

            $(document).ready(function() {
                $('.select2').each(function () {
                    $(this).select2()
                });
            });

            $(document).on('input', '.first-upper', function (e) {
                firstUpper(e);
            })
            $(document).on('input', '.lower', function (e) {
                allLower(e);
            })

            // $('.first-upper').each(function () {
            //     var $this = $(this);
            //     $this.on('input', function (e) {
            //         firstUpper(e);
            //     })
            // })

            // function firstUpper(event) {
            //     var words = event.target.value.toLowerCase().split(/\s+/g);
            //     var newWords = words.map(function(element){
            //         return element !== "" ?  element[0].toUpperCase() + element.substr(1, element.length) : "";
            //     });
            //     event.target.value = newWords.join("");
            // }
            function firstUpper(event) {
                var words = event.target.value.split(/\s+/g);
                var newWords = words.map(function(element){
                    return element !== "" ?  element[0].toUpperCase() + element.substr(1, element.length) : "";
                });
                event.target.value = newWords.join("");
            }

            function allLower(event) {
                var words = event.target.value.toLowerCase().split(/\s+/g);
     
                event.target.value = words.join("");
            }
            
            function slugFunction() {
				var x = document.getElementById("slugInput").value;
				document.getElementById("slugOutput").innerHTML = "{{ url('/page/') }}/" + convertToSlug(x);
			}
            function convertToSlug(Text)
            {
                return Text
                    .toLowerCase()
                    .replace(/ /g,'-')
                    .replace(/[^\w-]+/g,'')
                    ;
            }

        });
    </script>
@endpush
