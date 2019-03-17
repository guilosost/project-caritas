<?php
    session_start();

	if (isset($_SESSION["formulario"])) {
 			$usuario['DNI'] = $_REQUEST["dni"];
			$usuario['nombre'] = $_REQUEST["nombre"];
			$usuario['apellidos'] = $_REQUEST["apellidos"];
			$usuario['fechaNac'] = $_REQUEST["fechaNac"];
			}
	else{
        Header("Location: alta_usuario.php");
    }

    function validarDatosUsuario($usuario){
			
		
		if($usuario["dni"]=="") 
			$errores[] = "<p>El DNI no puede estar vacío</p>";
		else if(!preg_match("/^[0-9]{8}[A-Z]$/", $usuario["dni"])){
			$errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $usuario["dni"]. "</p>";
		}
		
		if($usuario["nombre"]=="" || ctype_alpha($usuario["nombre"])) {
			$errores[] = "<p>El nombre no puede estar vacío o no ser alfabetico</p>";
		}
		
		
		if($usuario["apellidos"]=="" || ctype_alpha($usuario["apellidos"])) {
			$errores[] = "<p>Los apellidos no puede estar vacío o no ser alfabeticos</p>";
		}

		if($usuario["parentesco"]=="" || ctype_alpha($usuario["apellidos"])) {
			$errores[] = "<p>Los apellidos no puede estar vacío o no ser alfabeticos</p>";
		}

		if($usuario["email"]==""){ 
			$errores[] = "<p>El email no puede estar vacío</p>";
		}else if(!filter_var($usuario["email"], FILTER_VALIDATE_EMAIL)){
			$errores[] = "<p>El email es incorrecto: " . $usuario["email"]. "</p>";
		}
			
    }
?>
