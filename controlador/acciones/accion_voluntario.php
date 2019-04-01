<?php
session_start();
require_once("../../modelo/GestionBD.php");

if (isset($_SESSION["formulario"])) {
	$voluntario['nombre'] = $_REQUEST["nombre"];
	$voluntario['contraseña'] = $_REQUEST["contraseña"];
	$voluntario['permisos'] = $_REQUEST["permisos"];
	
	$_SESSION["formulario"] = $voluntario;
} else {
	Header("Location: ../../controlador/altas/alta_voluntario.php");
}

$conexion = crearConexionBD();
$errores = validarDatosVoluntario($conexion, $voluntario);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
	Header('Location: ../../controlador/altas/alta_voluntario.php');
} else {
	// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
	Header('Location: ../../controlador/exitos/exito_alta_voluntario.php');
}

function validarDatosVoluntario($conexion, $voluntario)
{
	$errores=array();

	if ($voluntario["nombre"] == "") {
		$errores[] = "<p>El nombre no puede estar vacío.</p>";
	}
	}

	if ($voluntario["contraseña"] == "" || !preg_match("/^{6}$/", $voluntario["contraseña"])  {
		$errores[] = "<p>La contraseña no puede estar vacía o contener menos de 6 caracteres.</p>";
	}

	if ($voluntario["permisos"] == "" ) {
		$errores[] = "<p>Debes tener al menos un permiso seleccionado</p>";
	}

	

	return $errores;
}
 