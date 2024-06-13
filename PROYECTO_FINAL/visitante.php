<?php
// Redirección al catálogo de productos.
// Utilizamos la función header para navegar hacia 'catalogo.php'.
header("Location: catalogo.php");

// Finalizamos la ejecución del script para evitar cargar innecesariamente el resto de la página.
exit();
?>