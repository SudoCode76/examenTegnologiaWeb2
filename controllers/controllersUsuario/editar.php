<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Inicializar variables para mensajes de éxito o error
$mensaje = "";

// Verificar si se ha pasado el ID del usuario a través de GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Asegurar que el ID es un entero

    // Procesar el formulario cuando se envíe una solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener y sanitizar los datos del formulario
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);
        $id_perfil = intval($_POST['id_perfil']);

        // Validar los campos requeridos
        if (empty($nombre) || empty($apellido) || empty($usuario) || empty($password) || empty($id_perfil)) {
            $mensaje = "Por favor, completa todos los campos obligatorios.";
        } else {
            // Preparar la consulta SQL para actualizar el usuario
            $sql = "UPDATE USUARIO SET nombre = ?, apellido = ?, usuario = ?, password = ?, id_perfil = ? WHERE id_usuario = ?";
            $stmt = $conexion->prepare($sql);

            if ($stmt) {
                // Vincular los parámetros
                $stmt->bind_param("ssssii", $nombre, $apellido, $usuario, $password, $id_perfil, $id);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Redirigir con mensaje de éxito
                    header("Location: ../../views/dashboard.php?success=Usuario actualizado exitosamente");
                    exit();
                } else {
                    // Redirigir con mensaje de error
                    header("Location: ../../views/dashboard.php?error=Error al actualizar usuario: " . urlencode($stmt->error));
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

    // Obtener los datos actuales del usuario para prellenar el formulario
    $sql = "SELECT * FROM USUARIO WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
    } else {
        // Redirigir si el usuario no se encuentra
        header("Location: ../../views/dashboard.php?error=Usuario no encontrado");
        exit();
    }

    // Obtener los perfiles para el campo de selección
    $sqlPerfiles = "SELECT id_perfil, nombre FROM PERFIL";
    $resultPerfiles = $conexion->query($sqlPerfiles);

    if (!$resultPerfiles) {
        die("Error al obtener los perfiles: " . $conexion->error);
    }

    $perfiles = $resultPerfiles->fetch_all(MYSQLI_ASSOC);

    // Cerrar el statement
    $stmt->close();
} else {
    // Redirigir si no se ha proporcionado un ID
    header("Location: ../../views/dashboard.php?error=ID de usuario no especificado");
    exit();
}

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Enlace a DaisyUI y Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold mb-6">Editar Usuario</h1>

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

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" class="space-y-6">
            <!-- Nombre -->
            <div class="form-control">
                <label for="nombre" class="label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="input input-bordered" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>

            <!-- Apellido -->
            <div class="form-control">
                <label for="apellido" class="label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="input input-bordered" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
            </div>

            <!-- Usuario -->
            <div class="form-control">
                <label for="usuario" class="label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="input input-bordered" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
            </div>

            <!-- Contraseña -->
            <div class="form-control">
                <label for="password" class="label">Contraseña:</label>
                <input type="password" id="password" name="password" class="input input-bordered" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>
            </div>

            <!-- Perfil -->
            <div class="form-control">
                <label for="id_perfil" class="label">Perfil:</label>
                <select id="id_perfil" name="id_perfil" class="select select-bordered" required>
                    <option value="" disabled>Selecciona un perfil</option>
                    <?php foreach ($perfiles as $perfil) : ?>
                        <option value="<?php echo htmlspecialchars($perfil['id_perfil']); ?>" <?php if ($usuario['id_perfil'] == $perfil['id_perfil']) echo 'selected'; ?> >
                            <?php echo htmlspecialchars($perfil['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón de Envío -->
            <div class="form-control">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</body>
</html>
