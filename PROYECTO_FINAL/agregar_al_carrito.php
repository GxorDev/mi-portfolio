<?php
session_start(); // Conexión a la BD

// VerificaMOS si se ha recibido el ID del producto a agregar al carrito
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Aquí SE puede realizar la lógica para agregar el producto al carrito
    // Por ejemplo podemos almacenar el ID del producto en la sesión del cliente

    // Éste es el ejemplo de almacenamiento en la sesión del cliente
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array(); // Inicializamos el carrito si no existe
    }
    // Agregamos el ID del producto al carrito
    $_SESSION['carrito'][] = $id_producto;

    // Se redirige de vuelta al catálogo o a donde queramos
    header("Location: cliente.php");
    exit();
} else {
    // Si no se ha recibido el ID del producto, se redirige a alguna página de error
    header("Location: error.php");
    exit();
}
?>