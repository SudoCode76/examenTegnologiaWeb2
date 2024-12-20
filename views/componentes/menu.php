<?php
require_once __DIR__ . '/../../config/checkSession.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="navbar bg-base-100 shadow-md">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <!-- Menús para móviles -->
                <li><a href="#">PERFIL</a></li>
            <li><a href="#">USUARIO</a></li>
            <li><a href="#">DEPARTAMENTO</a></li>
            <li><a href="#">EMPLEADO</a></li>
            <li><a href="#">JUGUETE</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost text-xl">Dashboard</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <!-- Menús para escritorio -->
            <li><a href="#">PERFIL</a></li>
            <li><a href="#">USUARIO</a></li>
            <li><a href="#">DEPARTAMENTO</a></li>
            <li><a href="#">EMPLEADO</a></li>
            <li><a href="#">JUGUETE</a></li>


        </ul>
    </div>
    <div class="navbar-end">
        <a class="btn btn-outline btn-error" href="../controllers/authControllers/logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L14.586 11H7a1 1 0 110-2h7.586l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Cerrar sesión
        </a>
    </div>
</div>

</body>
</html>