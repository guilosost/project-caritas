<?php

function consultarVoluntarioRepetido($conexion, $usuariologin) {
    $consulta = "SELECT COUNT(*) AS TOTAL FROM VOLUNTARIOS WHERE NOMBREV=:nombrev AND CONTRASEÑA=:contraseña";
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':nombrev', $usuariologin["nombrelogin"]);
    $stmt->bindParam(':contraseña', $usuariologin["contrasena"]);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getPermisos($conexion, $usuariologin) {
    try {
        $permiso = "SELECT permiso as TOTAL FROM voluntarios WHERE nombrev =:nombrev";

        $stmt = $conexion->prepare($permiso);
        $stmt->bindParam(':nombrev', $usuariologin['nombrelogin']);

        $stmt->execute();
        $result = $stmt->fetch();
        $total = $result['TOTAL'];
        return  $total;
    } catch (PDOException $e) {
        $_SESSION['excepcion'] = $e->GetMessage();
        return  $e->GetMessage();
    }
}
