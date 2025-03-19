@extends('layout.app')
@section('content')

<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="card-title" style="font-weight: bolder">Lista de Clientes</h3>
    <button  type="button" class="btn btn-success" onclick="abrirAddModal()" style="margin-left: auto;">Agregar cliente</button>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped" id="clienteDataTable">
      <thead>
        <tr>
          <th>Nombre de la tienda</th>
          <th>Propietario</th>
          <th>Código CTE</th>
          <th>RFC</th>
          <th>Dirección</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($clientes as $cliente)
          <tr>
            <td>{{ $cliente->nombre_tienda }}</td>
            <td>{{ $cliente->propietario }}</td>
            <td>{{ $cliente->cod_cte }}</td>
            <td>{{ $cliente->rfc }}</td>
            <td>{{ $cliente->direccion }}</td>
            <td>
              <button class="btn btn-primary" onclick="abrirEditModal({{ $cliente }})">
                <i class="fas fa-pencil-alt"></i>
              </button>
              <button class="btn btn-danger" onclick="confirmarEliminar({{ $cliente->id }})">
                <i class="fas fa-trash-alt"></i>
              </button>
              <form id="delete-form-{{ $cliente->id }}" action="{{ route('eliminar-cliente', $cliente->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Crear -->
<div class="modal fade @if ($errors->any()) show d-block @endif" id="agregarClienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar cliente</h5>
        <button type="button" class="btn-close" onclick="cerrarAddModal()" aria-label="Close"></button>
      </div>
      <form id="crearClienteForm" action="{{ route('nuevo-cliente') }}" method="POST"  style="flex-direction: column;">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label for="">Nombre de la tienda</label>
                <input type="text" class="form-control" id="nombre_tienda" name="nombre_tienda">
                <small class="text-danger d-none" id="error_nombre_tienda"></small>
            </div>
            <div class="form-group">
                <label for="">Propietario</label>
                <input type="text" class="form-control" id="propietario" name="propietario">
                <small class="text-danger d-none" id="error_propietario"></small>
            </div>
            <div class="form-group">
                <label for="">Código CTE</label>
                <input type="text" class="form-control" id="cod_cte" name="cod_cte">
                <small class="text-danger d-none" id="error_cod_cte"></small>
            </div>
            <div class="form-group">
                <label for="">RFC</label>
                <input type="text" class="form-control" id="rfc" name="rfc" maxlength="13">
                <small class="text-danger d-none" id="error_rfc"></small>
            </div>
            <div class="form-group">
                <label for="">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
                <small class="text-danger d-none" id="error_direccion"></small>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="cerrarAddModal()">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit modal -->
<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Cliente</h5>
        <button type="button" class="btn-close" onclick="cerrarEditModal()" aria-label="Close"></button>
      </div>
      <form id="editClienteForm" action="" method="POST" style="flex-direction: column;">
        @csrf
        @method('PUT') <!-- Método para actualizar -->
        <div class="modal-body">
          <input type="hidden" id="edit_cliente_id" name="id"> <!-- Campo oculto con ID -->
          <div class="form-group">
            <label>Nombre de la tienda</label>
            <input type="text" class="form-control" id="edit_nombre_tienda" name="nombre_tienda">
            <small id="edit_error_nombre_tienda" class="text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label>Propietario</label>
            <input type="text" class="form-control" id="edit_propietario" name="propietario">
            <small id="edit_error_propietario" class="text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label>Código CTE</label>
            <input type="text" class="form-control" id="edit_cod_cte" name="cod_cte">
            <small id="edit_error_cod_cte" class="text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label>RFC</label>
            <input type="text" class="form-control" id="edit_rfc" name="rfc"maxlength="13">
            <small id="edit_error_rfc" class="text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" id="edit_direccion" name="direccion">
            <small id="edit_error_direccion" class="text-danger d-none"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="cerrarEditModal()">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@push('scripts')
  <script>
document.addEventListener("DOMContentLoaded", function () {

    var addModalInstance = new bootstrap.Modal(document.getElementById("agregarClienteModal"));
    var editModalInstance = new bootstrap.Modal(document.getElementById("editarClienteModal"));

    window.abrirAddModal = function () {
      $("#crearClienteForm")[0].reset();
      $(".text-danger").addClass("d-none");
      addModalInstance.show();
    };

    window.cerrarAddModal = function () {
      $("#crearClienteForm")[0].reset();
      $(".text-danger").addClass("d-none");
      addModalInstance.hide();
    }

    $("#crearClienteForm").submit(function (event) {
        event.preventDefault(); // Evita recargar la página

        $(".text-danger").addClass("d-none"); // Oculta errores previos

        let formData = $(this).serialize(); // Captura datos del formulario

        $.ajax({
            type: "POST",
            url: "{{ route('nuevo-cliente') }}",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    cerrarAddModal();
                    location.reload(); // Opcional: Recargar la tabla sin afectar la página
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    
                    if (errors.nombre_tienda) {
                        $("#error_nombre_tienda").text(errors.nombre_tienda[0]).removeClass("d-none");
                    }
                    if (errors.propietario) {
                        $("#error_propietario").text(errors.propietario[0]).removeClass("d-none");
                    }
                    if (errors.cod_cte) {
                        $("#error_cod_cte").text(errors.cod_cte[0]).removeClass("d-none");
                    }
                    if (errors.rfc) {
                        $("#error_rfc").text(errors.rfc[0]).removeClass("d-none");
                    }
                    if (errors.direccion) {
                        $("#error_direccion").text(errors.direccion[0]).removeClass("d-none");
                    }
                }
            },
        });
    });

        // Validación para el formulario de edición
        $("#editClienteForm").submit(function (event) {
        event.preventDefault(); // Evita recargar la página

        $(".text-danger").addClass("d-none"); // Oculta errores previos

        let formData = $(this).serialize(); // Captura datos del formulario

        $.ajax({
            type: "POST",
            url: $("#editClienteForm").attr("action"),
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    cerrarEditModal();
                    location.reload(); // Recargar la tabla sin afectar la página
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.nombre_tienda) {
                        $("#edit_error_nombre_tienda").text(errors.nombre_tienda[0]).removeClass("d-none");
                    }
                    if (errors.propietario) {
                        $("#edit_error_propietario").text(errors.propietario[0]).removeClass("d-none");
                    }
                    if (errors.cod_cte) {
                        $("#edit_error_cod_cte").text(errors.cod_cte[0]).removeClass("d-none");
                    }
                    if (errors.rfc) {
                        $("#edit_error_rfc").text(errors.rfc[0]).removeClass("d-none");
                    }
                    if (errors.direccion) {
                        $("#edit_error_direccion").text(errors.direccion[0]).removeClass("d-none");
                    }
                }
            },
        });
    });

    window.abrirEditModal = function (cliente) {
        $(".text-danger").addClass("d-none");
        document.getElementById("edit_cliente_id").value = cliente.id;
        document.getElementById("edit_nombre_tienda").value = cliente.nombre_tienda;
        document.getElementById("edit_propietario").value = cliente.propietario;
        document.getElementById("edit_cod_cte").value = cliente.cod_cte;
        document.getElementById("edit_rfc").value = cliente.rfc;
        document.getElementById("edit_direccion").value = cliente.direccion;

        document.getElementById("editClienteForm").action = "/clientes/" + cliente.id;

        editModalInstance.show();
    };

    window.cerrarEditModal = function () {
        $(".text-danger").addClass("d-none");
        editModalInstance.hide();
    };
});


    function confirmarEliminar(clienteId) {
      if (confirm('¿Estás seguro de que quieres eliminar este cliente?')) {
        document.getElementById('delete-form-' + clienteId).submit();
      }
    }

    $(document).ready(function() {
      $("#clienteDataTable").DataTable({
        "responsive": true,
        "lengthChange": false, 
        "autoWidth": false,
        'paging': true,
        "pageLength": 10,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
      }).buttons().container().appendTo('#clienteDataTable_wrapper .col-md-6:eq(0)');
    });



  
  </script>
  
@endpush