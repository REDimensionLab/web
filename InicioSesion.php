<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión actual
session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = "root"; // Usuario de la base de datos
    $pass = ""; // Contraseña de la base de datos (si está vacía, deja la cadena vacía)
    $host = "127.0.0.1:3307"; // Host de la base de datos
    $db = "aplicacionbdd"; // Nombre de la base de datos

    // Conectar a la base de datos
    $connection = mysqli_connect($host, $user, $pass, $db);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_POST["usuario"]) && isset($_POST["contraseña"])) {
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];

        $query = "SELECT * FROM registro WHERE usuario = ? AND contraseña = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("ss", $usuario, $contraseña);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["usuario_id"] = $row["id"]; // Asigna el id del usuario a la sesión
            $_SESSION["usuario"] = $row["usuario"];
            $_SESSION["Id_Cargo"] = $row["Id_Cargo"];

            if ($row["Id_Cargo"] == 1) {
                header("Location: bienvenidaAdmin.php");
            } elseif ($row["Id_Cargo"] == 2) {
                header("Location: bienvenidaCliente.php");
            } elseif ($row["Id_Cargo"] == 3) {
                header("Location: bienvenidaEmpleado.php");
            } else {
                header("Location: bienvenidaInvitado.php");
            }
            exit;
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } elseif (isset($_POST["invited"])) {
        $_SESSION["usuario_id"] = null; // Para invitados, no hay usuario_id
        $_SESSION["usuario"] = "Invitado";
        $_SESSION["Id_Cargo"] = 4;
        header("Location: bienvenidaInvitado.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="InicioSesion.css">
    <style>
       body {
        background-image: url('fondo2.jpeg'); /* Cambia 'ruta_de_tu_imagen.jpg' por la ubicación de tu imagen */
        background-size: 100% auto; /* Ajusta la imagen al ancho completo sin deformarla */
        background-repeat: no-repeat; /* Evita que la imagen se repita */
    }
</style>
</head>
<body>
    
    <form method="post" action="InicioSesion.php">
        <h1>Iniciar sesión</h1>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>
        <input type="submit" value="Iniciar sesión">
        <h4>No tienes cuenta? Crea una <a href="Registro.php">Aquí</a></h4>
    </form>
    <form action="bienvenidaInvitado.php" method="post">
        <input type="hidden" name="invited" value="true">
        <input type="submit" value="Acceder como Invitado">
    </form>
</body>
</html>
