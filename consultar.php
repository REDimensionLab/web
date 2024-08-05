<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Empeños</title>
    <link rel="stylesheet" href="BienvenidaCliente.css">
    <style>
        
        body {
        background-image: url('fondo2.jpeg'); /* Cambia 'ruta_de_tu_imagen.jpg' por la ubicación de tu imagen */
        background-size: 100% auto; /* Ajusta la imagen al ancho completo sin deformarla */
        background-repeat: no-repeat; /* Evita que la imagen se repita */
        
    }
    </style>
</head>
<body>
    <h1>Consultar Empeños</h1>
    <form action="resultadoConsulta.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" required><br>
        
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required><br>
        
        <input type="submit" value="Consultar">
    </form>
    <?php if (isset($_SESSION["Id_Cargo"]) && $_SESSION["Id_Cargo"] == 4): ?>
        <a href="bienvenidaInvitado.php">Volver al menú principal</a>
    <?php else: ?>
        <a href="#" onclick="volverAlMenu()">Volver al menú principal</a>
    <?php endif; ?>

    <script>
        function volverAlMenu() {
            <?php
            if (isset($_SESSION["Id_Cargo"])) {
                $id_cargo = $_SESSION["Id_Cargo"];
                if ($id_cargo == 1) {
                    echo 'window.location.href = "bienvenidaAdmin.php";';
                } elseif ($id_cargo == 2) {
                    echo 'window.location.href = "bienvenidaCliente.php";';
                } elseif ($id_cargo == 3) {
                    echo 'window.location.href = "bienvenidaEmpleado.php";';
                } else {
                    echo 'window.location.href = "bienvenidaInvitado.php";';
                }
            } else {
                echo 'window.location.href = "bienvenidaInvitado.php";';
            }
            ?>
        }
    </script>
</body>
</html>
