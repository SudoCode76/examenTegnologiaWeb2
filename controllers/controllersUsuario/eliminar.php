<?php

require_once __DIR__ . '/../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // Verificar si el usuario existe
    $sqlCheck = "SELECT * FROM USUARIO WHERE id_usuario = ?";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows === 0) {
        header("Location: ../../views/dashboard.php?error=Usuario no encontrado");
        exit();
    }

    $stmtCheck->close();

    // Eliminar el usuario
    $sql = "DELETE FROM USUARIO WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../views/dashboard.php?success=Usuario eliminado exitosamente");
    } else {
        header("Location: ../../views/dashboard.php?error=Error al eliminar usuario: " . urlencode($stmt->error));
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../views/dashboard.php?error=ID de usuario no especificado");
    exit();
}
?>
