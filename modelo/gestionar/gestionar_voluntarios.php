<?php

function nuevo_voluntario($conexion, $cita) {
    try {
        
        $consulta = "CALL nuevo_voluntario(:w_nombrev, :w_contraseña, :w_permiso)";

        $stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':w_nombrev',$cita["nombrev"]);
		$stmt->bindParam(':w_contraseña',$cita["password"]);
		$stmt->bindParam(':w_permiso',$cita["permisos"]);

        $stmt->execute();
		
		return true;
	} catch(PDOException $e) {
        echo $e->getMessage();
		return false;
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}