<?php	
	session_start();	
	
	if (isset($_SESSION["cita"])) {
		$cita = $_SESSION["cita"];
		unset($_SESSION["cita"]);
		
		require_once("../../modelo/GestionBD.php");
		require_once("../../modelo/gestionar/gestionar_citas.php"); 
		
        $conexion = crearConexionBD();
        
        borrar_cita($conexion,$cita["oid_c"]);
                  
		cerrarConexionBD($conexion);
		Header("Location: ../../vista/listas/lista_cita.php"); 
	}else if (isset($_SESSION["cita-eliminar"])) {
		$cita['oid_c'] = $_REQUEST["oid_c"];
		$_SESSION["cita-eliminar"] = $cita;
		unset($_SESSION["cita-eliminar"]);
		
		require_once("../../modelo/GestionBD.php");
		require_once("../../modelo/gestionar/gestionar_citas.php"); 
				
		$conexion = crearConexionBD();
		
		borrar_cita($conexion,$cita["oid_c"]);
		
		cerrarConexionBD($conexion);
		Header("Location: ../../vista/listas/lista_cita.php");

} else Header("Location: ../../vista/listas/lista_cita.php"); 
?>