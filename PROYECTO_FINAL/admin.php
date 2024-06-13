<?php
session_start();  // Comenzamos la sesión
   // Aquí se indica la posibilidad de que haya un mensaje de bienvenida
if (isset($_SESSION['welcome_message'])) {
    // Si lo hay, mostramos un mensaje de éxito para dar la bienvenida al usuario.
    echo '<div class="alert alert-success">' . $_SESSION['welcome_message'] . '</div>';
    // Una vez mostrado el mensaje, lo eliminamos para que no se muestre nuevamente.
    unset($_SESSION['welcome_message']);  // Ésta línea elimina el mensaje de bienvenida después de mostrarlo
}

// Aquí la función para obtener los productos de la base de datos
function obtenerProductos() {
    // Establecemos la conexión con la base de datos y ajustamos los valores según nuestra configuración).
    $conexion = mysqli_connect("localhost", "root", "", "bd");

    // Verificamos si la conexión se realizó con éxito.
    if (!$conexion) {
        // Si no se pudo establecer la conexión mostramos un mensaje de error y terminamos el script.
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta SQL para obtener todos los productos de la base de datos.
    $consulta = "SELECT * FROM productos";
    $resultado = mysqli_query($conexion, $consulta);

    // Creamos un array para almacenar los productos obtenidos de la base de datos.
    $productos = array();

    // Verificamos si se encontraron productos en la base de datos.
    if (mysqli_num_rows($resultado) > 0) {
        // Si hay productos los recorremos uno por uno y los almacenamos en el array.
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = $fila;
        }
    }

    // Cerramos la conexión con la base de datos para liberar recursos.
    mysqli_close($conexion);

    // Devolvemos el array con los productos obtenidos.
    return $productos;
}

// Obtenemos los productos de la base de datos utilizando la función definida anteriormente.
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración básica de la página web -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bajo-stock.css">
    <title>Panel de administración</title>
</head>
<body>
    <div class="container mt-4">
        <!-- Aquí el botón para volver atrás en la página -->
        <button class="btn btn-primary btn-volver" onclick="window.history.back()">Volver Atrás</button>
        <!-- Aquí el título de bienvenida para el administrador -->
        <h1 class="text-center mb-4">Hola, admin</h1>

        <!-- Aquí la lista de usuarios registrados -->
        <h2 class="mt-3">Lista de usuarios</h2>
        <!-- Aquí la tabla para mostrar los usuarios -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Contraseña</th>
                    <th>Cargo</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'mostrar_usuarios.php'; ?>
            </tbody>
        </table>

        <!-- Aquí el formulario para agregar un nuevo usuario -->
        <h2 class="mt-3">Agregar Nuevo Usuario</h2>
        <form action="agregar_usuario.php" method="post" class="mb-3">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <select class="form-control" id="cargo" name="cargo">
                    <option value="1">Admin</option>
                    <option value="2">Cliente</option>
                    <option value="3">Vendedor</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Usuario</button>
        </form>

        <!-- Aquí el formulario para gestionar el stock de productos -->
        <h2 class="mt-3">Gestionar Stock</h2>
        <form action="actualizar_stock.php" method="post" class="mb-3">
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

        <!-- Aquí la lista de productos con su información -->
        <h2 class="mt-3">Lista de Productos</h2>
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
                <!-- En éste bloque iteramos sobre la lista de productos para mostrar cada uno -->
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['precio']; ?></td>
                        <td><?php echo $producto['categoria']; ?></td>
                        <td <?php if ($producto['stock_disponible'] <= 3) echo 'class="bajo-stock"'; ?>>
                            <?php echo $producto['stock_disponible']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Botón para vovler atrás en la página -->
        <button class="btn btn-primary" onclick="window.history.back()">Volver Atrás</button>
    </div>
</body>
</html>