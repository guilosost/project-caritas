<?php
session_start();

//YANES ARREGLA ESTA RUTA PORFA
include_once("funciones.php");

if(isset($_SESSION["contrasena"])){
	$usuariologin["nombrelogin"] = $_SESSION["nombrelogin"];
	$usuariologin["contrasena"] = $_SESSION["contrasena"];
	
}
else{
    header("Location: ../../controlador/acceso/login.php");
}

$conexion = crearConexionBD(); 
$errores = validarDatosUsuario($usuariologin,$conexion);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
	Header('Location: ../../controlador/altas/alta_voluntario.php');
} else {
	// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
	Header('Location: ../../controlador/exitos/exito_alta_voluntario.php');
}

function validarDatosLogIn($usuariologin,$conexion){

	$errores = array();

	if($usuariologin["nombrelogin"]=="" || ctype_alpha($usuariologin["nombrelogin"])) {
	$errores[] = "<p>El nombre de usuario no puede estar vacío o contener caracteres numéricos.</p>";
}

if($usuariologin["contrasena"]=="") {
	$errores[] = "<p>La contraseña no puede estar vacía.</p>";
}
else if(minchars($usuariologin["contrasena"],6)==1){
	$errores[] = "<p>La contraseña debe contener al menos 6 caracteres .</p>";
	}

	return $errores;
}
?>