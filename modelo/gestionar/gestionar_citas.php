<?php

function nueva_cita($conexion, $cita) {
    date_default_timezone_set('UTC');
    $fecha = $cita["fechacita"];
    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaCita = "$dia/$mes/$año";
    try {
        $consulta = "CALL nueva_cita(:w_fechacita, :w_objetivo, :w_observaciones, :w_nombrev, :w_dni)";

        $stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':w_fechacita',$fechaCita);
		$stmt->bindParam(':w_objetivo',$cita["objetivo"]);
		$stmt->bindParam(':w_observaciones',$cita["observaciones"]);
		$stmt->bindParam(':w_nombrev',$cita["nombrev"]);
        $stmt->bindParam(':w_dni',$cita["dni"]);

        $stmt->execute();
		
		return true;
	} catch(PDOException $e) {
		return $e->getMessage();
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}
function aux_IdentificaCita( $conexion, $cita ){
    date_default_timezone_set('UTC');
    $fecha = $cita["fechacita"];

    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaCita = "$dia/$mes/$año";
	try {
		$total_consulta = " SELECT oid_c AS TOTAL FROM CITAS WHERE  FECHACITA=:w_fechacita AND OBJETIVO=:w_objetivo AND OBSERVACIONES=:w_observaciones AND NOMBREV=:w_nombrev
		 AND DNI=:w_dni";
		$stmt=$conexion->prepare($total_consulta);
        $stmt->bindParam(':w_fechacita',$fechaCita);
        $stmt->bindParam(':w_objetivo',$cita["objetivo"]);
        $stmt->bindParam(':w_observaciones',$cita["observaciones"]);
        $stmt->bindParam(':w_nombrev',$cita["nombrev"]);
        $stmt->bindParam(':w_dni',$cita["dni"]);

		$stmt->execute();
		$result = $stmt->fetch();
		$total = $result['TOTAL'];
		return  $total;
	}
	catch ( PDOException $e ) {
		$_SESSION['excepcion'] = $e->GetMessage();
		return  $e->GetMessage();
	}
}
function borrar_cita($conexion,$oid_c) {
   try{
    $consulta = "DELETE FROM CITAS WHERE OID_C=:oid_c";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_c',$oid_c);
   $stmt->execute();
   return "";
    }  catch ( PDOException $e ) {
    return  $e->GetMessage();
}
}
function editar_cita($conexion,$cita) {
    date_default_timezone_set('UTC');
    $fecha = $cita["fechacita"];

    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaCita = "$dia/$mes/$año";
    try{
    $consulta = "UPDATE CITAS SET DNI=:dni, NOMBREV=:nombrev, OBJETIVO=:objetivo, OBSERVACIONES=:observaciones, FECHACITA=:fechacita WHERE OID_C=:oid_c";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_c',$cita["oid_c"]);
   $stmt->bindParam(':dni',$cita["dni"]);
   $stmt->bindParam(':objetivo',$cita["objetivo"]);
   $stmt->bindParam(':observaciones',$cita["observaciones"]);
   $stmt->bindParam(':nombrev',$cita["nombrev"]);
   $stmt->bindParam(':fechacita',$fechaCita);
   $stmt->execute();
   return "true";
    } catch ( PDOException $e ) {
        return  $e->GetMessage();
    }
}
