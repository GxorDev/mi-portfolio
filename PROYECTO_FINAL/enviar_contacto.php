<?php
// Siempre se establece primero la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd");

// Aquí se verifica la conexión
if ($conexion === false) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Recuperamos los datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];

// Creamos la consulta SQL para insertar los datos en la tabla mensajes_contacto
$consulta = "INSERT INTO mensajes_contacto (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";

// Ejecutamos la consulta
if (mysqli_query($conexion, $consulta)) {
    $mensaje_enviado = "Mensaje enviado correctamente.";
} else {
    $mensaje_enviado = "Error al enviar el mensaje: " . mysqli_error($conexion);
}

// Se cierra la conexión
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Envío</title>
    <!-- Enlace al CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-<?php echo (strpos($mensaje_enviado, 'Error') !== false) ? 'danger' : 'success'; ?>" role="alert">
            <?php echo $mensaje_enviado; ?>
        </div>
        <button onclick="window.location.href = 'index.php';" class="btn btn-primary">Volver a Inicio</button>
    </div>
</body>
</html>