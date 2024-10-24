<nav class="navbar navbar-light navbar-vertical navbar-vibrant navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    @php
                        $link = null;
                        if (Auth::user()->role == 'developer') {
                            $link = 'dashboardDev';
                        } elseif (Auth::user()->role == 'administrator') {
                            $link = 'dashboardAdmin';
                        } elseif (Auth::user()->role == 'member') {
                            $link = 'dashboardMember';
                        } elseif (Auth::user()->role == 'individu') {
                            $link = '/dashboardIndi';
                        }
                    @endphp

                    <a class="nav-link @if ($title == 'Dashboard') active @endif" href="{{ url("$link") }}">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    data-feather="cast"></span></span><span class="nav-link-text">Dashbboard</span>
                        </div>
                    </a>
                </li>

                @if (Auth::user()->role == 'developer')
                    {{-- @include('pages.dev.index'); --}}
                    {{-- setiings --}}
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#settings" role="button" data-bs-toggle="collapse"
                            aria-expanded="false" aria-controls="settings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon d-flex flex-center"><span
                                        class="fas fa-caret-right fs-0"></span></div><span class="nav-link-icon"><span
                                        data-feather="settings"></span></span><span class="nav-link-text">Setting
                                    App</span>
                            </div>
                        </a>
                        <ul class="nav collapse parent 
                        @if ($title == 'Role Access' || $title == 'Menu' || $title == 'Sub Menu' || $title == 'Super Sub Menu') show @endif"
                            id="settings">
                            <li class="nav-item"><a class="nav-link @if ($title == 'Role Access') active @endif"
                                    href="{{ url('/role') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Role Access</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Menu') active @endif"
                                    href="{{ url('/menu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Sub Menu') active @endif"
                                    href="{{ url('/subMenu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Super Sub Menu') active @endif"
                                    href="{{ url('/superSubMenu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Super Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- setiings --}}

                    {{-- API --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#api" role="button" data-bs-toggle="collapse"
                            aria-expanded="false" aria-controls="api">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon d-flex flex-center"><span
                                        class="fas fa-caret-right fs-0"></span></div><span class="nav-link-icon"><span
                                        data-feather="server"></span></span><span class="nav-link-text">API</span>
                            </div>
                        </a>
                        <ul class="nav collapse parent 
                        @if ($title == 'App' || $title == 'Documentation' || $title == 'Token Management' || $title == 'Super Sub Menu') show @endif"
                            id="api">
                            <li class="nav-item"><a class="nav-link @if ($title == 'App') active @endif"
                                    href="{{ url('/role') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">App</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Documentation') active @endif"
                                    href="{{ url('/menu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Documentation</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Token Management') active @endif"
                                    href="{{ url('/subMenu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Token Management</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Super Sub Menu') active @endif"
                                    href="{{ url('/superSubMenu') }}" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Super Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- API --}}
                @endif

                @foreach ($menuSidebar as $m)
                    {{-- menu --}}
                    <li class="nav-item">
                        <p class="navbar-vertical-label">{{ $m->menu }} - {{ $m->id }}</p>
                    </li>

                    @php
                        $idMenu = $m->id;
                        $role = Auth::user()->role;
                        $subMenus = DB::table('user_access_submenus')
                            ->join('sub_menus', 'user_access_submenus.submenuId', '=', 'sub_menus.id')
                            ->where('user_access_submenus.roleId', $role)
                            ->where('user_access_submenus.menuId', $idMenu)
                            ->select('user_access_submenus.id as smId', 'user_access_submenus.*', 'sub_menus.*') // Pilih kolom dari kedua tabel
                            ->get();
                        // ->toArray();

                        // var_dump($subMenus);
                        // die();

                        $jumlahRow = $subMenus->count();
                    @endphp

                    @if ($jumlahRow == 1)
                        @foreach ($subMenus as $sm)
                            @php
                                $querysupersubmenu = DB::table('super_sub_menus')
                                    ->join('sub_menus', 'super_sub_menus.idSubMenu', '=', 'sub_menus.id')
                                    ->where('super_sub_menus.idSubMenu', $sm->smId)
                                    ->where('super_sub_menus.status', 1)
                                    ->select('super_sub_menus.*', 'sub_menus.*')
                                    ->get();

                                // var_dump($querysupersubmenu);

                                $jumlahRowSupersubmenu = $querysupersubmenu->count();
                            @endphp
                            <a class="nav-link" href="{{ url("$sm->url") }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span data-feather="{{ $sm->icon }}"></span>
                                    </span>
                                    <span class="nav-link-text">{{ $sm->subMenu }} -
                                        {{ $sm->id }}</span>
                                </div>
                            </a>
                        @endforeach
                    @elseif ($jumlahRow > 1)
                        @foreach ($subMenus as $sm)
                            @php
                                $submenuId = $sm->id;
                                $querysupersubmenu = DB::table('super_sub_menus')
                                    ->join('sub_menus', 'sub_menus.id', '=', 'super_sub_menus.id')
                                    ->where('super_sub_menus.idSubMenu', $submenuId)
                                    ->where('super_sub_menus.idMenu', $idMenu)
                                    ->where('super_sub_menus.status', 1)
                                    ->select(
                                        'super_sub_menus.*',
                                        'sub_menus.*',
                                        'super_sub_menus.url as urlSuperSubmenus',
                                    )
                                    ->get();

                            @endphp

                            @php
                                $submenuId = $sm->id;
                                $cekRowSupers = DB::table('super_sub_menus')
                                    ->join('sub_menus', 'sub_menus.id', '=', 'super_sub_menus.id')
                                    ->where('super_sub_menus.idSubMenu', $submenuId)
                                    ->where('super_sub_menus.idMenu', $idMenu)
                                    ->where('super_sub_menus.status', 1)
                                    ->select(
                                        'super_sub_menus.*',
                                        'sub_menus.*',
                                        'super_sub_menus.url as urlSuperSubmenus',
                                    )
                                    ->get();

                                $rowSupers = $cekRowSupers->count();
                            @endphp

                            {{-- submenu --}}
                            @if ($rowSupers > 0)
                                {{-- memiliki submenu --}}
                                <a class="nav-link dropdown-indicator" href="#sub{{ $sm->submenuId }}" role="button"
                                    data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="sub{{ $sm->submenuId }}">
                                    <div class="d-flex align-items-center">
                                        <div class="dropdown-indicator-icon d-flex flex-center">
                                            <span class="fas fa-caret-right fs-0"></span>
                                        </div>
                                        <span class="nav-link-icon">
                                            <span data-feather="{{ $sm->icon }}"></span>
                                        </span>
                                        <span class="nav-link-text">{{ $sm->subMenu }} - {{ $sm->submenuId }}
                                        </span>
                                    </div>
                                </a>

                                @php
                                    $submenuId = $sm->id;
                                    $querysuperSubmenu = DB::table('super_sub_menus')
                                        ->join('sub_menus', 'sub_menus.id', '=', 'super_sub_menus.id')
                                        ->where('super_sub_menus.idSubMenu', $submenuId)
                                        ->where('super_sub_menus.idMenu', $idMenu)
                                        ->where('super_sub_menus.status', 1)
                                        ->select(
                                            'super_sub_menus.*',
                                            'sub_menus.*',
                                            'super_sub_menus.url as urlSuperSubmenus',
                                        )
                                        ->get();
                                @endphp

                                <ul class="nav collapse parent" id="sub{{ $sm->submenuId }}">
                                    @foreach ($querysuperSubmenu as $key => $spsm)
                                        {{-- @if ($querysuperSubmenu) --}}
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url(" $spsm->urlSuperSubmenus ") }}"
                                                data-bs-toggle="" aria-expanded="false">
                                                <div class="d-flex align-items-center"><span
                                                        class="nav-link-text">{{ $spsm->super_sub_menus }}</span>
                                                </div>
                                            </a>
                                        </li>
                                        {{-- @endif --}}
                                    @endforeach
                                </ul>
                            @elseif ($rowSupers == 0)
                                <a class="nav-link" href="{{ url("$sm->url") }}" role="button" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon">
                                            <span data-feather="{{ $sm->icon }}"></span>
                                        </span>
                                        <span class="nav-link-text">{{ $sm->subMenu }} -
                                            {{ $sm->id }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    @else
                        <li class="nav-item">
                            <small class="navbar-vertical-label"> Menu Tidak ditemukan</small>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
        <div class="navbar-vertical-footer"><a class="btn btn-link border-0 fw-semi-bold d-flex ps-0"
                href="/logout"><span class="navbar-vertical-footer-icon" data-feather="log-out"></span><span>Sign
                    Out</span></a></div>
    </div>
</nav>
