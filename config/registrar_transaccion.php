<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['productos']) && isset($data['total'])) {
        $productos = $data['productos'];
        $total = $data['total'];

        try {
            $pdo->beginTransaction();

            // Insertar la transacción
            $stmt = $pdo->prepare("INSERT INTO transacciones (total) VALUES (?)");
            $stmt->execute([$total]);
            $transaccion_id = $pdo->lastInsertId();

            // Insertar los detalles de la transacción
            $stmt = $pdo->prepare("INSERT INTO detalle_transaccion (transaccion_id, producto_id, cantidad, subtotal) VALUES (?, ?, ?, ?)");

            foreach ($productos as $producto) {
                $stmt->execute([
                    $transaccion_id,
                    $producto['id'],
                    $producto['cantidad'],
                    $producto['subtotal']
                ]);
            }

            $pdo->commit();
            echo json_encode(["success" => true, "transaccion_id" => $transaccion_id]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => "Datos incompletos."]);
    }
}
?>
