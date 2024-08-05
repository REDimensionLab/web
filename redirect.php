<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html");
    exit;
}

// Redirige al usuario a la página correcta según su rango
switch ($_SESSION["Id_Cargo"]) {
    case 1: // Admin
        header("Location: bienvenidaAdmin.php");
        break;
    case 2: // Cliente
        header("Location: bienvenidaCliente.php");
        break;
    case 3: // Empleado
        header("Location: bienvenidaEmpleado.php");
        break;
    default:
        // Si el rango no es válido, redirige al login o a una página de error
        header("Location: login.html");
        break;
}
exit;
?>
