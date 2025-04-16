@extends('layout.app')
@section('content')


<div class="container" id="usuario">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title"><b>Lista de Usuarios</b></h3>
            <button type="button" class="btn btn-primary" style="margin-left: auto;" data-toggle="modal"
                data-target="#exampleModal" v-on:click="mostrarModal()">
                <i class="fas fa-plus"></i> Agregar usuario
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="usuarioTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                    <tr id="usuario-{{ $usuario->id }}">
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellidos }}</td>
                        <td>{{ $usuario->usuario }}</td>
                        <td>************</td>
                        <td>
                            <button class="btn btn-danger btn-eliminar" data-id="{{ $usuario->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <!--Agregar Usuario-->

        <!-- /Fin de Agregar Usuario -->

        <!-- Modal -->
        <div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==true"><b>Agregar Usuario</b>
                        </h5>
                        <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==false"><b>Editar Usuario</b>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formAgregarUsuario" style="flex-direction: column;">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="form-control" placeholder="Nombre" name="nombre"><br>
                            <input type="text" class="form-control" placeholder="Apellidos" name="apellidos"><br>
                            <input type="text" class="form-control" placeholder="Usuario" name="usuario"><br>
                            <select name="rol" id="" class="form-select">
                                <option value="Administrador">Administrador</option>
                                <option value="Usuario">Usuario</option>
                            </select><br>
                            <input type="password" class="form-control" placeholder="Contraseña" name="password"><br>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

</div>
</div>


@endsection
@push('scripts')
<script src="dist/js/usuarios/usuario.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $("#usuarioTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        'paging': true,
        "pageLength": 10,
        'searching': true,
        'ordering': true,
        'info': true,
    }).buttons().container().appendTo('#usuarioTable_wrapper .col-md-6:eq(0)');
});

// Manejar clic en botón eliminar
$(document).on('click', '.btn-eliminar', function() {
    const id = $(this).data('id');

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarUsuario(id);
        }
    });
});

// Función para eliminar usuario via AJAX
function eliminarUsuario(id) {
    $.ajax({
        url: '/usuarios/' + id,
        type: 'PUT',
        data: {
            _token: '{{ csrf_token() }}',
            activo: 0
        },
        beforeSend: function() {
            Swal.fire({
                title: 'Eliminando...',
                html: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        },
        success: function(response) {
            if (response.success) {
                // Eliminar la fila de la tabla
                $('#usuario-' + id).remove();

                Swal.fire(
                    '¡Eliminado!',
                    response.message,
                    'success'
                );
            } else {
                Swal.fire(
                    'Error',
                    response.message,
                    'error'
                );
            }
        },
        error: function(xhr) {
            let errorMsg = 'Ocurrió un error al eliminar el usuario';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            Swal.fire(
                'Error',
                errorMsg,
                'error'
            );
        }
    });
}

// Formulario de agregar usuario
$('#formAgregarUsuario').on('submit', function(e) {
    e.preventDefault();
    
    Swal.fire({
        title: 'Agregando usuario...',
        html: 'Por favor espera',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '/usuarios',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.success) {
                Swal.fire(
                    '¡Éxito!',
                    response.message,
                    'success'
                );
                
                // Cerrar el modal
                $('#ModalUsuario').modal('hide');
                
                // Recargar la página para ver el nuevo usuario
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                Swal.fire(
                    'Error',
                    response.message,
                    'error'
                );
            }
        },
        error: function(xhr) {
            let errorMsg = 'Ocurrió un error al agregar el usuario';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
                
                // Mostrar errores de validación
                if (xhr.responseJSON.errors) {
                    errorMsg = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMsg += value + '<br>';
                    });
                }
            }
            
            Swal.fire(
                'Error',
                errorMsg,
                'error'
            );
        }
    });
});

// Limpiar el formulario cuando se cierra el modal
$('#ModalUsuario').on('hidden.bs.modal', function () {
    $('#formAgregarUsuario')[0].reset();
});
</script>
@endpush