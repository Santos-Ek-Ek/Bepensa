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
                  <button class="btn btn-primary btn-sm" onclick="abrirEditModal({{ json_encode($factura->load('productos.producto')) }})">
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
                  <input type="number" class="form-control" id="edit_total" name="total" required step="0.01" disabled>
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
    var productosDataTable = null;

    window.abrirEditModal = function (facturaData) {
        // Limpieza completa antes de abrir
        if (productosDataTable) {
            productosDataTable.destroy();
            $('#productos-tbody').empty();
            productosDataTable = null;
        }

        // Parsear datos
        const factura = typeof facturaData === 'string' ? JSON.parse(facturaData.replace(/&quot;/g, '"')) : facturaData;
        
        console.log('Factura a editar:', factura); // Depuración
        
        // Llenar datos básicos
        $('#edit_facturacion_id').val(factura.id);
        $('#edit_codigo').val(factura.codigo);
        $('#edit_total').val(factura.total);

        // Limpiar y reconstruir tabla de productos
        rebuildProductosTable(factura.productos);

        editModalInstance.show();
    };

    function rebuildProductosTable(productos) {
        const tbody = $('#productos-tbody');
        tbody.empty(); // Limpieza completa

        if (productos && productos.length > 0) {
            productos.forEach(p => {
                const nombre = p.producto ? p.producto.nombre : 'Producto no disponible';
                const subtotal = (p.precio * p.cantidad).toFixed(2);
                
                tbody.append(`
                    <tr data-id="${p.id}">
                        <td>${nombre}</td>
                        <td class="precio">${p.precio}</td>
                        <td><input type="number" class="form-control cantidad" 
                               value="${p.cantidad}" min="1"></td>
                        <td class="subtotal">${subtotal}</td>
                    </tr>
                `);
            });
        }

        // Destruir DataTable si existe
        if (productosDataTable) {
            productosDataTable.destroy();
        }

        // Crear nuevo DataTable con configuración mínima
        productosDataTable = $('#productosDataTable').DataTable({
            searching: false,
            paging: false,
            info: false,
            ordering: false,
            responsive: true,
            autoWidth: false,
            destroy: true // Permite recreación
        });

        // Eventos de cambio
        $('#productosDataTable').off('change', '.cantidad').on('change', '.cantidad', function() {
            const row = $(this).closest('tr');
            const precio = parseFloat(row.find('.precio').text());
            const cantidad = parseInt($(this).val()) || 0;
            const subtotal = (precio * cantidad).toFixed(2);
            row.find('.subtotal').text(subtotal);
            updateTotal();
        });
    }

    function updateTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            total += parseFloat($(this).text()) || 0;
        });
        $('#edit_total').val(total.toFixed(2));
    }

    window.cerrarEditModal = function() {
        // Limpieza completa al cerrar
        if (productosDataTable) {
            productosDataTable.destroy();
            $('#productos-tbody').empty();
            productosDataTable = null;
        }
        $('#edit_facturacion_id, #edit_codigo, #edit_total').val('');
        editModalInstance.hide();
    };

    // Envío del formulario
    $('#editFacturacionForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        const productos = [];
        $('#productos-tbody tr').each(function() {
            productos.push({
                id: $(this).data('id'),
                cantidad: $(this).find('.cantidad').val(),
                precio: parseFloat($(this).find('.precio').text())
            });
        });

        $.ajax({
            url: `/facturas/${$('#edit_facturacion_id').val()}`,
            type: 'POST',
            data: {
                _token: $('[name="_token"]').val(),
                _method: 'PUT',
                codigo: $('#edit_codigo').val(),
                total: $('#edit_total').val(),
                productos: productos
            },
            success: function(res) {
                alert(res.message || 'Actualizado correctamente');
                location.reload();
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert(xhr.responseJSON?.message || 'Error al actualizar');
            }
        });
    });
});

// DataTable principal
$(function() {
    $('#facturacionDataTable').DataTable({
        order: [[0, 'desc']],
        responsive: true,
        pageLength: 10
    });
});
</script>
</div>
@endsection
@push('scripts')
@endpush

