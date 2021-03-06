<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}
unset($_SESSION["cita"]);
unset($_SESSION["cita-eliminar"]);
unset($_SESSION["cita-editar"]);

if (!isset($_SESSION["formulario_cita"])) {
    $formulario['fechacita'] = "";
    $formulario['objetivo'] = "";
    $formulario['nombrev'] = "";
    $formulario['observaciones'] = "";
    $formulario['dni'] = "";
    $_SESSION["formulario_cita"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_cita"];
}
// Reseteamos los errores de $_SESSION
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de Cita</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <script type="text/javascript" src="../../vista/js/validacion_cita.js"></script>
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");

    date_default_timezone_set('UTC');
    $date = date('Y-m-d', time());

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
            <h2 class="form-h2">Alta de cita</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_cita.php" id="altaCita" method="POST">
                    <fieldset>
                        <legend>Información básica de la cita</legend>
                        <label for="dni" required>DNI del solicitante:</label>
                        <input class="celda" placeholder="12345678X" name="dni" type="text" required /><br>

                        <label for="nombrev">Nombre del voluntario: </label>
                        <input class="celda" name="nombrev" type="text" value="<?php echo $_SESSION['nombreusuario'] ?>" required /><br>

                        <label for="fechacita" required>Fecha de la cita:</label>
                        <input class="celda" name="fechacita" type="date" value="<?php echo $date; ?>" required /><br>

                        <label for="objetivo">Objetivo de la cita:</label>
                        <input class="celda" name="objetivo" type="text" value="<?php echo $formulario['objetivo']; ?>" required /><br>

                        <label for="observaciones">Observaciones:</label><br>
                        <textarea class="fillable" name="observaciones" maxlength="590" required ><?php echo $formulario['observaciones']; ?></textarea>
                    </fieldset>
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_cita.php'">Cancelar</a>
                        <input type="submit" value="Confirmar cita">
                    </div>
                </form>
            </div>
        </div>
    </div>
     <script type="text/javascript">
        var frmvalidator = new Validator("altaCita");
        frmvalidator.EnableMsgsTogether();

        frmvalidator.addValidation("dni", "req", "Introduzca el DNI.");
        frmvalidator.addValidation("dni", "regexp=^[0-9]{8}[A-Z]$", "Introduzca un DNI en el siguiente formato: 12345678A");
        
        frmvalidator.addValidation("nombrev", "req", "Introduzca el nombre.");
        frmvalidator.addValidation("nombrev", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú]*$", "El nombre solo puede contener caracteres alfabéticos.");

        frmvalidator.addValidation("objetivo", "req", "Introduzca el objetivo de la cita.");
        frmvalidator.addValidation("objetivo", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "El objetivo solo puede contener caracteres alfabéticos y espacios.");

        frmvalidator.addValidation("observaciones", "req", "Introduzca alguna observación.");
        frmvalidator.addValidation("observaciones", "regexp=^[a-zA-Z ÑñáÁÉÍÓÚéíóú\\s]*$", "Las observaciones solo pueden contener caracteres alfabéticos y espacios.");
     </script> 
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>