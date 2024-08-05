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

// Conectar a la base de datos
$connection = mysqli_connect($host, $user, $pass);
$datab = "aplicacionbdd";
// Seleccionar la base de datos
$db = mysqli_select_db($connection, $datab);
// Obtén el rol del usuario desde la base de datos
$sqlRol = "SELECT Id_Cargo FROM registro WHERE usuario = '" . $_SESSION["usuario"] . "'";
$resultRol = $connection->query($sqlRol);
$rol = ($resultRol->num_rows > 0) ? $resultRol->fetch_assoc()["Id_Cargo"] : null;
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EmpeñaFacil</title>
    <link rel="stylesheet" href="GestionarAdmin.css">
    <style>
    #Logo {
      margin-top: -100px;
      margin-left: 680px;
    }
    #SesionUsuario {
        margin-top: 60px;
        margin-left: 1200px;
        color: white;
    }
    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    /* Estilos del formulario de edición */
    #editarForm {
        display: none;
        background-color: #ffffff;
        padding: 20px;
        border: 1px solid #ccc;
        margin: 20px auto;
        width: 50%;
    }

    #editarForm label {
        display: block;
        margin-bottom: 10px;
        color: #333;
    }

    #editarForm input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    #editarForm input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    #editarForm input[type="submit"]:hover {
        background-color: #45a049;
    }
    table {
        border: none; /* Elimina el borde de la tabla */
    }
    </style>
</head>
<body>
    <div class="navegacion">
        <h2 id="SesionUsuario">Usuario Empresa: <?php echo $_SESSION["usuario"]; ?></h2>
        <div class="navbar">
            <a href="bienvenidaAdmin.php">Inicio</a>
            <a href="productos.php">Productos</a>
            <a href="consultar.php">Consultar</a>
            <a href="#contacto">Contacto</a>
        </div>
        <div class="navbarsesion">
            <a href="InicioSesion.php">Cerrar sesión</a>
            <a href="#">Gestionar</a>
        </div>
    </div>
    <img id="Logo" src="SecondCash (1).png" alt="">

    <?php
    // Consulta SQL para seleccionar todos los registros de la tabla 'registro'
    $sqlRegistro = "SELECT * FROM registro";
    $resultRegistro = $connection->query($sqlRegistro);

    // Consulta SQL para seleccionar todos los productos de la tabla 'productos'
    $sqlProducto = "SELECT * FROM productos";
    $resultProducto = $connection->query($sqlProducto);

    // Crear la tabla HTML para registros
    echo "<h3>Registros</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Usuario</th><th>Contraseña</th><th>Cargo</th><th></th><th></th></tr>";

    // Mostrar los resultados en la tabla de registros
    if ($resultRegistro->num_rows > 0) {
        while ($row = $resultRegistro->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["usuario"] . "</td>";
            echo "<td>" . $row["contraseña"] . "</td>";
            echo "<td>" . $row["Id_Cargo"] . "</td>";
            echo "<td><button onclick='editarRegistro(" . $row["id"] . ")'>Editar</button></td>";
            if ($rol != 3) {
                echo "<td><button onclick='eliminarRegistro(" . $row['id'] . ")'>Eliminar</button></td>";
            } else {
                echo "<td><button onclick='alert(\"Se necesita permiso de administración para eliminar\")'>Eliminar</button></td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";

    // Crear la tabla HTML para productos
    echo "<h3>Productos</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID Producto</th><th>ID Usuario</th><th>Tipo</th><th>Estado</th><th>Descripción</th><th></th><th></th></tr>";

    // Mostrar los resultados en la tabla de productos
    if ($resultProducto->num_rows > 0) {
        while ($row = $resultProducto->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["usuario_id"] . "</td>";
            echo "<td>" . $row["descripcion"] . "</td>";
            echo "<td>" . $row["tipo"] . "</td>";
            echo "<td>" . $row["estado"] . "</td>";
            echo "<td><button onclick='editarProducto(" . $row["id"] . ")'>Editar</button></td>";
            if ($rol != 3) {
                echo "<td><button onclick='eliminarProducto(" . $row['id'] . ")'>Eliminar</button></td>";
            } else {
                echo "<td><button onclick='alert(\"Se necesita permiso de administración para eliminar\")'>Eliminar</button></td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";

    $connection->close();
    ?>

    <div id="editarForm" style="display:none;">
        <form action="actualizar.php" method="post" id="editForm">
            <input type="hidden" name="id" id="editId">
            <input type="hidden" name="type" id="editType"> <!-- Campo oculto para tipo de entidad -->
            <!-- Campos específicos para registros -->
            <div id="registroFields">
                <label for="editUsuario">Usuario:</label>
                <input type="text" name="usuario" id="editUsuario"><br>
                <label for="editContraseña">Contraseña:</label>
                <input type="text" name="contraseña" id="editContraseña"><br>
                <label for="editId_Cargo">Cargo:</label>
                <input type="text" name="Id_Cargo" id="editId_Cargo"><br>
            </div>
            <!-- Campos específicos para productos -->
            <div id="productoFields" style="display:none;">
                <label for="editDescripcion">Descripción:</label>
                <input type="text" name="descripcion" id="editDescripcion"><br>
                <label for="editTipo">Tipo:</label>
                <input type="text" name="tipo" id="editTipo"><br>
                <label for="editEstado">Estado:</label>
                <input type="text" name="estado" id="editEstado"><br>
                <label for="editUsuarioId">Usuario ID:</label>
                <input type="text" name="usuario_id" id="editUsuarioId"><br>
            </div>
            <input type="submit" value="Guardar cambios">
        </form>
    </div>

    <script>
    function editarRegistro(id) {
        document.getElementById('editarForm').style.display = 'block';
        document.getElementById('editId').value = id;
        document.getElementById('editType').value = 'registro';

        // Mostrar campos para registros y ocultar campos para productos
        document.getElementById('productoFields').style.display = 'none';
        document.getElementById('registroFields').style.display = 'block';

        // Obtener los valores de la fila y llenar el formulario
        var row = document.querySelector(`button[onclick='editarRegistro(${id})']`).parentNode.parentNode;
        document.getElementById('editUsuario').value = row.cells[1].innerText;
        document.getElementById('editContraseña').value = row.cells[2].innerText;
        document.getElementById('editId_Cargo').value = row.cells[3].innerText;
    }

    function editarProducto(id) {
        document.getElementById('editarForm').style.display = 'block';
        document.getElementById('editId').value = id;
        document.getElementById('editType').value = 'producto';

        // Mostrar campos para productos y ocultar campos para registros
        document.getElementById('registroFields').style.display = 'none';
        document.getElementById('productoFields').style.display = 'block';

        // Obtener los valores de la fila y llenar el formulario
        var row = document.querySelector(`button[onclick='editarProducto(${id})']`).parentNode.parentNode;
        document.getElementById('editDescripcion').value = row.cells[2].innerText;
        document.getElementById('editTipo').value = row.cells[3].innerText;
        document.getElementById('editEstado').value = row.cells[4].innerText;
        document.getElementById('editUsuarioId').value = row.cells[1].innerText;
    }

    function eliminarRegistro(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este registro?")) {
            window.location.href = "eliminarRegistro.php?id=" + id;
        }
    }

    function eliminarProducto(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
            window.location.href = "eliminarProducto.php?id=" + id;
        }
    }
    </script>
</body>
</html>
