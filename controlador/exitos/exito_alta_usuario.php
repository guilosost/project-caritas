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
  <meta charset="utf-8">
  <title>Alta de usuario</title>
</head>

<body>
		<?php include ("../../vista/header.php"); 
			if ($usuario["solicitante"]=="Sí"){
	 
			 if(alta_solicitante($conexion,$usuario)){
		?>	
            <p>Todo ha ido bien </p>
			<?php 
			} else{
				echo "El solicitante ya existe.";
			}
		}?>
		

	</main>
	<?php cerrarConexionBD($conexion); ?>
	<?php include ("../../vista/footer.php");  ?> 
</body>
</html>