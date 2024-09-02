<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand pl-5" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="visibility: visible">
        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
            <li class="nav-item me-5">
                <a class="nav-link active" aria-current="page" href="{{ url('/') }}">الصفحة الرئيسية</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    الصفحات
                </a>
            
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
            </li>
        </ul>

        <ul class="navbar-nav mx-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route('post.create')}}"><i class="fa fa-plus fa-fw"></i>موضوع جديد</a>
                </li>
            @endauth
        
            <!-- Search Box -->
            <li>
                <form class="d-flex" method="post" action="{{route('search')}}">
                    @csrf
                    <input class="form-control ms-2" name="keyword" type="search" placeholder="ابحث عن منشور..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">ابحث</button>
                </form>        
            </li>
        </ul>

        <ul class="navbar-nav mr-auto">
            <div class="topbar" style="z-index: 1">
                @auth
<!-- Nav Item - Alerts -->
<li class="nav-item dropdown no-arrow alert-dropdown mx-1" style="list-style: none">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw fa-lg"></i>
        <!-- Counter - Alerts -->
        <span class="badge badge-danger badge-counter notif-count" data-count="{{nb_alerts()}}" id="notifications-count">{{nb_alerts()}}</span>
    </a>
    <!-- Dropdown - Alerts -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right text-right mt-2 mr-auto"
        aria-labelledby="alertsDropdown">
        <div class="alert-body" id="notifications-container">

        </div>
        <a class="dropdown-item text-center small text-gray-500" href="#">عرض جميع الإشعارات</a>
    </div>
</li>                @endauth
            </div>
            @guest
                <li class="nav-item my-auto">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                </li>

                <li class="nav-item my-auto">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('إنشاء حساب') }}</a>
                </li>
            @else
                <li class="nav-item dropdown justify-content-left my-auto">
                    <a id="navbarDropdown" class="nav-link" href="#" data-bs-toggle="dropdown">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </a>

                    <div class="dropdown-menu dropdown-menu-left px-2 text-right mt-2">
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <a href="#">
                                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                </a>
                            </div>

                            <div class="mt-3 space-y-1">
                                <!-- Account Management -->
                                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                    {{ __('الملف الشخصي') }}
                                </x-responsive-nav-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                        {{ __('API Tokens') }}
                                    </x-responsive-nav-link>
                                @endif

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-responsive-nav-link href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                        {{ __('تسجيل خروج') }}
                                    </x-responsive-nav-link>
                                </form>

                                <!-- Team Management -->
                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                    <div class="border-t border-gray-200"></div>

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                                        {{ __('Team Settings') }}
                                    </x-responsive-nav-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                            {{ __('Create New Team') }}
                                        </x-responsive-nav-link>
                                    @endcan

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team" component="jet-responsive-nav-link" />
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            @endguest
        </ul>

    </div>
  </div>
</nav>