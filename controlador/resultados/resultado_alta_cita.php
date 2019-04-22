<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
require_once(MODELO."/GestionBD.php");
require_once(GESTIONAR."gestionar_citas.php");

if (isset($_SESSION["formulario_cita"])) {
	$cita = $_SESSION["formulario_cita"];
	unset($_SESSION["formulario_cita"]);
} else {
	Header("Location: ../../controlador/altas/alta_usuario.php");
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
  <title>Alta de cita</title>
  <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
 
</head>

<body>
    <?php include("../../vista/header.php");
    include("../../vista/navbar.php");
   
		if (nueva_cita($conexion, $cita)) {
    $_SESSION['citaId'] = aux_IdentificaCita( $conexion, $cita );
    ?> 
  <p>Todo ha ido bien </p> 
   <?php 
	} else {

		echo "La cita ya existe.";
	}
	?>


    </main>
    <?php cerrarConexionBD($conexion); ?>
    <?php include("../../vista/footer.php");  ?>
</body>

</html> 