<?php
function alta_ayuda($conexion,$ayuda){
    $zero = 0;

    if($ayuda['tipoayuda'] == "bolsacomida"){
        try {
            $consulta = "CALL nueva_ayuda_de_comida(:w_suministradapor, :w_concedida, :w_bebe, :w_niño, :w_oid_c)";
            $stmt=$conexion->prepare($consulta);
            $stmt->bindParam(':w_suministradapor',$ayuda["suministradapor"]);
            $stmt->bindParam(':w_concedida',$ayuda["concedida"]);
            $stmt->bindParam(':w_bebe',$ayuda["bebe"]);
            $stmt->bindParam(':w_niño',$ayuda["niño"]);
            $stmt->bindParam(':w_oid_c',$_SESSION["citaId"]);
            $stmt->execute();
            
            return true;
        } catch(PDOException $e) {
            return $e->getMessage();
        }
        }else if($ayuda['tipoayuda'] == "ayudaeconomica"){
            try {
                $consulta = "CALL nueva_ayuda_economica(:w_suministradapor, :w_concedida, :w_cantidad, :w_motivo, :w_prioridad, :w_oid_c)";
                $stmt=$conexion->prepare($consulta);
                $stmt->bindParam(':w_suministradapor',$ayuda["suministradapor"]);
                $stmt->bindParam(':w_concedida',$ayuda["concedida"]);
                $stmt->bindParam(':w_cantidad',$ayuda["cantidad"]);
                $stmt->bindParam(':w_motivo',$ayuda["motivo"]);
                $stmt->bindParam(':w_prioridad', $ayuda["prioridad"]);
                $stmt->bindParam(':w_oid_c',$_SESSION["citaId"]);
                $stmt->execute();
                
                return true;
            } catch(PDOException $e) {
                return $e->getMessage();
            }
        /* }else if($ayuda['tipoayuda'] == "curso"){
            try {
                $consulta=  "CALL nuevo_curso(:w_profesor, :w_materia, :w_fechacomienzo, :w_fechafin, :w_numerosesiones,"
                    . ":w_horasporsesion, :w_numeroalumnosactuales, :w_numeroalumnosmaximo, :w_lugar)";
                $stmt=$conexion->prepare($consulta);
                $stmt->bindParam(':w_profesor', $ayuda["profesor"]);
                $stmt->bindParam(':w_materia', $ayuda["materia"]);
                $stmt->bindParam(':w_fechacomienzo', $ayuda["fechacomienzo"]);
                $stmt->bindParam(':w_fechafin', $ayuda["fechafin"]);
                $stmt->bindParam(':w_numerosesiones', $ayuda["numerosesiones"]);
                $stmt->bindValue(':w_horasporsesion',null, PDO::PARAM_INT);
                $stmt->bindParam(':w_numeroalumnosactuales', $zero);
                $stmt->bindParam(':w_numeroalumnosmaximo', $ayuda["numeroalumnosmaximo"]);
                $stmt->bindValue(':w_lugar',null, PDO::PARAM_INT);
                $stmt->execute();
                
                return true;
            } catch(PDOException $e) {
                return $e->getMessage();
            } */
        }else if($ayuda['tipoayuda'] == "trabajos"){
            try {
                $consulta = "CALL nueva_ayuda_trabajo(:w_suministradapor, :w_concedida, :w_descripcion, :w_empresa, :w_salarioaproximado, :w_oid_c)";
                $stmt=$conexion->prepare($consulta);
                $stmt->bindParam(':w_suministradapor',$ayuda["suministradapor"]);
                $stmt->bindParam(':w_concedida',$ayuda["concedida"]);
                $stmt->bindParam(':w_descripcion',$ayuda["descripcion"]);
                $stmt->bindParam(':w_empresa',$ayuda["empresa"]);
                $stmt->bindParam(':w_salarioaproximado', $ayuda["salarioaproximado"]);
                $stmt->bindParam(':w_oid_c',$_SESSION["citaId"]);
                $stmt->execute();
                
                return true;
            } catch(PDOException $e) {
                return $e->getMessage();
            }
    }
   
}

function getComida($conexion,$oid_a) {
    $consulta = "SELECT *  FROM COMIDAS WHERE OID_a=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return $stmt->fetch();
}

function getAyudaEconomica($conexion,$oid_a) {
    $consulta = "SELECT *  FROM AYUDASECONOMICAS WHERE OID_a=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return $stmt->fetch();
}
/*
function getCurso($conexion,$oid_a) {
    $consulta = "SELECT *  FROM CURSOS WHERE OID_a=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return $stmt->fetch();
}*/

function getTrabajo($conexion,$oid_a) {
    $consulta = "SELECT *  FROM TRABAJOS WHERE OID_a=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return $stmt->fetch();
}

function getCita($conexion,$oid_c) {
    $consulta = "SELECT *  FROM CITAS WHERE OID_c=:oid_c";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_c',$oid_c);
   $stmt->execute();
   return $stmt->fetch();
}

function borrar_ayuda($conexion,$oid_a) {
    $consulta = "DELETE FROM AYUDAS WHERE OID_A=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return "";
}

function borrar_comida($conexion,$oid_a) {
    $consulta = "DELETE FROM COMIDAS WHERE OID_A=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return "";
}
function borrar_ayudaeconomica($conexion,$oid_a) {
    $consulta = "DELETE FROM AYUDASECONOMICAS WHERE OID_A=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return "";
}
function borrar_trabajo($conexion,$oid_a) {
    $consulta = "DELETE FROM TRABAJOS WHERE OID_A=:oid_a";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_a',$oid_a);
   $stmt->execute();
   return "";
}


function editar_ayuda($conexion,$ayuda) {
    try {
   $stmt=$conexion->prepare("CALL editar_ayuda(:oid_a,:bebe,:niño,:cantidad,:motivo,:prioridad,:descripcion,:empresa,:salarioaproximado,
   :concedida,
   :suministradapor)");
   $stmt->bindParam(':oid_a',$ayuda["oid_a"]);
   $stmt->bindParam(':bebe',$ayuda["bebe"]);
   $stmt->bindParam(':niño',$ayuda["niño"]);
   $stmt->bindParam(':cantidad',$ayuda["cantidad"]);
   $stmt->bindParam(':motivo',$ayuda["motivo"]);
   $stmt->bindParam(':prioridad',$ayuda["prioridad"]);
   $stmt->bindParam(':descripcion',$ayuda["descripcion"]);
   $stmt->bindParam(':salarioaproximado',$ayuda["salarioaproximado"]);
   $stmt->bindParam(':empresa',$ayuda["empresa"]);
   $stmt->bindParam(':concedida',$ayuda["concedida"]);
   $stmt->bindParam(':suministradapor',$ayuda["suministradapor"]);
   $stmt->execute();
    return true;
} catch(PDOException $e) {
    return $e->getMessage();
}
}