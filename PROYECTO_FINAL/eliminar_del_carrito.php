<?php
session_start(); //Conectamos

// Verificamos si se ha recibido el ID del producto a eliminar del carrito
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Buscar el índice del producto en el array del carrito
    $indice = array_search($id_producto, $_SESSION['carrito']);

    // Eliminamos el producto del carrito si se encuentra
    if ($indice !== false) {
        unset($_SESSION['carrito'][$indice]);
    }
}

// Se redirige de vuelta al carrito después de eliminar el producto
header("Location: carrito.php");
exit();
?>