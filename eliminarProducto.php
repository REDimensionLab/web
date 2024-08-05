<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}

// Conectamos a la base de datos
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";
$datab = "aplicacionbdd";

$connection = mysqli_connect($host, $user, $pass, $datab);

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener el ID del producto a eliminar
$id = $_GET['id'];

// Consulta SQL para eliminar el producto
$sql = "DELETE FROM productos WHERE id = ?";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Producto eliminado con éxito.";
} else {
    echo "Error al eliminar el producto: " . $stmt->error;
}

$stmt->close();
$connection->close();
header("Location: GestionarAdmin.php"); // Redirige de vuelta a la página de administración
exit;
?>
