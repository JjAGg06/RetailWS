@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="page-title">Dashboard</h1>
  <div>
    <input type="month" id="cmpFrom" class="form-control form-control-sm d-inline" style="width:auto;" value="2024-01">
    <span class="mx-2">a</span>
    <input type="month" id="cmpTo" class="form-control form-control-sm d-inline" style="width:auto;" value="2024-12">
    <button class="btn btn-sm btn-primary ms-2" id="btnApplyFilters"><i class="bi bi-funnel"></i> Aplicar</button>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-3"><div class="card kpi-card shadow-sm"><div class="card-body"><div class="text-muted">Ventas Totales</div><div class="display-6" id="kpiVentas">$1,254,300</div><div class="text-success small" id="kpiVentasVar">+12.4% vs. período anterior</div></div></div></div>
  <div class="col-md-3"><div class="card kpi-card shadow-sm"><div class="card-body"><div class="text-muted">Tickets</div><div class="display-6" id="kpiTickets">48,902</div><div class="text-success small" id="kpiTicketsVar">+4.1%</div></div></div></div>
  <div class="col-md-3"><div class="card kpi-card shadow-sm"><div class="card-body"><div class="text-muted">Ticket Promedio</div><div class="display-6" id="kpiATP">$25.66</div><div class="text-danger small" id="kpiATPVar">-1.2%</div></div></div></div>
  <div class="col-md-3"><div class="card kpi-card shadow-sm"><div class="card-body"><div class="text-muted">Margen</div><div class="display-6" id="kpiMargin">33.8%</div><div class="text-success small" id="kpiMarginVar">+0.7 pp</div></div></div></div>
</div>

<div class="row g-3 mt-1">
  <div class="col-lg-8"><div class="card shadow-sm"><div class="card-header bg-white">Ventas por Mes</div><div class="card-body"><canvas id="chartLine"></canvas></div></div></div>
  <div class="col-lg-4"><div class="card shadow-sm"><div class="card-header bg-white">Top Categorías</div><div class="card-body"><canvas id="chartBar"></canvas></div></div></div>
</div>

<div class="card shadow-sm mt-3">
  <div class="card-header bg-white d-flex justify-content-between">
    <span>Detalle de Ventas</span>
    <div>
      <select class="form-select form-select-sm d-inline" style="width:auto;" id="fSucursal">
        <option value="">Todas Sucursales</option><option>Centro</option><option>Norte</option><option>Sur</option>
      </select>
      <select class="form-select form-select-sm d-inline" style="width:auto;" id="fCategoria">
        <option value="">Todas Categorías</option><option>Bebidas</option><option>Lácteos</option><option>Abarrotes</option><option>Limpieza</option>
      </select>
    </div>
  </div>
  <div class="card-body">
    <table id="tblVentas" class="table table-striped table-hover w-100">
      <thead><tr><th>Fecha</th><th>Sucursal</th><th>Categoría</th><th>Producto</th><th>Cantidad</th><th>Total</th></tr></thead>
      <tbody></tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>initNavbar('dashboard'); initDashboard('/api/mock/sales');</script>
@endpush
