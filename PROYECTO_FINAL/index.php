<!DOCTYPE html>
<!-- Estructura básica de un documento HTML5 -->
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Esto asegura que la web sea responsive en dispositivos móviles/dispositivos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recambios Global</title>
    <!-- Importamos Bootstrap para un diseño responsivo y moderno -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilo personalizado para el contenedor del formulario, limitando su ancho */
        .form-container {
            max-width: 700px; /* Aquí podemos controlar el ancho del formulario para mejor legibilidad */
        }
    </style>
</head>
<body>
    <!-- Contenedor principal que centra el formulario en la pantalla completa (vh-100) -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <!-- Contenedor específico para el formulario con estilo personalizado -->
        <div class="form-container">
            <!-- Formulario de inicio de sesión con clases de Bootstrap para estilos y espaciado -->
            <form action="validar.php" method="post" class="bg-light p-4 border rounded">
                <!-- Título del formulario con estilo centrado y margen inferior -->
                <h1 class="text-center mb-4">Inicio de sesión</h1>
                <!-- Grupo de formulario para el campo de usuario con etiqueta y campo de texto -->
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <!-- Campo de texto para el nombre de usuario con placeholder como guía -->
                    <input type="text" class="form-control" id="usuario" placeholder="Ingrese su usuario" name="usuario">
                </div>
                <!-- Grupo de formulario para el campo de email con etiqueta y campo de texto -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <!-- Campo de texto para el email con validación de tipo email -->
                    <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email">
                </div>
                <!-- Grupo de formulario para el campo de contraseña con etiqueta y campo de contraseña -->
                <div class="form-group">
                    <label for="contraseña">Contraseña</label>
                    <!-- Campo de contraseña para la contraseña del usuario con placeholder como guía -->
                    <input type="password" class="form-control" id="contraseña" placeholder="Ingrese su contraseña" name="contraseña">
                </div>
                <!-- Botón de envío para el formulario con estilo de botón primario y ancho completo -->
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <!-- En este bloque PHP mostraremos mensajes de error si existen en la sesión -->
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger mt-2">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <!-- Estos enlaces centrados son para registro, contacto y acceso como visitante -->
            <div class="text-center mt-4">
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                <p>¿Necesitas ayuda? <a href="contacto.php">Contáctanos</a></p>
                <p>Accede como visitante <a href="visitante.php">aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html>