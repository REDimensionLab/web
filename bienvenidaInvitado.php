
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EmpeñaFacil</title>
    <link rel="stylesheet" href="BienvenidaAdmin.css">
    <style>
    #Logo {
      margin-top: -100px;
      margin-left: 680px;
    }
    #SesionUsuario{
        margin-top: 150px;
        margin-left: 830px;
    }
  </style>
</head>
<body>
    
<div class="navegacion">
        <div class="navbar">
            <a href="#inicio">Inicio</a>
            <a href="#" onclick="mostrarAlertaProductos()">Productos</a>
            <a href="consultar.php">Consultar</a>
            <a href="#contacto">Contacto</a>
        </div>
        <div class="navbarsesion">
            <a href="InicioSesion.php">Iniciar Sesion</a>
            <a href="#" onclick="mostrarAlertaGestionar()">Gestionar</a>
        </div>
    </div>
    <img id="Logo" src="SecondCash (1).png" alt="">

    
    <script>
        function mostrarAlertaProductos() {
            alert('Necesitas iniciar sesión para poder disponer de esa función');
        }

        function mostrarAlertaGestionar() {
            alert('Solo personal autorizado');
        }
    </script>
</body>
</html>