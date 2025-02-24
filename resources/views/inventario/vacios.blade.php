@extends('layout.app')
@section('content')



<div class="container" id="vacio">
    <div class="card">
                <div class="card-header" style="background-color: rgb(0, 174, 255);">
                  <h3 class="card-title"><b>INVENTARIO, VACIOS, PLÁSTICOS Y OTROS</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="vacioTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>

                      <th>Categoría</th>
                      <th>Código</th>
                      <th>Producto</th>
                      <th>Paleta(s)</th>
                      <th>Total/C Tarimas</th>
                      <th>Total/S Tarimas</th>
                      <th>Total</th>
                      <th class="no-export">Acciones</th>
                      </thead>

                      <tbody>
                        <tr v-for="vacio in vacios">

                            <td>@{{ vacio.categoria }}</td>
                            <td>@{{ vacio.codigo }}</td>
                            <td>@{{ vacio.producto }}</td>
                            <td>@{{ vacio.paletas }}</td>
                            <td>@{{ vacio.saldos_c_tarimas }}</td>
                            <td>@{{ vacio.saldos_s_tarimas }}</td>
                            <td>@{{ vacio.total }}</td>

                        <td>
                            <button class="btn btn-primary">
                                <i class="fas fa-pencil-alt" @click="editarVacios(vacio.id)"></i>
                              </button>
                              <button class="btn btn-danger">
                                <i class="fas fa-trash-alt" @click="eliminarVacios(vacio.id)"></i>
                              </button>
                        </td>

                        </tr>



                      </tbody>



                        </tfoot>
                      </table>
                    </tr>


                </div>
                <!-- /.card-body -->

  <!-- /Agregar producto -->

              <div class="col-sm-12 mb-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" v-on:click="mostrarModal()">
                    Agregar
                  </button>
              </div>

  <!-- /Fin de Agregar Producto -->

   <!-- Modal -->
   <div class="modal fade" id="ModalVacio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==true"><b>Agregar</b></h5>
    <h5 class="modal-title" id="exampleModalLabel" v-if="agregando==false"><b>Editar</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
        <div class="modal-body">

        <div class="form-group">
            <label for="">Productos</label>
            <select class="form-control" v-model="id_producto">
                <option v-for="p in productos" v-bind:value="p.id">@{{ p.nombre }}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Paletas</label>
            <input type="number" class="form-control" placeholder="Paletas" v-model="paletas"><br>
          </div>
          <div class="form-group">
              <label for="">Total Con Tarimas</label>
            <input type="number" class="form-control" placeholder="Total con Tarimas" v-model="saldos_c_tarimas"><br>
          </div>
          <div class="form-group">
              <label for="">Total Sin Tarimas</label>
            <input type="number" class="form-control" placeholder="Total sin Tarimas" v-model="saldos_s_tarimas"><br>
          </div>
          <div class="form-group">
              <label for="">Total</label>
            <input type="number" class="form-control" placeholder="Total" v-model="total">
          </div>



        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" @click="agregarVacios()" v-if="agregando==true">Guardar</button>
        <button type="button" class="btn btn-primary" @click="actualizarVacios()" v-if="agregando==false">Actualizar</button>
        </div>
      </div>
    </div>
  </div>



  </div>



@endsection
@push('scripts')
<script src="dist/js/Inventarios/vacio.js"></script>
@endpush
