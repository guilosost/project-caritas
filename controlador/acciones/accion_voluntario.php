<?php
session_start();
require_once("../../modelo/GestionBD.php");
require_once("../../modelo/gestionar/gestionar_voluntarios.php");

if (isset($_SESSION["formulario_voluntario"])) {
	$voluntario['nombrev'] = $_REQUEST["nombrev"];
	$voluntario['password'] = $_REQUEST["password"];
	$voluntario['password2'] = $_REQUEST["password2"];
	$voluntario['permisos'] = $_REQUEST["permisos"];
	
	$_SESSION["formulario_voluntario"] = $voluntario;
}else if (isset($_SESSION["voluntario"])) {
	$voluntario['nombrev'] = $_REQUEST["nombrev"];
	$voluntario['password'] = $_REQUEST["password"];
	$voluntario['password2'] = $_REQUEST["password2"];
	$voluntario['permiso'] = $_REQUEST["permiso"];
	
	$_SESSION["voluntario"] = $voluntario;
} else if (isset($_SESSION["voluntario-editar"])) {
	$voluntario['nombrev'] = $_REQUEST["nombrev"];
	$voluntario['permiso'] = $_REQUEST["permiso"];
	
	$_SESSION["voluntario-editar"] = $voluntario;
} else {
	Header("Location: ../../vista/listas/lista_voluntario.php");
}

$conexion = crearConexionBD();
$errores = validarDatosVoluntario($conexion, $voluntario);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
if (isset($_SESSION["formulario_voluntario"])) {
	Header('Location: ../../controlador/altas/alta_voluntario.php');
} else if (isset($_SESSION["voluntario"])) {
	Header("Location: ../../controlador/ediciones/editar_voluntario.php");
} else if (isset($_SESSION["voluntario-editar"])) {
	Header("Location: ../../controlador/resultados/resultado_alta_voluntario.php");
}
} else {
	// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
	Header('Location: ../../controlador/resultados/resultado_alta_voluntario.php');
}

function validarDatosVoluntario($conexion, $voluntario)
{
	$errores=array();
	if (isset($_SESSION["formulario_voluntario"])) {
	if ($voluntario["nombrev"] == "") {
		$errores[] = "<p>El nombre no puede estar vacío.</p>";
	}
	else if(consultarVoluntarioRepetido($conexion,$voluntario["nombrev"])!=0){
		$errores[] = "<p>El nombre especificado ya está en uso.</p>";
	}

	if ($voluntario["password"] == "" or !preg_match("/[A-Z Ñ]/", $voluntario["password"]) or !preg_match("/[0-9]/", $voluntario["password"]))
		{
			$errores[] = "<p>La contraseña no puede estar vacía o contener menos de 6 caracteres.</p>";
		}

	if ($voluntario["permisos"] == "" ) {
		$errores[] = "<p>Al menos un permiso debe estar seleccionado.</p>";
	} 
	}else if (isset($_SESSION["voluntario"])) {
		if ($voluntario["nombrev"] == "") {
			$errores[] = "<p>El nombre no puede estar vacío.</p>";
		}
	
		if ($voluntario["password"] == "" or !preg_match("/[A-Z Ñ]/", $voluntario["password"]) or !preg_match("/[0-9]/", $voluntario["password"]))
		{
			$errores[] = "<p>La contraseña no puede estar vacía o contener menos de 6 caracteres.</p>";
		}
	
		if ($voluntario["permiso"] == "" ) {
			$errores[] = "<p>Al menos un permiso debe estar seleccionado.</p>";
		} 
	} else if (isset($_SESSION["voluntario-editar"])) {
		if ($voluntario["nombrev"] == "") {
			$errores[] = "<p>El nombre no puede estar vacío.</p>";
		}

		if ($voluntario["permiso"] == "" ) {
			$errores[] = "<p>Al menos un permiso debe estar seleccionado.</p>";
		} 
	}
	return $errores;
}
 