<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: InicioSesion.php"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EmpeñaFacil</title>
    <link rel="stylesheet" href="BienvenidaAdmin.css">
    <style>
    #Logo {
      margin-top: -100px;
      margin-left: 680px;
    }
    #SesionUsuario{
        margin-top: 150px;
        margin-left: 830px;
    }
  </style>
</head>
<body>
    
    <div class="navegacion">
    
    <h2 id="SesionUsuario">Bienvenido, <?php echo $_SESSION["usuario"]; ?>!</h2>
        <div class="navbar">
            <a href="#inicio">Inicio</a>
            <a href="productos.php">Productos</a>
            <a href="consultar.php">Consultar</a>
            <a href="#contacto">Contacto</a>
        </div>
        <div class="navbarsesion">
            <a href="logout.php">Cerrar sesión</a> <!-- Actualizado para usar logout.php -->
            <a href="GestionarAdmin.php">Gestionar</a>
        </div>
        
    </div><img id="Logo" src="SecondCash (1).png" alt="">
    
    
</body>
</html>
