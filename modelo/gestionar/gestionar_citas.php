<?php

function nueva_cita($conexion, $cita) {
    try {
        $consulta = "CALL nueva_cita(:w_fechacita, :w_objetivo, :w_observaciones, :w_nombrev, :w_dni)";

        $stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':w_fechacita',$cita["fechacita"]);
		$stmt->bindParam(':w_objetivo',$cita["objetivo"]);
		$stmt->bindParam(':w_observaciones',$cita["observaciones"]);
		$stmt->bindParam(':w_nombrev',$cita["nombrev"]);
        $stmt->bindParam(':w_dni',$cita["dni"]);

        $stmt->execute();
		
		return true;
	} catch(PDOException $e) {
		return false;
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}