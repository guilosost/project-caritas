<?php	
	session_start();	
	
	if (isset($_SESSION["ayuda"])) {
		$ayuda = $_SESSION["ayuda"];
		unset($_SESSION["ayuda"]);
		
		require_once("../../modelo/GestionBD.php");
		require_once("../../modelo/gestionar/gestionar_ayudas.php"); 
		
        $conexion = crearConexionBD();
        
        borrar_trabajo($conexion,$ayuda["oid_a"]);
        borrar_ayudaeconomica($conexion,$ayuda["oid_a"]);
        borrar_comida($conexion,$ayuda["oid_a"]);
        borrar_ayuda($conexion,$ayuda["oid_a"]);
                  
		cerrarConexionBD($conexion);
			
	
		 Header("Location: ../../vista/listas/lista_ayuda.php");
	}
	else Header("Location: ../../vista/listas/lista_ayuda.php"); 
?>