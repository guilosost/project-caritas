<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

if (!empty($referer) and $referer == "http://localhost:81/project-caritas/vista/listas/lista_cita.php") {
    $cita["dni"] = $_REQUEST["DNI"];
    $cita["nombrev"] = $_REQUEST["NOMBREV"];
    $cita["fechacita"] = $_REQUEST["FECHACITA"];
    $cita["objetivo"] = $_REQUEST["OBJETIVO"];
    $cita["observaciones"] = $_REQUEST["OBSERVACIONES"];
    $cita["oid_c"] = $_REQUEST["oid_c"];
    $_SESSION["cita"] = $cita;
} else {
    Header("Location:../../vista/listas/lista_cita.php");
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
    <title>Información de la Cita</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <!-- <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script> -->
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");
    ?>

    <div class="flex">
        <div class="form">
            <h2 class="form-h2">Información de la cita</h2>
            <div class="form-alta">
                <form action="../../controlador/eliminaciones/elimina_cita.php" method="POST">
                <fieldset>
                        <legend>Información básica de la cita</legend>
                    <label for="dni">DNI del solicitante: </label>
                    <input class="celda" name="dni" type="text" maxlength="10" value="<?php echo $cita["dni"] ?>" readonly />
                    <br>
                    <label for="nombrev" required>Nombre del voluntario:</label>
                    <input class="celda" name="nombrev" type="text" maxlength="40" value="<?php echo $cita['nombrev']; ?>" readonly />
                    <br>
                    <label for="fechacita" required>Fecha de la cita:</label>
                    <input name="fechacita" type="text" value="<?php echo $cita['fechacita']; ?>" required readonly/>
                    <br>
                    <label for="objetivo" required>Objetivo de la cita:</label>
                    <input class="celda" name="objetivo" type="text" maxlength="40" value="<?php echo $cita['objetivo']; ?>" readonly />
                    <br>
                    <label for="observaciones">Observaciones:</label><br>
                    <textarea class="fillable" name="observaciones" maxlength="590" readonly><?php echo $cita['observaciones'];?></textarea>
                    </fieldset>
                    <input style="float:left" type="submit" value="Eliminar">
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_cita.php'">Cancelar</a>
                        <input type="button" onclick="location.href='../../controlador/ediciones/editar_cita.php'" value="Editar" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>