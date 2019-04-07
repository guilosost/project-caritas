<?php
session_start();

include("../../modelo/GestionBD.php");


if (isset($_SESSION["formulario"])) {
    $cita = $_SESSION["formulario"];
    unset($_SESSION["formulario"]);
} else {
    Header("Location: ../../controlador/altas/alta_ayuda.php");
}

$conexion  = crearConexionBD();
?>
<!DOCTYPE html>
<html lang="es">

<head>
<link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
  <link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
  <link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
  <link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Alta de ayuda</title>
  <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
 
</head>

<body>
    <?php include("../../vista/header.php");


    if (alta_ayuda($conexion, $ayuda)) {
        ?>
    <p>Todo ha ido bien </p>
    <?php 
} else {
    echo "La ayuda ya existe.";
}
?>


    </main>
    <?php cerrarConexionBD($conexion); ?>
    <?php include("../../vista/footer.php");  ?>
</body>

</html> 