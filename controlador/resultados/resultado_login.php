<?php
	session_start();
	
	include("../../modelo/gestionar/gestionar_login.php"); 
	require_once("../../modelo/GestionBD.php");	
	
	if (isset($_SESSION["formulario"])) {
		$usuariologin = $_SESSION["formulario"];
		unset($_SESSION["formulario"]);
		}
		else{
			Header("Location: ../../controlador/acceso/login.php"); 
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
  <title>Alta de Usuario</title>
  <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
 
</head>

<body background="../../vista/img/background.png">
<?php include ("../../vista/header.php");
			 $errores = array();
				if(consultarVoluntarioRepetido($conexion, $usuariologin) == 1 ){
					
					$_SESSION["nombreusuario"] = $usuariologin["nombrelogin"];
					Header("Location: ../../controlador/altas/alta_usuario.php");
					//Header("Location: ../../vista/home.php"); 
				}
	
		?>
		
	<?php cerrarConexionBD($conexion); 
    include("../../vista/footer.php");  ?>
</body>

</html> 