<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Cobro - Bepensa Izamal</title>

  <!-- Ícono de la página -->
  <link rel="icon" href="https://www.bepensa.com/wp-content/uploads/2018/05/cropped32x32.png" sizes="32x32">

  <!-- Enlace al CSS de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <script defer src="script.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>
  <!-- Encabezado -->
  <header class="bg-primary text-white py-3 text-center">
    <div class="container d-flex align-items-center justify-content-center">
       <img src="https://portalproveedores-articulos.bepensa.com/Compras/Estilos/img/Logo_bepensa.png" alt="logo" class="header-logo">
      <h1>Sistema de Cobro</h1>
    </div>
  </header>

  <main class="container my-4">
    <!-- Formulario para agregar productos -->
    <section class="mb-4">
      <h2>Agregar Producto</h2>
      <form id="add-product-form" class="row g-3">
        <div class="col-md-4">
          <input type="text" id="product-code" class="form-control" placeholder="Nota de Venta" required>
        </div>
        <div class="col-md-4">
          <input type="text" id="product-name" class="form-control" placeholder="Nombre del Cliente" required>
        </div>
        <div class="col-md-2">
          <input type="number" id="product-quantity" class="form-control" placeholder="Cantidad" required>
        </div>
        <div class="col-md-12">
          <input type="file" id="product-image" class="form-control">
        </div>
        <div class="col-md-12 text-end">
          <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
      </form>
    </section>

    <!-- Tabla de productos -->
    <section class="mb-4">
      <h2>Facturas</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Marca</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody id="product-table-body">
          <tr>
            <td colspan="8" class="text-center">No hay productos seleccionados</td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- Generación de factura -->
    <section class="mb-4">
      <h2>Generar Reporte</h2>
      <button id="generate-invoice" class="btn btn-success">Generar PDF</button>
    </section>
  </main>

  <footer class="bg-light text-center py-3">
    <strong>Copyright &copy; 2025 <a href="https://www.bepensa.com/" target="_blank">Bepensa</a>.</strong> Todos los derechos reservados.
  </footer>

  <script>
    document.getElementById('generate-invoice').addEventListener('click', function () {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.text("Factura - Bepensa Izamal SA DE C.V", 10, 10);
      doc.save("factura.pdf");
    });
  </script>
</body>
</html>
