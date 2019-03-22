<?php
	session_start();
	
		
	
	if (isset($_SESSION["formulario"])) {
		$usuario = $_SESSION["formulario"];
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
  <title>Alta de usuario</title>
</head>

<body>
		<?php include ("header.php"); //ARREGLAR LINK
		 if(alta_usuario($conexion,$usuario)){
		?>	
            <p>Todo ha ido bien </p>
			<?php 
			} else{
				echo "El usuario ya existe.";
			}?>
		

	</main>
	<?php cerrarConexionBD($conexion); ?>
	<?php include ("footer.php"); //ARREGLAR LINK ?> 
</body>
</html>