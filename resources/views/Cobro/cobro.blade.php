@extends('layout.app')
@section('content')
<div style="margin: 1rem">
    <!-- Buscar facturas -->
    <div class="">
      <h2 style="text-align: left;">Buscar Facturas</h2>
      <form id="search-form" class="row g-3" style="gap: 0rem !important;">
        <div class="col-md-4">
          <label for="invoice-code" class="form-label">Código de factura</label>
          <input type="text" id="invoice-code" class="form-control" placeholder="Ejemplo: NH186124">
        </div>
        <div class="col-md-4">
          <label for="provider" class="form-label">Proveedor</label>
          <select class="form-select form-control">
            <option value="">Seleccionar</option>
            @foreach (App\Models\Proveedor::all() as $proveedor)
              <option value="{{ $proveedor->id }}">{{ $proveedor->proveedor }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label for="client" class="form-label">Cliente</label>
          <select class="form-select form-control">
            <option value="">Seleccionar</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="start-date" class="form-label">Fecha de inicio</label>
          <input type="date" id="start-date" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label for="end-date" class="form-label">Fecha de fin</label>
          <input type="date" id="end-date" class="form-control" required>
        </div>
        
        <div class="col-md-4 align-self-end">
          <button type="submit" class="btn btn-primary form-control">Buscar</button>
        </div>
      </form>
    </div>

    <!-- Tabla de facturas -->
    <div class="mb-4">
      <h2>Facturas</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Pagado</th>
            <th>Saldo</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="invoice-table-body">
          <tr>
            <td colspan="8" class="text-center">No hay facturas registradas</td>
          </tr>
        </tbody>
      </table>
    </div>

  <script>
    document.getElementById('generate-invoice').addEventListener('click', function () {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.text("Factura - Bepensa Izamal SA DE C.V", 10, 10);
      doc.save("factura.pdf");
    });
  </script>
</div>
@endsection
@push('scripts')
@endpush

