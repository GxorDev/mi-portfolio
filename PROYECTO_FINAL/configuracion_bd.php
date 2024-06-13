<?php

// Aquí aparecen los datos de conexión a la base de datos
$host = "localhost"; 
$usuario = "root"; 
$contraseña = ""; 
$nombre_bd = "bd"; 

// Aquí se procede a establecer la conexión a la base de datos
$conexion = mysqli_connect($host, $usuario, $contraseña, $nombre_bd);

// Y luego se verifica
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>