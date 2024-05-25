<style>
    .ctext-wrap {
        position: absolute;
        right: 10px;
        top: 110px;
    }

    @media screen and (max-width: 768px) {
        .ctext-wrap .btn {
            display: block;
            width: auto;
            float: none;
        }
    }

    .chart-range {
        font-size: .65rem !important;
    }

    [data-repeater-item]:first-child [data-repeater-delete] {
        display: none;
    }
</style>

<div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "chart") show active @endif" id="chart" role="tabpanel"
     aria-labelledby="pills-chart-tab">
	{{-- <form action="{{ route('panel.stories.update',$story->id) }}" method="POST"id="chart_form">                   --}}
	<div class="card-body">

		<div class="alert alert-info">
			Please fill in all the information precisely and accurately according to the given range. Avoid entering <strong>out of range or invalid data in
				patient apps to avoid app breakdowns.</strong> Only numbers <i>(0-9 || decimal)</i> are supported in the following inputs.
		</div>

		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Blood Picture</h6>
			</div>
			<div class="Blood_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted"> Haemoglobin</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Haemoglobin')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted"> WBC</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('WBC')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted"> RBC</strong>
								<div class="text-muted mt-1 fw-600 chart-range"> {{chartKeyRange('RBC')}}</div>
							</th>
							<th scope="col"><strong class="text-muted">Platlets</strong>
								<div class="text-muted mt-1 fw-600 chart-range">  {{chartKeyRange('Platlets')}}</div>
							</th>
							<th scope="col"><strong class="text-muted">Retic count</strong>
								<div class="text-muted mt-1 fw-600 chart-range"> {{chartKeyRange('Retic count')}}</div>
							</th>
							<th scope="col"><strong class="text-muted"> Htc </strong>
								<div class="text-muted mt-1 fw-600 chart-range"> {{chartKeyRange('Htc')}}</div>

							</th>
							<th scope="col"><strong class="text-muted"> MCV </strong>
								<div class="text-muted mt-1 fw-600 chart-range"> {{chartKeyRange('MCV')}}</div>
							</th>
						  <th scope="col">Action</th>
						</tr>
						</thead>
						<tbody data-repeater-list="blood">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text"
									       placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="haemoglobin" class="form-control chart_data check_number" id="" type="text"
									       placeholder="Haemoglobin">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="wbc" class="form-control chart_data check_number" id="" type="text" placeholder="WBC">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="rbc" class="form-control chart_data check_number" id="" type="text" placeholder="RBC ">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="platlets" class="form-control chart_data check_number" id="" type="text" placeholder="Platlets ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="retic" class="form-control chart_data check_number" id="" type="text" placeholder="Retic count ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="hematocrit" class="form-control chart_data check_number" id="" type="text"
									       placeholder=" Hematocrit ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="mcv" class="form-control chart_data check_number" id="" type="text" placeholder=" MCV ">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button"><i
							class="ik ik-plus"></i>
				</button>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Liver</h6>
			</div>
			<div class="liver_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>

							<th scope="col"><strong class="text-muted"> Tot Bili</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Tot Bili')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted"> Direct Bili</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Direct Bili')}}
								</div>
							</th>

							<th scope="col"><strong class="text-muted">Indirect Bili</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Indirect Bili')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Protein</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Protein')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Albumin</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Albumin')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">SGOT(AST)</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('AST')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">SGPT(ALT)</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('ALT')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">ALP</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('ALP')}}
								</div>
							</th>

							<th scope="col">Action</th>
						</tr>
						</thead>
						<tbody data-repeater-list="liver">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="tot Bili" class="form-control chart_data check_number" id="" type="text" placeholder="Tot Bili">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="direct bili" class="form-control chart_data check_number" id="" type="text" placeholder="Direct Bili ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="indirect bili" class="form-control chart_data check_number" id="" type="text" placeholder="Indirect Bili ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="protein" class="form-control chart_data check_number" id="" type="text" placeholder="Protein ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="albumin" class="form-control chart_data check_number" id="" type="text" placeholder="Albumin ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="ast" class="form-control chart_data check_number" id="" type="text" placeholder="AST ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="alt" class="form-control chart_data check_number" id="" type="text" placeholder="ALT ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="alp" class="form-control chart_data check_number" id="" type="text" placeholder="ALP ">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon"><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Kidney</h6>
			</div>
			<div class="Kidney_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted">Urea</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Urea')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Creatinine</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Creatinine')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">BUN</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('BUN')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Sodium</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Sodium')}}
								</div>
							</th>

							<th scope="col"><strong class="text-muted">Potassium</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Potassium')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Uric acid</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('uric acid')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Calcium</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Calcium')}}
								</div>
							</th>
							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="kidney">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="urea" class="form-control chart_data check_number" id="" type="text" placeholder="Urea">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="creatinine" class="form-control chart_data check_number" id="" type="text" placeholder="Creatinine ">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="bun" class="form-control chart_data check_number" id="" type="text" placeholder="Bun ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="sodium" class="form-control chart_data check_number" id="" type="text" placeholder="Sodium ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="potassium" class="form-control chart_data check_number" id="" type="text" placeholder="Potassium ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="uric" class="form-control chart_data check_number" id="" type="text" placeholder=" uric acid ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="calcium" class="form-control chart_data check_number" id="" type="text" placeholder="Calcium">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 7px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
				{{-- style="position: absolute;
				right: 5px;
				top: 128px;
			" --}}
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Lipid</h6>
			</div>
			<div class="Lipid_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted">Total Cholesterol</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Total Cholesterol')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Triglyceride</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Triglyceride')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">HDL</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('HDL')}}
								</div>
							</th>

							<th scope="col"><strong class="text-muted">LDL</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('LDL')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">VLDL</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('VLDL')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">LDL/ HDL</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('LDL/HDL')}}
								</div>
							</th>


							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="lipid">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data  check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="cholesterol" class="form-control chart_data check_number" id="" type="text" placeholder="Cholesterol">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="triglyceride" class="form-control chart_data check_number" id="" type="text" placeholder="Triglyceride ">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="hdl" class="form-control chart_data check_number" id="" type="text" placeholder="HDL ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="ldl" class="form-control chart_data check_number" id="" type="text" placeholder="LDL ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="vldl" class="form-control chart_data check_number" id="" type="text" placeholder="VLDL ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="ldl-hdl" class="form-control chart_data check_number" id="" type="text" placeholder="LDL/ HDL ">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0"> Diabetes Screening</h6>
			</div>
			<div class=" Diabetes_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted">FBS</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('FBS')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">PP2BS</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('PP2BS')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">RBS</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('RBS')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">OGT</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('OGT')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">HbA1c</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('HbA1c')}}
								</div>
							</th>

							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="diabetes">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="fbs" class="form-control chart_data check_number" id="" type="text" placeholder="FBS">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="pp2bs" class="form-control chart_data check_number" id="" type="text" placeholder="PP2BS ">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="rbs" class="form-control chart_data check_number" id="" type="text" placeholder="RBS ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="ogt" class="form-control chart_data check_number" id="" type="text" placeholder="OGT ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="hba1c" class="form-control chart_data check_number" id="" type="text" placeholder="HbA1c ">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0"> Thyroid Function</h6>
			</div>
			<div class="Thyroid_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted">TSH</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('TSH')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">T3</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('T3')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">T4</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('T4')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Free T3</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Free T3')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Free T4</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Free T4')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">TBG</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('TBG')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Anti TPO </strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Anti TPO')}}
								</div>
							</th>

							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="thyroid">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="tsh" class="form-control chart_data check_number" id="" type="text" placeholder="TSH">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="t3" class="form-control chart_data check_number" id="" type="text" placeholder="T3 ">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="t4" class="form-control chart_data check_number" id="" type="text" placeholder="T4">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="freet3" class="form-control chart_data check_number" id="" type="text" placeholder=" Free T3">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="freet4" class="form-control chart_data check_number" id="" type="text" placeholder="Free T4 ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="tbg" class="form-control chart_data check_number" id="" type="text" placeholder="TBG ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="anti tpo" class="form-control chart_data check_number" id="" type="text" placeholder="Anti TPO  ">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
			</div>
		</div>
		<hr>
		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Urine Test</h6>
			</div>
			<div class="UrineTest_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col"><strong class="text-muted">PH</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('PH')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Color</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Color')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Sugar</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Sugar')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Ketones</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Ketones')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Protein</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('ProteinTest')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Pus cells</strong>
								<div class="text-muted mt-1 fw-600 chart-range">
									{{chartKeyRange('Pus cells')}}
								</div>
							</th>
							<th scope="col"><strong class="text-muted">Cast</strong>

							</th>
							<th scope="col"><strong class="text-muted">Epithelial cell</strong>

							</th>

							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="urineTest">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data check_date" id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="ph" class="form-control chart_data check_number" id="" type="text" placeholder="pH">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="color" class="form-control " id="" type="text" placeholder="Color">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="sugar" class="form-control chart_data " id="" type="text" placeholder="Sugar">
								</div>
							</td>
							<td class="">
								<div class="form-group">

									<input name="ketones" class="form-control chart_data " id="ketones
                                        " type="text" placeholder="Ketones ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="protein" class="form-control chart_data" id="protein" type="text" placeholder="Protein ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="puscells" class="form-control chart_data check_number" id="puscells" type="text" placeholder="Pus cells ">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="cast" class="form-control chart_data " id="cast" type="text" placeholder="Cast">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="epithelial" class="form-control chart_data " id="cast" type="text" placeholder="Epithelial">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="repeater-create-btn btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon"><i
							class="ik ik-plus"></i></button>
			</div>
		</div>

		<hr>


		<div class="card">
			<div class="card-header p-2 mb-3">
				<h6 class="m-0">Other</h6>
			</div>
			<div class="Other_Repeater">
				<div class="table-responsive">
					<table class="table">
						<thead>
						<tr>
							<th scope="col">Date</th>
							<th scope="col">Name</th>
							<th scope="col">Result</th>
							<th scope="col">Action</th>

						</tr>
						</thead>
						<tbody data-repeater-list="other">
						<tr data-repeater-item>
							<td class="">
								<div class="form-group">
									<input name="date" class="form-control chart_data  check_date " id="" type="text" placeholder="YYYY-MM-DD">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="name" class="form-control chart_data " id="" type="text" placeholder="Name">
								</div>
							</td>
							<td class="">
								<div class="form-group">
									<input name="result" class="form-control chart_data " id="" type="text" placeholder="Result">
								</div>
							</td>

							<td class="col-md-1" style="display: flex;
                                align-items: center;">
								<div>
									<button style="position: absolute; right: 0px; top: 9px;" data-repeater-delete type="button"
									        class="btn btn-danger btn-icon "><i class="ik ik-trash-2"></i></button>
								</div>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class=" btn btn-icon btn-success" data-repeater-create type="button" class="btn btn-success btn-icon" style="position: absolute;
                    right: 5px;
                    top: 109px;"><i class="ik ik-plus"></i></button>
			</div>
		</div>
		<hr>
		<div class="col-md-12 mx-auto  d-flex justify-content-between">
			<div class="form-group">
				<button type="button" id="" class="btn btn-primary submit_btn">Save</button>
			</div>

		</div>
	</div>
	{{-- </form>    --}}
</div>

@push('script')
	<script>
        $(document).ready(function () {

            var liver_Repeater = $('.liver_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'tot Bili': "0",
                    'direct bili': "0",
                    'indirect bili': "0",
                    'protein': "0",
                    'albumin': "0",
                    'ast': "0",
                    'alt': "0",
                    'alp': "0",
                }
            })

			{{--            // @if (isset($chart) && !empty($chart['liver']))--}}

			
            setTimeout(() => {
                liver_Repeater.setList([
						@if (isset($chart['liver']) != null)
						@foreach ($chart['liver'] as $key => $list)
                    {
                        'date': "{{$list['date']}}",
                        'tot Bili': "{{$list['tot Bili']}}",
                        'direct bili': "{{$list['direct bili']}}",
                        'indirect bili': "{{$list['indirect bili']}}",
                        'protein': "{{$list['protein']}}",
                        'albumin': "{{$list['albumin']}}",
                        'ast': "{{$list['ast']}}",
                        'alt': "{{$list['alt']}}",
                        'alp': "{{$list['alp']}}",
                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);


            }, 1000);
			{{--// @endif--}}

            var Kidney_Repeater = $('.Kidney_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{now()->format('Y-m-d')}}",
                    'urea': "0",
                    'creatinine': "0",
                    'bun': "0",
                    'sodium': "0",
                    'potassium': "0",
                    'uric': "0",
                    'calcium': "0",
                }
            })
			@if (isset($chart) && !empty($chart['kidney']))
            setTimeout(() => {
                Kidney_Repeater.setList([
						@if (isset($chart['kidney']) != null)

						@foreach ($chart['kidney'] as $key => $list)

                    {
                        'date': "{{$list['date']}}",
                        'urea': "{{$list['urea']}}",
                        'creatinine': "{{$list['creatinine']}}",
                        'bun': "{{$list['bun'] ?? ''}}",
                        'sodium': "{{$list['sodium']}}",
                        'potassium': "{{$list['potassium']}}",
                        'uric': "{{$list['uric'] ?? ''}}",
                        'calcium': "{{$list['calcium'] ?? ''}}",
                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);


            }, 1000);
			@endif

            var Lipid_Repeater = $('.Lipid_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'cholesterol': "0",
                    'triglyceride': "0",
                    'hdl': "0",
                    'ldl': "0",
                    'vldl': "0",
                    'ldl-hdl': "0",

                }
            })
			@if (isset($chart) && !empty($chart['lipid']))
            setTimeout(() => {
                Lipid_Repeater.setList([
						@if (isset($chart['lipid']) != null)
						@foreach ($chart['lipid'] as $key => $list)
                    {
                        'date': "{{$list['date']}}",
                        'cholesterol': "{{$list['cholesterol']}}",
                        'triglyceride': "{{$list['triglyceride']}}",
                        'hdl': "{{$list['hdl'] ?? ''}}",
                        'ldl': "{{$list['ldl']}}",
                        'vldl': "{{$list['vldl'] ?? ''}}",
                        'ldl-hdl': "{{$list['ldl-hdl'] ?? ''}}",

                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);

            }, 1000);
			@endif


            var Diabetes_Repeater = $('.Diabetes_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'fbs': "0",
                    'pp2bs': "0",
                    'rbs': "0",
                    'ogt': "0",
                    'hba1c': "0",
                }
            })
			@if (isset($chart) && !empty($chart['diabetes']))
            setTimeout(() => {
                Diabetes_Repeater.setList([
						@if (isset($chart['diabetes']) != null)
						@foreach ($chart['diabetes'] as $key => $list)
                    {
                        'date': "{{$list['date']}}",
                        'fbs': "{{$list['fbs']}}",
                        'pp2bs': "{{$list['pp2bs']}}",
                        'rbs': "{{$list['rbs'] ?? ''}}",
                        'ogt': "{{$list['ogt']}}",
                        'hba1c': "{{$list['hba1c'] ?? ''}}",

                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);

            }, 1000);
			@endif



            var Thyroid_Repeater = $('.Thyroid_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'tsh': "0",
                    't3': "0",
                    't4': "0",
                    'freet3': "0",
                    'freet4': "0",
                    'tbg': "0",
                    'anti tpo': "0",
                }
            })
			@if (isset($chart) && !empty($chart['thyroid']))
            setTimeout(() => {
                Thyroid_Repeater.setList([
						@if (isset($chart['thyroid']) != null)
						@foreach ($chart['thyroid'] as $key => $list)

                    {

                        'date': "{{$list['date']}}",
                        'tsh': "{{$list['tsh']}}",
                        't3': "{{$list['t3']}}",
                        't4': "{{$list['t4'] ?? ''}}",
                        'freet3': "{{$list['freet3'] ??''}}",
                        'freet4': "{{$list['freet4'] ?? ''}}",
                        'tbg': "{{$list['tbg'] ?? ''}}",
                        'anti tpo': "{{$list['anti tpo'] ?? ''}}",

                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);

            }, 1000);
			@endif



            var UrineTest_Repeater = $('.UrineTest_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'ph': "0",
                    'color': "0",
                    'sugar': "0",
                    'ketones': "0",
                    'protein': "0",
                    'puscells': "0",
                    'cast': "0",
                    'epithelial': "0",
                }
            })
			@if (isset($chart) && !empty($chart['urineTest']))
            setTimeout(() => {
                UrineTest_Repeater.setList([
						@if (isset($chart['urineTest']) != null)
						@foreach ($chart['urineTest'] as $key => $list)

                    {
                        'date': "{{$list['date']}}",
                        'ph': "{{$list['ph']}}",
                        'color': "{{$list['color']}}",
                        'sugar': "{{$list['sugar']}}",
                        'ketones': "{{$list['ketones'] ?? ''}}",
                        'protein': "{{$list['protein'] ??''}}",
                        'puscells': "{{$list['puscells'] ?? ''}}",
                        'cast': "{{$list['cast'] ?? ''}}",
                        'epithelial': "{{$list['epithelial'] ?? ''}}",
                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);

            }, 1000);
			@endif


            var Other_Repeater = $('.Other_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
	            defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'name': "0",
                    'result': "0",
                }
            })
			@if (isset($chart) && !empty($chart['other']))
            setTimeout(() => {
                Other_Repeater.setList([
						@if (isset($chart['other']) != null)
						@foreach ($chart['other'] as $key => $list)

                    {
                        'date': "{{@$list['date']}}",
                        'name': "{{@$list['name']}}",
                        'result': "{{@$list['result']}}",
                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);

            }, 1000);
			@endif

            var Blood_Repeater = $('.Blood_Repeater').repeater({
                isFirstItemUndeletable: true,
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                        $('.submit_btn').trigger('click');
                    }
                },
                defaultValues: {
                    'date': "{{ now()->format('Y-m-d') }}",
                    'haemoglobin': "0",
                    'wbc': "0",
                    'rbc': "0",
                    'platlets': "0",
                    'retic': "0",
                    'hematocrit': "0",
                    'mcv': "0",
                },
            })
			@if (isset($chart) && !empty($chart['blood']))
            setTimeout(() => {
                Blood_Repeater.setList([
						@if (isset($chart['blood']) != null)
						@foreach ($chart['blood'] as $key => $list)
                    {
                        'date': "{{$list['date']}}",
                        'haemoglobin': "{{$list['haemoglobin']}}",
                        'wbc': "{{$list['wbc']}}",
                        'rbc': "{{$list['rbc']}}",

                        'platlets': "{{$list['platlets']}}",
                        'retic': "{{$list['retic']}}",
                        'hematocrit': "{{$list['hematocrit']??''}}",
                        'mcv': "{{$list['mcv']??''}}",
                    }
					@if(!$loop->last),@endif
					@endforeach
					@endif
                ]);
            }, 1000);
			@endif
        });
	</script>

@endpush



