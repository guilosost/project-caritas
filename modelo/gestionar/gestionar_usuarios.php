<?php

function alta_solicitante($conexion,$usuario) {
    date_default_timezone_set('UTC');
    $fecha = $usuario["fechaNac"];

    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaNacimiento = "$dia/$mes/$año";
    $vacio = " ";
    $no = "No";
	try {
        $consulta = "CALL nuevo_solicitante(:w_dni,:w_nombre,:w_apellidos,:w_ingresos
        ,:w_situacionlaboral,:w_estudios,:w_sexo,:w_telefono 
        ,:w_poblacion,:w_domicilio,:w_codigopostal,:w_gastosfamilia,:w_estadocivil,
        :w_fechanacimiento,:w_protecciondatos,:w_problematica,:w_tratamiento
        ,:w_minusvalia,:w_valoracionminusvalia )";

		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':w_dni',$usuario["dni"]);
		$stmt->bindParam(':w_nombre',$usuario["nombre"]);
		$stmt->bindParam(':w_apellidos',$usuario["apellidos"]);
        $stmt->bindParam(':w_ingresos',$usuario["ingresos"]);

        if($usuario["sitlaboral"]=="NULL"){
            $stmt->bindValue(':w_situacionlaboral',null, PDO::PARAM_INT);
        }else{
            $stmt->bindParam(':w_situacionlaboral',$usuario["sitlaboral"]);
        }

        if($usuario["estudios"]=="NULL"){
            $stmt->bindValue(':w_estudios',null, PDO::PARAM_INT);
        }else{
            $stmt->bindParam(':w_estudios',$usuario["estudios"]);
        }

		$stmt->bindParam(':w_sexo',$usuario["genero"]);
		$stmt->bindParam(':w_telefono',$usuario["telefono"]);
        $stmt->bindParam(':w_poblacion',$usuario["poblacion"]);
        $stmt->bindParam(':w_domicilio',$usuario["domicilio"]);
        $stmt->bindParam(':w_codigopostal',$usuario["codigopostal"]);
        $stmt->bindParam(':w_gastosfamilia',$usuario["gastosfamilia"]);
        $stmt->bindParam(':w_estadocivil',$vacio);
        $stmt->bindParam(':w_fechanacimiento',$fechaNacimiento);
        $stmt->bindParam(':w_protecciondatos',$usuario["proteccionDatos"]);
        $stmt->bindValue(':w_problematica',null, PDO::PARAM_INT);
        $stmt->bindValue(':w_tratamiento',null, PDO::PARAM_INT);
        $stmt->bindParam(':w_minusvalia',$usuario["minusvalia"]);
        $stmt->bindParam(':w_valoracionminusvalia',$no);
		
		$stmt->execute();
		
		return true;
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}

function consultarUsuarioRepetido($conexion,$dni) {
    $consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS WHERE DNI=:dni";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':dni',$dni);
   $stmt->execute();
   return $stmt->fetchColumn();
}

function eliminarUsuario($conexion, $usuario) {
    try {   
    if($usuario["solicitante"]=='Sí') {
        $stmt=$conexion->prepare('CALL borrar_solicitante(:dni)');
        $stmt->bindParam(':dni', $usuario["dni"]);
        $stmt->execute();
        return "";
    } else {
        $stmt=$conexion->prepare('CALL borrar_familiar(:dni)');
        $stmt->bindParam(':dni', $usuario["dni"]);
        $stmt->execute();
        return "";
        }
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

// He metido esta función dentro de gestionar_usuarios porque en la función eliminarUsuario ya había metido borrar_familiar
function nuevo_familiar($conexion, $usuario) {
    date_default_timezone_set('UTC');
    $fecha = $usuario["fechaNac"];

    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaNacimiento = "$dia/$mes/$año";
    
    $vacio = " ";
    $no = "No";
    try {
        $consulta = "CALL nuevo_familiar(:w_dni, :w_nombre, :w_apellidos, :w_ingresos, :w_situacionlaboral, :w_estudios,
         :w_sexo, :w_telefono, :w_estadocivil, :w_fechanacimiento, :w_parentesco, :w_problematica, :w_tratamiento, :w_minusvalia,
         :w_valoracionminusvalia, :w_dni_so)";

        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':w_dni',$usuario["dni"]);
		$stmt->bindParam(':w_nombre',$usuario["nombre"]);
		$stmt->bindParam(':w_apellidos',$usuario["apellidos"]);
		$stmt->bindParam(':w_ingresos',$usuario["ingresos"]);
        if($usuario["sitlaboral"]=="NULL"){
            $stmt->bindValue(':w_situacionlaboral',null, PDO::PARAM_INT);
        }else{
            $stmt->bindParam(':w_situacionlaboral',$usuario["sitlaboral"]);
        }
		$stmt->bindParam(':w_estudios',$usuario["estudios"]);
		$stmt->bindParam(':w_sexo',$usuario["genero"]);
		$stmt->bindParam(':w_telefono',$usuario["telefono"]);
        $stmt->bindParam(':w_estadocivil',$vacio);
        $stmt->bindParam(':w_fechanacimiento',$fechaNacimiento);
        $stmt->bindParam(':w_parentesco',$usuario["parentesco"]);
        $stmt->bindValue(':w_problematica',null, PDO::PARAM_INT);
        $stmt->bindParam(':w_tratamiento',$no);
        $stmt->bindParam(':w_minusvalia',$usuario["minusvalia"]);
        $stmt->bindParam(':w_valoracionminusvalia',$no);
        $stmt->bindParam(':w_dni_so',$usuario["dniSol"]);
		
		$stmt->execute();

        return true;
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function nueva_unidadfamiliar($conexion, $unidadesfamiliares) {
    try{
        $consulta = "CALL nueva_unidadfamiliar(:w_poblacion, :w_domicilio, :w_codigopostal, :w_gastosfamilia)";
        $stmt =$conexion->prepare($consulta);
        $stmt->bindParam(':w_poblacion', $unidadesfamiliares["poblacion"]);
        $stmt->bindParam(':w_domicilio', $unidadesfamiliares["domicilio"]);
        $stmt->bindParam(':w_codigopostal', $unidadesfamiliares["codigopostal"]);
        $stmt->bindParam(':w_gastosfamilia', $unidadesfamiliares["gastosfamilia"]);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}
function eliminar_solicitante($conexion,$dni) {
	try {
		$stmt=$conexion->prepare('CALL borrar_solicitante(:dni)');
		$stmt->bindParam(':dni',$dni);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function eliminar_familiar($conexion,$dni) {
	try {
		$stmt=$conexion->prepare('CALL borrar_familiar(:dni)');
		$stmt->bindParam(':dni',$dni);
		$stmt->execute();
		return "";
	} catch(PDOException $e) {
		return $e->getMessage();
    }
}
function unidadfamiliar_solicitante($conexion,$dni) {
    $consulta = "SELECT *  FROM UNIDADESFAMILIARES WHERE OID_UF=:oid_uf";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':oid_uf',$dni);
   $stmt->execute();
   return $stmt->fetch();
}

function editar_solicitante($conexion,$usuario) {
    $true="true";
    date_default_timezone_set('UTC');
    $fecha = $usuario["fechaNac"];
    $no = "No";
    $vacio=" ";
    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaNacimiento = "$dia/$mes/$año";
    try {
   $stmt=$conexion->prepare("CALL editar_solicitante(:dni,:nombre,:apellidos,:ingresos,:situacionlaboral,:estudios,:sexo,:telefono,
   :poblacion,:domicilio,:codigopostal,:gastosfamilia,:estadocivil, TO_DATE(:fechanac, 'DD/MM/RRRR'),
   :protecciondatos,:problematica,:tratamiento,:minusvalia,:valoracionminusvalia,:oid_uf,:solicitante)");
    
    $stmt->bindParam(':dni',$usuario["dni"]);
    $stmt->bindParam(':solicitante',$usuario["solicitante"]);
	$stmt->bindParam(':nombre',$usuario["nombre"]);
	$stmt->bindParam(':apellidos',$usuario["apellidos"]);
	$stmt->bindParam(':ingresos',$usuario["ingresos"]);
    if($usuario["sitlaboral"]=="NULL"){
        $stmt->bindValue(':situacionlaboral',null, PDO::PARAM_INT);
    }else{
        $stmt->bindParam(':situacionlaboral',$usuario["sitlaboral"]);
    }
	$stmt->bindParam(':estudios',$usuario["estudios"]);
	$stmt->bindParam(':sexo',$usuario["genero"]);
	$stmt->bindParam(':telefono',$usuario["telefono"]);
    $stmt->bindParam(':estadocivil',$vacio);
    $stmt->bindParam(':fechanac',$fechaNacimiento);
    $stmt->bindParam(':protecciondatos',$usuario["protecciondatos"]);
    $stmt->bindValue(':problematica',null, PDO::PARAM_INT);
    $stmt->bindParam(':tratamiento',$no);
    $stmt->bindParam(':minusvalia',$usuario["minusvalia"]);
    $stmt->bindParam(':valoracionminusvalia',$no);
    $stmt->bindParam(':poblacion', $usuario["poblacion"]);
    $stmt->bindParam(':domicilio', $usuario["domicilio"]);
    $stmt->bindParam(':codigopostal', $usuario["codigopostal"]);
    $stmt->bindParam(':gastosfamilia', $usuario["gastosfamilia"]);
    $stmt->bindParam(':oid_uf', $usuario["oid_uf"]);
   $stmt->execute();
    
} catch(PDOException $e) {
    return $e->getMessage();
}
}
function editar_familiar($conexion,$usuario) {
    $true="true";
    date_default_timezone_set('UTC');
    $fecha = $usuario["fechaNac"];
    $no = "No";
    $vacio=" ";
    list($año, $mes, $dia) = split('[/.-]', $fecha);
    $fechaNacimiento = "$dia/$mes/$año";
    try {
   $stmt=$conexion->prepare("CALL editar_familiar(:dni,:nombre,:apellidos,:ingresos,:situacionlaboral,:estudios,:sexo,:telefono,
   :estadocivil, TO_DATE(:fechanac, 'DD/MM/RRRR'),
   :protecciondatos,:problematica,:tratamiento,:minusvalia,:valoracionminusvalia,:parentesco)");
    
    $stmt->bindParam(':dni',$usuario["dni"]);
	$stmt->bindParam(':nombre',$usuario["nombre"]);
	$stmt->bindParam(':apellidos',$usuario["apellidos"]);
	$stmt->bindParam(':ingresos',$usuario["ingresos"]);
    if($usuario["sitlaboral"]=="NULL"){
        $stmt->bindValue(':situacionlaboral',null, PDO::PARAM_INT);
    }else{
        $stmt->bindParam(':situacionlaboral',$usuario["sitlaboral"]);
    }
	$stmt->bindParam(':estudios',$usuario["estudios"]);
	$stmt->bindParam(':sexo',$usuario["genero"]);
	$stmt->bindParam(':telefono',$usuario["telefono"]);
    $stmt->bindParam(':estadocivil',$vacio);
    $stmt->bindParam(':fechanac',$fechaNacimiento);
    $stmt->bindParam(':protecciondatos',$usuario["protecciondatos"]);
    $stmt->bindValue(':problematica',null, PDO::PARAM_INT);
    $stmt->bindParam(':tratamiento',$no);
    $stmt->bindParam(':minusvalia',$usuario["minusvalia"]);
    $stmt->bindParam(':valoracionminusvalia',$no);
    $stmt->bindParam(':parentesco',$usuario["parentesco"]);

   $stmt->execute();

} catch(PDOException $e) {
    return $e->getMessage();
}
}

function editar_usuario($conexion,$usuario) {
    try {
        $consulta = "UPDATE  USUARIOS  SET NOMBRE=:nombre, APELLIDOS=:apellidos, INGRESOS=:ingresos, SITUACIONLABORAL=:situacionlaboral, TELEFONO=:telefono WHERE DNI=:dni";
   $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':dni',$usuario["dni"]);
	$stmt->bindParam(':nombre',$usuario["nombre"]);
	$stmt->bindParam(':apellidos',$usuario["apellidos"]);
	$stmt->bindParam(':ingresos',$usuario["ingresos"]);
    if($usuario["sitlaboral"]=="NULL"){
        $stmt->bindValue(':situacionlaboral',null, PDO::PARAM_INT);
    }else{
        $stmt->bindParam(':situacionlaboral',$usuario["sitlaboral"]);
    }
	$stmt->bindParam(':telefono',$usuario["telefono"]);
   $stmt->execute();
        return true;
} catch(PDOException $e) {
    return $e->getMessage();
}
}