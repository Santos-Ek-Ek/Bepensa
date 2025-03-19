@extends('layout.app')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title fw-bold">Agregar Facturación</h3>
  </div>

  <div class="card-body">
    <form action="{{ route('crear-facturacion') }}" method="POST" style="flex-direction: column;">
      @csrf
      
      <div class="row g-3">
        <div class="col-md-4">
          <label for="provider" class="form-label">Proveedor</label>
          <select name="proveedor_id" class="form-select form-control" required>
            <option value="">Seleccionar</option>
            @foreach ($proveedores as $proveedor)
              <option value="{{ $proveedor->id }}">{{ $proveedor->proveedor }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="client" class="form-label">Cliente</label>
          <select name="cliente_id" class="form-select form-control" required>
            <option value="">Seleccionar</option>
            @foreach ($clientes as $cliente)
              <option value="{{ $cliente->id }}">{{ $cliente->nombre_tienda }} - {{ $cliente->rfc }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="cfdi" class="form-label">CFDI</label>
          <select name="cfdi_id" class="form-select form-control" required>
            <option value="">Seleccionar</option>
            @foreach ($cfdis as $cfdi)
              <option value="{{ $cfdi->id }}">{{ $cfdi->nombre }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <hr>

      <h5>Productos</h5>
      <div id="productos-container">
        <div class="row g-3 producto-row">
          <div class="col-md-6">
            <select name="productos[]" class="form-select form-control" required>
              <option value="">Seleccionar Producto</option>
              @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }} - {{ $producto->codigo }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <input type="number" name="cantidades[]" class="form-control" placeholder="Cantidad" required min="1">
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-product">X</button>
          </div>
        </div>
      </div>

      <button type="button" class="btn btn-success mt-3" id="add-product">Añadir Producto</button>

      <div class="modal-footer mt-3">
        <button type="submit" class="btn btn-primary">Guardar Facturación</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('add-product').addEventListener('click', function() {
    let container = document.getElementById('productos-container');
    let row = document.querySelector('.producto-row').cloneNode(true);
    row.querySelector('select').value = '';
    row.querySelector('input').value = '';
    container.appendChild(row);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-product')) {
        e.target.closest('.producto-row').remove();
    }
});
</script>
@endpush
