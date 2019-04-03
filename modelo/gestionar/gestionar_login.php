<?php

function consultarVoluntarioRepetido($conexion, $usuariologin) {
    $consulta = "SELECT COUNT(*) AS TOTAL FROM VOLUNTARIOS WHERE NOMBREV=:nombrev AND CONTRASEÑA=:contraseña";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':nombrev',$usuariologin["nombrev"]);
    $stmt->bindParam(':contraseña',$usuariologin["contrasena"]);
    $stmt->execute();
    return $stmt->fetchColumn();
}