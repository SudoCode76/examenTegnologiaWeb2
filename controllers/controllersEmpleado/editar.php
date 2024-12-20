<?php
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = "";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $apellido = trim($_POST['apellido']);
        $nombre = trim($_POST['nombre']);
        $telefono = trim($_POST['telefono']);
        $direccion = trim($_POST['direccion']);
        $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
        $observaciones = trim($_POST['observaciones']);
        $sueldo = intval($_POST['sueldo']);
        $id_departamento = intval($_POST['id_departamento']);

        if (empty($apellido) || empty($nombre) || empty($telefono) || empty($direccion) || empty($fecha_nacimiento) || empty($sueldo) || empty($id_departamento)) {
            $mensaje = "Por favor, completa todos los campos obligatorios.";
        } else {
            $sql = "UPDATE EMPLEADO SET apellido = ?, nombre = ?, telefono = ?, direcccion = ?, fecha_nacimiento = ?, observaciones = ?, sueldo = ?, id_departamento = ? WHERE id_empleado = ?";
            $stmt = $conexion->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssssssiii", $apellido, $nombre, $telefono, $direccion, $fecha_nacimiento, $observaciones, $sueldo, $id_departamento, $id);

                if ($stmt->execute()) {
                    header("Location: ../../views/dashboard.php?success=Empleado actualizado exitosamente");
                    exit();
                } else {
                    header("Location: ../../views/dashboard.php?error=Error al actualizar empleado: " . urlencode($stmt->error));
                    exit();
                }

                $stmt->close();
            } else {
                header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
                exit();
            }
        }
    }

    $sql = "SELECT * FROM EMPLEADO WHERE id_empleado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $empleado = $result->fetch_assoc();
    } else {
        header("Location: ../../views/dashboard.php?error=Empleado no encontrado");
        exit();
    }

    $sqlDepartamentos = "SELECT id_departamento, nombre FROM DEPARTAMENTO";
    $resultDepartamentos = $conexion->query($sqlDepartamentos);

    if (!$resultDepartamentos) {
        die("Error al obtener los departamentos: " . $conexion->error);
    }

    $departamentos = $resultDepartamentos->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    header("Location: ../../views/dashboard.php?error=ID de empleado no especificado");
    exit();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold mb-6">Editar Empleado</h1>

        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-error shadow-lg mb-5">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span><?php echo htmlspecialchars($mensaje); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" class="space-y-6">
            <!-- Apellido -->
            <div class="form-control">
                <label for="apellido" class="label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required>
            </div>

            <!-- Nombre -->
            <div class="form-control">
                <label for="nombre" class="label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
            </div>

            <!-- Teléfono -->
            <div class="form-control">
                <label for="telefono" class="label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['telefono']); ?>" required>
            </div>

            <!-- Dirección -->
            <div class="form-control">
                <label for="direccion" class="label">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['direcccion']); ?>" required>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="form-control">
                <label for="fecha_nacimiento" class="label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['fecha_nacimiento']); ?>" required>
            </div>

            <!-- Observaciones -->
            <div class="form-control">
                <label for="observaciones" class="label">Observaciones:</label>
                <input type="text" id="observaciones" name="observaciones" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['observaciones']); ?>">
            </div>

            <!-- Sueldo -->
            <div class="form-control">
                <label for="sueldo" class="label">Sueldo:</label>
                <input type="number" id="sueldo" name="sueldo" class="input input-bordered" value="<?php echo htmlspecialchars($empleado['sueldo']); ?>" required>
            </div>

            <!-- Departamento -->
            <div class="form-control">
                <label for="id_departamento" class="label">Departamento:</label>
                <select id="id_departamento" name="id_departamento" class="select select-bordered" required>
                    <option value="" disabled>Selecciona un departamento</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo htmlspecialchars($departamento['id_departamento']); ?>" <?php if ($empleado['id_departamento'] == $departamento['id_departamento']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($departamento['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>
