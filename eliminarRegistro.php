<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $user = "root";
    $pass = "";
    $host = "127.0.0.1:3307";

    // Conectamos a la base de datos
    $connection = mysqli_connect($host, $user, $pass, "aplicacionbdd");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Primero eliminamos los productos asociados
    $sqlDeleteProductos = "DELETE FROM productos WHERE usuario_id = $id";
    if (!mysqli_query($connection, $sqlDeleteProductos)) {
        echo "Error eliminando productos: " . mysqli_error($connection);
        mysqli_close($connection);
        exit;
    }

    // Ahora eliminamos el registro
    $sqlDeleteRegistro = "DELETE FROM registro WHERE id = $id";
    if (mysqli_query($connection, $sqlDeleteRegistro)) {
        echo "Registro eliminado correctamente";
        header("Location: GestionarAdmin.php"); // Redirige de nuevo a la página principal
        exit;
    } else {
        echo "Error eliminando registro: " . mysqli_error($connection);
    }

    mysqli_close($connection);
} else {
    echo "ID no especificado";
}
?>
