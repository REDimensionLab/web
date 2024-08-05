<?php
session_start();

if (!isset($_GET['mensaje'])) {
    header("Location: productos.php");
    exit;
}

$mensaje = $_GET['mensaje'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación</title>
    <style>
        .mensaje {
            text-align: center;
            margin-top: 50px;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <h1><?php echo $mensaje; ?></h1>
        <p>Serás redirigido en 3 segundos...</p>
    </div>

    <?php
    // Redirigir automáticamente después de 3 segundos
    header("refresh:3;url=productos.php");
    ?>
</body>
</html>
