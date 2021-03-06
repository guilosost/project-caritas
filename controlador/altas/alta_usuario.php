<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}
unset($_SESSION["usuario"]);
unset($_SESSION["usuario-editar"]);
unset($_SESSION["usuario-eliminar"]);

if (!isset($_SESSION["formulario_usuario"])) {
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
    $formulario['poblacion'] = "";
    $formulario['domicilio'] = "";
    $formulario['gastosfamilia'] = "";
    $formulario['codigopostal'] = "";
    $formulario['dniSol'] = "";
    $_SESSION["formulario_usuario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_usuario"];
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
    <title>Alta de Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script>
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>

    <script>
        var solicitanteSiNo = "";

        function showHide(elm) {
            var solicitante = document.getElementById("esSolicitante");
            var familiar = document.getElementById("esFamiliar");

            if (elm.id == 'solicitar') {
                solicitante.classList.remove('hide');
                familiar.classList.add('hide');
                solicitanteSiNo = "Sí";
            } else if (elm.id == 'familiar') {
                solicitante.classList.add('hide');
                familiar.classList.remove('hide');
                solicitanteSiNo = "No";
            }
            console.log(solicitanteSiNo);
        }

        console.log("Sino: " + solicitanteSiNo);

    </script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");
    ?>



    <div id="flex" class="flex">
        <?php
        //Mostramos los errores del formulario enviado previamente
        if (isset($errores) && count($errores) > 0) {
            // echo "<script> error(); </script>";
            echo "<div class='error'>";
            echo "<h4> Errores en el formulario:</h4>";
            foreach ($errores as $error) {
                echo $error;
            }
            echo "</div>";
        }
        ?>
        <div class="form">
            <h2 class="form-h2">Alta de usuario</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_usuario.php" id="altaUsuario" method="POST">
                    <fieldset>
                        <legend>Información básica del usuario</legend>

                        <label for="nombre" required>Nombre:</label>
                        <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $formulario['nombre']; ?>" required />

                        <label for="apellidos" required>Apellidos:</label>
                        <input name="apellidos" type="text" maxlength="50" value="<?php echo $formulario['apellidos']; ?>" required /><br>

                        <label for="dni">DNI:</label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php echo $formulario['dni']; ?>" required /><br>

                        <label for="fechaNac">Fecha de nacimiento:</label>
                        <input name="fechaNac" type="date" value="<?php echo $formulario['fechaNac']; ?>" required /><br>

                        <label for="genero">Género: </label>
                        <input type="radio" name="genero" value="Masculino" <?php if ($formulario['genero'] == 'Masculino') echo ' checked '; ?>> Hombre
                        <input type="radio" name="genero" value="Femenino" <?php if ($formulario['genero'] == 'Femenino') echo ' checked '; ?>> Mujer<br>

                        <label for="email">Correo electrónico:</label>
                        <input class="celda" name="email" type="text" value="<?php echo $formulario['email']; ?>" required /><br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $formulario['telefono']; ?>" required /><br>

                        <label for="estudios">Estudios: </label>
                        <select class="celda" value="000" name="estudios" size=1 required>
                            <option value="No es relevante" <?php if ($formulario['estudios'] == 'No es relevante') echo ' selected '; ?>>No es relevante </option>
                            <option value="Sin estudios" <?php if ($formulario['estudios'] == 'Sin estudios') echo ' selected '; ?>>Sin estudios </option>
                            <option value="Educación primaria" <?php if ($formulario['estudios'] == 'Educación primaria') echo ' selected '; ?>>Educación primaria </option>
                            <option value="Educación secundaria" <?php if ($formulario['estudios'] == 'Educación secundaria') echo ' selected '; ?>>Educación secundaria </option>
                            <option value="Bachillerato" <?php if ($formulario['estudios'] == 'Bachillerato') echo ' selected '; ?>>Bachillerato </option>
                            <option value="Grado medio" <?php if ($formulario['estudios'] == 'Grado medio') echo ' selected '; ?>>Grado medio </option>
                            <option value="Grado superior" <?php if ($formulario['estudios'] == 'Grado superior') echo ' selected '; ?>>Grado superior </option>
                            <option value="Grado universitario" <?php if ($formulario['estudios'] == 'Grado universitario') echo ' selected '; ?>>Grado universitario </option>
                        </select>
                        <br>
                        <label for="sitlaboral">Situación laboral: </label>
                        <select class="celda" value="000" name="sitlaboral" size=1 required>
                            <option value="No es relevante" <?php if ($formulario['sitlaboral'] == 'No es relevante') echo ' selected '; ?>>No es relevante </option>
                            <option value="En paro" <?php if ($formulario['sitlaboral'] == 'En paro') echo ' selected '; ?>>Desempleado </option>
                            <option value="Trabajando" <?php if ($formulario['sitlaboral'] == 'Trabajando') echo ' selected '; ?>>Trabajando </option>
                        </select>
                        <br>

                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $formulario['ingresos']; ?>" required /><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($formulario['minusvalia'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($formulario['minusvalia'] == 'No') echo ' checked '; ?>>No<br>

                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio" id="solicitar" name="solicitante" onclick="showHide(this)" onchange="return validateDate();" value="Sí" <?php if ($formulario['solicitante'] == 'Sí') echo ' checked '; ?>> Sí
                        <input type="radio" id="familiar" name="solicitante" onclick="showHide(this)" value="No" <?php if ($formulario['solicitante'] == 'No') echo ' checked '; ?>> No<br>

                    </fieldset>
                    <?php
                    if ($formulario['solicitante'] == 'Sí') {
                        echo '<div id="esSolicitante">';
                    } else {
                        echo '<div id="esSolicitante" class="hide">';
                    }
                    ?>
                    <br>
                    <fieldset>
                        <legend>Información básica del solicitante</legend>

                        <label for="gastosfamilia">Gastos de la familia:</label>
                        <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php echo $formulario['gastosfamilia']; ?>" /><br>

                        <label for="poblacion">Población:</label>
                        <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php echo $formulario['poblacion']; ?>" /><br>

                        <label for="domicilio">Dirección del domicilio:</label>
                        <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php echo $formulario['domicilio']; ?>" /><br>

                        <label for="codigopostal">Código postal:</label>
                        <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php echo $formulario['codigopostal']; ?>" /><br>

                        <label for="proteccionDatos">
                            <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($formulario['proteccionDatos'] == 'Sí') echo ' checked '; ?>>De acuerdo con la Ley de Protección de Datos
                        </label>
                    </fieldset>
            </div>

            <?php
            if ($formulario['solicitante'] == 'No') {
                echo '<div id="esFamiliar">';
            } else {
                echo '<div id="esFamiliar" class="hide">';
            }
            ?>
            <br>
            <fieldset>
                <legend>Información básica del familiar</legend>

                <label for="dniSol">DNI del solicitante:</label>
                <input class="celda" name="dniSol" placeholder="12345678X" type="text" maxlength="9" value="<?php echo $formulario['dniSol']; ?>" /><br>

                <label for='parentesco'>Parentesco con el solicitante:</label>
                <input name='parentesco' type='text' value="<?php echo $formulario['parentesco']; ?>" /><br>
            </fieldset>
        </div>

        <div class="botones">
            <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_usuario.php'">Cancelar</a>
            <input type="submit" value="Dar de alta">
        </div>
        </form>
    </div>
    </div>
    </div>
    <script type="text/javascript">
        var frmvalidator = new Validator("altaUsuario");
        var solicitante = document.forms["altaUsuario"]["solicitante"].value;
        var poblacion = document.forms["altaUsuario"]["poblacion"].value;
        var sitlaboral = document.forms["altaUsuario"]["sitlaboral"].value;

        frmvalidator.EnableMsgsTogether();

        frmvalidator.addValidation("nombre", "req", "Introduzca el nombre.");
        frmvalidator.addValidation("nombre", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "El nombre solo puede contener caracteres alfabéticos.");

        frmvalidator.addValidation("apellidos", "req", "Introduzca los apellidos");
        frmvalidator.addValidation("apellidos", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "Los apellidos solo pueden contener caracteres alfabéticos");

        frmvalidator.addValidation("dni", "req", "Introduzca el DNI");
        frmvalidator.addValidation("dni", "regexp=^[0-9]{8}[A-Z]$", "Introduzca un DNI en el siguiente formato: 12345678A");

        frmvalidator.addValidation("fechaNac", "req", "Introduzca la fecha de nacimiento.");

        frmvalidator.addValidation("genero", "selone_radio", "Introduzca el género.");

        frmvalidator.addValidation("email", "req", "Introduzca el email.");
        frmvalidator.addValidation("email", "email", "Introduca un email válido.");

        frmvalidator.addValidation("telefono", "regexp=^[0-9]{9}$", "Introduzca un número de teléfono válido.");

        frmvalidator.addValidation("estudios", "dontselect=000", "Introduzca el nivel de estudios.");

        frmvalidator.addValidation("sitlaboral", "dontselect=000", "Introduzca la situación laboral del usuario.");

        frmvalidator.addValidation("ingresos", "req", "Introduzca los ingresos.");
        frmvalidator.addValidation("ingresos", "num", "Introduzca los ingresos con caracteres numéricos");
        frmvalidator.addValidation("ingresos", "lt=1000", "Los ingresos no deben de superar los 1000€.");
        frmvalidator.addValidation("ingresos", "lt=673", "Los ingresos son mayores de lo estimado por estar desempleado.",
            "VWZ_IsListItemSelected(document.forms['altaUsuario'].elements['sitlaboral'],'En paro')");
        frmvalidator.addValidation("ingresos", "gt=0", "Los ingresos son menores de lo estimado por tener alguna discapacidad.",
            "VWZ_IsChecked(document.forms['altaUsuario'].elements['minusvalia'],'Sí')");

        frmvalidator.addValidation("minusvalia", "selone_radio", "Introduzca si tiene alguna discapacidad.");

        frmvalidator.addValidation("solicitante", "selone_radio", "Introduzca si el usuario es solicitante.");

        console.log("A ver: " + solicitante);
        if (solicitante == "Sí" || solicitanteSiNo == "Sí") {
            frmvalidator.addValidation("gastosfamilia", "req", "Introduzca los gastos de la familia.");
            frmvalidator.addValidation("gastosfamilia", "num", "Introduzca los gastos familiares con caracteres numéricos.");

            frmvalidator.addValidation("poblacion", "req", "Introduzca la población.");
            frmvalidator.addValidation("poblacion", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "La población debe contener únicamente letras y espacios.");

            frmvalidator.addValidation("domicilio", "req", "Introduzca el domicilio.");

            frmvalidator.addValidation("codigopostal", "req", "Introduzca el código postal.");
            frmvalidator.addValidation("codigopostal", "regexp=^[0-9]{5}$", "Introduzca un código postal válido.");

            frmvalidator.addValidation("proteccionDatos", "shouldselchk=on", "El solicitante debe aceptar la Ley de Protección de Datos.");

        } else if (solicitante == "No" || solicitanteSiNo == "No") {
            frmvalidator.addValidation("dniSol", "req", "Introduzca el DNI del solicitante.");
            frmvalidator.addValidation("dniSol", "regexp=^[0-9]{8}[A-Z]$", "Introduzca el DNI del solicitante en el siguiente formato: 12345678A");

            frmvalidator.addValidation("parentesco", "req", "Introduzca el parentesco con el solicitante.");
            frmvalidator.addValidation("parentesco", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "El parentesco debe contener únicamente letras y espacios.");
        }
    </script>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>