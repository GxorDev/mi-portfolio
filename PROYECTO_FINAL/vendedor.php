<?php
// Iniciamos la sesión para manejar datos entre páginas
session_start();

// Si hay un mensaje de bienvenida almacenado en la sesión, lo mostramos
if (isset($_SESSION['welcome_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['welcome_message'] . '</div>';
    unset($_SESSION['welcome_message']);  // Eliminamos el mensaje después de mostrarlo
}

// Función para obtener los productos desde la base de datos
function obtenerProductos() {
    // Establecemos la conexión a la base de datos (reemplaza los valores con los correctos)
    $conexion = mysqli_connect("localhost", "root", "", "bd");

    // Verificamos la conexión
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta SQL para obtener todos los productos
    $consulta = "SELECT * FROM productos";
    $resultado = mysqli_query($conexion, $consulta);

    // Creamos un array para almacenar los productos
    $productos = array();

    // Verificamos si se encontraron productos
    if (mysqli_num_rows($resultado) > 0) {
        // Obtenemos los datos de cada producto y los almacenamos en el array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = $fila;
        }
    }

    // Cerramos la conexión
    mysqli_close($conexion);

    return $productos;
}

// Obtenemos los productos
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bajo-stock.css">
    <title>Panel de vendedor</title>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Hola, vendedor</h1>

        <!-- Botón para ir a la página de inicio -->
        <a href="index.php" class="btn btn-primary">Ir a Inicio</a>

        <h2 class="mt-4">Gestionar Stock</h2>
        <form action="actualizar_stock.php" method="post">
            <div class="form-group">
                <label for="id_producto">ID del Producto:</label>
                <input type="text" class="form-control" id="id_producto" name="id_producto" required>
            </div>
            <div class="form-group">
                <label for="unidades_a_agregar">Unidades a Agregar:</label>
                <input type="number" class="form-control" id="unidades_a_agregar" name="unidades_a_agregar" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Stock</button>
        </form>

        <h2 class="mt-4">Lista de Productos</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock Disponible</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td><?php echo $producto['categoria']; ?></td>
                        <td <?php if ($producto['stock_disponible'] <= 3) echo 'class="bajo-stock"'; ?>><?php echo $producto['stock_disponible']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        // Verificamos si hay un aviso de stock bajo
        if (isset($_SESSION['aviso_stock_bajo'])) {
            echo '<div class="alert alert-warning">' . $_SESSION['aviso_stock_bajo'] . '</div>';

            // Eliminamos el aviso de la sesión
            unset($_SESSION['aviso_stock_bajo']);
        }
        ?>
    </div>
</body>
</html>