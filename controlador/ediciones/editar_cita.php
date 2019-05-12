<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["cita"])) {
    $cita = $_SESSION["cita"];
} else {
    Header("Location:../../vista/listas/lista_cita.php");
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
            <h2 class="form-h2">Información de la ayuda</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_cita.php" method="POST" id=altaCita name=altaCita>
                    <fieldset>
                        <legend>Información básica de la ayuda</legend>
                        <label for="dni">DNI del solicitante: </label>
                        <input class="celda" name="dni" type="text" maxlength="10" value="<?php echo $cita["dni"]?>"
                           /><br>
                        </select>
                        <br>

                        <label for="nombrev" required>Nombre del voluntario:</label>
                        <input class="celda" name="nombrev" type="text" maxlength="40" value="<?php echo $cita['nombrev']; ?>" /><br>

                        <label for="objetivo" required>Objetivo de la cita:</label>
                        <input class="celda" name="objetivo" type="text" maxlength="40" value="<?php echo $cita['objetivo']; ?>" /><br>
                        <br>
                        <label for="fechacita" required>Fecha de la cita:</label>
                        <input class="celda" name="fechacita" type="text" value="<?php echo $cita['fechacita']; ?>" /><br>

                    <input style="float:left" type="submit" value="Eliminar" >
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_cita.php'">Cancelar</a>
                        <input  type="submit" value="Editar" >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--<script type="text/javascript">
        var frmvalidator = new Validator("altaAyuda");

        frmvalidator.EnableMsgsTogether();
        var tipo = document.forms["altaAyuda"]["tipoayuda"].value;
        
        frmvalidator.addValidation("tipoayuda", "req", "Introduzca el tipo de ayuda");

        frmvalidator.addValidation("suministradapor", "req", "Introduzca el proveedor de la ayuda");
        //frmvalidator.addValidation("suministradapor", "alphabetic_space", "el proveedor de la ayuda debe de constar de letras y espacios");

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
    </script> -->
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>