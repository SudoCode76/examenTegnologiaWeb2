<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = "";

// Procesar el formulario cuando se envíe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
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
        $sql = "INSERT INTO EMPLEADO (apellido, nombre, telefono, direcccion, fecha_nacimiento, observaciones, sueldo, id_departamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Vincular los parámetros
            $stmt->bind_param("ssssssii", $apellido, $nombre, $telefono, $direccion, $fecha_nacimiento, $observaciones, $sueldo, $id_departamento);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir con mensaje de éxito
                header("Location: ../../views/dashboard.php?success=Empleado añadido exitosamente");
                exit();
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../views/dashboard.php?error=Error al añadir empleado: " . urlencode($stmt->error));
                exit();
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            // Redirigir si hay un error en la preparación del statement
            header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
            exit();
        }
    }
}

// Obtener los departamentos para el campo de selección
$sqlDepartamentos = "SELECT id_departamento, nombre FROM DEPARTAMENTO";
$resultDepartamentos = $conexion->query($sqlDepartamentos);

if (!$resultDepartamentos) {
    die("Error al obtener los departamentos: " . $conexion->error);
}

$departamentos = $resultDepartamentos->fetch_all(MYSQLI_ASSOC);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Empleado</title>
    <!-- Enlace a DaisyUI y Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold mb-6">Añadir Nuevo Empleado</h1>

        <!-- Mostrar mensaje de error si existe -->
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

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-6">
            <!-- Apellido -->
            <div class="form-control">
                <label for="apellido" class="label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="input input-bordered" required>
            </div>

            <!-- Nombre -->
            <div class="form-control">
                <label for="nombre" class="label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="input input-bordered" required>
            </div>

            <!-- Teléfono -->
            <div class="form-control">
                <label for="telefono" class="label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="input input-bordered" required>
            </div>

            <!-- Dirección -->
            <div class="form-control">
                <label for="direccion" class="label">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="input input-bordered" required>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="form-control">
                <label for="fecha_nacimiento" class="label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="input input-bordered" required>
            </div>

            <!-- Observaciones -->
            <div class="form-control">
                <label for="observaciones" class="label">Observaciones:</label>
                <input type="text" id="observaciones" name="observaciones" class="input input-bordered">
            </div>

            <!-- Sueldo -->
            <div class="form-control">
                <label for="sueldo" class="label">Sueldo:</label>
                <input type="number" id="sueldo" name="sueldo" class="input input-bordered" required>
            </div>

            <!-- Departamento -->
            <div class="form-control">
                <label for="id_departamento" class="label">Departamento:</label>
                <select id="id_departamento" name="id_departamento" class="select select-bordered" required>
                    <option value="" disabled selected>Selecciona un departamento</option>
                    <?php foreach ($departamentos as $departamento) : ?>
                        <option value="<?php echo htmlspecialchars($departamento['id_departamento']); ?>">
                            <?php echo htmlspecialchars($departamento['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón de Envío -->
            <div class="form-control">
                <button type="submit" class="btn btn-primary">Guardar Empleado</button>
            </div>
        </form>
    </div>
</body>
</html>
