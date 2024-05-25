<div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "journey") show active @endif" id="journey" role="tabpanel" aria-labelledby="pills-journey-tab">
    <div class="card-body">
        <div class="col-md-12 other-div  mb-2">

            <div class="alert alert-info mt-2">
                Utilize standard font size, font family, and color settings while working on the Detail Journey. On mobile devices, complex structures affect the user experience. Tables and images should be sized according to the device.</i>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <label for="journey" class="control-label"> Detail Journey</label>
                <button type="button" id="default-template" class="btn btn-primary btn-sm">Use Default Template</label>
            </div>
            
            <textarea name="journey" id="summary" class="form-control story_data ckeditor" cols="30" rows="15" placeholder="Enter Detail Journey here...">
                {{$story->journey ?? ''}}
                 
            </textarea>
        </div>
        {{-- @dd($note); --}}
    @if(AuthRole() == 'Admin')
        <div class="col-md-12 mt-4">
            <label for="note" class="control-label">Story Remark:</label>
            <textarea name="note" id="note" class="form-control  " cols="30" rows="4" placeholder="Enter Note  Here From User">{{$story->remark}}</textarea>

            <div class="alert alert-info mt-2">
                User sees this remark <strong>when it is not empty</strong>. It can be useful when our story editor needs additional information and documents from the patient. <i>This is visible in document upload page.</i>
            </div>
        </div>
    @endif

        <div class="col-md-12 mx-auto">
            <div class="form-group">
                <button type="button" id="" class="btn btn-primary submit_btn">Save</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script>
    let template = `<h2>Introduction&nbsp;</h2>
<p>This means that health is a resource to support an individual&rsquo;s function in wider society, rather than an end in itself. A healthful lifestyle provides the means to lead a full life with meaning and purpose.</p>

<h3>High Priority :</h3>

<ul>
\t<li>Restful and consistent sleeping patterns.</li>
\t<li>Good energy levels.&nbsp;</li>
\t<li>Healthy bowel movement.&nbsp;</li>
\t<li>Healthy Urinary System.&nbsp;</li>
\t<li>Healthy, dewy skin.</li>
\t<li>Healthy hair.&nbsp;</li>
\t<li>Good oral health and neutral-smelling breath.</li>
</ul>

<h3>&nbsp;Medium Priority&nbsp;:</h3>

<ul>
\t<li>Sudden Weight Loss or Gain.</li>
\t<li>Changes in Appetite.</li>
\t<li>Fatigue or Weakness.</li>
\t<li>Shortness of Breath.</li>
\t<li>Nausea or Vomiting.</li>
\t<li>Difficulty Swallowing</li>
</ul>

<h3>&nbsp; Low Priority:</h3>

<ul>
\t<li>You snore.</li>
\t<li>Your skin isn&#39;t clear.</li>
\t<li>The whites of your eyes aren&#39;t white.</li>
\t<li>Your toenails and fingernails are an odd color or texture.</li>
\t<li>You&#39;re gassy.&nbsp;</li>
\t<li>You&#39;re always tired.</li>
\t<li>Your urine isn&#39;t a &quot;pale, straw color.</li>
</ul>
<h2>&nbsp;</h2>

<table class="border table table-striped" style="width:100%!important">
	<thead>
		<tr>
			<th scope="col" style="text-align:left">
			<div style="background-color:#0095b6"><span style="font-size:20px"><span style="color:#ffffff">Heading 1</span></span></div>
			</th>
		</tr>
		<tr>
			<td><span style="font-size:18px"><span style="font-family:&quot;Open Sans&quot;,sans-serif"><span style="color:#212529">We have overcome this problem by creating a solution for digital health files which will be formulated as per the doctor&#39;s requirement and one-click use for patients. Handling both ends of healthcare at a single platform will give the required boost to digital healthcare.</span></span></span></td>
		</tr>
	</thead>
</table>

<table class="border table table-striped" style="width:100%!important">
	<thead>
		<tr>
			<th scope="col" style="text-align:left">
			<div style="background-color:#0095b6"><span style="font-size:20px"><span style="color:#ffffff">Heading 2</span></span></div>
			</th>
		</tr>
		<tr>
			<td><span style="font-size:18px"><span style="font-family:&quot;Open Sans&quot;,sans-serif"><span style="color:#212529">Handling both ends of healthcare at a single platform will give the required boost to digital healthcare.</span></span></span></td>
		</tr>
	</thead>
</table>

<table class="border table table-striped" style="width:100%!important">
	<thead>
		<tr>
			<th scope="col" style="text-align:left">
			<div style="background-color:#0095b6"><span style="font-size:20px"><span style="color:#ffffff">Heading 3</span></span></div>
			</th>
		</tr>
		<tr>
			<td><span style="font-size:18px"><span style="font-family:&quot;Open Sans&quot;,sans-serif"><span style="color:#212529">Handling both ends of healthcare at a single platform will give the required boost to digital healthcare.</span></span></span></td>
		</tr>
	</thead>
</table>`;
    $(document).ready(function(){
        $('#default-template').click(function(){
            $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: 'If you Click on Confirm Your template will remove!',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-danger',
                    action: function(){
                        CKEDITOR.instances['summary'].setData(template);
                    }
                },
                close: function () {
                }
            }
        });
         
        
        })
    })
    var options = {
        filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
        filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
        filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
        filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
    };
    $(window).on('load', function (){
        CKEDITOR.replace('description', options);
    });


            
</script>
