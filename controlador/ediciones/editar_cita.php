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
    <title>Editar Cita</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <!-- <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script> -->
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");

    list($dia, $mes, $anyo) = split("/", $cita['fechacita']);
    $fechaDef = "$anyo-$mes-$dia";
    ?>

    <div class="flex">
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
            <h2 class="form-h2">Editando cita</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_cita.php" method="POST" id=altaCita name=altaCita>
                    <fieldset>
                        <legend>Información básica de la cita</legend>
                        <label for="dni">DNI del solicitante: </label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" maxlength="10" value="<?php echo $cita["dni"] ?>" />
                        <br>
                        <label for="nombrev" required>Nombre del voluntario:</label>
                        <input class="celda" name="nombrev" type="text" maxlength="40" value="<?php echo $cita['nombrev']; ?>" />
                        <br>
                        <label for="fechacita" required>Fecha de la cita:</label>
                        <input name="fechacita" type="date" value="<?php echo $fechaDef; ?>" required />
                        <br>
                        <label for="objetivo" required>Objetivo de la cita:</label>
                        <input class="celda" name="objetivo" type="text" style="margin-top: 1%;" maxlength="40" value="<?php echo $cita['objetivo']; ?>" />
                        <br>
                        <label for="observaciones" required>Observaciones:</label><br>
                        <textarea class="fillable" name="observaciones" maxlength="590" required ><?php echo $cita['observaciones'];?></textarea>
                    </fieldset>
                    <input style="float:left" type="submit" value="Eliminar">
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_cita.php'">Cancelar</a>
                        <input type="submit" value="Editar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var frmvalidator = new Validator("altaCita");
        var solicitante = document.forms["altaUsuario"]["solicitante"].value;
        var poblacion = document.forms["altaUsuario"]["poblacion"].value;

        frmvalidator.EnableMsgsTogether();

        frmvalidator.addValidation("dni", "req", "Introduzca el DNI.");
        frmvalidator.addValidation("dni", "regexp=^[0-9]{8}[A-Z]$", "Introduzca un DNI de la forma 12345678A.");

        frmvalidator.addValidation("nombrev", "req", "Introduzca el nombre");
        frmvalidator.addValidation("nombrev", "regexp=^[a-zA-Z Ññáéíóú\\s]", "El nombre debe de constar de letras");

        frmvalidator.addValidation("objetivo", "req", "Introduzca el objetivo de la cita");
        frmvalidator.addValidation("objetivo", "regexp=^[a-zA-Z Ññáéíóú\\s]", "El objetivo debe de constar de letras y espacios");

        /* frmvalidator.addValidation("observaciones", "req", "Introduzca alguna observacion");
        frmvalidator.addValidation("observaciones", "regexp=^[a-zA-Z Ññáéíóú\\s]", "Las observaciones deben de constar de letras y espacios"); */
    </script> 
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>