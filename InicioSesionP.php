<?php
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";

//conetamos al base datos
$connection = mysqli_connect($host, $user, $pass,);
$datab = "aplicacionbdd";
//indicamos selecionar ala base datos
$db = mysqli_select_db($connection,$datab);
// Recibir datos del formulario
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Consulta SQL para verificar el usuario y la contraseña
$sql = "SELECT * FROM registro WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
$resultado = mysqli_query($connection, $sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();
    // Iniciar sesión y redirigir según el rol
    session_start();
    // Después de validar el inicio de sesión...
$_SESSION["usuario_id"] = $row["id"];
$_SESSION["usuario"] = $row["usuario"];
$_SESSION["Id_Cargo"] = $row["Id_Cargo"];


    switch ($row['Id_Cargo']) {
        case 1:
            header("Location: bienvenidaAdmin.php");
            break;
        case 2:
            header("Location: bienvenidaCliente.php");
            break;
        case 3:
            header("Location: bienvenidaEmpleado.php");
            break;
        case 4:
            header("Location: bienvenidaInvitado.php");
            break;
        default:
            echo "Rol no válido.";
    }
} else {
    echo "Usuario o contraseña incorrectos.";
}

// Cerrar la conexión a la base de datos
mysqli_close($connection);
