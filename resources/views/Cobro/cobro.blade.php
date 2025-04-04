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
                  <button class="btn btn-info btn-sm" onclick="abrirViewModal({{ json_encode($factura->load('productos.producto')) }})">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-primary btn-sm" onclick="abrirEditModal({{ json_encode($factura->load('productos.producto')) }})">
                      <i class="fas fa-pencil-alt"></i>
                  </button>
                  <form action="{{ route('facturacion.destroy', $factura->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">
                          <i class="fas fa-trash-alt"></i>
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

    <!-- Modal de edición -->
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
              <!-- Espacio para mensajes de error -->
              <div id="modal-error-container"></div>
              <input type="hidden" id="edit_facturacion_id" name="id">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="edit_codigo" class="form-label">Código</label>
                  <input type="text" class="form-control" id="edit_codigo" name="codigo" required disabled>
                </div>
                <div class="mb-3 col-md-6">
                  <label for="edit_total" class="form-label">Total</label>
                  <input type="number" class="form-control" id="edit_total" name="total" required step="0.01" disabled>
                </div>
              </div>
              
              <!-- Add Product Search -->
              <div class="row mb-3">
                <div class="col-md-8" style="position: relative;">
                  <label for="producto" class="form-label">Buscar Producto</label>
                  <input type="text" id="buscarProducto" class="form-control" placeholder="Ingrese código o nombre">
                  <select id="sugerencias" class="form-select mt-2" size="5" 
                      style="display: none; position: absolute; width: 100%; top: 100%; left: 0; z-index: 1000;">
                  </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                  <button type="button" id="agregarProductoBtn" class="btn btn-primary">Agregar Producto</button>
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
                          <th></th>
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

    <!-- Modal de Visualización (Solo lectura) -->
    <div class="modal fade" id="verFacturacionModal" tabindex="-1" aria-labelledby="verFacturacionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalles de Factura</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="cerrarViewModal()"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Código:</label>
                  <input type="text" class="form-control" id="view_codigo" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Cliente:</label>
                  <input type="text" class="form-control" id="view_cliente" readonly>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Fecha:</label>
                  <input type="text" class="form-control" id="view_fecha" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Total:</label>
                  <input type="text" class="form-control" id="view_total" readonly>
                </div>
              </div>
            </div>
            
            <h5>Productos</h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Cantidad</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody id="view-productos-tbody">
                <!-- Productos se llenarán con JS -->
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="cerrarViewModal()">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Modal de visualización
    var viewModalInstance = new bootstrap.Modal(document.getElementById('verFacturacionModal'));

    window.abrirViewModal = function(facturaData) {
    const factura = typeof facturaData === 'string' ? JSON.parse(facturaData.replace(/&quot;/g, '"')) : facturaData;
    
    // Convertir total a número si es necesario
    const total = typeof factura.total === 'string' ? parseFloat(factura.total) : factura.total;
    
    // Llenar datos básicos con validación
    $('#view_codigo').val(factura.codigo || '');
    $('#view_cliente').val(factura.cliente ? `${factura.cliente.nombre_tienda} - ${factura.cliente.rfc}` : 'Cliente no disponible');
    $('#view_fecha').val(factura.created_at ? new Date(factura.created_at).toLocaleDateString() : '');
    $('#view_total').val(total ? `$${Number(total).toFixed(2)}` : '$0.00');
    
    // Llenar productos
    const tbody = $('#view-productos-tbody');
    tbody.empty();
    
    if (factura.productos && factura.productos.length > 0) {
        factura.productos.forEach(p => {
            // Asegurarse que precio y cantidad sean números
            const precio = typeof p.precio === 'string' ? parseFloat(p.precio) : p.precio;
            const cantidad = typeof p.cantidad === 'string' ? parseInt(p.cantidad) : p.cantidad;
            const subtotal = (precio * cantidad).toFixed(2);
            const nombre = p.producto ? `${p.producto.codigo} - ${p.producto.nombre}` : 'Producto no disponible';
            
            tbody.append(`
                <tr>
                    <td>${nombre}</td>
                    <td>$${Number(precio).toFixed(2)}</td>
                    <td>${cantidad}</td>
                    <td>$${subtotal}</td>
                </tr>
            `);
        });
    } else {
        tbody.append('<tr><td colspan="4" class="text-center">No hay productos registrados</td></tr>');
    }
    
    viewModalInstance.show();
};

window.cerrarViewModal = function() {
    // Limpieza básica
    $('#view_codigo, #view_cliente, #view_fecha, #view_total').val('');
    $('#view-productos-tbody').empty();
    
    // Cerrar modal
    viewModalInstance.hide();
};

    // edicion 
    var editModalInstance = new bootstrap.Modal(document.getElementById('editarFacturacionModal'));
    var productosDataTable = null;
    var selectedProduct = null;

    window.abrirEditModal = function (facturaData) {
        // Limpiar errores previos
        $('#modal-error-message').remove();
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

        // Reset product search
        $('#buscarProducto').val('');
        $('#sugerencias').hide().empty();
        selectedProduct = null;

        editModalInstance.show();
    };

    function rebuildProductosTable(productos) {
        const tbody = $('#productos-tbody');
        tbody.empty(); // Limpieza completa

        if (productos && productos.length > 0) {
            // Group products by product_id and sum quantities
            const groupedProducts = {};
            productos.forEach(p => {
                const productId = p.producto_id;
                if (!groupedProducts[productId]) {
                    groupedProducts[productId] = {
                        id: p.id,
                        producto_id: productId,
                        codigo: p.producto ? p.producto.codigo : '',
                        nombre: p.producto ? p.producto.nombre : 'Producto no disponible',
                        precio: p.precio,
                        cantidad: 0
                    };
                }
                groupedProducts[productId].cantidad += p.cantidad;
            });

            // Add grouped products to table
            Object.values(groupedProducts).forEach(p => {
                const subtotal = (p.precio * p.cantidad).toFixed(2);
                
                tbody.append(`
                    <tr data-id="${p.id}" data-product-id="${p.producto_id}">
                        <td>${p.codigo} - ${p.nombre}</td>
                        <td class="precio">${p.precio}</td>
                        <td><input type="number" class="form-control cantidad" 
                              value="${p.cantidad}" min="1"></td>
                        <td class="subtotal">${subtotal}</td>
                        <td>
                          <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </td>
                    </tr>
                `);
            });
        }

        // Agregar evento para eliminar productos
        $('#productosDataTable').on('click', '.btn-eliminar-producto', function() {
          const row = $(this).closest('tr');
          row.addClass('producto-eliminado');
          row.hide();
          updateTotal(); // Actualizar el total inmediatamente
        });

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

    // Product search functionality
    $('#buscarProducto').on('input', function() {
        const query = $(this).val();
        if (query.length < 2) {
            $('#sugerencias').hide().empty();
            return;
        }

        $.ajax({
            url: '/buscar-productos',
            type: 'GET',
            data: { q: query },
            success: function(response) {
                const sugerencias = $('#sugerencias');
                sugerencias.empty();
                
                if (response.length > 0) {
                    response.forEach(producto => {
                        sugerencias.append(`<option value="${producto.id}" data-precio="${producto.precio}">${producto.codigo} - ${producto.nombre}</option>`);
                    });
                    sugerencias.show();
                } else {
                    sugerencias.hide();
                }
            }
        });
    });

    // Select product from suggestions
    $('#sugerencias').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        if (selectedOption.length) {
            selectedProduct = {
                id: selectedOption.val(),
                nombre: selectedOption.text(),
                precio: selectedOption.data('precio')
            };
        }
    });

    // Add product button
    $('#agregarProductoBtn').on('click', function() {
        if (!selectedProduct) {
            alert('Por favor seleccione un producto de la lista');
            return;
        }

        // Check if product already exists in the table
        const existingRow = $(`#productos-tbody tr[data-product-id="${selectedProduct.id}"]`);
        if (existingRow.length > 0) {
            // Increase quantity if product exists
            const cantidadInput = existingRow.find('.cantidad');
            cantidadInput.val(parseInt(cantidadInput.val()) + 1);
            cantidadInput.trigger('change');
        } else {
            // Add new product row
            const newRow = `
                <tr data-product-id="${selectedProduct.id}">
                    <td>${selectedProduct.nombre}</td>
                    <td class="precio">${selectedProduct.precio}</td>
                    <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
                    <td class="subtotal">${selectedProduct.precio}</td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm btn-eliminar-producto">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                </tr>
            `;
            $('#productos-tbody').append(newRow);
            updateTotal();
        }

        // Reset selection
        $('#buscarProducto').val('');
        $('#sugerencias').hide().empty();
        selectedProduct = null;
    });

    // Modificar la función updateTotal para ignorar filas ocultas
    function updateTotal() {
        let total = 0;
        $('#productos-tbody tr:visible').each(function() { // Solo filas visibles
            const subtotalText = $(this).find('.subtotal').text();
            total += parseFloat(subtotalText) || 0;
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

// Envío del formulario - Versión mejorada
$('#editFacturacionForm').off('submit').on('submit', function(e) {
    e.preventDefault();
    
    const productos = [];
    const nuevosProductos = [];
    const productosEliminados = [];

    // Contar productos visibles (no eliminados)
    const productosVisibles = $('#productos-tbody tr:visible').length;
    
    if(productosVisibles === 0) {
        mostrarErrorEnModal('Debe agregar al menos un producto');
        return;
    }

    $('#productos-tbody tr').each(function() {
        const row = $(this);
        const productoId = row.data('product-id');
        const facturaProductoId = row.data('id');
        
        if (row.hasClass('producto-eliminado')) {
            productosEliminados.push({
                id: facturaProductoId,
                producto_id: productoId
            });
        } else {
            const cantidad = parseInt(row.find('.cantidad').val()) || 0;
            const precio = parseFloat(row.find('.precio').text());
            
            if(cantidad <= 0) {
                mostrarErrorEnModal('La cantidad debe ser mayor a 0');
                return false; // Salir del each
            }
            
            const productoData = {
                producto_id: productoId,
                cantidad: cantidad,
                precio: precio
            };
            
            if (facturaProductoId) {
                productoData.id = facturaProductoId;
                productos.push(productoData);
            } else {
                nuevosProductos.push(productoData);
            }
        }
    });

    // Limpiar errores previos
    $('#modal-error-message').remove();
    
    $.ajax({
        url: `/facturas/${$('#edit_facturacion_id').val()}`,
        type: 'POST',
        data: {
            _token: $('[name="_token"]').val(),
            _method: 'PUT',
            codigo: $('#edit_codigo').val(),
            total: $('#edit_total').val(),
            productos: productos,
            nuevos_productos: nuevosProductos,
            productos_eliminados: productosEliminados
        },
        success: function(res) {
            if(res.success) {
                location.reload();
            } else {
                mostrarErrorEnModal(res.message || 'Error al actualizar');
            }
        },
        error: function(xhr) {
            let errorMsg = 'Error al actualizar la factura';
            if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            mostrarErrorEnModal(errorMsg);
        }
    });
});

// Función para mostrar errores en el modal
function mostrarErrorEnModal(mensaje) {
    // Eliminar mensajes anteriores
    $('#modal-error-message').remove();
    
    // Crear y mostrar nuevo mensaje
    const errorDiv = $('<div id="modal-error-message" class="alert alert-danger mt-3"></div>');
    errorDiv.text(mensaje);
    $('.modal-body').prepend(errorDiv);
    
    // Hacer scroll al mensaje
    $('.modal-body').animate({
        scrollTop: 0
    }, 500);
}
});

// Eliminar facturación
// En tu archivo JavaScript principal
document.addEventListener('DOMContentLoaded', function() {
    // Delegación de eventos para todos los formularios de eliminación
    $(document).on('submit', 'form[method="DELETE"]', function(e) {
        e.preventDefault();
        
        if(confirm('¿Estás seguro de eliminar esta factura?')) {
            const form = this;
            
            $.ajax({
                url: form.action,
                type: 'POST',
                data: {
                    _token: form.querySelector('[name="_token"]').value,
                    _method: 'DELETE'
                },
                success: function(res) {
                    if(res.success) {
                        // Si la respuesta incluye redirección
                        if(res.redirect) {
                            window.location.href = res.redirect;
                        } else {
                            // Recargar la página si no hay redirección
                            location.reload();
                        }
                    } else {
                        alert(res.message || 'Error al eliminar');
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Error en la solicitud');
                }
            });
        }
    });
});

// DataTable principal
$(function() {
    $('#facturacionDataTable').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        paging: true,
        pageLength: 10,
        searching: true,
        ordering: true,
        info: true,
        order: [[0, 'desc']],
      }).buttons().container().appendTo('#facturacionDataTable_wrapper .col-md-6:eq(0)');
});
</script>
</div>
@endsection
@push('scripts')
@endpush

