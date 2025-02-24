@extends('layout.app')
@section('content')


<div class="container" id="usuario">
    <div class="card">
        <div class="card-header" style="background-color: rgb(0, 174, 255);">
          <h3 class="card-title"><b>USUARIOS</b></h3>
            <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <div class="input-group-append">
                <button type="button" class="btn btn" style="background-color: rgb(255, 255, 255)" data-toggle="modal" data-target="#exampleModal" v-on:click="mostrarModal()">
                    <i class="fas fa-plus"></i>
                    </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 150px;">
            <table id="usuarioTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="usuario in usuarios">

                <td>@{{ usuario.nombre }}</td>
                <td>@{{ usuario.apellidos }}</td>
                <td>@{{ usuario.usuario }}</td>
                <td>************</td>
                <td>
                    <button class="btn btn-danger">
                        <i class="fas fa-trash-alt" @click="eliminarUsuarios(usuario.id)"></i>
                      </button>
                </td>
              </tr>
              <tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
<!--Agregar Usuario-->

        <!-- /Fin de Agregar Usuario -->

        <!-- Modal -->
        <div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==true"><b>Agregar Usuario</b></h5>
        <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==false"><b>Editar Usuario</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">

        <input type="text" class="form-control" placeholder="Nombre" v-model="nombre"><br>
        <input type="text" class="form-control" placeholder="Apellidos" v-model="apellidos"><br>
        <input type="text" class="form-control" placeholder="Usuario" v-model="usuario"><br>
        <input type="text" class="form-control" placeholder="Contraseña" v-model="password"><br>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" @click="agregarUsuarios()" v-if="agregando==true">Guardar</button>
        {{-- <button type="button" class="btn btn-primary" @click="actualizarUsuarios()" v-if="agregando==false">Actualizar</button> --}}
        </div>
        </div>
        </div>
        </div>

      </div>
</div>


@endsection
@push('scripts')
<script src="dist/js/usuarios/usuario.js"></script>
@endpush
