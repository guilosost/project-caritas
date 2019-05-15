<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (!isset($_SESSION["formulario_ayuda"])) {
    $formulario['tipoayuda'] = "";
    $formulario['suministradapor'] = "";
    $formulario['concedida'] = "";
    $formulario['bebe'] = "";
    $formulario['niño'] = "";
    $formulario['cantidad'] = "";
    $formulario['motivo'] = "";
    $formulario['prioridad'] = "";
    $formulario['descripcion'] = "";
    $formulario['empresa'] = "";
    $formulario['salarioaproximado'] = "";
    $_SESSION["formulario_ayuda"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_ayuda"];
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
    <title>Alta de Ayuda</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type = "text/javascript" src = "../../vista/js/jquery_form.js" ></script>
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
    <script>
        <!--
        function showHide(elm) {
            var comida = document.getElementById("comida");
            var economica = document.getElementById("economica");
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
                <form action="../../controlador/acciones/accion_ayuda.php" method="POST" id=altaAyuda name=altaAyuda>
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
        var frmvalidator = new Validator("altaAyuda");

        frmvalidator.EnableMsgsTogether();
        var tipo = document.forms["altaAyuda"]["tipoayuda"].value;
        
        frmvalidator.addValidation("tipoayuda", "req", "Introduzca el tipo de ayuda");

        frmvalidator.addValidation("suministradapor", "req", "Introduzca el proveedor de la ayuda");
        frmvalidator.addValidation("suministradapor","regexp=^[a-zA-Z Ññáéíóú\\s]","El nombre del proveedor de la ayuda debe contener letras y espacios");

        frmvalidator.addValidation("concedida", "selone_radio", "Introduzca si la ayuda está concedida");

        if (tipo == "bolsacomida") {
        frmvalidator.addValidation("bebe", "selone_radio", "Introduzca si el solicitante tiene a un bebé");

        frmvalidator.addValidation("nino", "selone_radio", "Introduzca si el solicitante tiene niños");

        }else if (tipo == "ayudaeconomica"){
        frmvalidator.addValidation("cantidad", "req", "Introduzca la cantidad");
        frmvalidator.addValidation("cantidad", "num", "La cantidad debe de ser numérica");

        frmvalidator.addValidation("prioridad", "selone_radio", "Introduzca si posee prioridad");

        frmvalidator.addValidation("motivo", "req", "Introduzca el motivo de la ayuda");
        frmvalidator.addValidation("motivo", "alphabetic_space", "Introduzca el motivo de la ayuda");

        }else if (tipo == "trabajo"){
        frmvalidator.addValidation("salarioaproximado", "req", "Introduzca un salario");
        frmvalidator.addValidation("salarioaproximado", "num", "Introduzca un número como salario");

        frmvalidator.addValidation("descripcion", "req", "Introduzca la descripción del trabajo");
        frmvalidator.addValidation("descripcion", "alphabetic_space", "Introduzca la descripción del trabajo");

        frmvalidator.addValidation("empresa", "req", "Introduzca la empresa");
        frmvalidator.addValidation("empresa", "alphabetic_space", "Introduzca la empresa");

        }
    </script> 
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>