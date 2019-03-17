<?php
    session_start();
?>
<?php
if (!isset($_SESSION["formulario"])) {
    $formulario['nombre'] = "";
    $formulario['apellidos'] = "";
    $formulario['dni'] = "";
    $formulario['fechaNac'] = "";
    $formulario['email'] = "";
    $formulario['genero'] = "";
    $formulario['minusvalia'] = "";
    $formulario['sitlaboral'] = "";
    $formulario['proteccionDatos'] = "";
    $formulario['solicitante'] = "";
    $formulario['parentesco'] = "";
    $formulario['estudios'] = "";
    $_SESSION["formulario"] = $formulario;
}
else{
    $formulario = $_SESSION["formulario"];
}

if (isset($_SESSION["errores"])){
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
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

		<label for="fechaNac" >Fecha de nacimiento:</label>
        <input name="fechaNac" type="date" required/><br>

        <label for="genero" >Género: </label>
        <input type="radio" name="genero" value="Hombre" > Hombre<br>
        <input type="radio" name="genero" value="Mujer"> Mujer<br>

        <select name="sitlaboral"  size =1 required >
        <option value="NULL">No es relevante </option>
        <option value="En paro">Desempleado </option>
        <option value="Trabajando">Trabajando </option>
        </select>

        <select name="estudios"  size =1 required >
        <option value="No es relevante">No es relevante </option>
        <option value="Nada">Nada </option>
        <option value="Educacion primaria">Educación primaria </option>
        <option value="Educacion secundaria">Educación secundaria </option>
        <option value="Bachillerato">Bachillerato </option>
        <option value="Título universitario">Título universitario </option>
        </select>

        <label for="proteccionDatos" >De acuerdo con la ley de protección de datos vigente </label>
        <input type="radio" name="proteccionDatos" value="Si" > Firmada<br>
        <input type="radio" name="proteccionDatos" value="No"> No firmada<br>

        <label for="parentesco">Parentesco:</label>
		<input name="parentesco" type="text" /><br>

        <label for="minusvalia" >¿El usuario tiene alguna discapacidad? </label>
        <input type="radio" name="minusvalia" value="Si" >Sí<br>
        <input type="radio" name="minusvalia" value="No">No<br>

        <label for="solicitante" >¿Es el usuario solicitante? </label>
        <input type="radio" name="solicitante" value="Si" > Sí<br>
        <input type="radio" name="solicitante" value="No"> No<br>

</form>

<?php
    include("footer.php");
    cerrarConexionBD($conexion);
?>
</body>
</html>

