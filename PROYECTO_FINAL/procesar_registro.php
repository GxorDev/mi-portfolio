<?php
// Activamos la visualización de errores para facilitar la depuración
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Procesamos el formulario solo si se ha enviado con el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos del formulario
    $usuario = $_POST["txtUsuario"];
    $email = $_POST["txtEmail"];
    $contraseña = $_POST["txtContraseña"];

    // Aseguramos que todos los campos estén completos
    if (!empty($usuario) && !empty($email) && !empty($contraseña)) {
        // Establecemos conexión con la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Si hay problemas con la conexión, lo manejamos aquí
        if ($conexion === false) {
            die("No se pudo conectar a la base de datos: " . mysqli_connect_error());
        }

        // Comprobamos si el usuario ya existe en la base de datos
        $consulta_existente = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado_existente = mysqli_query($conexion, $consulta_existente);

        if (mysqli_num_rows($resultado_existente) > 0) {
            // Si el usuario ya existe, preparamos un mensaje
            $mensaje = "El email $email ya está registrado en nuestro sistema.";
        } else {
            // Si es un nuevo usuario, procedemos a registrar
            $hash_contraseña = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertamos el nuevo usuario en la base de datos
            $consulta = "INSERT INTO usuarios (usuario, email, contraseña, id_cargo) VALUES ('$usuario', '$email', '$hash_contraseña', 2)";

            // Ejecutamos la consulta y verificamos el resultado
            if (mysqli_query($conexion, $consulta)) {
                $mensaje = "¡Registro completado con éxito!";
            } else {
                $mensaje = "Hubo un error al intentar registrar: " . mysqli_error($conexion);
            }
        }

        // Cerramos la conexión una vez terminado
        mysqli_close($conexion);
    } else {
        $mensaje = "Es necesario completar todos los campos.";
    }
} else {
    // Este mensaje es por si se intenta acceder al script directamente
    $mensaje = "Este acceso no está permitido.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <!-- Utilizamos bootstrap para un diseño responsivo -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Aquí mostramos el mensaje resultante del proceso de registro -->
        <div class="alert alert-<?php echo (strpos($mensaje, 'Error') !== false) ? 'danger' : 'success'; ?>" role="alert">
            <?php echo $mensaje; ?>
        </div>
        <!-- Botón para regresar al inicio -->
        <button onclick="window.location.href = 'index.php';" class="btn btn-primary">Volver a Inicio</button>
    </div>
</body>
</html>