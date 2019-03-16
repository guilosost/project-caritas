<?php
session_start();

if (isset($_SESSION["usuario"])){
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="header-footer.css">
    <link rel="stylesheet" type="text/css" href="button.css">
    <link rel="stylesheet" type="text/css" href="form.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proyecto Cáritas</title>
    <link rel="shortcut icon" type="image/png" href="../img/favicon.png" />

</head>

<body background="../img/background.png">
    <?php include("header.php") ?>

<?php 
    if ($_POST){
        
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $conexion = crearConexionBD();
    }
    ?>
    <div class="form">
        <h2 class="form-h2">Iniciar sesión</h2>

        <form action="/action_page.php">
            <div>
                <p class="form-text">Usuario:<p>
                        <input type="text" name="usuario">
            </div>

            <div>
                <p class="form-text">Contraseña:<p>
                        <input type="password" name="contrasena">
            </div>
            <a class="button" type="submit">Iniciar sesión</a>
        </form>
    </div>

    
    <?php include("footer.php") ?>

</body>

</html> 