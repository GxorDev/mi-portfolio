<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Aplicamos Bootstrap para un diseño responsivo y moderno -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Estilos personalizados para darle nuestro toque especial a la página -->
    <style>
        /* Ajustamos el margen superior para que el formulario no esté muy pegado al inicio de la página */
        .formulario-container {
            margin-top: 50px; /* Este valor lo podemos adaptar */
        }

        /* Un pequeño botón de 'Volver Atrás' para mejorar la experiencia del usuario */
        .btn-volver-atras {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: auto; /* Éste código es para que el botón se ajuste al texto */
            padding: 5px 10px; /* Ponemos un poco de padding para que se vea mejor */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <!-- Centramos el formulario en la página para un mejor enfoque -->
        <div class="row justify-content-center formulario-container">
            <div class="col-md-6">
                <!-- Título claro y directo para nuestra página de registro -->
                <h1 class="text-center my-4">Registro de Usuario</h1>
                <!-- Formulario donde los usuarios se registran -->
                <form action="procesar_registro.php" method="post" class="border p-4 bg-white shadow">
                    <!-- Campo para el nombre, imprescindible para obtener los datos de los usuarios -->
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="txtUsuario" class="form-control" required>
                    </div>
                    
                    <!-- Email, vital para obtener el dato -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="txtEmail" class="form-control" required>
                    </div>
                    
                    <!-- Contraseña, lo mismo que lo anterior, dato crucial. -->
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <input type="password" id="contraseña" name="txtContraseña" class="form-control" required>
                    </div>
                    
                    <!-- Mostramos un botón llamativo para enviar la información -->
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Botón útil para regresar al punto anterior sin perderse -->
    <button type="button" class="btn btn-primary btn-volver-atras" onclick="history.back()">Volver Atrás</button>
</body>
</html>