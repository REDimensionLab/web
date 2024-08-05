
<?php
$user = "root";
$pass = "";
$host = "127.0.0.1:3307";

//conetamos al base datos
$connection = mysqli_connect($host, $user, $pass,);
$datab = "aplicacionbdd";
//indicamos selecionar ala base datos
$db = mysqli_select_db($connection,$datab);
// Obtener el ID del registro desde la URL
$id = $_GET['id'];

// Preparar y ejecutar la consulta
$sql = "SELECT * FROM tu_tabla WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo "0 results";
}

$conn->close();   

?>