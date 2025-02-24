@extends('layout.app')
@section('content')



<div class="container" id="proveedor">
    <div class="card">
        <div class="card-header" style="background-color: rgb(0, 174, 255);">
          <h3 class="card-title"><b>PROVEEDORES</b></h3>

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 160px;">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>

                <th>Proveedor</th>
                <th>Dirección</th>
                <th>Producto</th>
                <th>Acciones</th>

              </tr>
            </thead>
            <tbody>
                <tr v-for="proveedor in proveedores">

                <td>@{{ proveedor.proveedor }}</td>
                <td>@{{ proveedor.direccion }}</td>
                <td>@{{ proveedor.tipo_producto }}</td>

                <td>
                    <button class="btn btn-primary">
                      <i class="fas fa-pencil-alt" @click="editarProveedores(proveedor.id)"></i>
                    </button>
                    <button class="btn btn-danger">
                      <i class="fas fa-trash-alt" @click="eliminarProveedores(proveedor.id)"></i>
                    </button>
                  </td>

              </tr>

            </tbody>

          </table>


        </div>


  <!-- /Agregar producto -->

  <div class="col-sm-12 mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" v-on:click="mostrarModal()">
        Agregar Proveedor
      </button>
  </div>

<!-- /Fin de Agregar Producto -->

<!-- Modal -->
<div class="modal fade" id="ModalProveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel" v-if="agregando==true"><b>Agregar Proveedor</b></h5>
<h5 class="modal-title" id="exampleModalLabel" v-if="agregando==false"><b>Editar Proveedor</b></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<input type="text" class="form-control" placeholder="Proveedor" v-model="proveedor"><br>
<input type="text" class="form-control" placeholder="Dirección" v-model="direccion"><br>
<input type="text" class="form-control" placeholder="Producto" v-model="tipo_producto">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
<button type="button" class="btn btn-success" @click="agregarProveedores" v-if="agregando==true">Guardar</button>
<button type="button" class="btn btn-primary" @click="actualizarProveedores()" v-if="agregando==false">Actualizar</button>
</div>
</div>
</div>
</div>
        <!-- /.card-body -->
      </div>
</div>


@endsection
@push('scripts')
 <script src="dist/js/proveedores/proveedor.js"></script>
@endpush
