<?php
// Iniciamos la conexión a la base de datos para obtener información de los usuarios
$conexion = mysqli_connect("localhost", "root", "", "bd");

// Preparamos una consulta SQL para obtener los usuarios y sus cargos
$consulta = "SELECT usuarios.id, usuarios.Usuario, usuarios.Email, usuarios.Contraseña, cargo.id AS Cargo 
             FROM usuarios 
             INNER JOIN cargo ON usuarios.id_cargo = cargo.id";

// Ejecutamos la consulta y almacenamos el resultado
$resultado = mysqli_query($conexion, $consulta);

// Iteramos sobre cada fila del resultado para mostrar los datos de los usuarios
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Comenzamos la fila de la tabla
    echo "<tr>";
    // Mostramos cada columna con los datos del usuario
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . $fila['Usuario'] . "</td>";
    echo "<td>" . $fila['Email'] . "</td>";
    echo "<td>" . $fila['Contraseña'] . "</td>";
    // Aquí se muestra el cargo del usuario, obtenido mediante la unión con la tabla 'cargo'
    echo "<td>" . $fila['Cargo'] . "</td>";
    // Aquí se proporcionan enlaces para editar y eliminar usuarios, pasando el ID como parámetro GET
    echo "<td><a href='editar_usuario.php?id=" . $fila['id'] . "'>Editar</a> | <a href='eliminar_usuario.php?id=" . $fila['id'] . "'>Eliminar</a></td>";
    // Cerramos la fila de la tabla
    echo "</tr>";
}

// Finalizamos la conexión a la base de datos para liberar recursos
mysqli_close($conexion);
?>