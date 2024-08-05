<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="Registro.css">
</head>
<body>
    <form method="post" action="RegistroP.php" id="registroForm">
        <h1>Registro</h1>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p style='color: red;'>El nombre de usuario ya existe. Por favor, elija otro.</p>";
        }
        ?>
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <input type="submit" name="register" value="Registrar">
    </form>
    <script>
        if (window.location.search.indexOf('success=1') > -1) {
            alert('Los datos se han enviado correctamente.');
        }
    </script>
</body>
</html>
