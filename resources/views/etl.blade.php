@extends('layouts.app')
@section('title','ETL')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title">Gestión de ETL</h1>
  <span class="text-muted small">Demo: acciones simuladas en el navegador</span>
</div>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white">Dimensiones</div>
      <div class="card-body d-grid gap-2">
        <button class="btn btn-outline-primary role-analyst" onclick="etlRun('DIM_PRODUCTO')">
          <i class="bi bi-play-fill"></i> Cargar DIM_PRODUCTO
        </button>
        <button class="btn btn-outline-primary role-analyst" onclick="etlRun('DIM_CLIENTE')">
          <i class="bi bi-play-fill"></i> Cargar DIM_CLIENTE
        </button>
        <button class="btn btn-outline-primary role-analyst" onclick="etlRun('DIM_SUCURSAL')">
          <i class="bi bi-play-fill"></i> Cargar DIM_SUCURSAL
        </button>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white">Hechos</div>
      <div class="card-body d-grid gap-2">
        <button class="btn btn-outline-success role-analyst" onclick="etlRun('FACT_VENTAS')">
          <i class="bi bi-play-fill"></i> Construir HECHOS (PR_CONSTRUYE_HECHOS)
        </button>
        <button class="btn btn-outline-warning role-analyst" onclick="etlRun('REPROCESO_HECHOS')">
          <i class="bi bi-arrow-repeat"></i> Reprocesar Hechos (p_valor=2)
        </button>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-header bg-white">Estado</div>
      <div class="card-body">
        <div id="etlStatus">Listo.</div>
        <div class="progress mt-2 d-none" id="etlProgress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm mt-3">
  <div class="card-header bg-white">Logs de Ejecución</div>
  <div class="card-body">
    <table id="tblLogs" class="table table-sm table-hover w-100">
      <thead>
        <tr><th>Fecha</th><th>Proceso</th><th>Estado</th><th>Detalle</th></tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Asegura init de navbar/roles y carga de logs
  if (typeof initNavbar === 'function') initNavbar('etl');
  if (typeof initETL === 'function') initETL('/api/mock/logs');
</script>
@endpush
