<?php
session_start();

include("../../modelo/gestionar/gestionar_usuarios.php");
require_once("../../modelo/GestionBD.php");

if (isset($_SESSION["formulario_usuario"])) {
	$usuario = $_SESSION["formulario_usuario"];
} else if (isset($_SESSION["usuario-editar"])) {
	unset($_SESSION["usuario"]);
	$usuario = $_SESSION["usuario-editar"];
} else if (isset($_SESSION["usuario"])) {
	$usuario = $_SESSION["usuario"];
} else {
	Header("Location: ../../vista/listas/lista_usuario.php");
}

$conexion  = crearConexionBD();

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
	<link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
	<link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
	<link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Alta de Usuario: Resultado</title>
	<link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />

</head>

<body background="../../vista/img/background.png">
	<?php
	include("../../vista/header.php");
	include("../../vista/navbar.php");
	if (isset($_SESSION["formulario_usuario"])) {
		unset($_SESSION["formulario_usuario"]);
		if ($usuario["solicitante"] == "Sí") {

			if (consultarUsuarioRepetido($conexion, $usuario["dni"]) > 0) { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>Este solicitante ya se encontraba en la base de datos.</p>
					</div>
				</div>
			<?php } else if (alta_solicitante($conexion, $usuario)) {
			?>
				<div class="flex">
					<div class="resultado">
						<p>El solicitante ha sido creado correctamente, redirigiendo al listado... </p>
					</div>
				</div>
				<meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El solicitante no ha sido creado, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	} else if ($usuario["solicitante"] == "No") {
		if (consultarUsuarioRepetido($conexion, $usuario["dni"]) != 0) { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>Este familiar ya se encontraba en la base de datos.</p>
					</div>
				</div>
			<?php } else if (nuevo_familiar($conexion, $usuario)) {
			?>
				<div class="flex">
					<div class="resultado">
						<p>El familiar ha sido creado correctamente, redirigiendo al listado... </p>
					</div>
				</div>
				<meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El familiar no ha sido creado, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	}
} else if (isset($_SESSION["usuario"])) {
	unset($_SESSION["usuario"]);

	if ($usuario["solicitante"] == "No") {
		if (consultarUsuarioRepetido($conexion, $usuario["dni"]) > 0) {
			editar_familiar($conexion, $usuario);
			?>
				<div class="flex">
					<div class="resultado">
						<p>El familiar ha sido editado correctamente, redirigiendo al listado... </p>
					</div>
				</div>
				<meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El familiar no ha sido editado, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	} else {
		if (consultarUsuarioRepetido($conexion, $usuario["dni"]) > 0) {
			editar_solicitante($conexion, $usuario);
			?>
				<div class="flex">
					<div class="resultado">
						<p>El solicitante ha sido editado correctamente, redirigiendo al listado... </p>
					</div>
				</div>
				<meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El solicitante no ha sido editado, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	}
} else if (isset($_SESSION["usuario-editar"])) {
	unset($_SESSION["usuario-editar"]);

	if ($usuario["solicitante"] == "Sí") {
		if (editar_usuario($conexion, $usuario)) {
			?>
				<meta http-equiv="refresh" content="0;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { ?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El solicitante no ha sido editado vía JavaScript, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	} else {
		if (editar_usuario($conexion, $usuario)) {
			?>
				<meta http-equiv="refresh" content="0;url=http://localhost:81/project-caritas/vista/listas/lista_usuario.php" />
			<?php
		} else { 
			?>
				<div class="flex">
					<div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
						<p>El familiar no ha sido editado vía JavaScript, ha ocurrido un error inesperado.</p>
					</div>
				</div>
			<?php }
	}
}

?>

	</main>
	<?php cerrarConexionBD($conexion); ?>
	<?php include("../../vista/footer.php");  ?>
</body>

</html>