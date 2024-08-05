<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si tiene el rango 1, 2 o 3
if (!isset($_SESSION["usuario"]) || !in_array($_SESSION["Id_Cargo"], [1, 2, 3])) {
    header("Location: login.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empeñar Producto</title>
    <link rel="stylesheet" href="productos.css">
</head>
<body>
    <div class="container">
        <h1>Empeñar Producto</h1>
        <form action="registrarProducto.php" method="post">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required></textarea><br>

            <label for="tipo">Tipo de objeto:</label>
            <input type="text" name="tipo" id="tipo" required><br>

            <label for="estado">Estado del objeto:</label>
            <input type="text" name="estado" id="estado" required><br>

            <input type="submit" value="Registrar">
        </form>
        <a href="redirect.php" class="back-button">Volver a la página principal</a>
    </div>
</body>
</html>
