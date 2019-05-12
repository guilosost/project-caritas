<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

if (!empty($referer) and $referer == "http://localhost:81/project-caritas/vista/listas/lista_voluntario.php") {
    $voluntario["nombrev"] = $_REQUEST["NOMBREV"];
    $voluntario["contrasena"] = $_REQUEST["CONTRASENA"];
    $voluntario["permiso"] = $_REQUEST["PERMISO"];
    $_SESSION["voluntario"] = $voluntario;
} else {
    Header("Location:../../vista/listas/lista_voluntario.php");
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
    <title>Información del voluntario</title>
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
                <form action="../../controlador/eliminaciones/elimina_voluntario.php" method="POST" >
                        <label for="nombrev">Nombre del voluntario: </label>
                        <input class="celda" name="nombrev" type="text" maxlength="30" value="<?php echo $voluntario["nombrev"]?> "
                           readonly/><br>
                        </select>
                        <br>

                        <label for="permiso" required>Permiso del voluntario:</label>
                        <input class="celda" name="permiso" type="text" maxlength="40" value="<?php echo $voluntario['permiso']; ?>" readonly/><br>
                        <br>

                    <input style="float:left" type="submit" value="Eliminar" >
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_voluntario.php'">Cancelar</a>
                        <input type="button" onclick="location.href='../../controlador/ediciones/editar_voluntario.php'" value="Editar" />
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