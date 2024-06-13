<?php
session_start();  // Iniciamos siempre la sesión al principio
if (isset($_SESSION['welcome_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['welcome_message'] . '</div>';
    unset($_SESSION['welcome_message']);  // Eliminamos el mensaje de bienvenida después de mostrarlo
}
// Esta función es para obtener los productos de una categoría específica
function obtenerProductosPorCategoria($categoria) {
    // Aquí podemos realizar la lógica para obtener los productos de la base de datos
    // Por ahora devolveremos una lista de productos
    $productos = array();
    // Conectamos a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "bd");
    // Verificamos
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    // Consulta SQL para obtener los productos de la categoría seleccionada
    $consulta = "SELECT * FROM productos WHERE categoria = '$categoria'";
    $resultado = mysqli_query($conexion, $consulta);
    // Se verifica si se encontraron productos
    if (mysqli_num_rows($resultado) > 0) {
        // Se obtienen los datos de cada producto
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos[] = $fila;
        }
    }
    mysqli_close($conexion); // Cerramos
    return $productos;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <!-- Añadimos el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Aquí está el estilo para los botones */
        .btn {
            width: 200px; /* Ancho para los botones */
            height: 200px; /* Altura fija para los botones */
            display: flex; /* Se utiliza flexbox para centrar la imagen */
            flex-direction: column; /* Para que el texto aparezca debajo de la imagen */
            justify-content: center; /* Se centra horizontalmente el contenido */
            align-items: center; /* Se centra verticalmente el contenido */
        }
        /* Aquí el estilo para las imágenes dentro de los botones */
        .btn img {
            max-width: 100%; /* Establecemos un ancho máximo del 100% */
            max-height: 100%; /* Establecemos una altura máxima del 100% */
        }
        /* Estilo para el botón de Ver Carrito */
        .btn-ver-carrito {
            margin: 20px auto 0; /* Ajustamos el margen superior para bajar el botón */
            display: block; /* Esta línea hace que el botón sea un bloque para permitir el centrado automático */
            height: 50px; /* Establecemos la altura del botón */
            line-height: 30px; /* Centramos el texto verticalmente dentro del botón */
        }
        /* Aquí el estilo para los botones de agregar al carrito */
        .btn-agregar-carrito {
            height: 25px; /* Reducimos la altura del botón a la mitad */
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h1 class="text-center mb-4">Catálogo de Productos</h1>
        <form action="cliente.php" method="get" class="mb-3"><!-- Formulario para filtrar por categoría -->
            <div class="d-flex justify-content-around"><!-- Utilizamos flexbox para alinear los botones horizontalmente -->
                <!-- En este tramo cada imagen es un botón que envía el formulario con la categoría correspondiente -->
                <button type="submit" name="categoria" value="filtros" class="btn btn-outline-primary">
                    <img src="filtros.jpg" alt="Filtros">
                    <p class="text-center">Filtros</p>
                </button>
                <button type="submit" name="categoria" value="rodamientos" class="btn btn-outline-primary">
                    <img src="rodamientos.jpg" alt="Rodamientos">
                    <p class="text-center">Rodamientos</p>
                </button>
                <button type="submit" name="categoria" value="lubricantes" class="btn btn-outline-primary">
                    <img src="lubricantes.jpg" alt="Lubricantes">
                    <p class="text-center">Lubricantes</p>
                </button>
            </div>
        </form>
        <?php
        // Aquí se verifica si se ha seleccionado una categoría para filtrar
        if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
            // Aquí se obtiene la categoría seleccionada
            $categoria = $_GET['categoria'];
            // Obtenemos los productos de la categoría seleccionada
            $productos = obtenerProductosPorCategoria($categoria);
            echo "<div class='row'>";
            // Mostramos los productos de la categoría seleccionada
            foreach ($productos as $producto) {
                echo "<div class='col-md-4 mb-3'>";
                echo "<div class='card'>";
                
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$producto['nombre']}</h5>";
                echo "<p class='card-text'>{$producto['descripcion']}</p>";
                echo "<p class='card-text'>Precio: " . number_format($producto['precio'], 2, ',', '.') . " €</p>"; // Mostrar el precio con coma
                echo "<p class='card-text'>Stock Disponible: {$producto['stock_disponible']}</p>"; // Aquí se muestra el stock disponible
                // Éste es el formulario para agregar al carrito
                echo "<form action='cliente.php' method='post'>";
                echo "<input type='hidden' name='id_producto' value='{$producto['id']}' />";
                echo "<button type='submit' class='btn btn-primary btn-agregar-carrito'>Agregar al carrito</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        }
        // Verificamos si se ha recibido el ID del producto a agregar al carrito
        if (isset($_POST['id_producto'])) {
            $id_producto = $_POST['id_producto'];
            // Agregamos el ID del producto al carrito
            $_SESSION['carrito'][] = $id_producto;
            // Redirigimos de vuelta al catálogo para seguir navegando
            header("Location: cliente.php");
            exit();
        }
        ?>
        <div class="text-center"> <!-- Botón para ver el carrito -->
            <form action="carrito.php" method="get">
                <button type="submit" class="btn btn-info btn-ver-carrito">Ver Carrito</button>
            </form>
        </div>
    </div>
</body>
</html>