<?php
// Validamos datos del servidor
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";

// Conectamos a la base de datos
$connection = mysqli_connect($host, $user, $pass);

// Verificamos la conexión
if (!$connection) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Hacemos llamado al input de formulario
$nombre = $_POST["nombre"];
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Indicamos el nombre de la base de datos
$datab = "aplicacionbdd";

// Seleccionamos la base de datos
$db = mysqli_select_db($connection, $datab);

// Verificamos si el nombre de usuario ya existe
$checkUserSQL = "SELECT * FROM registro WHERE usuario = '$usuario'";
$result = mysqli_query($connection, $checkUserSQL);

if (mysqli_num_rows($result) > 0) {
    // Si el usuario ya existe, redirigimos al formulario de registro con un mensaje de error
    header("Location: Registro.php?error=1");
    exit;
} else {
    // Insertamos datos de registro a MySQL indicando nombre de la tabla y sus atributos
    $instruccion_SQL = "INSERT INTO registro (nombre, usuario, contraseña, Id_Cargo) VALUES ('$nombre', '$usuario', '$contraseña', 2)";
    
    if (mysqli_query($connection, $instruccion_SQL)) {
        // Redirigimos al usuario a la página de inicio de sesión con un mensaje de éxito
        header("Location: InicioSesion.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Cerramos la conexión
mysqli_close($connection);
?>
