<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('panel.dashboard')}}">
            <div class="logo-img">
               <img height="40" src="{{ getBackendLogo(getSetting('app_white_logo'))}}" class="header-brand-img" title="DZE"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"></button>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $segment3 = request()->segment(3);
        $segment4 = request()->segment(4);
    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <div class="px-20px mt-3 mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" style="background-color: #131923;border-color: #131923;" type="text" name="" placeholder="{{ __('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <nav id="search-menu-navigation" class="navigation-main">

            </nav>
            <nav id="main-menu-navigation" class="navigation-main">

                <div class="nav-item {{ ($segment2 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('panel.dashboard')}}" class="a-item" ><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>                                                             
                
                @if(auth()->user()->roles[0]->name != 'Super Admin')
                        {{-- @can('manage_chats')
                            <div class="nav-item {{ ($segment2 == 'chats') ? 'active' : '' }}">
                                <a href="{{route('panel.chats.index')}}" class="a-item" ><i class="ik ik-bar-chart-2"></i><span>{{ __('Chats')}}</span></a>
                            </div> 
                        @endcan     --}}
                


                   @include('backend.include.partial.admin_sidebar')
                   @include('backend.include.partial.user_sidebar')
                   @include('backend.include.partial.staff_sidebar')
                   @include('backend.include.partial.crud_sidebar')




                @endif
                   @include('backend.include.partial.dev_sidebar')
            </nav>
        </div>
    </div>
</div>