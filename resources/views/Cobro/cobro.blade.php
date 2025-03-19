@extends('layout.app')
@section('content')
<div style="margin: 1rem">
    <!-- Buscar facturas -->
    <div class="">
      <h5 style="text-align: left; font-weight: bolder">Filtrar por:</h5>
      <form id="search-form" class="row g-3" style="gap: 0rem !important;">
        <!-- <div class="col-md-4">
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
            @foreach (App\Models\Cliente::where('activo', 1)->get() as $cliente)
              <option value="{{ $cliente->id }}">{{ $cliente->nombre_tienda }}</option>
            @endforeach
          </select>
        </div> -->
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
    <div class="card">
      <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="card-title" style="font-weight: bolder">Lista de Facturas</h3>
        <a href="{{ route('nueva-facturacion') }}" class="btn btn-primary" style="margin-left: auto;">
          Agregar Factura
        </a>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped" id="facturacionDataTable">
          <thead>
            <tr>
              <th>Código</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="invoice-table-body">
            <!-- <tr>
              <td colspan="8" class="text-center">No hay facturas registradas</td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <!-- <div class="modal fade" id="facturacionModal" tabindex="-1" aria-labelledby="facturacionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar facturación</h5>
            <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Close"></button>
          </div>
          <form action="" style="flex-direction: column;">
            @csrf
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div> -->

  <script>
    window.onload = function () {
      var modalInstance = new bootstrap.Modal(document.getElementById('facturacionModal'));

      window.abrirModal = function () {
        modalInstance.show();
      }

      window.cerrarModal = function () {
        modalInstance.hide();
      }
    };

    // document.getElementById('generate-invoice').addEventListener('click', function () {
    //   const { jsPDF } = window.jspdf;
    //   const doc = new jsPDF();
    //   doc.text("Factura - Bepensa Izamal SA DE C.V", 10, 10);
    //   doc.save("factura.pdf");
    // });

    $(document).ready(function() {

      $("#facturacionDataTable").DataTable({
        "responsive": true,
        "lengthChange": false, 
        "autoWidth": false,
        'paging': true,
        "pageLength": 10,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
      }).buttons().container().appendTo('#facturacionDataTable_wrapper .col-md-6:eq(0)');
    });
  </script>
</div>
@endsection
@push('scripts')
@endpush

