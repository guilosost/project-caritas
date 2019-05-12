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
function consultarVoluntarioRepetido($conexion,$nombrev) {
    $consulta = "SELECT COUNT(*) AS TOTAL FROM VOLUNTARIOS WHERE NOMBREV =:nombrev";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':nombrev',$nombrev);
   $stmt->execute();
   return $stmt->fetchColumn();
}

function borrar_voluntario($conexion,$nombrev) {
    $consulta = "DELETE FROM VOLUNTARIOS WHERE NOMBREV =:nombrev";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':nombrev',$nombrev);
   $stmt->execute();
   return "";
}
function editar_voluntario($conexion,$voluntario) {
    try {
    $consulta = "UPDATE  VOLUNTARIOS  SET PERMISO=:permiso, CONTRASEÑA=:contrasena WHERE NOMBREV =:nombrev";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':nombrev',$voluntario["nombrev"]);
   $stmt->bindParam(':permiso',$voluntario["permiso"]);
   $stmt->bindParam(':contrasena',$voluntario["contrasena"]);
   $stmt->execute();
   return true;
} catch(PDOException $e) {
    echo $e->getMessage();
    return false;
    // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
}
}