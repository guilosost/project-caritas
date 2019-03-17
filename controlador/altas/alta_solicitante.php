<?php
    session_start();
?>
<?php
if (!isset($_SESSION["formulario"])) {
    $formulario['nombre'] = "";
    $formulario['apellidos'] = "";
    $formulario['dni'] = "";
    $formulario['fechaNac'] = "";
    $formulario['genero'] = "";
    $_SESSION["formulario"] = $formulario;
}


$conexion = crearConexionBD();
?>
<?php
    include("header.php")    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="accion_usuario.php" method="POST">
        <label for="nombre" required>Nombre:</label>
		<input name="nombre" type="text" required/>
		<label for="apellidos" required>Apellidos:</label>
		<input name="apellidos" type="text" required/><br>
		<label for="dni">DNI:</label>
		<input name="dni" type="text" required/>
		<label for="email">Ingresos:</label>
		<input name="email" type="text" required/><br>
		<label for="fechaNac" required >Fecha de nacimiento:</label>
        <input name="fechaNac" type="date" required/><br>
        <label for="nombre" required >Género:</label>
        <input type="radio" name="genero" value="male" > Hombre<br>
        <input type="radio" name="genero" value="female"> Mujer<br>
</form>

<?php
    include("footer.php");
    cerrarConexionBD($conexion);
?>
</body>
</html>

