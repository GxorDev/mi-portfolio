<?php

$conexion = mysqli_connect("localhost", "root", "", "bd");

// Con este código verificamos si se ha enviado un ID de usuario válido
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Obtenemos la información del usuario desde la base de datos
    $consulta = "SELECT * FROM usuarios WHERE id = $id_usuario";
    $resultado = mysqli_query($conexion, $consulta);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        // Aquí se muestra el formulario prellenado con la información del usuario
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Editar Usuario</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5">
                <h2 class="mb-4">Editar Usuario</h2>
                <form action="guardar_edicion.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">
                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $fila['Usuario']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $fila['Email']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
                <a href="javascript:history.go(-1)" class="btn btn-secondary mt-3">Volver atrás</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "ID de usuario no especificado.";
}

mysqli_close($conexion);
?>