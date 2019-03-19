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

function validarDatosLogIn($usuariologin,$conexion){
if($usuariologin["nombrelogin"]=="" || ctype_alpha($usuariologin["nombrelogin"])) {
	$errores[] = "<p>El nombre de usuario no puede estar vacío o contener caracteres numéricos.</p>";
}

if($usuariologin["contrasena"]=="") {
	$errores[] = "<p>La contraseña no puede estar vacía.</p>";
}
else if(minchars($usuariologin["contrasena"],6)==1){
	$errores[] = "<p>La contraseña debe contener al menos 6 caracteres .</p>";
	}
}
?>