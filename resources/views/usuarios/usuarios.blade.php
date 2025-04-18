@extends('layout.app')
@section('content')


<div class="container">
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title">Lista de Usuarios</h3>
            <button type="button" class="btn btn-success" style="margin-left: auto;" onclick="abrirAddModal()">
                <i class="fas fa-plus"></i> Agregar usuario
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="usuarioDataTable" class="table table-bordered table-striped">
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
                            <button class="btn btn-primary btn-sm" title="Editar facturación" onclick="">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-eliminar" data-id="{{ $usuario->id }}">
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

        <!-- Modal Crear -->
        <div class="modal fade @if ($errors->any()) show d-block @endif" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
                        <button type="button" class="btn-close" onclick="cerrarAddModal()" aria-label="Close"></button>
                    </div>
                    <form id="crearUsuarioForm" style="flex-direction: column;">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre">
                                <small class="text-danger d-none" id="error_nombre"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Apellidos</label>
                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos">
                                <small class="text-danger d-none" id="error_apellidos"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Usuario</label>
                                <input type="text" class="form-control" placeholder="Usuario" name="usuario">
                                <small class="text-danger d-none" id="error_usuario"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Contraseña</label>
                                <input type="password" class="form-control" placeholder="Contraseña" name="password">
                                <small class="text-danger d-none" id="error_password"></small>
                            </div>
                            <div class="form-group">
                                <label for="">Rol</label>
                                <select name="rol" id="" class="form-select">
                                    <option value="">Selecciona el rol</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Usuario">Usuario</option>
                                </select>
                                <small class="text-danger d-none" id="error_rol"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="cerrarAddModal()">Cerrar</button>
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
<!-- <script src="dist/js/usuarios/usuario.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        var addModalInstance = new bootstrap.Modal(document.getElementById("agregarUsuarioModal"));
        // var editModalInstance = new bootstrap.Modal(document.getElementById("editarClienteModal"));
        console.log(addModalInstance);

        window.abrirAddModal = function () {
            $("#crearUsuarioForm")[0].reset();
            $(".text-danger").addClass("d-none");
            addModalInstance.show();
        };

        window.cerrarAddModal = function () {
            $("#crearUsuarioForm")[0].reset();
            $(".text-danger").addClass("d-none");
            addModalInstance.hide();
        }

        $("#crearUsuarioForm").submit(function (event) {
            event.preventDefault(); // Evita recargar la página

            $(".text-danger").addClass("d-none"); // Oculta errores previos

            let formData = $(this).serialize(); // Captura datos del formulario

            $.ajax({
                type: "POST",
                url: '/usuarios',
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            '¡Éxito!',
                            response.message,
                            'success'
                        );
                        cerrarAddModal();
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
                error: function (xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        
                        if (errors.nombre) {
                            $("#error_nombre").text(errors.nombre[0]).removeClass("d-none");
                        }
                        if (errors.apellidos) {
                            $("#error_apellidos").text(errors.apellidos[0]).removeClass("d-none");
                        }
                        if (errors.usuario) {
                            $("#error_usuario").text(errors.usuario[0]).removeClass("d-none");
                        }
                        if (errors.password) {
                            $("#error_password").text(errors.password[0]).removeClass("d-none");
                        }
                        if (errors.rol) {
                            $("#error_rol").text(errors.rol[0]).removeClass("d-none");
                        }
                    }
                },
            });
        });

        //     // Validación para el formulario de edición
        //     $("#editClienteForm").submit(function (event) {
        //     event.preventDefault(); // Evita recargar la página

        //     $(".text-danger").addClass("d-none"); // Oculta errores previos

        //     let formData = $(this).serialize(); // Captura datos del formulario

        //     $.ajax({
        //         type: "POST",
        //         url: $("#editClienteForm").attr("action"),
        //         data: formData,
        //         dataType: "json",
        //         success: function (response) {
        //             if (response.success) {
        //                 cerrarEditModal();
        //                 location.reload(); // Recargar la tabla sin afectar la página
        //             }
        //         },
        //         error: function (xhr) {
        //             if (xhr.responseJSON && xhr.responseJSON.errors) {
        //                 let errors = xhr.responseJSON.errors;

        //                 if (errors.nombre_tienda) {
        //                     $("#edit_error_nombre_tienda").text(errors.nombre_tienda[0]).removeClass("d-none");
        //                 }
        //                 if (errors.propietario) {
        //                     $("#edit_error_propietario").text(errors.propietario[0]).removeClass("d-none");
        //                 }
        //                 if (errors.cod_cte) {
        //                     $("#edit_error_cod_cte").text(errors.cod_cte[0]).removeClass("d-none");
        //                 }
        //                 if (errors.rfc) {
        //                     $("#edit_error_rfc").text(errors.rfc[0]).removeClass("d-none");
        //                 }
        //                 if (errors.direccion) {
        //                     $("#edit_error_direccion").text(errors.direccion[0]).removeClass("d-none");
        //                 }
        //             }
        //         },
        //     });
        // });

        // window.abrirEditModal = function (cliente) {
        //     $(".text-danger").addClass("d-none");
        //     document.getElementById("edit_cliente_id").value = cliente.id;
        //     document.getElementById("edit_nombre_tienda").value = cliente.nombre_tienda;
        //     document.getElementById("edit_propietario").value = cliente.propietario;
        //     document.getElementById("edit_cod_cte").value = cliente.cod_cte;
        //     document.getElementById("edit_rfc").value = cliente.rfc;
        //     document.getElementById("edit_direccion").value = cliente.direccion;

        //     document.getElementById("editClienteForm").action = "/clientes/" + cliente.id;

        //     editModalInstance.show();
        // };

        // window.cerrarEditModal = function () {
        //     $(".text-danger").addClass("d-none");
        //     editModalInstance.hide();
        // };
    });
$(document).ready(function() {
    $("#usuarioDataTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        'paging': true,
        "pageLength": 10,
        'searching': true,
        'ordering': true,
        'info': true,
    }).buttons().container().appendTo('#usuarioDataTable_wrapper .col-md-6:eq(0)');
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
// $('#formAgregarUsuario').on('submit', function(e) {
//     e.preventDefault();
    
//     Swal.fire({
//         title: 'Agregando usuario...',
//         html: 'Por favor espera',
//         allowOutsideClick: false,
//         didOpen: () => {
//             Swal.showLoading();
//         }
//     });

//     $.ajax({
//         url: '/usuarios',
//         type: 'POST',
//         data: $(this).serialize(),
//         success: function(response) {
//             if (response.success) {
//                 Swal.fire(
//                     '¡Éxito!',
//                     response.message,
//                     'success'
//                 );
                
//                 // Cerrar el modal
//                 $('#agregarUsuarioModal').modal('hide');
                
//                 // Recargar la página para ver el nuevo usuario
//                 setTimeout(() => {
//                     location.reload();
//                 }, 1500);
//             } else {
//                 Swal.fire(
//                     'Error',
//                     response.message,
//                     'error'
//                 );
//             }
//         },
//         error: function(xhr) {
//             let errorMsg = 'Ocurrió un error al agregar el usuario';
//             if (xhr.responseJSON && xhr.responseJSON.message) {
//                 errorMsg = xhr.responseJSON.message;
                
//                 // Mostrar errores de validación
//                 if (xhr.responseJSON.errors) {
//                     errorMsg = '';
//                     $.each(xhr.responseJSON.errors, function(key, value) {
//                         errorMsg += value + '<br>';
//                     });
//                 }
//             }
            
//             Swal.fire(
//                 'Error',
//                 errorMsg,
//                 'error'
//             );
//         }
//     });
// });

// // Limpiar el formulario cuando se cierra el modal
// $('#agregarUsuarioModal').on('hidden.bs.modal', function () {
//     $('#formAgregarUsuario')[0].reset();
// });
</script>
@endpush