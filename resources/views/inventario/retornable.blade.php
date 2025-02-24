@extends('layout.app')
@section('content')

<div class="container" id="retornable">
    <div class="card">
                <div class="card-header" style="background-color: rgb(0, 174, 255);">
                  <h3 class="card-title"><b>INVENTARIO RETORNABLE</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="retornableTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>Tipo</th>
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
                        <tr v-for="retornable in retornables">
                          <td>Retornable</td>
                          <td>@{{ retornable.categoria }}</td>
                          <td>@{{ retornable.codigo }}</td>
                          <td>@{{ retornable.producto }}</td>
                          <td>@{{ retornable.paletas }}</td>
                          <td>@{{ retornable.saldos_c_tarimas }}</td>
                          <td>@{{ retornable.saldos_s_tarimas }}</td>
                          <td>@{{ retornable.total }}</td>

                        <td>
                          <button class="btn btn-primary">
                            <i class="fas fa-pencil-alt" @click="editarRetornables(retornable.id)"></i>
                          </button>
                          <button class="btn btn-danger">
                            <i class="fas fa-trash-alt" @click="eliminarRetornables(retornable.id)"></i>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  v-on:click="mostrarModal()">
                    Agregar
                  </button>
              </div>

  <!-- /Fin de Agregar Producto -->

  <!-- Modal -->
  <div class="modal fade" id="ModalRetornable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            {{-- <label for="">Tipo</label>
            <select class="form-control" v-model="id_tipo">
                <option v-for="t in tipos" v-bind:value="t.id">@{{ t.tipo }}</option>
            </select> --}}
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
        <button type="button" class="btn btn-success" @click="agregarRetornables" v-if="agregando==true">Guardar</button>
        <button type="button" class="btn btn-primary" @click="actualizarRetornables()" v-if="agregando==false">Actualizar</button>
        </div>
      </div>
    </div>
  </div>


  </div>


@endsection
@push('scripts')
<script src="dist/js/Inventarios/retornable.js"></script>
@endpush
