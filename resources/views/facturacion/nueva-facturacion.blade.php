@extends('layout.app')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="card-title" style="font-weight: bolder">Agregar Facturación</h3>
    </div>
    <div class="card-body">
        <form id="facturacionForm" action="{{ route('facturacion.store') }}" method="POST" style="flex-direction: column;">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="proveedor" class="form-label">Proveedor</label>
                    <select name="proveedor_id" class="form-select form-control" required>
                        <option value="">Seleccionar</option>
                        @foreach (App\Models\Proveedor::all() as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->proveedor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select form-control" required>
                        <option value="">Seleccionar</option>
                        @foreach (App\Models\Cliente::where('activo', 1)->get() as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre_tienda }} - {{ $cliente->rfc }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="cfdi" class="form-label">CFDI</label>
                    <select name="cfdi_id" class="form-select form-control" required>
                        <option value="">Seleccionar</option>
                        @foreach (App\Models\CFDI::where('activo', 1)->get() as $cfdi)
                            <option value="{{ $cfdi->id }}">{{ $cfdi->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <hr>

            <!-- Buscar y agregar productos -->
            <div class="row">
              <div class="col-md-8" style="position: relative;">
                <label for="producto" class="form-label">Buscar Producto</label>
                <input type="text" id="buscarProducto" class="form-control" placeholder="Ingrese código o nombre">
                <select id="sugerencias" class="form-select mt-2" size="5" 
                    style="display: none; position: absolute; width: 100%; top: 100%; left: 0; z-index: 1000;">
                </select>
              </div>
            </div>

            <hr>

            <!-- Tabla de productos agregados -->
            <div class="table-responsive">
                <table class="table table-bordered" id="tablaProductos">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <hr>

            <!-- Total de la Facturación -->
            <div class="row">
                <div class="col-md-4">
                    <h4>Total: $ <span id="totalFactura">0.00</span></h4>
                    <input type="hidden" name="total" id="totalInput">
                </div>
            </div>

            <hr>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar Facturación</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let productosSeleccionados = [];

    // Buscar producto
    document.getElementById("buscarProducto").addEventListener("keyup", function () {
        let query = this.value;
        let sugerencias = document.getElementById("sugerencias");
        
        if (query.length > 2) {
            fetch(`/buscar-productos?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    sugerencias.innerHTML = "";
                    if (data.length > 0) {
                        sugerencias.style.display = "block"; 
                        data.forEach(producto => {
                            let option = document.createElement("option");
                            option.value = producto.id;
                            option.textContent = `${producto.codigo} - ${producto.nombre}`;
                            option.setAttribute("data-codigo", producto.codigo);
                            option.setAttribute("data-nombre", producto.nombre);
                            option.setAttribute("data-precio", producto.precio);
                            sugerencias.appendChild(option);
                        });
                    } else {
                        sugerencias.style.display = "none"; 
                    }
                });
        } else {
            sugerencias.style.display = "none"; 
        }
    });

    // Agregar producto desde el select
    document.getElementById("sugerencias").addEventListener("change", function () {
        let selectedOption = this.options[this.selectedIndex];
        let id = selectedOption.value;
        let codigo = selectedOption.getAttribute("data-codigo");
        let nombre = selectedOption.getAttribute("data-nombre");
        let precio = parseFloat(selectedOption.getAttribute("data-precio"));

        if (id) {
            agregarProducto(id, codigo, nombre, precio);
            this.style.display = "none";
        }
    });

    // Agregar producto a la tabla
    function agregarProducto(id, codigo, nombre, precio) {
        let cantidadInput = document.querySelector(`input[data-id="${id}"]`);
        
        if (cantidadInput) {
            // Si el producto ya está en la tabla, incrementa la cantidad
            cantidadInput.value = parseInt(cantidadInput.value) + 1;
            actualizarSubtotal(id);
        } else {
            // Si el producto no está, agrégalo a la tabla
            productosSeleccionados.push(id);
            let fila = `
                <tr id="fila-${id}">
                    <td>${codigo}</td>
                    <td>${nombre}</td>
                    <td>$${precio.toFixed(2)}</td>
                    <td>
                        <input type="number" name="cantidades[]" value="1" min="1" class="form-control cantidad" data-id="${id}" data-precio="${precio}" oninput="actualizarSubtotal(${id})">
                    </td>
                    <td id="subtotal-${id}">$${precio.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${id})">Eliminar</button>
                        <input type="hidden" name="productos[]" value="${id}">
                    </td>
                </tr>
            `;
            document.querySelector("#tablaProductos tbody").insertAdjacentHTML("beforeend", fila);
            actualizarTotal();
        }
    }


    // Actualizar subtotal
    function actualizarSubtotal(id) {
        let cantidadInput = document.querySelector(`input[data-id="${id}"]`);
        let cantidad = parseInt(cantidadInput.value) || 1;
        let precio = parseFloat(cantidadInput.dataset.precio);
        let subtotal = cantidad * precio;

        document.getElementById(`subtotal-${id}`).textContent = `$${subtotal.toFixed(2)}`;
        actualizarTotal();
    }

    // Calcular total
    function actualizarTotal() {
        let total = 0;
        document.querySelectorAll("td[id^='subtotal-']").forEach(subtotal => {
            total += parseFloat(subtotal.textContent.replace("$", ""));
        });
        document.getElementById("totalFactura").textContent = `${total.toFixed(2)}`;
        document.getElementById("totalInput").value = total.toFixed(2);
    }

    // Eliminar producto
    function eliminarProducto(id) {
        productosSeleccionados = productosSeleccionados.filter(prod => prod !== id);
        document.getElementById(`fila-${id}`).remove();
        actualizarTotal();
    }

    // Cuando se envía el formulario, asegúrate de actualizar el total final
    document.querySelector("form").addEventListener("submit", function () {
        actualizarTotal();
    });
</script>
@endpush
