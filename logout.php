<?php
session_start();
session_unset(); // Limpia todas las variables de sesión
session_destroy(); // Destruye la sesión actual
header("Location: InicioSesion.php");
exit;

?>
