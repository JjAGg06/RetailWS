@extends('layouts.app')
@section('title','Cargas de Archivos')

@section('content')
<h1 class="page-title mb-3">Cargas de Archivos</h1>
<div class="alert alert-info mb-3">
  Formatos permitidos: <strong>CSV, XLSX, JSON</strong>. Validación 100% en el navegador (demo).
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form onsubmit="return handleUpload(event)">
      <div class="row g-3 align-items-end">
        <div class="col-md-6">
          <label class="form-label">Archivo</label>
          <input type="file" class="form-control" id="fileInput" accept=".csv,.xlsx,.json" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Destino (DW)</label>
          <select class="form-select" id="uploadTarget">
            <option value="STG_PRODUCTO">STG_PRODUCTO</option>
            <option value="STG_CLIENTE">STG_CLIENTE</option>
            <option value="STG_SUCURSAL">STG_SUCURSAL</option>
          </select>
        </div>
        <div class="col-md-2 d-grid">
          <button class="btn btn-primary role-analyst">
            <i class="bi bi-upload"></i> Enviar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="card shadow-sm mt-3">
  <div class="card-header bg-white">Resultado de Validación</div>
  <div class="card-body">
    <pre id="uploadResult" class="mb-0" style="white-space:pre-wrap;"></pre>
  </div>
</div>

<div class="card shadow-sm mt-3">
  <div class="card-header bg-white">Historial de Cargas (demo)</div>
  <div class="card-body">
    <table class="table table-sm table-striped w-100">
      <thead><tr><th>Fecha</th><th>Archivo</th><th>Destino</th><th>Estado</th></tr></thead>
      <tbody id="tblUploads">
        <tr><td>2025-11-06 18:22</td><td>clientes.json</td><td>STG_CLIENTE</td>
          <td><span class="badge bg-success">OK</span></td></tr>
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
  {{-- SheetJS para leer .xlsx en el navegador --}}
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script>
    initNavbar('uploads');
  </script>
@endpush
