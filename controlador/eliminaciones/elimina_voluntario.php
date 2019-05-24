<?php	
	session_start();	
	
	if (isset($_SESSION["voluntario"])) {
		$voluntario = $_SESSION["voluntario"];
		unset($_SESSION["voluntario"]);
		
		require_once("../../modelo/GestionBD.php");
		require_once("../../modelo/gestionar/gestionar_voluntarios.php"); 
		
        $conexion = crearConexionBD();
        
        borrar_voluntario($conexion,$voluntario["nombrev"]);
                  
		cerrarConexionBD($conexion);
			
		 Header("Location: ../../vista/listas/lista_voluntario.php");
} else if (isset($_SESSION["voluntario-eliminar"])) {
		$voluntario['nombrev'] = $_REQUEST["nombrev"];
		$_SESSION["voluntario-eliminar"] = $voluntario;
		unset($_SESSION["voluntario-eliminar"]);
		
		require_once("../../modelo/GestionBD.php");
		require_once("../../modelo/gestionar/gestionar_voluntarios.php"); 
				
		$conexion = crearConexionBD();
		
		borrar_voluntario($conexion,$voluntario["nombrev"]);
		
		cerrarConexionBD($conexion);
		Header("Location: ../../vista/listas/lista_voluntario.php");

} else Header("Location: ../../vista/listas/lista_voluntario.php"); 
?>