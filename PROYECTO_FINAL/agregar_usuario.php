<?php
session_start();

// Verificamos si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluimos en el archivo de configuración de la base de datos
    include_once "configuracion_bd.php"; 

    // Obtenemos los datos del formulario
    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $contraseña = $_POST["contraseña"];
    $id_cargo = $_POST["cargo"];

    // Realizamos una consulta para verificar si el id_cargo existe en la tabla cargo
    $consulta_cargo = "SELECT id FROM cargo WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $consulta_cargo);
    mysqli_stmt_bind_param($stmt, "i", $id_cargo);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificamos si la consulta devolvió algún resultado
    if(mysqli_num_rows($resultado) > 0) {
        // Si el id_cargo es válido, se procede con la inserción de datos en la tabla usuarios
        $sql = "INSERT INTO usuarios (usuario, email, contraseña, id_cargo) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $usuario, $email, $contraseña, $id_cargo);

        // Ejecutamos la declaración
        if (mysqli_stmt_execute($stmt)) {
            // Se redirige a la página admin.php después de agregar el usuario
            header("Location: admin.php");
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
        }

        // Cerramos la declaración
        mysqli_stmt_close($stmt);
    } else {
        // Si el id_cargo no es válido, se informa al usuario y se evitar la inserción
        echo "El id_cargo proporcionado no es válido.";
    }

    // Cerramos la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se han recibido datos del formulario, redirigimos a la página de inicio
    header("Location: index.php");
    exit();
}
?>