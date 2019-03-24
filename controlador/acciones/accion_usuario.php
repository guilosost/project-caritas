<?php
session_start();

if (isset($_SESSION["formulario"])) {
	$usuario['DNI'] = $_REQUEST["dni"];
	$usuario['nombre'] = $_REQUEST["nombre"];
	$usuario['apellidos'] = $_REQUEST["apellidos"];
	$usuario['fechaNac'] = $_REQUEST["fechaNac"];
	$usuario['parentesco'] = $_REQUEST["parentesco"];
	$usuario['telefono'] = $_REQUEST["telefono"];
	$usuario['genero'] = $_REQUEST["genero"];
	$usuario['discapacidad'] = $_REQUEST["discapacidad"];
	$usuario['solicitante'] = $_REQUEST["solicitante"];
	$usuario['ingresos'] = $_REQUEST["ingresos"];
	$usuario['estudios'] = $_REQUEST["estudios"];
	$usuario['sitlaboral'] = $_REQUEST["sitlaboral"];
	$usuario['proteccionDatos'] = $_REQUEST["proteccionDatos"];
	$usuario['poblacion'] = $_REQUEST["poblacion"];
	$usuario['codigopostal'] = $_REQUEST["codigopostal"];
	$usuario['domicilio'] = $_REQUEST["domicilio"];
	$usuario['gastosfamiliares'] = $_REQUEST["gastosfamiliares"];
	$_SESSION["formulario"] = $usuario;
} else {
	Header("Location: ../../controlador/altas/alta_usuario.php");
}

$conexion = crearConexionBD();
$errores = validarDatosUsuario($conexion, $usuario);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
	Header('Location: ../../controlador/altas/alta_usuario.php');
} else
	// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
	Header('Location: ../../controlador/exitos/exito_alta_usuario.php');

function validarDatosUsuario($conexion, $usuario)
{
	$errores=array();

	if ($usuario["dni"] == "") {
		$errores[] = "<p>El DNI no puede estar vacío.</p>";
	} elseif (!preg_match("/^[0-9]{8}[A-Z]$/", $usuario["dni"])) {
		$errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $usuario["dni"] . ".</p>";
	}

	if ($usuario["nombre"] == "" || ctype_alpha($usuario["nombre"])) {
		$errores[] = "<p>El nombre no puede estar vacío o contener caracteres numéricos.</p>";
	}

	if ($usuario["apellidos"] == "" || ctype_alpha($usuario["apellidos"])) {
		$errores[] = "<p>Los apellidos no pueden estar vacíos o contener caracteres numéricos.</p>";
	}

	if ($usuario["parentesco"] == "" || ctype_alpha($usuario["parentesco"])) {
		$errores[] = "<p>El parentesco no puede estar vacío o contener caracteres numéricos.</p>";
	}

	if ($usuario["email"] == "") {
		$errores[] = "<p>El email no puede estar vacío</p>";
	} else if (!filter_var($usuario["email"], FILTER_VALIDATE_EMAIL)) {
		$errores[] = "<p>El email es incorrecto: " . $usuario["email"] . ".</p>";
	}

	if ($usuario["telefono"] == "") {
		$errores[] = "<p>El telefono no puede estar vacío</p>";
	} else if (!preg_match("/^[0-9]{9}$/", $usuario["telefono"])) {
		$errores[] = "<p>El teléfono debe contener 9 dígitos y ser numérico: " . $usuario["telefono"] . ".</p>";
	}

	if($usuario["genero"]=="") {
		$errores[] = "<p>El campo género no puede estar vacío.</p>";
	}else if($usuario["genero"]!="Masculino" and $usuario["genero"]!="Femenino" ){
		$errores[] = "<p>El campo género debe tomar los valores del formuario.</p>";
	}

	if($usuario["fechaNac"]=="") {
		$errores[] = "<p>El campo fecha de nacimiento no puede estar vacío.</p>";
	}

	if($usuario["ingresos"]=="") {
		$errores[] = "<p>El campo de ingresos no puede quedar vacío.</p>";
	}else if(!preg_match("/^[0-9][.]$/", $usuario["ingresos"])) {
		$errores[] = "<p>El campo ingresos no puede contener letras.</p>";
	}

	if($usuario["discapacidad"]=="") {
		$errores[] = "<p>El campo discapacidad no puede estar vacío.</p>";
	}

	if($usuario["solicitante"]=="") {
		$errores[] = "<p>El campo solicitante no puede estar vacío.</p>";
	}

	if($usuario["estudios"]=="") {
		$errores[] = "<p>El campo estudios no puede estar vacío.</p>";
	}

	if($usuario["sitlaboral"]=="") {
		$errores[] = "<p>El campo de situación laboral no puede estar vacío.</p>";
	}
	
	if($usuario["solicitante"]=="Sí"){

		if($usuario["poblacion"]=="") {
			$errores[] = "<p>El campo población no puede estar vacío.</p>";
		}else if ($usuario["poblacion"] !="San Juan de Aznalfarache"){
			$errores[] = "<p>El solicitante debe de vivir en San Juan de Aznalfarache.</p>";
		}

		if($usuario["domicilio"]=="") {
			$errores[] = "<p>El campo domicilio no puede estar vacío.</p>";
		}

		if(strtotime($usuario["fechaNac"])-strtotime(date("d/m/Y"))<18){
			$errores[] = "<p>El solicitante debe de ser mayor de 18 años</p>";
		}

		if($usuario["gastosfamilia"]=="") {
			$errores[] = "<p>El campo de gastos familiares no puede estar vacío.</p>";
		}

		if($usuario["codigopostal"]=="") {
			$errores[] = "<p>El dódigo postal no puede estar vacío.</p>";
		}else if (!preg_match("/^[0-9]{5}$/", $usuario["codigopostal"])) {
			$errores[] = "<p>El dódigo postal debe de constar 5 dígitos.</p>";
		} else if ($usuario["codigopostal"] != "41920"){
			$errores[] = "<p>El dódigo postal no es el de San Juan de Aznalfarache.</p>";
		}

		if($usuario["proteccionDatos"]=="") {
			$errores[] = "<p>El usuario tiene que aceptar la Ley de Protección de Datos.</p>";
	}
	}
}
 