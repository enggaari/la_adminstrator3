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

                    <a class="nav-link @if ($title == 'Dashboard') active @endif" href="{{ $link }}">
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
                                    href="/role" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Role Access</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Menu') active @endif"
                                    href="/menu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Sub Menu') active @endif"
                                    href="/subMenu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Super Sub Menu') active @endif"
                                    href="/superSubMenu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Super Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- API --}}
                    <li class="nav-item">
                        <a class="nav-link dropdown-indicator" href="#api" role="button" data-bs-toggle="collapse"
                            aria-expanded="false" aria-controls="api">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon d-flex flex-center"><span
                                        class="fas fa-caret-right fs-0"></span></div><span class="nav-link-icon"><span
                                        data-feather="api"></span></span><span class="nav-link-text">Setting
                                    API</span>
                            </div>
                        </a>
                        <ul class="nav collapse parent 
                        @if ($title == 'Role Access' || $title == 'Menu' || $title == 'Sub Menu') show @endif"
                            id="api">
                            <li class="nav-item"><a class="nav-link @if ($title == 'Role Access') active @endif"
                                    href="/role" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Role Access</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Menu') active @endif"
                                    href="/menu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Sub Menu') active @endif"
                                    href="/subMenu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if ($title == 'Super Sub Menu') active @endif"
                                    href="/superSubMenu" data-bs-toggle="" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text">Super Sub Menu</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </li>


                    {{-- setiings --}}
                @endif


                <li class="nav-item">
                    <p class="navbar-vertical-label">Pages</p>
                    <a class="nav-link" href="pages/starter.html" role="button" data-bs-toggle=""
                        aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                    data-feather="flag"></span></span><span class="nav-link-text">Starter</span></div>
                    </a>

                    <a class="nav-link dropdown-indicator" href="#errors" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="errors">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon d-flex flex-center"><span
                                    class="fas fa-caret-right fs-0"></span></div><span class="nav-link-icon"><span
                                    data-feather="alert-triangle"></span></span><span
                                class="nav-link-text">Errors</span>
                        </div>
                    </a>
                    <ul class="nav collapse parent" id="errors">
                        <li class="nav-item"><a class="nav-link" href="pages/errors/404.html" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">404</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/errors/500.html" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">500</span></div>
                            </a></li>
                    </ul>
                    <a class="nav-link dropdown-indicator" href="#authentication" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="authentication">
                        <div class="d-flex align-items-center">
                            <div class="dropdown-indicator-icon d-flex flex-center"><span
                                    class="fas fa-caret-right fs-0"></span></div><span class="nav-link-icon"><span
                                    data-feather="lock"></span></span><span
                                class="nav-link-text">Authentication</span>
                        </div>
                    </a>
                    <ul class="nav collapse parent" id="authentication">
                        <li class="nav-item"><a class="nav-link" href="pages/authentication/simple/sign-in.html"
                                data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Sign
                                        in</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/authentication/simple/sign-up.html"
                                data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Sign
                                        up</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/authentication/simple/sign-out.html"
                                data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Sign
                                        out</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="pages/authentication/simple/forgot-password.html" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Forgot
                                        password</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="pages/authentication/simple/reset-password.html" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Reset
                                        password</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="pages/authentication/simple/lock-screen.html"
                                data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-text">Lock
                                        screen</span></div>
                            </a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <div class="navbar-vertical-footer"><a class="btn btn-link border-0 fw-semi-bold d-flex ps-0"
                href="/logout"><span class="navbar-vertical-footer-icon" data-feather="log-out"></span><span>Sign
                    Out</span></a></div>
    </div>
</nav>
