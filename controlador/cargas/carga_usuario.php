<?php	
	session_start();
	
	if (isset($_REQUEST["DNI"])){
		$usuario["dni"] = $_REQUEST["DNI"];
		$usuario["apellidos"] = $_REQUEST["APELLIDOS"];
		
		$_SESSION["usuario"] = $usuario;
			
	Header("Location: ../../vista/mostrar/mostrar_usuario.php"); 
	}
	else 
		Header("Location: consulta_libros.php");
?>