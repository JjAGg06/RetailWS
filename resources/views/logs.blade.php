@extends('layouts.app')
@section('title','Logs del Sistema')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title">Logs</h1>
  <span class="text-muted small">Listado de eventos recientes</span>
</div>

<div class="card shadow-sm">
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
  // reutilizamos el mismo loader de ETL
  if (typeof initLogsTable === 'function') {
    initLogsTable('/api/mock/logs');
  }
  // y navbar/roles
  if (typeof initNavbar === 'function') initNavbar('logs');
</script>
@endpush
