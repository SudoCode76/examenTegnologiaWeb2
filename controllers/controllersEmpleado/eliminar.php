<?php
require_once __DIR__ . '/../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sqlCheck = "SELECT * FROM EMPLEADO WHERE id_empleado = ?";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows === 0) {
        header("Location: ../../views/dashboard.php?error=Empleado no encontrado");
        exit();
    }

    $stmtCheck->close();

    $sql = "DELETE FROM EMPLEADO WHERE id_empleado = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
        exit();
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../views/dashboard.php?success=Empleado eliminado exitosamente");
    } else {
        header("Location: ../../views/dashboard.php?error=Error al eliminar empleado: " . urlencode($stmt->error));
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../views/dashboard.php?error=ID de empleado no especificado");
    exit();
}
?>
