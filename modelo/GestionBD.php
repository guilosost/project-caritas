<?php

function crearConexionBD()
{
	$host="oci:dbname=localhost/XE;charset=UTF8";
	$usuario="PROYECTODEFINITIVO";
	$password="REPOSITORIO";

	try{
		/* Indicar que las sucesivas conexiones se puedan reutilizar */	
		$conexion=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
	    /* Indicar que se disparen excepciones cuando ocurra un error*/
    	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conexion;
	}catch(PDOException $e){
		$_SESSION['excepcion'] = $e->GetMessage();
		header("Location: ../../modelo/excepcionBD/excepcionBD.php");
	}
}

function cerrarConexionBD($conexion){
	$conexion=null;
}

?>