<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $id_perfil = intval($_POST['id_perfil']);

    if (empty($nombre) || empty($apellido) || empty($usuario) || empty($password) || empty($id_perfil)) {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    } else {
        $sql = "INSERT INTO USUARIO (nombre, apellido, usuario, password, id_perfil) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $nombre, $apellido, $usuario, $password, $id_perfil);

            if ($stmt->execute()) {
                header("Location: ../../views/dashboard.php?success=Usuario añadido exitosamente");
                exit();
            } else {
                header("Location: ../../views/dashboard.php?error=Error al añadir usuario: " . urlencode($stmt->error));
                exit();
            }

            $stmt->close();
        } else {
            header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
            exit();
        }
    }
}

$sqlPerfiles = "SELECT id_perfil, nombre FROM PERFIL";
$resultPerfiles = $conexion->query($sqlPerfiles);

if (!$resultPerfiles) {
    die("Error al obtener los perfiles: " . $conexion->error);
}

$perfiles = $resultPerfiles->fetch_all(MYSQLI_ASSOC);

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold mb-6">Añadir Nuevo Usuario</h1>

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
            <!-- Nombre -->
            <div class="form-control">
                <label for="nombre" class="label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="input input-bordered" required>
            </div>

            <!-- Apellido -->
            <div class="form-control">
                <label for="apellido" class="label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="input input-bordered" required>
            </div>

            <!-- Usuario -->
            <div class="form-control">
                <label for="usuario" class="label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="input input-bordered" required>
            </div>

            <!-- Contraseña -->
            <div class="form-control">
                <label for="password" class="label">Contraseña:</label>
                <input type="password" id="password" name="password" class="input input-bordered" required>
            </div>

            <!-- Perfil -->
            <div class="form-control">
                <label for="id_perfil" class="label">Perfil:</label>
                <select id="id_perfil" name="id_perfil" class="select select-bordered" required>
                    <option value="" disabled selected>Selecciona un perfil</option>
                    <?php foreach ($perfiles as $perfil) : ?>
                        <option value="<?php echo htmlspecialchars($perfil['id_perfil']); ?>">
                            <?php echo htmlspecialchars($perfil['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-control">
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </div>
        </form>
    </div>
</body>
</html>
