<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand brand" href="{{ route('dashboard') }}">
      <i class="bi bi-shop"></i> Comercio Minorista
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('etl') ? 'active' : '' }}" href="{{ route('etl') }}">ETL</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('uploads') ? 'active' : '' }}" href="{{ route('uploads') }}">Cargas</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('logs') ? 'active' : '' }}" href="{{ route('logs') }}">Logs</a></li>
      </ul>

      <div class="d-flex align-items-center gap-3">
        <span class="text-light small">{{ session('email') }}</span>
        <span class="badge bg-info role-badge" id="roleBadge">{{ session('role','Invitado') }}</span>
        <div class="dropdown">
          <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">Rol</button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item role-select" data-role="Admin" href="#">Admin</a></li>
            <li><a class="dropdown-item role-select" data-role="Analista" href="#">Analista</a></li>
            <li><a class="dropdown-item role-select" data-role="Invitado" href="#">Invitado</a></li>
          </ul>
        </div>
        <a class="btn btn-outline-warning btn-sm" href="{{ route('twofa') }}"><i class="bi bi-shield-lock"></i> 2FA</a>
        <a class="btn btn-outline-danger btn-sm" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Salir</a>
      </div>
    </div>
  </div>
</nav>
