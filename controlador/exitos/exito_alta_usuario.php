<?php
	session_start();
	
	include("../../modelo/gestionar/gestionar_usuarios.php"); 
	require_once("../../modelo/GestionBD.php");	
	
	if (isset($_SESSION["formulario"])) {
		$usuario = $_SESSION["formulario"];
		unset($_SESSION["formulario"]);
		}
		else{
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
  <title>Alta de Usuario</title>
  <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
 
</head>

<body background="../../vista/img/background.png">
		<?php include ("../../vista/header.php"); 
			if ($usuario["solicitante"]=="Sí"){
			$d = alta_solicitante($conexion,$usuario);
			if(alta_solicitante($conexion,$usuario)){
				echo $d;
        	echo"Todo ha ido bien";
			
			} else{
				echo "Error.";
			}
		}
		
		if ($usuario["solicitante"]=="No"){
		
			if(nuevo_familiar($conexion,$usuario)){
        	echo"Todo ha ido bien";
			
			} else{
				echo "Error.";
			}
		}
		?>
		
	</main>
	<?php cerrarConexionBD($conexion); ?>
	<?php include ("../../vista/footer.php");  ?> 
</body>
</html>