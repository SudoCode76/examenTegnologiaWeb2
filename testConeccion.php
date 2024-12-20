<?php
require_once 'config/conexion.php';

if ($conexion->connect_errno) {
    die("Falló la conexión a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos'.";
}
?>
