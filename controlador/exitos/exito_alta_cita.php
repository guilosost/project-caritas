<?php
	session_start();
	
	include("../../modelo/GestionBD.php"); 
		
	
	if (isset($_SESSION["formulario"])) {
		$cita = $_SESSION["formulario"];
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
  <meta charset="utf-8">
  <title>Alta de cita</title>
</head>

<body>
		<?php include ("../../vista/header.php"); 
			
	 
			 if(alta_cita($conexion,$cita)){
		?>	
            <p>Todo ha ido bien </p>
			<?php 
			} else{
				echo "La cita ya existe.";
			}
		?>
		

	</main>
	<?php cerrarConexionBD($conexion); ?>
	<?php include ("../../vista/footer.php");  ?> 
</body>
</html>