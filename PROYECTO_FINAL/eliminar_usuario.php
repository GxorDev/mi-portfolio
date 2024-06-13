<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        // Conectamos con a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Aquí se verifica si se ha enviado un ID de usuario válido
        if (isset($_GET['id'])) {
            $id_usuario = $_GET['id'];

            // Eliminamos el usuario de la base de datos
            $consulta = "DELETE FROM usuarios WHERE id = $id_usuario";
            if (mysqli_query($conexion, $consulta)) {
                echo '<div class="alert alert-success" role="alert">Usuario eliminado correctamente.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error al eliminar usuario: ' . mysqli_error($conexion) . '</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">ID de usuario no especificado.</div>';
        }

        // Cerramos conexión
        mysqli_close($conexion);
        ?>
        <a href="javascript:history.go(-1)" class="btn btn-secondary mt-3">Volver atrás</a>
    </div>
</body>
</html>