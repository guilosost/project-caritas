<?php
session_start();
require_once("/../../modelo/gestionBD.php");

if (!isset($_SESSION["formularioUsuario"])) {
    $formulario['nombre'] = "";
    $formulario['apellidos'] = "";
    $formulario['dni'] = "";
    $formulario['fechaNac'] = "";
    $formulario['email'] = "";
    $formulario['telefono'] = "";
    $formulario['genero'] = "";
    $formulario['minusvalia'] = "";
    $formulario['sitlaboral'] = "";
    $formulario['proteccionDatos'] = "";
    $formulario['solicitante'] = "";
    $formulario['parentesco'] = "";
    $formulario['ingresos'] = "";
    $formulario['estudios'] = "";
    $_SESSION["formularioUsuario"] = $formulario;
} else {
    $formulario = $_SESSION["formularioUsuario"];
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}

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
    include("../../vista/header.php");

     //Mostramos los errores del formulario enviado previamente
     if (isset($errores) && count($errores)>0) { 
        //    echo "<div id=\"div_errores\" class=\"error\">";
            echo "<h4> Errores en el formulario:</h4>";
            foreach($errores as $error){
                echo $error;
            } 
        //    echo "</div>";
          }
    ?>

    <div class="form">
        <h2 class="form-h2">Alta de usuario</h2>
        <div class="form-alta">
            <form action="accion_usuario.php" method="POST">
            <!--<fieldset> -->
            <!--    <legend>Información básica del usuario</legend> -->
                <label for="nombre" required>Nombre:</label>
                <input class="celda" name="nombre" type="text" maxlength="50" value="<?php $formulario['nombre'] ?>" required />

                <label for="apellidos" required>Apellidos:</label>
                <input name="apellidos" type="text" maxlength="50" value="<?php $formulario['apellidos'] ?>" required /><br>

                <label for="dni">DNI:</label>
                <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php $formulario['dni'] ?>"required />

                <label for="fechaNac">Fecha de nacimiento:</label>
                <input name="fechaNac" type="date" value="<?php $formulario['fechaNac'] ?>" required /><br>

                <label for="genero">Género: </label>
                <input type="radio" name="genero" value="Masculino"> Hombre
                <input type="radio" name="genero" value="Femenino"> Mujer<br>

                <label for="email">Correo electrónico:</label>
                <input class="celda" name="email" type="text" value="<?php $formulario['email'] ?>" required /><br>

                <label for="telefono">Teléfono:</label>
                <input class="celda" name="telefono" type="text" maxlength="10" value="<?php $formulario['telefono'] ?>" required /><br>

                <label for="estudios">Estudios: </label>
                <select class="celda" name="estudios" size=1 required>
                    <option value="No es relevante">No es relevante </option>
                    <option value="Nada">Nada </option>
                    <option value="Educacion primaria">Educación primaria </option>
                    <option value="Educacion secundaria">Educación secundaria </option>
                    <option value="Bachillerato">Bachillerato </option>
                    <option value="Título universitario">Título universitario </option>
                </select>
                <br>
                <label for="sitlaboral">Situación laboral: </label>
                <select class="celda" name="sitlaboral" size=1 required>
                    <option value="NULL">No es relevante </option>
                    <option value="En paro">Desempleado </option>
                    <option value="Trabajando">Trabajando </option>
                </select>
                <br>
                <label for="email">Ingresos:</label>
                <input name="email" type="text" value="<?php $formulario['ingresos'] ?>" required /><br>

                <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                <input type="radio" name="minusvalia" value="Sí">Sí
                <input type="radio" name="minusvalia" value="No">No<br>

                <label for="solicitante">¿Es el usuario solicitante? </label>
                <input type="radio" name="solicitante" value="Sí"> Sí
                <input type="radio" name="solicitante" value="No"> No<br>

                <label for='parentesco'>Parentesco con el solicitante ('null' si es solicitante):</label>
                <input name='parentesco' type='text' placeholder="null" value="<?php $formulario['parentesco'] ?>" required/><br>

                <label for="proteccionDatos">
                    <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center">De acuerdo con la Ley de Protección de Datos
                </label>
            <!-- </fieldset> -->
                <br>

                <a class="confirm" type="submit">Dar de alta</a>
                <a class= "cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancel</a>
            </form>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html> 