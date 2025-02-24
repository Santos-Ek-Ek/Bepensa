document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("add-product-form");
    const productTableBody = document.getElementById("product-table-body");
    const totalAmountSpan = document.getElementById("total-amount");

    let totalAmount = 0; // Variable para almacenar el total

    // Función para agregar un producto a la tabla
    function addProduct(productData) {
      const subtotal = productData.quantity * productData.unitPrice;
      totalAmount += subtotal;

      // Crear una nueva fila para la tabla
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${productData.code}</td>
        <td>${productData.name}</td>
        <td>${productData.quantity}</td>
        <td>$${productData.unitPrice.toFixed(2)}</td>
        <td>$${subtotal.toFixed(2)}</td>
        <td><button class="delete-product">Eliminar</button></td>
      `;
      productTableBody.appendChild(row);

      // Actualizar el total
      updateTotal();
    }

    // Función para eliminar un producto de la tabla
    function deleteProduct(row) {
      const subtotal = parseFloat(row.children[4].textContent.replace("$", ""));
      totalAmount -= subtotal;

      // Eliminar la fila de la tabla
      row.remove();

      // Actualizar el total
      updateTotal();
    }

    // Función para actualizar el total en el DOM
    function updateTotal() {
      totalAmountSpan.textContent = totalAmount.toFixed(2);
    }

    // Función para limpiar la tabla y reiniciar el total
    function resetTable() {
      productTableBody.innerHTML = "";
      totalAmount = 0;
      updateTotal();
    }

    // Función para confirmar el cobro
    function confirmPayment() {
      if (totalAmount > 0) {
        alert(`Cobro confirmado. Total: $${totalAmount.toFixed(2)}`);
        resetTable();
      } else {
        alert("No hay productos en la lista.");
      }
    }

    // Evento: Agregar producto
    form.addEventListener("submit", (e) => {
      e.preventDefault();

      const productCode = document.getElementById("product-code").value;

      // Simulación de datos del producto
      const productData = {
        code: productCode,
        name: "Producto " + productCode,
        quantity: 1,
        unitPrice: Math.floor(Math.random() * 100) + 1 // Precio aleatorio
      };

      addProduct(productData);

      // Limpiar el formulario
      form.reset();
    });

    // Evento: Eliminar producto
    productTableBody.addEventListener("click", (e) => {
      if (e.target.classList.contains("delete-product")) {
        const row = e.target.closest("tr");
        deleteProduct(row);
      }
    });

    // Evento: Cancelar el cobro
    document.getElementById("cancel-payment").addEventListener("click", resetTable);

    // Evento: Confirmar el cobro
    document.getElementById("confirm-payment").addEventListener("click", confirmPayment);
  });


  //---------------------------------------------------------------------------------------------------------//
// Función para buscar un producto por código
async function fetchProduct(code) {
    try {
      const response = await fetch(`buscar_producto.php?codigo=${code}`);
      const product = await response.json();
      return product;
    } catch (error) {
      console.error("Error al buscar el producto:", error);
    }
  }

  // Función para registrar la transacción
  async function registerTransaction(products, total) {
    try {
      const response = await fetch("registrar_transaccion.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ productos: products, total: total }),
      });
      const result = await response.json();
      if (result.success) {
        alert(`Transacción registrada con éxito. ID: ${result.transaccion_id}`);
        resetTable();
      } else {
        alert(`Error: ${result.error}`);
      }
    } catch (error) {
      console.error("Error al registrar la transacción:", error);
    }
  }

  // Evento: Agregar producto
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const productCode = document.getElementById("product-code").value;

    const productData = await fetchProduct(productCode);
    if (productData.error) {
      alert(productData.error);
      return;
    }

    const product = {
      id: productData.id,
      code: productData.codigo,
      name: productData.nombre,
      quantity: 1,
      unitPrice: parseFloat(productData.precio),
    };

    addProduct(product);
    form.reset();
  });

  // Evento: Confirmar el cobro
  document.getElementById("confirm-payment").addEventListener("click", () => {
    if (productTableBody.children.length > 0) {
      const products = Array.from(productTableBody.children).map((row) => {
        return {
          id: parseInt(row.dataset.id),
          cantidad: parseInt(row.children[2].textContent),
          subtotal: parseFloat(row.children[4].textContent.replace("$", "")),
        };
      });
      registerTransaction(products, totalAmount);
    } else {
      alert("No hay productos para registrar.");
    }
  });
