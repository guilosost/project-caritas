<?php
session_start();
if (isset($_SESSION["nombreusuario"])) {
    unset($_SESSION["nombreusuario"]);
}
if (!isset($_SESSION["formulario_login"])) {
    $formulario["nombrelogin"] = "";
    $formulario["contrasena"] = "";
    $_SESSION["formulario_login"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_login"];
}

if (isset($_SESSION["errores"])) {
    $errores = $_SESSION["errores"];
    unset($_SESSION["errores"]);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proyecto Cáritas</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />

</head>

<body background="../../vista/img/background.png">

    <?php
    include("../../vista/header.php");

    ?>
    <div class="flex">
    <?php
        //Mostramos los errores del formulario enviado previamente
        if (isset($errores) && count($errores) > 0) {
           // echo "<script> error(); </script>";
            echo "<div class='error' style='margin-top: 5%;'>";
            echo "<h4> Errores en el formulario:</h4>";
            foreach ($errores as $error) {
                echo $error;
            }
            echo "</div>";
        }
        ?>
        <div class="form" style="text-align:center; margin-top: 5%">
            <h2 class="form-h2">Iniciar sesión</h2>

            <form action="../../controlador/acciones/accion_login.php" method="POST">
            <fieldset>
                <div style="margin-top: 2%;">
                    <p class="form-text">Usuario:<p>
                            <input type="text" name="nombrelogin">
                </div>

                <div style="margin-bottom: -2%;">
                    <p class="form-text">Contraseña:<p>
                            <input type="password" name="contrasena" minlength="6">
                </div>
            </fieldset>
            <br>
                <input type="submit" class="login" value="Iniciar sesión">
                <br>
            </form>
        </div>
    </div>


    <?php include("../../vista/footer.php") ?>

</body>

</html>