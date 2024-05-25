@can('access_by_super_admin')
<div class="nav-item {{ ($segment2 == 'filemanager') ? 'active' : '' }}">
    <a href="{{ route('panel.filemanager.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'File Manager' }}</span></a>
</div>
<div class="nav-item {{ ($segment2 == 'qr') ? 'active' : '' }}">
    <a href="{{ route('panel.qr.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'QR Code ' }}</span></a>
</div>
<div class="nav-item {{ ($segment2 == 'map') ? 'active' : '' }}">
    <a href="{{ route('panel.map.index') }}" class="a-item" ><i class="ik ik-folder"></i><span>{{ 'Map Location ' }}</span></a>
</div>
@endcan