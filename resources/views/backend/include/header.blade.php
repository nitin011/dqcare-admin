 <header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                @if(!request()->routeIs('panel.receptionist.dashboard'))
                    <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                    <a href="{{ URL::previous() }}" type="button" id="" class="nav-link bg-gray mr-1"><i
                            class="ik ik-arrow-left"></i></a>
                  @endif
                @if(AuthRole() != 'Receptionist') 
                    <button type="button" id="navbar-fullscreen" class="nav-link"><i
                            class="ik ik-maximize"></i></button>
                    <a href="{{ url('/panel/dashboard') }}" type="button" id="" class="nav-link bg-gray ml-1"><i
                            class="ik ik-home"></i></a>
                    @if(Route::is('panel.dashboard'))
                        <button type="button" class="nav-link bg-gray ml-1" data-toggle="modal" data-target="#addBrodcast">
                            <i class="ik ik ik-radio" title="Broadcast"></i>
                        </button>
                    @endif
                @endif     
            </div>
            {{-- @if(getSetting('notification')) --}}
                @php
                    $notifications = App\Models\Notification::whereUserId(auth()->id())
                        ->whereIsReaded(0)
                        ->limit(5)
                        ->get();
                    //  return dd($notification->count());
                @endphp
            {{-- @endif --}}
            <div class="top-menu d-flex align-items-center">
                @if(AuthRole() != 'Receptionist')  
                    @if(getSetting('notification'))
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i><span
                                    class="badge bg-danger">{{ fetchGetData('App\Models\Notification', ['user_id', 'is_readed'], [auth()->id(), 0])->count() }}</span></a>
                            <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                                <h4 class="header">{{ __('Notifications') }}</h4>
                                <div class="notifications-wrap">
                                    @foreach ($notifications as $notification)
                                        <a href="{{ route('panel.notification.read', $notification->id) }}" class="media">
                                            <span class="d-flex">
                                                <i class="ik ik-check"></i>
                                            </span>
                                            <span class="media-body">
                                                <span class="heading-font-family media-heading d-block">{{ $notification->title }}</span>
                                                <span class="media-content">{{ $notification->notification }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                                <div class="footer"><a
                                        href="{{ route('panel.constant_management.notification.index') }}">{{ __('See all activity') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                    <div class="dropdown">
                        {{-- <sub class="user-status" >{{ authRole() }}</sub> --}}
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="avatar" src="{{ auth()->user() && auth()->user()->avatar ? auth()->user()->avatar : asset('backend/default/default-avatar.png') }}"
                                style="object-fit: cover; width: 35px; height: 35px" alt="">
                            <span class="user-name font-weight-bolder"
                                style="top: -0.8rem;position: relative;margin-left: 8px;">{{ auth()->user()->name }}
                                <span class="text-muted"
                                    style="font-size: 10px;position: absolute;top: 16px;left: 3px;">{{ authRole() }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ url('panel/user-profile') }}"><i
                                    class="ik ik-user dropdown-icon"></i> {{ __('Profile') }}</a>
                            {{-- <a class="dropdown-item" href="#"><i class="ik ik-navigation dropdown-icon"></i> {{ __('Message')}}</a> --}}
                            <a class="dropdown-item" href="{{ url('logout') }}">
                                <i class="ik ik-power dropdown-icon"></i>
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </div>
                     
            </div>
        </div>
    </div>
</header>
@include('backend.include.broadcast-model')

