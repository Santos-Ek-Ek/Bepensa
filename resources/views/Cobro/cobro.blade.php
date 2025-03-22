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
            @foreach ($cobros as $factura)
              <tr>
                <td>{{ $factura->codigo }}</td>
                <td>{{ $factura->cliente->nombre_tienda }} - {{ $factura->cliente->rfc }}</td>
                <td>{{ $factura->created_at->format('d/m/Y') }}</td>
                <td>${{ $factura->total }}</td>
                <td></td>
                <td>
                  <a href="" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i>
                  </a>
                  <button class="btn btn-primary btn-sm" onclick="abrirEditModal({{ $factura }})">
                    <i class="fas fa-pencil-alt"></i>
                  </button>
                  <form action="" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt "></i>
                      </button>
                  </form>
                </td>
              </tr>
            @endforeach
            <!-- <tr>
              <td colspan="8" class="text-center">No hay facturas registradas</td>
            </tr> -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editarFacturacionModal" tabindex="-1" aria-labelledby="facturacionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar facturación</h5>
            <button type="button" class="btn-close" onclick="cerrarEditModal()" aria-label="Close"></button>
          </div>
          <form id="editFacturacionForm" action="" method="POST"  style="flex-direction: column;">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <input type="hidden" id="edit_facturacion_id" name="id">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="edit_codigo" class="form-label">Código</label>
                  <input type="text" class="form-control" id="edit_codigo" name="codigo" required>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="edit_total" class="form-label">Total</label>
                  <input type="number" class="form-control" id="edit_total" name="total" required>
                </div>
              </div>
              <h5>Productos</h5>
              <table class="table table-bordered" id="productosDataTable">
                  <thead>
                      <tr>
                          <th>Producto</th>
                          <th>Precio</th>
                          <th>Cantidad</th>
                          <th>Subtotal</th>
                      </tr>
                  </thead>
                  <tbody id="productos-tbody">
                      <!-- Aquí se llenarán los productos con JS -->
                  </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="cerrarEditModal()">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var editModalInstance = new bootstrap.Modal(document.getElementById('editarFacturacionModal'));

      window.abrirEditModal = function (factura) {
        document.getElementById("edit_facturacion_id").value = factura.id;
        document.getElementById("edit_codigo").value = factura.codigo;
        document.getElementById("edit_total").value = factura.total;

        let productosTbody = document.getElementById("productos-tbody");
        productosTbody.innerHTML = ""; // Limpiar la tabla antes de llenarla

        factura.productos.forEach(producto => {
            let fila = `
                <tr data-id="${producto.id}">
                    <td>${producto.producto.nombre}</td>
                    <td class="precio">${producto.precio}</td>
                    <td><input type="number" class="form-control cantidad" value="${producto.cantidad}" min="1"></td>
                    <td class="subtotal">${(producto.precio * producto.cantidad).toFixed(2)}</td>
                </tr>
            `;
            productosTbody.innerHTML += fila;
        });

        
        // Destruir cualquier instancia anterior del DataTable
        if ($.fn.dataTable.isDataTable('#productosDataTable')) {
          $('#productosDataTable').DataTable().destroy();
        }

        // Inicializar el DataTable después de llenar la tabla con productos
        $("#productosDataTable").DataTable({
          "responsive": true,
          "lengthChange": false, 
          "autoWidth": false,
          'paging': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
        }).buttons().container().appendTo('#productosDataTable_wrapper .col-md-6:eq(0)');

        actualizarTotal();

        editModalInstance.show();
      }

      document.addEventListener("input", function (event) {
        if (event.target.classList.contains("cantidad")) {
            let fila = event.target.closest("tr");
            let precio = parseFloat(fila.querySelector(".precio").textContent);
            let cantidad = parseInt(event.target.value) || 1;

            let subtotal = precio * cantidad;
            fila.querySelector(".subtotal").textContent = subtotal.toFixed(2);

            actualizarTotal();
        }
      });

      function actualizarTotal() {
          let total = 0;
          document.querySelectorAll("#productos-tbody tr").forEach(fila => {
              total += parseFloat(fila.querySelector(".subtotal").textContent);
          });
          document.getElementById("edit_total").value = total.toFixed(2);
      }

      window.cerrarEditModal = function () {
        editModalInstance.hide();
      }
    });


    $(document).ready(function () {
    $("#editFacturacionForm").submit(function (event) {
        event.preventDefault();

        let facturaId = $("#edit_facturacion_id").val();
        let productos = [];

        $("#productos-tbody tr").each(function () {
            productos.push({
                id: $(this).attr("data-id"),
                cantidad: $(this).find(".cantidad").val()
            });
        });

        let data = {
            id: facturaId,
            codigo: $("#edit_codigo").val(),
            total: $("#edit_total").val(),
            productos: productos
        };

        $.ajax({
            url: `/facturas/${facturaId}`,
            type: "PUT",
            headers: {
                "X-CSRF-TOKEN":  document.querySelector("#token").getAttribute("value"),
            },
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function (response) {
                alert("Factura actualizada correctamente");
                location.reload();
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                alert("Error al actualizar la factura. Revisa la consola para más detalles.");
            }
        });
    });
});

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
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        "order": [[0, "desc"]],
      }).buttons().container().appendTo('#facturacionDataTable_wrapper .col-md-6:eq(0)');
    });
  </script>
</div>
@endsection
@push('scripts')
@endpush

