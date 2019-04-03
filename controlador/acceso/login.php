<?php
session_start();

if (!isset($_SESSION["formulario"])) {
    $formulario["nombrelogin"] = "";
    $formulario["contrasena"] = "";
    $_SESSION["formulario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario"];
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
    
    //BORRAR NAVBAR EN LA VERSION FINAL 
    include("../../vista/navbar.php");
    ?>


    <div class="form">
        <h2 class="form-h2">Iniciar sesión</h2>

        <form action="../../controlador/acciones/accion_login.php" method="POST">
            <div>
                <p class="form-text">Usuario:<p>
                        <input type="text" name="nombrelogin" value="<?php echo $_SESSION["nombrelogin"]; ?>">
            </div>

            <div>
                <p class="form-text">Contraseña:<p>
                        <input type="password" name="contrasena" minlength="6">
            </div>
            <input type="submit" class="login" value="Iniciar sesión">
            <br>
        </form>
    </div>


    <?php include("../../vista/footer.php") ?>

    </body> </html> 