<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Comercio Minorista')</title>

  <!-- Bootstrap + Icons + DataTables CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    body { background:#f8f9fa; }
    .brand { font-weight:700; letter-spacing:.3px; }
    .role-badge { text-transform: uppercase; font-size:.75rem; }
    .kpi-card .display-6 { font-weight:700; }
    .page-title { font-weight:700; }
  </style>

  @stack('styles')
</head>
<body>
  @include('partials.nav')

  <main class="container py-4">
    {{-- Flash messages globales --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @yield('content')
  </main>

  <!-- JS: jQuery (para DataTables), Bootstrap bundle, Chart.js, DataTables, app.js -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

  <script>
    // Exponer token CSRF por si haces POST con fetch/AJAX
    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Tooltips (por si usas data-bs-toggle="tooltip")
    document.addEventListener('DOMContentLoaded', () => {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.map(el => new bootstrap.Tooltip(el))
    });
  </script>

  <script src="{{ asset('assets/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
