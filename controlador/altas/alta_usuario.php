<?php
session_start();
require_once("/../../modelo/gestionBD.php");

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
} else {
    $formulario = $_SESSION["formulario"];
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

$conexion = crearConexionBD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php")
    ?>

    <div class="form">
        <h2 class="form-h2">Alta de usuario</h2>
        <div class="form-alta">
            <form action="accion_usuario.php" method="POST">
                <label for="nombre" required>Nombre:</label>
                <input class="celda" name="nombre" type="text" required />

                <label for="apellidos" required>Apellidos:</label>
                <input name="apellidos" type="text" required /><br>

                <label for="dni">DNI:</label>
                <input class="celda" name="dni" placeholder="12345678X" type="text" required />

                <label for="email">Ingresos:</label>
                <input class="celda" name="email" type="text" required /><br>

                <label for="fechaNac">Fecha de nacimiento:</label>
                <input name="fechaNac" type="date" required /><br>

                <label for="genero">Género: </label>
                <input type="radio" name="genero" value="Hombre"> Hombre
                <input type="radio" name="genero" value="Mujer"> Mujer<br>

                <label for="sitlaboral">Situación laboral: </label>
                <select name="sitlaboral" size=1 required>
                    <option value="NULL">No es relevante </option>
                    <option value="En paro">Desempleado </option>
                    <option value="Trabajando">Trabajando </option>
                </select>
                <br>
                <label for="estudios">Estudios: </label>
                <select name="estudios" size=1 required>
                    <option value="No es relevante">No es relevante </option>
                    <option value="Nada">Nada </option>
                    <option value="Educacion primaria">Educación primaria </option>
                    <option value="Educacion secundaria">Educación secundaria </option>
                    <option value="Bachillerato">Bachillerato </option>
                    <option value="Título universitario">Título universitario </option>
                </select>
                <br>
                <label for="proteccionDatos">De acuerdo con la ley de protección de datos vigente: </label>
                <input type="radio" name="proteccionDatos" value="Sí"> Sí
                <input type="radio" name="proteccionDatos" value="No"> No<br>

                <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                <input type="radio" name="minusvalia" value="Si">Sí
                <input type="radio" name="minusvalia" value="No">No<br>

                <label for="solicitante">¿Es el usuario solicitante? </label>
                <input type="radio" name="solicitante" value="Si"> Sí
                <input type="radio" name="solicitante" value="No"> No<br>

                <label for='parentesco'>Parentesco:</label>
                <input name='parentesco' type='text' /><br>
                
            </form>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
 </body>

</html>