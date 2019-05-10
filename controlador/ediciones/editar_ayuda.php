<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["ayuda"])) {
    $ayuda = $_SESSION["ayuda"];
} else {
    Header("Location:../../vista/listas/lista_ayuda.php");
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
    <!-- <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script> -->
    <script>
        <!--
        function showHide(elm) {
            var comida = document.getElementById("comida");
            var economica = document.getElementById("economica");
            var curso = document.getElementById("curso");
            var trabajo = document.getElementById("trabajo");

            if (elm.value == 'bolsacomida') {
                comida.classList.remove('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'ayudaeconomica') {
                comida.classList.add('hide');
                economica.classList.remove('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'curso') {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.remove('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'trabajo') {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.remove('hide');
            } else {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            }

        }
        //-->
    </script>
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");

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
            <h2 class="form-h2">Alta de ayuda</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_ayuda.php" method="POST">
                    <fieldset>
                        <legend>Información básica de la ayuda</legend>

                        <label for="tipoayuda">Selección del tipo de ayuda: </label>
                        <select class="celda" id="tipoayuda" onchange="showHide(this)" name="tipoayuda" size=1 required>
                            <option value="">Seleccionar...</option>
                            <option value="bolsacomida">Bolsa de comida </option>
                            <option value="ayudaeconomica">Ayuda económica </option>
                            <option value="curso">Curso formativo </option>
                            <option value="trabajo">Propuesta de trabajo </option>
                        </select>
                        <br>
                        <label for="suministradapor" required>Suministrada por:</label>
                        <select class="celda" name="suministradapor" size=1 required>
                            <option value="">Seleccionar...</option>
                            <option value="Cáritas San Juan de Aznalfarache">Cáritas San Juan de Aznalfarache </option>
                            <option value="Diocesana Sevilla">Diocesana Sevilla </option>
                            <option value="Otro">Otro </option>
                        </select>
                        <br>
                        <label for="concedida" required>¿Está la ayuda concedida?:</label>
                        <input type="radio" name="concedida" value="Sí">Sí
                        <input type="radio" name="concedida" value="No">No<br>

                    </fieldset>

                    <div id="comida" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información de la bolsa de comida</legend>

                            <label for="bebe">¿Debe contener productos para bebé?:</label>
                            <input type="radio" name="bebe" value="Sí">Sí
                            <input type="radio" name="bebe" value="No">No<br>

                            <label for="niño">¿Debe contener productos para niños?:</label>
                            <input type="radio" name="niño" value="Sí">Sí
                            <input type="radio" name="niño" value="No">No<br>
                        </fieldset>
                    </div>

                    <div id="economica" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información de la ayuda económica</legend>
                            <label for="cantidad">Cantidad (€): </label>
                            <input class="celda" name="cantidad" type="text" /><br>

                            <label for="motivo">Motivo:</label>
                            <input class="celda" name="motivo" type="text" /><br>

                            <label for="prioridad">¿Esta ayuda tiene prioridad?:</label>
                            <input type="radio" name="prioridad" value="Sí">Sí
                            <input type="radio" name="prioridad" value="No">No<br>
                        </fieldset>
                    </div>

                    <div id="curso" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información del curso</legend>
                            <label for="profesor">Profesor: </label>
                            <input class="celda" name="profesor" type="text" maxlength="50" /><br>

                            <label for="materia">Materia del curso: </label>
                            <input class="celda" name="materia" type="text" maxlength="50" /><br>
                            </select>

                            <label for="fechacomienzo">Fecha comienzo:</label>
                            <input name="fechacomienzo" type="date" value="<?php $formulario['fechacomienzo'] ?>" /><br>

                            <label for="fechafin">Fecha final:</label>
                            <input name="fechafin" type="date" value="<?php $formulario['fechafin'] ?>" /><br>

                            <label for="numerosesiones">Número de sesiones: </label>
                            <input name="numerosesiones" type="number" value="<?php $formulario['numerosesiones'] ?>" /><br>

                            <label for="numeroalumnosmaximo">Número de alumnos: </label>
                            <input name="numeroalumnosmaximo" type="number" value="<?php $formulario['numeroalumnosmaximo'] ?>" /><br>
                        </fieldset>
                    </div>

                    <div id="trabajo" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información del trabajo</legend>

                            <label for="descripcion">Descripción: </label>
                            <textarea class="fillable" name="descripcion" maxlength="50"></textarea><br>

                            <label for="empresa">Empresa/persona que contrata:</label>
                            <input class="celda" name="empresa" type="text" maxlength="30" /><br>

                            <label for="salarioaproximado">Salario aproximado:</label>
                            <input class="celda" name="salarioaproximado" type="text" maxlength="50" /><br>

                            </label>
                        </fieldset>
                    </div>

                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_ayuda.php'">Cancelar</a>
                        <input type="submit" value="Confirmar">
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
            frmvalidator.addValidation("parentesco", "alpha", "El nombre debe de constar de letras");
        }
    </script>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>