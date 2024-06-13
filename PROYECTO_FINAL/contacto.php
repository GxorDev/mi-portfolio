<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <!-- Enlazamos al CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <style>
        /* Estilo personalizado para ajustar el margen superior del formulario */
        .formulario-container {
            margin-top: 0px; /* Se puede ajustar el margen superior según sea necesario */
        }

        /* Aquí esta el estilo para el botón de volver atrás */
        .btn-volver-atras {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 80px; /* Ancho del botón */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center formulario-container">
            <div class="col-md-6">
                <h1 class="text-center my-4">Contacto</h1>
                <form action="enviar_contacto.php" method="post" class="border p-4 bg-white shadow">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="mensaje">Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" rows="4" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Enviar mensaje</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Botón para volver a la página anterior en la parte inferior izquierda -->
    <button type="button" class="btn btn-primary btn-volver-atras" onclick="history.back()">Volver Atrás</button>
</body>
</html>