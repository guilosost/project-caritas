<?php
	session_start();
	
	include(gestionar_usuarios.php); //ARREGLAR LINK
		
	
	if (isset($_SESSION["formulario"])) {
		$cita = $_SESSION["formulario"];
		unset($_SESSION["formulario"]);
		}
		else{
			Header("Location: alta_usuario.php"); //ARREGLAR LINK
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
		<?php include ("header.php"); //ARREGLAR LINK
			
	 
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
	<?php include ("footer.php"); //ARREGLAR LINK ?> 
</body>
</html>