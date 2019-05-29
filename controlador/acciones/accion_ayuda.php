<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
require_once(MODELO."/GestionBD.php");
include_once("../funciones.php");

if(isset($_SESSION["formulario_ayuda"])){
    $ayuda['tipoayuda'] = $_REQUEST["tipoayuda"];
    $ayuda['suministradapor'] = $_REQUEST["suministradapor"];
    $ayuda['concedida'] = $_REQUEST["concedida"];
    // Ayuda de comida
    $ayuda['bebe'] = $_REQUEST["bebe"];
    $ayuda['niño'] = $_REQUEST["niño"];
    // Ayuda económica
    $ayuda['cantidad'] = $_REQUEST["cantidad"];
    $ayuda['motivo'] = $_REQUEST["motivo"];
    if(isset($_REQUEST["prioridad"])){
    $ayuda['prioridad'] = $_REQUEST["prioridad"];
    }
    $ayuda['descripcion'] = $_REQUEST["descripcion"];
    $ayuda['empresa'] = $_REQUEST["empresa"];
    $ayuda['salarioaproximado'] = $_REQUEST["salarioaproximado"];
    $_SESSION["formulario_ayuda"] = $ayuda;
} else if (isset($_SESSION["ayuda"])) {
    $ayuda['tipoayuda'] = $_REQUEST["tipoayuda"];
    $ayuda['suministradapor'] = $_REQUEST["suministradapor"];
    $ayuda['concedida'] = $_REQUEST["concedida"];
    // Ayuda de comida
    $ayuda['bebe'] = $_REQUEST["bebe"];
    $ayuda['niño'] = $_REQUEST["niño"];
    // Ayuda económica
    $ayuda['cantidad'] = $_REQUEST["cantidad"];
    $ayuda['motivo'] = $_REQUEST["motivo"];
    $ayuda['prioridad'] = $_REQUEST["prioridad"];
    $ayuda['descripcion'] = $_REQUEST["descripcion"];
    $ayuda['empresa'] = $_REQUEST["empresa"];
    $ayuda['salarioaproximado'] = $_REQUEST["salarioaproximado"];
    $ayuda_aux = $_SESSION["ayuda"];
	$ayuda["oid_a"] = $ayuda_aux["oid_a"]; 
    $_SESSION["ayuda"] = $ayuda;
} else {
	Header("Location: ../../controlador/altas/alta_ayuda.php");
}

$conexion = crearConexionBD();
$errores = validarDatosAyuda($conexion, $ayuda);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
    $_SESSION["errores"] = $errores;
    if(isset($_SESSION["formulario_ayuda"])){
    Header('Location: ../../controlador/altas/alta_ayuda.php');
    }else if (isset($_SESSION["usuario"])) {
        Header('Location: ../../controlador/ediciones/editar_ayuda.php');
    }
} else {
    // Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
    Header('Location: ../../controlador/resultados/resultado_alta_ayuda.php');
}
function validarDatosAyuda($conexion, $ayuda){

    if ($ayuda["suministradapor"] == "" || !preg_match("/^[a-zA-Z Ññáéíóú\\s]/",$ayuda["suministradapor"])) {
    $errores[] = "<p>El campo de suministrador de la ayuda no puede estar vacío ni contener caracteres numéricos.</p>";
    } 

    if ($ayuda["concedida"] == "") {
        $errores[] = "<p>El estado de la ayuda debe ser especificado.</p>";
    } 

    if($ayuda['tipoayuda'] == "bolsacomida"){

    if ($ayuda["bebe"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
    } 

    if ($ayuda["niño"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
    } 
    }
    if($ayuda['tipoayuda'] == "ayudaeconomica"){

    if ($ayuda["cantidad"] == "" || !preg_match("/^[0-9]+$/",$ayuda["cantidad"])) {
        $errores[] = "<p>El campo cantidad no puede estar vacío.</p>";
    } 
    if ($ayuda["motivo"] == "" || !preg_match("/^[a-zA-Z Ññáéíóú\\s]/",$ayuda["motivo"])) {
        $errores[] = "<p>El campo motivo no puede estar vacío.</p>";
    } 

    if ($ayuda["prioridad"] == "") {
        $errores[] = "<p>La prioridad de la ayuda debe ser especificada.</p>";
    } 
    }

    if($ayuda['tipoayuda'] == "trabajos"){
    if ($ayuda["descripcion"] == "" || !preg_match("/^[a-zA-Z Ññáéíóú\\s]/",$ayuda["descripcion"])) {
        $errores[] = "<p>El campo de descripción del trabajo no puede estar vacío.</p>";
    } 

    if ($ayuda["empresa"] == "" || !preg_match("/^[a-zA-Z Ññáéíóú\\s]/",$ayuda["empresa"])) {
        $errores[] = "<p>El campo de la empresa no puede estar vacío.</p>";
    }    

    if ($ayuda["salarioaproximado"] == "" || !preg_match("/^[0-9]+$/",$ayuda["salarioaproximado"])) {
        $errores[] = "<p>El salario aproximado no puede estar vacío.</p>";
    }
}
    return $errores;
}