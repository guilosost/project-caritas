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
    // Cursos
    $ayuda['profesor'] = $_REQUEST["profesor"];
    $ayuda['materia'] = $_REQUEST["materia"];
    $ayuda['fechacomienzo'] = $_REQUEST["fechacomienzo"];
    $ayuda['fechafin'] = $_REQUEST["fechafin"];
    $ayuda['numerosesiones'] = $_REQUEST["numerosesiones"];
    $ayuda['numeroalumnosmaximo'] = $_REQUEST["numeroalumnosmaximo"];
    $ayuda['descripcion'] = $_REQUEST["descripcion"];
    $ayuda['empresa'] = $_REQUEST["empresa"];
    $ayuda['salarioaproximado'] = $_REQUEST["salarioaproximado"];
    $_SESSION["formulario_ayuda"] = $ayuda;

} else {
	Header("Location: ../../controlador/altas/alta_ayuda.php");
}

$conexion = crearConexionBD();
$errores = validarDatosAyuda($conexion, $ayuda);
cerrarConexionBD($conexion);

if (count($errores)>0) {
	// Guardo en la sesión los mensajes de error y volvemos al formulario
	$_SESSION["errores"] = $errores;
	Header('Location: ../../controlador/altas/alta_ayuda.php');
} else {
    // Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
    Header('Location: ../../controlador/resultados/resultado_alta_ayuda.php');
}
function validarDatosAyuda($conexion, $ayuda){

    if ($ayuda["suministradapor"] == "") {
    $errores[] = "<p>El campo de suministro no puede estar vacío.</p>";
    } 

    if ($ayuda["concedida"] == "") {
        $errores[] = "<p>Es necesario conocer el estado de la ayuda.</p>";
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

    if ($ayuda["cantidad"] == "") {
        $errores[] = "<p>El campo cantidad no puede estar vacío.</p>";
    } 
    if ($ayuda["motivo"] == "") {
        $errores[] = "<p>El campo motivo no puede estar vacío.</p>";
    } 

    if ($ayuda["prioridad"] == "") {
        $errores[] = "<p>Es necesario conocer la prioridad de la ayuda.</p>";
    } 
    }
    if($ayuda['tipoayuda'] == "curso"){

    if ($ayuda["profesor"] == "") {
        $errores[] = "<p>El campo profesor no puede estar vacío.</p>";
    } 

    if ($ayuda["materia"] == "") {
        $errores[] = "<p>El campo materia no puede estar vacío.</p>";
    } 


    if ($ayuda["fechacomienzo"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
        } 


    if ($ayuda["fechafin"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
    } 


    if ($ayuda["numerosesiones"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
    } 


    if ($ayuda["numeroalumnosmaximo"] == "") {
        $errores[] = "<p>El campo no puede estar vacío.</p>";
    }   
    }
    if($ayuda['tipoayuda'] == "trabajo"){
    if ($ayuda["descripcion"] == "") {
        $errores[] = "<p>El campo lugar no puede estar vacío.</p>";
    } 

    if ($ayuda["empresa"] == "") {
        $errores[] = "<p>El campo lugar no puede estar vacío.</p>";
    }    

    if ($ayuda["salarioaproximado"] == "") {
        $errores[] = "<p>El campo lugar no puede estar vacío.</p>";
    }
}
    return $errores;
}