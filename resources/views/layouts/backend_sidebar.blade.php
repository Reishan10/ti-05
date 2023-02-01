<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets') }}//images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets') }}//images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="index.html" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets') }}//images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets') }}//images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title side-nav-item">Navigation</li>

            <li class="side-nav-item {{ request()->segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('dashboard') }}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false" aria-controls="sidebarEmail"
                    class="side-nav-link">
                    <i class="uil-folder"></i>
                    <span> Data Master </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEmail">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="apps-email-inbox.html">Inbox</a>
                        </li>
                        <li>
                            <a href="apps-email-read.html">Read Email</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPost"
                    aria-expanded="{{ request()->segment(1) == 'kategori' ? 'true' : 'false' }}"
                    aria-controls="sidebarPost"
                    class="side-nav-link {{ request()->segment(1) == 'kategori' ? 'collapsed' : '' }}">
                    <i class="uil-envelope"></i>
                    <span> Post </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ request()->segment(1) == 'kategori' ? 'show' : '' }}" id="sidebarPost">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('post.create') }}">Tambah Postingan</a>
                        </li>
                        <li>
                            <a href="{{ route('post.index') }}">Post List</a>
                        </li>
                        <li>
                            <a href="{{ route('kategori.index') }}">Kategori</a>
                        </li>
                        <li>
                            <a href="{{ route('tag.index') }}">Tag</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-comments-alt"></i>
                    <span> Komen </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-image"></i>
                    <span> Galeri </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Mahasiswa </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-clipboard-notes"></i>
                    <span> Pengumuman </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="apps-chat.html" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> Pengguna </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPengaturan" aria-expanded="false"
                    aria-controls="sidebarPengaturan" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Pengaturan </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPengaturan">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="apps-email-inbox.html">Basic</a>
                        </li>
                        <li>
                            <a href="apps-email-read.html">Navbar</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('logout') }}" class="side-nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="uil-sign-out-alt"></i>
                    <span> Keluar </span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
