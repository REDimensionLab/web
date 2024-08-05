<?php
session_start(); // Debe estar al principio del archivo

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.html"); // Redirige al inicio de sesión si no ha iniciado sesión
    exit;
}

// Conexión a la base de datos
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";
$connection = mysqli_connect($host, $user, $pass, "aplicacionbdd");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $type = $_POST['type']; // Tipo de entidad ('registro' o 'producto')

    if ($type == 'registro') {
        // Obtener los valores del formulario
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $Id_Cargo = $_POST['Id_Cargo'];

        // Consulta SQL para actualizar el registro
        $sql = "UPDATE registro SET usuario = ?, contraseña = ?, Id_Cargo = ? WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $usuario, $contraseña, $Id_Cargo, $id);
    } elseif ($type == 'producto') {
        // Obtener los valores del formulario
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipo'];
        $estado = $_POST['estado'];
        $usuario_id = $_POST['usuario_id'];

        // Verificar si el usuario_id existe en la tabla registro
        $check_sql = "SELECT id FROM registro WHERE id = ?";
        $check_stmt = mysqli_prepare($connection, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "i", $usuario_id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) == 0) {
            echo "Error: El usuario_id especificado no existe en la tabla registro.";
            mysqli_close($connection);
            exit;
        }

        // Consulta SQL para actualizar el producto
        $sql = "UPDATE productos SET descripcion = ?, tipo = ?, estado = ?, usuario_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($connection, $sql);
        mysqli_stmt_bind_param($stmt, "sssii", $descripcion, $tipo, $estado, $usuario_id, $id);
    } else {
        echo "Tipo no válido";
        mysqli_close($connection);
        exit;
    }

    // Ejecutar la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo "Cambios guardados correctamente";
    } else {
        echo "Error guardando cambios: " . mysqli_stmt_error($stmt);
    }

    // Cerrar la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
} else {
    echo "No se ha enviado el formulario";
}
?>
