<?php

function consultarUsuarios($conexion) {
    $consulta = "SELECT dni, nombre, apellidos, telefono, situacionlaboral, ingresos FROM usuarios";
    return $conexion->query($consulta);
}

function eliminarUsuario($conexion, $dni) {
    try {   
    if($solicitante=='Sí') {
        $stmt=$conexion->prepare('CALL borrar_solicitante(:dni)');
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return "";
    } else {
        $stmt=$conexion->prepare('CALL familiar(:dni)');
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return "";
        }
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function modificarUsuario($conexion, $dni) {
    
}