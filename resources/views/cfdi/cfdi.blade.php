@extends('layout.app')
@section('content')

<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <h3 class="card-title" style="font-weight: bolder">Lista de CFDI</h3>
    <button  type="button" class="btn btn-success" onclick="abrirAddModal()" style="margin-left: auto;">Agregar CFDI</button>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped" id="cfdiDataTable">
      <thead>
        <tr>
          <th>Folio</th>
          <th>CFDI</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($cfdis as $cfdi)
          <tr>
            <td>{{ $cfdi->folio }}</td>
            <td>{{ $cfdi->nombre }}</td>
            <td>
              <button class="btn btn-primary" onclick="abrirEditModal({{ $cfdi }})">
                <i class="fas fa-pencil-alt"></i>
              </button>
              <button class="btn btn-danger" onclick="confirmarEliminar({{ $cfdi->id }})">
                <i class="fas fa-trash-alt"></i>
              </button>
              <form id="delete-form-{{ $cfdi->id }}" action="{{ route('eliminar-cfdi', $cfdi->id) }}" method="POST" style="display: none;">
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
<div class="modal fade  @if ($errors->any()) show d-block @endif" id="agregarCDFIModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar cliente</h5>
        <button type="button" class="btn-close" onclick="cerrarAddModal()" aria-label="Close"></button>
      </div>
      <form id="crearCFDIForm" action="{{ route('nuevo-cfdi') }}" method="POST" style="flex-direction: column;">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="">Folio</label>
            <input type="text" class="form-control" placeholder="Folio" name="folio">
            <small class="text-danger d-none" id="error_folio"></small>
          </div>
          <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" name="nombre">
            <small class="text-danger d-none" id="error_nombre"></small>
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
<div class="modal fade" id="editarCFDIModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar CFDI</h5>
        <button type="button" class="btn-close" onclick="cerrarEditModal()" aria-label="Close"></button>
      </div>
      <form id="editCFDIForm" action="" method="POST" style="flex-direction: column;">
        @csrf
        @method('PUT') <!-- Método para actualizar -->
        <div class="modal-body">
          <input type="hidden" id="edit_cfdi_id" name="id"> <!-- Campo oculto con ID -->
          <div class="form-group">
            <label>Folio</label>
            <input type="text" class="form-control" id="edit_folio" name="folio">
            <small id="edit_error_folio" class="text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" id="edit_nombre" name="nombre">
            <small id="edit_error_nombre" class="text-danger d-none"></small>
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
    window.onload = function () {
      var addModalInstance = new bootstrap.Modal(document.getElementById('agregarCDFIModal'));
      var editModalInstance = new bootstrap.Modal(document.getElementById('editarCFDIModal'));

      window.abrirAddModal = function () {
        $("#crearCFDIForm")[0].reset();
        $(".text-danger").addClass("d-none");
        addModalInstance.show();
      }

      window.cerrarAddModal = function () {
        $("#crearCFDIForm")[0].reset();
        $(".text-danger").addClass("d-none");
        addModalInstance.hide();
      }

      
      $("#crearCFDIForm").submit(function (event) {
          event.preventDefault(); // Evita recargar la página

          $(".text-danger").addClass("d-none"); // Oculta errores previos

          let formData = $(this).serialize(); // Captura datos del formulario

          $.ajax({
              type: "POST",
              url: "{{ route('nuevo-cfdi') }}",
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
                      
                      if (errors.folio) {
                          $("#error_folio").text(errors.folio[0]).removeClass("d-none");
                      }
                      if (errors.nombre) {
                          $("#error_nombre").text(errors.nombre[0]).removeClass("d-none");
                      }
                  }
              },
          });
      });

              // Validación para el formulario de edición
      $("#editCFDIForm").submit(function (event) {
          event.preventDefault(); // Evita recargar la página

          $(".text-danger").addClass("d-none"); // Oculta errores previos

          let formData = $(this).serialize(); // Captura datos del formulario

          $.ajax({
              type: "POST",
              url: $("#editCFDIForm").attr("action"),
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

                      if (errors.folio) {
                          $("#edit_error_folio").text(errors.folio[0]).removeClass("d-none");
                      }
                      if (errors.nombre) {
                          $("#edit_error_nombre").text(errors.nombre[0]).removeClass("d-none");
                      }
                  }
              },
          });
      });

      window.abrirEditModal = function (cfdi) {
        $(".text-danger").addClass("d-none");
        // Llenar el formulario con los datos del cfdi seleccionado
        document.getElementById('edit_cfdi_id').value = cfdi.id;
        document.getElementById('edit_folio').value = cfdi.folio;
        document.getElementById('edit_nombre').value = cfdi.nombre;

        // Actualizar la acción del formulario con la ruta correcta
        document.getElementById('editCFDIForm').action = "/cfdi/" + cfdi.id;

        // Mostrar el modal
        editModalInstance.show();
      }

      window.cerrarEditModal = function () {
        $(".text-danger").addClass("d-none");
        editModalInstance.hide();
      }
    };

    function confirmarEliminar(cfdiId) {
      if (confirm('¿Estás seguro de que quieres eliminar este cfdi?')) {
        document.getElementById('delete-form-' + cfdiId).submit();
      }
    }

    $(document).ready(function() {
      $("#cfdiDataTable").DataTable({
        "responsive": true,
        "lengthChange": false, 
        "autoWidth": false,
        'paging': true,
        "pageLength": 10,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
      }).buttons().container().appendTo('#cfdiDataTable_wrapper .col-md-6:eq(0)');
    });
  </script>
@endpush