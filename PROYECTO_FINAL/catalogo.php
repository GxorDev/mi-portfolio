<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Mostramos estilos personalizados para las imágenes del catálogo */
        .catalogo-img {
            width: 200px;  /* Aquí modificamos el ancho */
            height: 200px;  /* Aquí altura */
        }
        /* Éste bloque muestra el estilo para el botón de volver atrás */
        .btn-volver-atras {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 80px; /* Ancho del botón */
        }
        /* Estilo para el texto debajo de las imágenes */
        .categoria-texto {
            margin-top: 10px; /* Espacio superior */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botón para volver a la página anterior en la parte inferior izquierda -->
        <button type="button" class="btn btn-primary btn-volver-atras" onclick="history.back()">Volver Atrás</button>

        <h1 class="text-center my-4">Catálogo de Productos</h1>

        <!-- Formulario para filtrar por categoría -->
        <form action="catalogo.php" method="get" class="mb-3">
            <div class="row justify-content-around"><!-- Utilizamos flexbox para centrar los botones horizontalmente -->
                <!-- Cada imagen es un botón que envía el formulario con la categoría correspondiente -->
                <div class="col-sm-4 text-center">
                    <button type="submit" name="categoria" value="filtros" class="btn btn-link p-0">
                        <img src="filtros.jpg" alt="Filtros" class="img-fluid catalogo-img">
                        <p class="categoria-texto">Filtros</p>
                    </button>
                </div>
                <div class="col-sm-4 text-center">
                    <button type="submit" name="categoria" value="rodamientos" class="btn btn-link p-0">
                        <img src="rodamientos.jpg" alt="Rodamientos" class="img-fluid catalogo-img">
                        <p class="categoria-texto">Rodamientos</p>
                    </button>
                </div>
                <div class="col-sm-4 text-center">
                    <button type="submit" name="categoria" value="lubricantes" class="btn btn-link p-0">
                        <img src="lubricantes.jpg" alt="Lubricantes" class="img-fluid catalogo-img">
                        <p class="categoria-texto">Lubricantes</p>
                    </button>
                </div>
            </div>
        </form>

        <?php
        //  Aquí se verifica si se ha seleccionado una categoría para filtrar
        if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
            // Conectamos a la base de datos
            $conexion = mysqli_connect("localhost", "root", "", "bd");
            $categoria = $_GET['categoria'];
            // Se reliza consulta SQL para obtener los productos de la categoría seleccionada
            $consulta = "SELECT *, stock_disponible FROM productos WHERE categoria = '$categoria'";
            $resultado = mysqli_query($conexion, $consulta);

            echo "<div class='row'>";
            // Se muestran los productos de la categoría seleccionada
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<div class='col-md-4 mb-3'>";
                echo "<div class='card'>";
                
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$fila['nombre']}</h5>";
                echo "<p class='card-text'>{$fila['descripcion']}</p>";
                echo "<p class='card-text'>Precio: {$fila['precio']} €</p>";
                echo "<p class='card-text'>Categoría: {$fila['categoria']}</p>";
                echo "<p class='card-text'>Stock Disponible: {$fila['stock_disponible']}</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";

            // Cerramos conexión
            mysqli_close($conexion);
        }
        ?>
    </div>
</body>
</html>