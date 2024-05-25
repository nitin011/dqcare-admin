@can('access_by_staff')
{{-- <div class="nav-item {{ ($segment2 == 'filemanager') ? 'active' : '' }}">
    <a href="{{ route('panel.filemanager.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'File Manager' }}</span></a>
</div>
<div class="nav-item {{ ($segment2 == 'qr') ? 'active' : '' }}">
    <a href="{{ route('panel.qr.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'QR Code ' }}</span></a>
</div>
<div class="nav-item {{ ($segment2 == 'map') ? 'active' : '' }}">
    <a href="{{ route('panel.map.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'Map Location ' }}</span></a>
</div> --}}
<div class="nav-item {{ ($segment2 == 'patient-files') ? 'active' : '' }}">
    <a href="{{ route('panel.patient_files.index')}}" class="a-item" ><i class="ik ik-file-minus"></i><span>Patient Files</span></a>
</div>
<div class="nav-item {{ ($segment2 == 'stories') ? 'active' : '' }}">
    <a href="{{ route('panel.stories.index')}}" class="a-item" ><i class="ik ik-copy"></i><span>Stories</span></a>
</div> 
@endcan