<?php
// Comenzamos la sesión para llevar información a través de las páginas
session_start();

// Establecemos encabezados para evitar el almacenamiento en caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Solo procesamos el formulario si el método es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos que los campos necesarios estén presentes
    if (isset($_POST['usuario'], $_POST['email'], $_POST['contraseña'])) {
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];

        // Intentamos conectar a la base de datos
        $conexion = mysqli_connect("localhost", "root", "", "bd");

        // Si algo sale mal, mostramos un mensaje y terminamos la ejecución
        if (!$conexion) {
            die("Problemas con la conexión: " . mysqli_connect_error());
        }

        // Preparamos una consulta segura para evitar problemas de inyección SQL
        $consulta = "SELECT * FROM usuarios WHERE usuario=? AND email=? AND contraseña=?";
        $stmt = mysqli_stmt_init($conexion);

        // Si la consulta está bien preparada, procedemos
        if (mysqli_stmt_prepare($stmt, $consulta)) {
            mysqli_stmt_bind_param($stmt, "sss", $usuario, $email, $contraseña);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            // Revisamos si encontramos al usuario
            if (mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
                // Dependiendo del cargo, redirigimos al usuario
                if ($fila['id_cargo'] == 1) { // Administrador
                    $_SESSION['welcome_message'] = "¡Bienvenido, administrador $usuario!";
                    header("location: admin.php");
                    exit();
                } elseif ($fila['id_cargo'] == 2) { // Cliente
                    $_SESSION['welcome_message'] = "¡Hola, cliente $usuario!";
                    header("location: cliente.php");
                    exit();
                } elseif ($fila['id_cargo'] == 3) { // Vendedor
                    $_SESSION['welcome_message'] = "Saludos, vendedor $usuario.";
                    header("location: vendedor.php");
                    exit();
                }

                // Aquí registramos el inicio de sesión en un archivo de log
                $fecha_actual = date("Y-m-d H:i:s");
                $mensaje_log = "Inicio de sesión: $usuario a las $fecha_actual.";
                file_put_contents('log.txt', $mensaje_log . PHP_EOL, FILE_APPEND);

                // Un pequeño mensaje para confirmar el inicio de sesión
                echo '<script>alert("Inicio de sesión exitoso.");</script>';
            } else {
                // Si no hay resultados, algo salió mal
                $_SESSION['error'] = "Usuario o contraseña incorrectos.";
                echo "<script>alert('Error al iniciar sesión.'); window.location.replace('index.html');</script>";
                exit();
            }
        } else {
            // Si hay un error en la consulta, lo mostramos
            echo "Error al preparar la consulta: " . mysqli_error($conexion);
        }

        // No olvidamos cerrar la conexión
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
    } else {
        // Si faltan campos, avisamos al usuario
        echo "Todos los campos son obligatorios.";
    }
}
?>