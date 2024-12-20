<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Recuperar el rol del usuario
$rol = $_SESSION['rol'] ?? 'usuario'; // Asigna 'usuario' por defecto si no está definido
?>
