<?php	
	session_start();
	
	if (isset($_REQUEST["CONCEDIDA"])){
        $ayuda["concedida"] = $_REQUEST["CONCEDIDA"];
        $ayuda["suministradapor"] = $_REQUEST["SUMINISTRADAPOR"];
        $ayuda["nino"] = $_REQUEST["NIÑO"];
        $ayuda["cantidad"] = $_REQUEST["CANTIDAD"];
        $ayuda["motivo"] = $_REQUEST["MOTIVO"];
        $ayuda["descripcion"] = $_REQUEST["DESCRIPCION"];
        $ayuda["bebe"] = $_REQUEST["BEBE"];
        $ayuda["empresa"] = $_REQUEST["EMPRESA"];
        $ayuda["salarioaproximado"] = $_REQUEST["SALARIOAPROXIMADO"];
        $ayuda["prioridad"] = $_REQUEST["PRIORIDAD"];
        $ayuda["oid_a"] = $_REQUEST["oid_a"];
		$_SESSION["ayuda"] = $ayuda;


	Header("Location: ../../vista/mostrar/mostrar_ayuda.php");
			
	}
	else 
		Header("Location: ../../vista/listas/lista_ayuda.php");
?>