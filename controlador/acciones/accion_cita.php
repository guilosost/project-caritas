<?php
session_start();

//YANES ARREGLA ESTA RUTA PORFA
include_once("../funciones.php");
require_once("../../modelo/GestionBD.php");

if (isset($_SESSION["formulario_cita"])) {
	$cita['fechacita'] = $_REQUEST["fechacita"];
	$cita['objetivo'] = $_REQUEST["objetivo"];
	$cita['nombrev'] = $_REQUEST["nombrev"];
	$cita['observaciones'] = $_REQUEST["observaciones"];
	$cita['dni'] = $_REQUEST["dni"];
    $_SESSION["formulario_cita"] = $cita;

} else {
	Header("Location: ../../controlador/altas/alta_cita.php");
}

$conexion = crearConexionBD();
$errores = validarDatosCita($conexion, $cita);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
	Header('Location:../../controlador/altas/alta_cita.php');
} else
	// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
	Header('Location: resultado_alta_cita.php');


function validarDatosCita($conexion, $cita)
{
	$errores=array();
	
	if ($cita["fechacita"] == "") {
		$errores[] = "<p>La fecha de la cita no puede estar vacía.</p>";
	} else if (fechaAnteriorActual($cita["fechacita"] == 0)){
		$errores[] = "<p>La fecha de la cita no puede ser posterior a la fecha actual.</p>";
	} 

	if ($cita["objetivo"] == "") {
		$errores[] = "<p>El objetivo no puede estar vacio.</p>";
	}

	if ($cita["dni"] == "" || !preg_match("/^[0-9]{8}[A-Z]$/", $cita["dni"])) {
		$errores[] = "<p>El dni no puede estar vacio y tiene que ser del formato 12345678A.</p>";
	}

	if ($cita["nombrev"] == "") {
		$errores[] = "<p>El nombre del voluntario responsable de la cita no puede estar vacío.</p>";
	}
	return $errores;
}
 