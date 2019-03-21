<?php
session_start();

if (isset($_SESSION["formulario"])) {
	$cita['fechacita'] = $_REQUEST["fechacita"];
	$cita['objetivo'] = $_REQUEST["objetivo"];
	$cita['nombrev'] = $_REQUEST["nombrev"];
	$cita['observaciones'] = $_REQUEST["observaciones"];
	$cita['dni'] = $_REQUEST["dni"];
    $cita['formulario'] = $_REQUEST["formulario"];
    $_SESSION["formulario"] = $cita;

} else {
	Header("Location: ../../controlador/altas/alta_cita.php");
}

$conexion = crearConexionBD();
$errores = validarDatosCita($conexion, $cita);
cerrarConexionBD($conexion);

function validarDatosCita($conexion, $cita)
{

	if ($cita["fechacita"] == "") {
		$errores[] = "<p>La fecha de la cita no puede estar vacía.</p>";
	} 

	if ($cita["objetivo"] == "") {
		$errores[] = "<p>El objetivo no puede estar vacio.</p>";
	}

	if ($cita["dni"] == "" || !preg_match("/^[0-9]{8}[A-Z]$/", $cita["dni"])) {
		$errores[] = "<p>El dni no puede estar vacio y tiene que ser del formato 12345678A.</p>";
	}
	if ($cita["formulario"] == "") {
    $errores[] = "<p>El formulario no puede estar vacio</p>";
    }
}
 