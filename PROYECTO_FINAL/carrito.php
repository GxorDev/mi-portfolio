<?php
// Iniciamos la sesión para mantener los datos del carrito entre páginas
session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica del documento -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Enlace al CSS de Bootstrap para dar estilo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php
    // Funciones para obtener información del producto desde la base de datos

    // Función para obtener el nombre del producto mediante su ID
    function obtenerNombreProducto($id_producto) {
        // Conexión a la base de datos (ajusta los valores según tu configuración)
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Verificamos la conexión
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta SQL para obtener el nombre del producto
        $consulta = "SELECT nombre FROM productos WHERE id = '$id_producto'";
        $resultado = mysqli_query($conexion, $consulta);

        // Verificamos si se encontró el producto
        if (mysqli_num_rows($resultado) == 1) {
            // Obtenemos el nombre del producto
            $fila = mysqli_fetch_assoc($resultado);
            $nombre = $fila['nombre'];
        } else {
            $nombre = "Producto no encontrado";
        }

        // Cerramos la conexión
        mysqli_close($conexion);

        return $nombre;
    }

    // Función para obtener la descripción del producto mediante su ID
    function obtenerDescripcionProducto($id_producto) {
        // Conexión a la base de datos (ajusta los valores según tu configuración)
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Verificamos la conexión
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta SQL para obtener la descripción del producto
        $consulta = "SELECT descripcion FROM productos WHERE id = '$id_producto'";
        $resultado = mysqli_query($conexion, $consulta);

        // Verificamos si se encontró el producto
        if (mysqli_num_rows($resultado) == 1) {
            // Obtenemos la descripción del producto
            $fila = mysqli_fetch_assoc($resultado);
            $descripcion = $fila['descripcion'];
        } else {
            $descripcion = "Descripción no disponible";
        }

        // Cerramos la conexión
        mysqli_close($conexion);

        return $descripcion;
    }

    // Función para obtener el precio del producto mediante su ID
    function obtenerPrecioProducto($id_producto) {
        // Conexión a la base de datos (ajusta los valores según tu configuración)
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Verificamos la conexión
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta SQL para obtener el precio del producto
        $consulta = "SELECT precio FROM productos WHERE id = '$id_producto'";
        $resultado = mysqli_query($conexion, $consulta);

        // Verificamos si se encontró el producto
        if (mysqli_num_rows($resultado) == 1) {
            // Obtenemos el precio del producto
            $fila = mysqli_fetch_assoc($resultado);
            $precio = $fila['precio'];
        } else {
            $precio = 0; // Precio por defecto si el producto no se encuentra
        }

        // Cerramos la conexión
        mysqli_close($conexion);

        return $precio;
    }
    

    // Verificamos si hay productos en el carrito
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        // Mostramos la estructura HTML para el carrito de compras
        echo '<div class="container mt-3">';
        echo '<a href="javascript:history.go(-1)" class="btn btn-primary mb-3">Volver a la página anterior</a>';
        echo '<h1>Carrito de Compras</h1>';
        echo '<table class="table">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Acciones</th></tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($_SESSION['carrito'] as $id_producto) {
            // Obtenemos los detalles del producto
            $nombre = obtenerNombreProducto($id_producto);
            $descripcion = obtenerDescripcionProducto($id_producto);
            $precio = obtenerPrecioProducto($id_producto);

            // Mostramos la información del producto en la tabla
            echo '<tr>';
            echo "<td>$id_producto</td>";
            echo "<td>$nombre</td>";
            echo "<td>$descripcion</td>";
            echo "<td>" . number_format($precio, 2, ',', '.') . " €</td>"; // Mostramos el precio con coma
            echo '<td>';
            echo '<form action="eliminar_del_carrito.php" method="post">';
            echo '<input type="hidden" name="id_producto" value="'.$id_producto.'" />';
            echo '<button type="submit" class="btn btn-danger">Eliminar</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        // Calculamos el total de artículos y el total a pagar
        $totalCantidad = count($_SESSION['carrito']);
        $totalPrecio = 0;
        foreach ($_SESSION['carrito'] as $id_producto) {
            $totalPrecio += obtenerPrecioProducto($id_producto);
        }
        $descuento = $totalPrecio * 0.05; // Aplicamos un descuento del 5%
        $totalConDescuento = $totalPrecio - $descuento;

        // Mostramos el resumen del carrito
        echo "<p>Total de artículos en el carrito: <strong>$totalCantidad</strong></p>";
        echo "<p>Total a pagar: <strong>".number_format($totalConDescuento, 2, ',', '.')." €</strong></p>";
        echo "<p>Descuento del 5% aplicado: <strong>".number_format($descuento, 2, ',', '.')." €</strong> de ahorro en su compra</p>";
        echo '<button class="btn btn-success" onclick="finalizarPedido()">Finalizar Pedido</button>';
        echo '</div>';
    } else {
        // Mostramos un mensaje si el carrito está vacío
        echo '<div class="container mt-3">';
        echo '<h1>Carrito de Compras Vacío</h1>';
        echo '<a href="index.php" class="btn btn-primary">Volver a la página principal</a>';
        echo '<a href="javascript:history.go(-1)" class="btn btn-secondary">Volver a la página anterior</a>';
        echo '</div>';
    }
    ?>
    
    <script>
    // Función para finalizar el pedido
    function finalizarPedido() {
        // Generamos un número de turno aleatorio entre 1 y 30
        var turno = Math.floor(Math.random() * 30) + 1;
        var referencia = '';
        var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var caracteresLength = caracteres.length; // Definimos la longitud de la cadena de caracteres
        for (var i = 0; i < 6; i++) {
            referencia += caracteres.charAt(Math.floor(Math.random() * caracteresLength));
        }
        // Creamos un mensaje con la información del pedido y lo mostramos en un cuadro de confirmación
        var mensaje = "¡Pedido finalizado!\n\nNúmero de turno: " + turno + "\nNúmero de referencia: " + referencia + "\n\n";
        if (confirm(mensaje)) {
            // Enviamos una solicitud para confirmar el pedido al servidor
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        // Si el pedido se confirma correctamente, redirigimos a la página del carrito
                        location.href = 'carrito.php';
                    } else {
                        // Si hay algún error, mostramos un mensaje de alerta con el error
                        alert("Error al finalizar el pedido: " + response.message);
                    }
                }
            };
            xhttp.open("POST", "finalizar_pedido.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("confirmar_pedido=true");
        }
    }
    </script>
</body>
</html>