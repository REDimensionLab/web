<?php
session_start();

// Datos de conexión
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass, "aplicacionbdd");

// Recibir los datos del formulario
$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Validar el usuario y la contraseña
$query = "SELECT * FROM registro WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
$result = mysqli_query($connection, $query);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de Consulta</title>
    <link rel="stylesheet" href="BienvenidaCliente.css">
</head>
<body>
    <div class="container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            // Si las credenciales son válidas, buscar los empeños del usuario
            $row = mysqli_fetch_assoc($result);
            $usuario_id = $row['id'];

            $queryEmpeños = "SELECT * FROM productos WHERE usuario_id = '$usuario_id'";
            $resultEmpeños = mysqli_query($connection, $queryEmpeños);

            echo "<h1>Empeños de $usuario</h1>";
            if (mysqli_num_rows($resultEmpeños) > 0) {
                echo "<table>
                        <tr>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($resultEmpeños)) {
                    echo "<tr>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['tipo']}</td>
                            <td>{$row['estado']}</td>
                            <td>{$row['fecha']}</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "No se encontraron empeños para este usuario.";
            }
        } else {
            echo "Usuario o contraseña incorrectos.";
        }

        mysqli_close($connection);
        ?>
        <a href="consultar.php">Volver</a>
        <a href="#" onclick="volverAlMenu()">Volver al menú principal</a>

    <script>
        function volverAlMenu() {
            <?php
            if (isset($_SESSION["Id_Cargo"])) {
                $id_cargo = $_SESSION["Id_Cargo"];
                if ($id_cargo == 1) {
                    echo 'window.location.href = "bienvenidaAdmin.php";';
                } elseif ($id_cargo == 2) {
                    echo 'window.location.href = "bienvenidaCliente.php";';
                } elseif ($id_cargo == 3) {
                    echo 'window.location.href = "bienvenidaEmpleado.php";';
                } else {
                    echo 'window.location.href = "bienvenidaInvitado.php";';
                }
            } else {
                echo 'window.location.href = "bienvenidaInvitado.php";';
            }
            ?>
        }
    </script>
    </div>
</body>
</html>
