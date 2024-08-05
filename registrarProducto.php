<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si tiene el rango 1, 2 o 3
if (!isset($_SESSION["usuario"]) || !in_array($_SESSION["Id_Cargo"], [1, 2, 3])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["usuario_id"])) {
        die("Error: Usuario no identificado.");
    }

    $usuario_id = $_SESSION["usuario_id"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $estado = $_POST["estado"];

    $user = "root";
    $pass = "";
    $host = "127.0.0.1:3307";
    $database = "aplicacionbdd";

    // Conectamos a la base de datos
    $connection = mysqli_connect($host, $user, $pass, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Consulta SQL para insertar el nuevo producto
    $sql = "INSERT INTO productos (usuario_id, descripcion, tipo, estado) VALUES ('$usuario_id', '$descripcion', '$tipo', '$estado')";

    if (mysqli_query($connection, $sql)) {
        // Redirigir a la página de confirmación con un mensaje
        header("Location: confirmacion.php?mensaje=Producto registrado correctamente");
        exit;
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "Método no permitido";
}
?>
