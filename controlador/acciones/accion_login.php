<?php
session_start();

include_once("../../modelo/gestionBD.php");
include_once("../../controlador/funciones.php");
include_once("../../modelo/gestionar/gestionar_login.php");

if(isset($_SESSION["formulario"])){
	$usuariologin["nombrelogin"] = $_REQUEST["nombrelogin"];
	$usuariologin["contrasena"] = $_REQUEST["contrasena"];
	$_SESSION["formulario"] = $usuariologin;
}
else{
    header("Location: ../../controlador/acceso/login.php");
}

$conexion = crearConexionBD(); 
$errores = validarDatosLogIn($usuariologin,$conexion);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	$_SESSION["errores"] = $errores;
	Header('Location: ../../controlador/acceso/login.php"');
} else {
	Header('Location: ../../controlador/resultados/resultado_login.php');
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