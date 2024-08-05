<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}

$user = "root";
$pass = "";
$host = "127.0.0.1:3307";
$datab = "aplicacionbdd";

// Conectamos a la base de datos
$connection = mysqli_connect($host, $user, $pass, $datab);

if (!$connection) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = $_POST['id'];
$type = $_POST['type'];

if ($type == 'registro') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $Id_Cargo = $_POST['Id_Cargo'];

    $sql = "UPDATE registro SET usuario = ?, contraseña = ?, Id_Cargo = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssi", $usuario, $contraseña, $Id_Cargo, $id);

} elseif ($type == 'producto') {
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $usuario_id = $_POST['usuario_id'];

    $sql = "UPDATE productos SET descripcion = ?, tipo = ?, estado = ?, usuario_id = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssii", $descripcion, $tipo, $estado, $usuario_id, $id);

}

if ($stmt->execute()) {
    echo "Registro actualizado con éxito.";
} else {
    echo "Error al actualizar el registro: " . $stmt->error;
}

$stmt->close();
$connection->close();
header("Location: GestionarAdmin.php"); // Redirige de vuelta a la página de administración
exit;
?>
