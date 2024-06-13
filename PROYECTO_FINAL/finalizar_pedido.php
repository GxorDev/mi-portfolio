<?php
session_start();

// Establecemos onexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd");

// Verificamos la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Se verifica si se recibió la confirmación del pedido y que el carrito no está vacío
if (isset($_POST['confirmar_pedido']) && !empty($_SESSION['carrito'])) {
    // Iniciar transacción
    mysqli_begin_transaction($conexion);

    try {
        // Este código ecorre cada producto en el carrito y actualiza el stock
        foreach ($_SESSION['carrito'] as $id_producto) {
            // Consulta SQL para actualizar el stock del producto
            $consulta = "UPDATE productos SET stock_disponible = stock_disponible - 1 WHERE id = $id_producto AND stock_disponible > 0";

            // Aquí se ejecuta la consulta
            if (!mysqli_query($conexion, $consulta)) {
                throw new Exception("Error al actualizar el stock: " . mysqli_error($conexion));
            }
        }

        // Si todo salió bien aquí se vacía el carrito y confirma la transacción
        $_SESSION['carrito'] = array();
        mysqli_commit($conexion);

        echo json_encode(['success' => true, 'message' => 'Pedido finalizado con éxito.']); // Enviamos una respuesta JSON al cliente
    } catch (Exception $e) {
        // Si algo sale mal revertimos todos los cambios
        mysqli_rollback($conexion);

        echo json_encode(['success' => false, 'message' => $e->getMessage()]); // Enviamos una respuesta JSON al cliente
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No se recibió la confirmación del pedido o el carrito está vacío.']); // Enviamos una respuesta JSON al cliente
}

// Cerramos conexión
mysqli_close($conexion);
?>