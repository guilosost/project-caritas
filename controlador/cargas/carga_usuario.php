<?php	
	session_start();
	
	if (isset($_REQUEST["DNI"])){
		$usuario["dni"] = $_REQUEST["DNI"];
		$usuario["apellidos"] = $_REQUEST["APELLIDOS"];
		$usuario["nombre"] = $_REQUEST["NOMBRE"];
		$usuario["telefono"] = $_REQUEST["TELEFONO"];
		$usuario["ingresos"] = $_REQUEST["INGRESOS"];
		$usuario["sitlaboral"] = $_REQUEST["SITUACIONLABORAL"];
		$usuario["estudios"] = $_REQUEST["ESTUDIOS"];
		$usuario["genero"] = $_REQUEST["GENERO"];
		$usuario["fechaNac"] = $_REQUEST["FECHANAC"];
		$usuario["protecciondatos"] = $_REQUEST["PROTECCIONDATOS"];
		$usuario["solicitante"] = $_REQUEST["SOLICITANTE"];
		$usuario["parentesco"] = $_REQUEST["PARENTESCO"];
		$usuario["minusvalia"] = $_REQUEST["MINUSVALIA"];
		$usuario["dni_so"] = $_REQUEST["DNI_SO"];
		$_SESSION["usuario"] = $usuario;
			
	Header("Location: ../../vista/mostrar/mostrar_usuario.php"); 
	}
	else 
		Header("Location: consulta_libros.php");
?>