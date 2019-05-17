<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
} else {
    Header("Location:../../vista/listas/lista_usuario.php");
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
    <link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script>
    <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script>
    <script>
        function showHide(elm) {
            var solicitante = document.getElementById("esSolicitante");
            var familiar = document.getElementById("esFamiliar");

            if (elm.id == 'solicitar') {
                solicitante.classList.remove('hide');
                familiar.classList.add('hide');
            } else if (elm.id == 'familiar') {
                solicitante.classList.add('hide');
                familiar.classList.remove('hide');
            }
        }
    </script>
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");

    list($dia, $mes, $anyo) = split("/", $usuario['fechaNac']);
    $fechaDef = "$anyo-$mes-$dia";

    //Mostramos los errores del formulario enviado previamente
    if (isset($errores) && count($errores) > 0) {
        //    echo "<div id=\"div_errores\" class=\"error\">";
        echo "<h4> Errores en el formulario:</h4>";
        foreach ($errores as $error) {
            echo $error;
        }
        //    echo "</div>";
    }
    ?>


    <div class="flex">
        <div class="form">
            <h2 class="form-h2">Alta de usuario</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_usuario.php" id="altaUsuario" method="POST" name="altaUsuario">
                    <fieldset>
                        <legend>Información básica del usuario</legend>

                        <label for="nombre" required>Nombre:</label>
                        <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $usuario['nombre']; ?>" />

                        <label for="apellidos" required>Apellidos:</label>
                        <input name="apellidos" type="text" maxlength="50" value="<?php echo $usuario['apellidos']; ?>" /><br>

                        <label for="dni">DNI:</label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php echo $usuario['dni']; ?>" required /><br>

                        <label for="fechaNac">Fecha de nacimiento:</label>
                        <input name="fechaNac" type="date" value="<?php echo $fechaDef; ?>" required /><br>

                        <label for="genero">Género: </label>
                        <input type="radio" name="genero" value="Masculino" <?php if ($usuario['genero'] == 'Masculino') echo ' checked '; ?>> Hombre
                        <input type="radio" name="genero" value="Femenino" <?php if ($usuario['genero'] == 'Femenino') echo ' checked '; ?>> Mujer<br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $usuario['telefono']; ?>" required /><br>

                        <label for="estudios">Estudios: </label>
                        <select class="celda" name="estudios" size=1 required>
                            <option value="No es relevante" <?php if ($usuario['estudios'] == 'No es relevante') echo ' selected '; ?>>No es relevante </option>
                            <option value="Sin estudios" <?php if ($usuario['estudios'] == 'Sin estudios') echo ' selected '; ?>>Sin estudios </option>
                            <option value="Educación primaria" <?php if ($usuario['estudios'] == 'Educación primaria') echo ' selected '; ?>>Educación primaria </option>
                            <option value="Educación secundaria" <?php if ($usuario['estudios'] == 'Educación secundaria') echo ' selected '; ?>>Educación secundaria </option>
                            <option value="Bachillerato" <?php if ($usuario['estudios'] == 'Bachillerato') echo ' selected '; ?>>Bachillerato </option>
                            <option value="Grado medio" <?php if ($usuario['estudios'] == 'Grado medio') echo ' selected '; ?>>Grado medio </option>
                            <option value="Grado superior" <?php if ($usuario['estudios'] == 'Grado superior') echo ' selected '; ?>>Grado superior </option>
                            <option value="Grado universitario" <?php if ($usuario['estudios'] == 'Grado universitario') echo ' selected '; ?>>Grado universitario </option>
                        </select>
                        <br>
                        <label for="sitlaboral">Situación laboral: </label>
                        <select class="celda" name="sitlaboral" size=1 required>
                        <option value="No es relevante" <?php if ($usuario['sitlaboral'] == 'No es relevante') echo ' selected '; ?>>No es relevante </option>
                            <option value="En paro" <?php if ($usuario['sitlaboral'] == 'En paro') echo ' selected '; ?>>Desempleado </option>
                            <option value="Trabajando" <?php if ($usuario['sitlaboral'] == 'Trabajando') echo ' selected '; ?>>Trabajando </option>
                        </select>
                        <br>

                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $usuario['ingresos']; ?>" required /><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($usuario['minusvalia'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($usuario['minusvalia'] == 'No ') echo ' checked '; ?>>No<br>

                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio" id="solicitar" name="solicitante" onclick="showHide(this)" onchange="return validateDate();" value="Sí" <?php if ($usuario['solicitante'] == 'Sí') echo ' checked '; ?>> Sí
                        <input type="radio" id="familiar" name="solicitante" onclick="showHide(this)" value="No" <?php if ($usuario['solicitante'] == 'No ') echo ' checked '; ?>> No<br>

                    </fieldset>

                    <?php
                    if ($usuario['solicitante'] == 'Sí') {
                        echo '<div id="esSolicitante">';
                    } else {
                        echo '<div id="esSolicitante" class="hide">';
                    }
                    ?>
                    <br>
                    <fieldset>
                        <legend>Información básica del solicitante</legend>

                        <label for="gastosfamilia">Gastos de la familia:</label>
                        <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['gastosfamilia']; ?>" /><br>

                        <label for="poblacion">Población:</label>
                        <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['poblacion']; ?>" /><br>

                        <label for="domicilio">Dirección del domicilio:</label>
                        <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['domicilio']; ?>" /><br>

                        <label for="codigopostal">Código postal:</label>
                        <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['codigopostal']; ?>" /><br>

                        <label for="proteccionDatos">
                            <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($usuario["solicitante"] == "Sí") echo ' checked '; ?>>De acuerdo con la Ley de Protección de Datos
                        </label>
                    </fieldset>
            </div>
            <?php
                    if ($usuario['solicitante'] == 'No ') {
                        echo '<div id="esFamiliar">';
                    } else {
                        echo '<div id="esFamiliar" class="hide">';
                    }
                    ?>
                <br>
                <fieldset>
                    <legend>Información básica del familiar</legend>

                    <label for="dniSol">DNI del solicitante:</label>
                    <input class="celda" name="dniSol" type="text" maxlength="9" value="<?php if ($usuario["solicitante"] == "No ") echo $usuario['dni_so']; ?>" /><br>

                    <label for='parentesco'>Parentesco con el solicitante:</label>
                    <input name='parentesco' type='text' value="<?php if ($usuario["solicitante"] == "No ") echo $usuario['parentesco']; ?>" /><br>
                </fieldset>
            </div>

            <div class="botones">
                <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancelar</a>
                <input type="submit" value="Editar">
            </div>
            </form>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        var frmvalidator = new Validator("altaUsuario");
        var solicitante = document.forms["altaUsuario"]["solicitante"].value;
        var poblacion = document.forms["altaUsuario"]["poblacion"].value;

        frmvalidator.EnableMsgsTogether();

        frmvalidator.addValidation("nombre", "req", "Introduzca el nombre");
        frmvalidator.addValidation("nombre", "alphabetic_space", "El nombre debe de constar de letras y espacios");

        frmvalidator.addValidation("apellidos", "req", "Introduzca los apellidos");
        frmvalidator.addValidation("apellidos", "alphabetic_space", "Los apellidos deben de constar de letras y espacios");

        frmvalidator.addValidation("dni", "req", "Introduzca el dni");
        frmvalidator.addValidation("dni", "regexp=^[0-9]{8}[A-Z]$", "Introduzca un dni de la forma 12345678A");

        frmvalidator.addValidation("fechaNac", "req", "Introduzca la fecha de nacimiento");

        frmvalidator.addValidation("genero", "selone_radio", "Introduzca el género");

        frmvalidator.addValidation("telefono", "req", "Introduzca el teléfono");
        frmvalidator.addValidation("telefono", "regexp=^[0-9]{9}$", "Introduzca un número de teléfono válido");

        frmvalidator.addValidation("estudios", "dontselect=000", "Introduzca el nivel de estudios");

        frmvalidator.addValidation("sitlaboral", "dontselect=000", "Introduzca la situación laboral del usuario");

        frmvalidator.addValidation("ingresos", "req", "Introduzca los ingresos");
        frmvalidator.addValidation("ingresos", "num", "Introduzca un valor numérico en los ingresos");
        frmvalidator.addValidation("ingresos", "lt=1000", "Los ingresos no deben de superar los 1000 euros");
        frmvalidator.addValidation("ingresos", "lt=672", "Los ingresos son mayores de lo estimado por estar desempleado",
            "VWZ_IsListItemSelected(document.forms['altaUsuario'].elements['sitlaboral'],'En paro')");
        frmvalidator.addValidation("ingresos", "lt=1", "Los ingresos son mayores de lo estimado",
            "VWZ_IsListItemSelected(document.forms['altaUsuario'].elements['sitlaboral'],'No es relevante')");
        frmvalidator.addValidation("ingresos", "gt=0", "Los ingresos son mayores de lo estimado por tener alguna discapacidad",
            "VWZ_IsChecked(document.forms['altaUsuario'].elements['minusvalia'],'Sí')");

        frmvalidator.addValidation("minusvalia", "selone_radio", "Introduzca si posee alguna minusvalia");

        frmvalidator.addValidation("solicitante", "selone_radio", "Introduzca si el usuario es solicitante");

        if (solicitante == "Sí") {
            frmvalidator.addValidation("gastosfamilia", "req", "Introduzca los gastos de la familia");
            frmvalidator.addValidation("gastosfamilia", "num", "Introduzca un valor numérico en los gastos familiares");

            frmvalidator.addValidation("poblacion", "req", "Introduzca la población");
            frmvalidator.addValidation("poblacion", "alphabetic_space", "La población debe de constar de letras y espacios");

            frmvalidator.addValidation("domicilio", "req", "Introduzca el domicilio");

            frmvalidator.addValidation("codigopostal", "req", "Introduzca el código postal");
            frmvalidator.addValidation("codigopostal", "regexp=^[0-9]{5}$", "Introduzca un código postal válido");

            frmvalidator.addValidation("proteccionDatos", "shouldselchk=on", "El solicitante debe de aceptar la Ley de Protección de Datos");

        } else if (solicitante == "No") {
            frmvalidator.addValidation("dniSol", "req", "Introduzca el dni del solicitante");
            frmvalidator.addValidation("dniSol", "regexp=^[0-9]{8}[A-Z]$", "Introduzca un dni de la forma 12345678A");

            frmvalidator.addValidation("parentesco", "req", "Introduzca el aprentesco co el solicitante");
            frmvalidator.addValidation("parentesco", "alphabetic_space", "El nombre debe de constar de letras");
        }
    </script>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>