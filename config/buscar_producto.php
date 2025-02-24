<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_code = $_GET['code']; // Código del producto recibido desde el frontend

    $query = $conn->prepare("SELECT * FROM productos WHERE codigo = ?");
    $query->bind_param("s", $product_code);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product); // Retornar datos del producto en formato JSON
    } else {
        echo json_encode(["error" => "Producto no encontrado"]);
    }
}
?>

//Función para buscar producto por código

<?php
require 'conexion.php';
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $stmt = $pdo->prepare("SELECT * FROM productos WHERE codigo = ?");
    $stmt->execute([$codigo]);

    if ($producto = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode($producto);
    } else {
        echo json_encode(["error" => "Producto no encontrado."]);
    }
}
?>
