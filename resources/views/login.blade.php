<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login — Comercio Minorista</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center" style="min-height:100vh;background:#f8f9fa">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <div class="display-6"><i class="bi bi-shop"></i></div>
              <h1 class="h4 mt-2">Comercio Minorista</h1>
              <p class="text-muted mb-0">Análisis de Ventas</p>
            </div>

            @if (session('msg'))
              <div class="alert alert-info">{{ session('msg') }}</div>
            @endif

            <form method="POST" action="{{ route('login.do') }}">
              @csrf
              <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" required placeholder="admin@demo.com">
              </div>
              <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
              </div>
              <div class="mb-3">
                <label class="form-label">Rol (demo)</label>
                <select class="form-select" name="role">
                  <option>Admin</option>
                  <option>Analista</option>
                  <option selected>Invitado</option>
                </select>
              </div>
              <button class="btn btn-dark w-100">Ingresar</button>
            </form>

            <hr>
            <div class="text-center">
              <small class="text-muted">Login simulado</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
