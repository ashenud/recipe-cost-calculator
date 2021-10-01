<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="hamburger hamburger-btn" id="hamburger" type="button">
            <i class="fas fa-bars"></i>
        </button>
        <span class="nav-title navbar-brand mb-0 h1">RECIPE |</span> <span class="current-page"> @if (isset($data['page_title'])) {{ $data['page_title'] }} @endif</span>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link user-anchor dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-menu-button-wide-fill"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ url('/admin/profile') }}">
                            <i class="bi bi-person-circle"></i>My profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('/admin/settings') }}">
                            <i class="bi bi-gear"></i>Settings
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-power"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>