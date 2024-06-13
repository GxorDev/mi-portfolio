<!DOCTYPE html>
<!-- Este documento HTML es para la página que guarda las ediciones de los usuarios. -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Nos aseguramos de que nuestra página se vea bien en todos los dispositivos. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guardar Edición</title>
    <!-- Bootstrap nos ayuda a que todo se vea ordenado y profesional. -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        // Primero nos asegurarnos de que podemos ver cualquier error que ocurra con este codigo.
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        // Ahora verificaremos si el formulario ha sido enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Después ecogemos los datos que el usuario ha introducido.
            $id_usuario = $_POST["id"];
            $nuevo_usuario = $_POST["usuario"];
            $nuevo_email = $_POST["email"];
            $nueva_contraseña = $_POST["contraseña"];

            // Ahora validamos esos datos para asegurarnos de que todo está en orden.
            if (!empty($id_usuario) && !empty($nuevo_usuario) && !empty($nuevo_email) && !empty($nueva_contraseña)) {
                // Si todo está bien se conecta a la base de datos.
                $conexion = mysqli_connect("localhost", "root", "", "bd");

                // Si algo va mal con la conexión lo sabremos inmediatamente.
                if ($conexion === false) {
                    die("Error de conexión a la base de datos: " . mysqli_connect_error());
                }

                // Es probable que haya usuarios con la contraseña encriptada en el proyecto para probar la seguridad.
                $hash_nueva_contraseña = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

                // Ahora preparamos la consulta SQL para actualizar los datos del usuario.
                $consulta = "UPDATE usuarios SET usuario='$nuevo_usuario', email='$nuevo_email', contraseña='$hash_nueva_contraseña' WHERE id=$id_usuario";

                // Ejecutamos
                if (mysqli_query($conexion, $consulta)) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        ¡Genial! Los cambios se han guardado exitosamente.
                    </div>
                    <?php
                } else {
                    // Si algo sale mal informamos al usuario.
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Ups, parece que ha habido un error al guardar los cambios: <?php echo mysqli_error($conexion); ?>
                    </div>
                    <?php
                }

                // Se cierra conexion al terminar
                mysqli_close($conexion);
            } else {
                // Recordatorio al usuario si se ha olvidado de ingresar algún dato.
                ?>
                <div class="alert alert-warning" role="alert">
                    Recuerda, necesitas completar todos los campos para guardar los cambios.
                </div>
                <?php
            }
        } else {
            // Si alguien intenta acceder a esta página sin pasar por el formulario le decimos que no está permitido.
            ?>
            <div class="alert alert-danger" role="alert">
                Parece que estás intentando acceder directamente. Eso no está permitido.
            </div>
            <?php
        }
        ?>
        <!-- Botón para volver atrás. -->
        <a href="javascript:history.go(-1)" class="btn btn-primary">Volver atrás</a>
    </div>
</body>
</html>