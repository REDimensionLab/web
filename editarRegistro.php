<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: InicioSesion.php"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];
    $Id_Cargo = $_POST["Id_Cargo"];

    $user = "root";
    $pass = "";
    $host = "127.0.0.1:3307";

    $connection = mysqli_connect($host, $user, $pass, "aplicacionbdd");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE registro SET usuario='$usuario', contraseña='$contraseña', Id_Cargo='$Id_Cargo' WHERE id=$id";

    if (mysqli_query($connection, $sql)) {
        header("Location: GestionarAdmin.php"); // Redirige de nuevo a la página principal
        exit(); // Asegura que no se ejecuta más código después de la redirección
    } else {
        echo "Error actualizando registro: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "Método no permitido";
}
?>
