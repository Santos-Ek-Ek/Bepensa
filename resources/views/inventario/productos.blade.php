{{-- @extends('layout.app')
@section('content')

<div class="container" id="producto">

    <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>PRODUCTOS</b></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered table-striped">

            <thead>
            <tr>
              <th>Código</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Categoria</th>
              <th>Tipo</th>
              <th>Acciones</th>

              </thead>

              <tbody>
                <tr v-for="producto in productos">
                  <td>@{{ producto.codigo }}</td>
                  <td>@{{ producto.nombre }}</td>
                  <td>@{{ producto.descripcion }}</td>
                  <td>@{{ producto.categorias.nombre }}</td>
                  <td>@{{ producto.categorias.tipos.tipo }}</td>

                <td>
                    <button class="btn btn-primary">
                        <i class="fas fa-pencil-alt"></i>
                      </button>
                      <button class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                </td>

                </tr>



              </tbody>

              </table>




        </div>
        <!-- /.card-body -->

<!-- /Agregar producto -->


</div>

@endsection
@push('scripts')
<script src="dist/js/productos/producto.js"></script>
@endpush


 --}}

 @extends('layout.app')
 @section('content')
 <div class="container" id="producto">
    <div class="card">
        <div class="card-header" style="background-color: rgb(0, 174, 255);">
          <h3 class="card-title"><b>PRODUCTOS</b></h3>
          {{-- <h3 class="card-title"><b><span style="color: white;">PRODUCTOS</span></b></h3> --}}

          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              {{-- <input type="text" name="table_search" class="form-control float-right" placeholder="Search"> --}}
              <div class="input-group-append">
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" v-on:click="mostrarModal()">
                  Agregar Producto
                </button> --}}
                <button type="button" class="btn btn" style="background-color: rgb(255, 255, 255)" data-toggle="modal" data-target="#exampleModal" v-on:click="mostrarModal()">
                    <i class="fas fa-plus"></i>
                    </button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="height: 500px;">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>

                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Tipo</th>
                <th>Acciones</th>

              </tr>
            </thead>
            <tbody>
                <tr v-for="producto in productos">
                  <td>@{{ producto.codigo }}</td>
                  <td>@{{ producto.nombre }}</td>
                  <td>@{{ producto.categorias.nombre }}</td>
                  <td>@{{ producto.categorias.tipos.tipo }}</td>

                  <td>
                    {{-- <button class="btn btn-primary">
                      <i class="fas fa-pencil-alt" @click="editarProductos(producto.id)"></i>
                    </button> --}}
                    <button class="btn btn-danger">
                      <i class="fas fa-trash-alt" @click="eliminarProductos(producto.id)"></i>
                    </button>
                  </td>
                </tr>
            </tbody>
          </table>

    <!--Modal-->
    <!-- /Agregar producto -->


<!-- /Fin de Agregar Producto -->

<!-- Modal -->
<div class="modal fade" id="ModalProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel" v-if="agregando==true"><b>Agregar Producto</b></h5>
<h5 class="modal-title" id="exampleModalLabel" v-if="agregando==false"><b>Editar Producto</b></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

    <div class="form-group">
        <label for="">Código</label>
        <input type="text" class="form-control" placeholder="Código" v-model="codigo">
    </div>
    <div class="form-group">
        <label for="">Nombre de Producto</label>
        <input type="text" class="form-control" placeholder="Nombre" v-model="nombre">
    </div>
    <div class="form-group">
        <label for="">Categoría</label>
        <select class="form-control" v-model="id_categoria">
            <option v-for="c in categorias" v-bind:value="c.id">@{{ c.nombre }} - @{{ c.tipos.tipo }}</option>
        </select>
    </div>






</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
<button type="button" class="btn btn-success" @click="agregarProductos" v-if="agregando==true">Guardar</button>
<button type="button" class="btn btn-primary" @click="actualizarProductos()" v-if="agregando==false">Actualizar</button>
</div>
</div>
</div>
</div>
        <!-- /.card-body -->
      </div>
</div>
<!--Fin Modal-->

@endsection
@push('scripts')
<script src="dist/js/productos/producto.js"></script>
@endpush
