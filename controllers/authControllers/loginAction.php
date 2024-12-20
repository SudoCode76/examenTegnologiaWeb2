<?php
require_once __DIR__ . '/loginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if ($usuario && $password) {
        $controller = new LoginController();
        $user = $controller->login($usuario, $password);

        if ($user) {
            session_start();
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['rol'] = $user['nombre']; 
            header("Location: ../../views/dashboard.php");
            exit();
        } else {
            header("Location: ../../index.php?error=1");
            exit();
        }
    } else {
        header("Location: ../../index.php?error=1");
        exit();
    }
}
?>
