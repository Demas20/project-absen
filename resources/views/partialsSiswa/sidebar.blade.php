<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <img class="img-80 img-radius" src="{{asset('assets/images/avatar-4.jpg')}}" alt="User-Profile-Image">
                <div class="user-details">
                    <span id="more-details">{{Auth::guard('admin')->user()->name}}<i class="fa fa-caret-down"></i></span>
                    <span>{{ $siswaDetails->kelas_name }} {{ $siswaDetails->jurusan_name }} | {{$siswaDetails->kelompok_name}}</span>
                </div>
            </div>

            <div class="main-menu-content">
                <ul>
                    <li class="more-details">
                        <a href="user-profile.html"><i class="ti-user"></i>View Profile</a>
                        <a href="#!"><i class="ti-settings"></i>Settings</a>
                        <a href="auth-normal-sign-in.html"><i class="ti-layout-sidebar-left"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="p-15 p-b-0">
            <form class="form-material">
                <div class="form-group form-primary">
                    <input type="text" name="footer-email" class="form-control" required="">
                    <span class="form-bar"></span>
                    <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                </div>
            </form>
        </div>
        <div class="pcoded-navigation-label" data-i18n="nav.category.navigation">Sistem Monitoring</div>
        @if (Auth::guard('admin')->user()->role === 'siswa')
        <ul class="pcoded-item pcoded-left-item">
            {{-- //project --}}
            <li class="{{ Route::currentRouteName() === 'siswa.index' ? 'active' : '' }}">
                <a href="{{route('siswa.index')}}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-pencil"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Project</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        @endif
    </div>
</nav>
