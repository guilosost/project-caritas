<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
require_once(MODELO."/gestionBD.php");
require_once(MODELO."/gestionar/gestionar_citas.php");
require_once(MODELO."/gestionar/gestionar_voluntarios.php");

if (isset($_SESSION["formulario_cita"])) {
	$cita['fechacita'] = $_REQUEST["fechacita"];
	$cita['objetivo'] = $_REQUEST["objetivo"];
	$cita['nombrev'] = $_REQUEST["nombrev"];
	$cita['observaciones'] = $_REQUEST["observaciones"];
	$cita['dni'] = $_REQUEST["dni"];
    $_SESSION["formulario_cita"] = $cita;
}else if (isset($_SESSION["cita"])) {
	$cita['fechacita'] = $_REQUEST["fechacita"];
	$cita['objetivo'] = $_REQUEST["objetivo"];
	$cita['nombrev'] = $_REQUEST["nombrev"];
	$cita['observaciones'] = $_REQUEST["observaciones"];
	$cita['dni'] = $_REQUEST["dni"];
	$cita_aux = $_SESSION["cita"];
	$cita["oid_c"] = $cita_aux["oid_c"]; 
    $_SESSION["cita"] = $cita;
}  else if (isset($_SESSION["cita-editar"])) {
	$cita['oid_c'] = $_REQUEST["oid_c"];
	$cita['fechacita'] = $_REQUEST["fechacita"];
	
	$_SESSION["cita-editar"] = $cita;
} else {
	Header("Location: ../../vista/listas/lista_cita.php");
}

$conexion = crearConexionBD();
$errores = validarDatosCita($conexion, $cita);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	$_SESSION["errores"] = $errores;
 if (isset($_SESSION["cita"])) {
	Header('Location:../../controlador/ediciones/editar_cita.php');
}  else if (isset($_SESSION["cita-editar"])) {
	Header('Location:../../controlador/ediciones/editar_cita.php');
}else{
	Header('Location:../../controlador/altas/alta_cita.php');
 }
} else
	Header('Location:../../controlador/resultados/resultado_alta_cita.php');


function validarDatosCita($conexion, $cita)
{
	$errores=array();
	if(!isset($_SESSION["cita-editar"])) {
	if ($cita["fechacita"] == "") {
		$errores[] = "<p>La fecha de la cita no puede estar vacía.</p>";
	} 

	if ($cita["objetivo"] == "") {
		$errores[] = "<p>El objetivo no puede estar vacío.</p>";
	}

	if ($cita["observaciones"] == "") {
		$errores[] = "<p>Las observaciones no pueden estar vacías.</p>";
	}

	if ($cita["fechacita"] == "") {
		$errores[] = "<p>La fecha de la cita no puede estar vacía.</p>";
	}

	if(consultarUsuarioSolicitante($conexion,$cita["dni"]) == 0){
		$errores[] = "<p>El usuario debe de ser solicitante.</p>";
	}

	if ($cita["dni"] == "" || !preg_match("/^[0-9]{8}[A-Z]$/", $cita["dni"])) {
		$errores[] = "<p>El DNI no puede estar vacio y tiene que ser del formato 12345678A.</p>";
	}

	if ($cita["nombrev"] == "") {
		$errores[] = "<p>El nombre del voluntario responsable de la cita no puede estar vacío.</p>";
	} else if(consultarVoluntarioRepetido($conexion,$cita["nombrev"])==0){
		$errores[] = "<p>El voluntario especificado no existe.</p>";
	}
	
	} else {
		if ($cita["fechacita"] == "") {
			$errores[] = "<p>La fecha de la cita no puede estar vacía.</p>";
		} 
	}
	return $errores;
}
