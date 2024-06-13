<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Actualizado</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <!-- Botón para volver atrás -->
        <button class="btn btn-primary mb-3" onclick="window.history.back()">Volver Atrás</button>
        <!-- Aquí se mostrará el mensaje -->
        <?php
        // Esta línea de código verifica si el formulario ha sido enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conectamos a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "bd");

            // Aquí se verifica si la conexión fue exitosa
            if (!$conexion) {
                die("Error al conectar con la base de datos: " . mysqli_connect_error());
            }

            // Obtenemos los datos del formulario
            $id = $_POST["id_producto"];  // Cambiado a 'id'
            $unidades_a_agregar = $_POST["unidades_a_agregar"];

            // Consulta SQL para verificar si el producto existe
            $consulta_existencia = "SELECT * FROM productos WHERE id = $id";

            // Se ejecuta la consulta para verificar la existencia del producto
            $resultado_existencia = mysqli_query($conexion, $consulta_existencia);

            // Se verifica si el producto existe en la base de datos
            if (mysqli_num_rows($resultado_existencia) == 0) {
                echo '<div class="alert alert-danger" role="alert">Error: El producto con ID ' . $id . ' no existe.</div>';
            } else {
                // Consulta SQL para actualizar el stock
                $consulta = "UPDATE productos SET stock_disponible = stock_disponible + $unidades_a_agregar WHERE id = $id";  // Cambiado a 'productos', 'id' y 'stock_disponible'

                // Se ejecuta la consulta
                if (mysqli_query($conexion, $consulta)) {
                    echo '<div class="alert alert-success" role="alert">Stock actualizado correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error al actualizar el stock: ' . mysqli_error($conexion) . '</div>';
                }

                // Consulta SQL para obtener el stock actualizado
                $consulta = "SELECT stock_disponible FROM productos WHERE id = $id";  
                $resultado = mysqli_query($conexion, $consulta);
                $fila = mysqli_fetch_assoc($resultado);
                $stock_actualizado = $fila['stock_disponible'];

                // Aquí se verifica si el stock es bajo
                if ($stock_actualizado <= 3) {
                    // Aquí se almacena el aviso en la sesión
                    $_SESSION['aviso_stock_bajo'] = "¡Atención! Solo quedan $stock_actualizado unidades del producto $id.";
                }
            }

            // Cerramos conexión
            mysqli_close($conexion);
        }
        ?>
    </div>
    <!-- Enlace al JavaScript de Bootstrap (opcional, pero puede ser necesario para ciertos componentes de Bootstrap) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>