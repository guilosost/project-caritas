<?php	
	session_start();		
	require_once("../../modelo/GestionBD.php");
	require_once("../../modelo/gestionar/gestionar_usuarios.php"); 
	$conexion = crearConexionBD();

	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
		
        if($usuario["solicitante"] == "Sí"){
            eliminar_solicitante($conexion,$usuario["dni"]);
        }else{
            eliminar_familiar($conexion,$usuario["dni"]);
		}	
		unset($_SESSION["usuario"]);
		cerrarConexionBD($conexion);
		Header("Location: ../../vista/listas/lista_usuario.php");
	} else if(isset($_SESSION["usuario-eliminar"])) {
	$usuario['dni'] = $_REQUEST["dni"];
	$usuario['solicitante'] = $_REQUEST["solicitante"];
	unset($_SESSION["usuario-eliminar"]); 
		
        if($usuario["solicitante"] == "Sí"){
            eliminar_solicitante($conexion,$usuario["dni"]);
	} else {
            eliminar_familiar($conexion,$usuario["dni"]);
        }	
		cerrarConexionBD($conexion);
		Header("Location: ../../vista/listas/lista_usuario.php");

	} else Header("Location: ../../vista/listas/lista_usuario.php"); 
?>