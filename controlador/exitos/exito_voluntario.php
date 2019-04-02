<?php
session_start();

include("../../modelo/GestionBD.php");


if (isset($_SESSION["formulario"])) {
    $voluntario = $_SESSION["formulario"];
    unset($_SESSION["formulario"]);
} else {
    Header("Location: ../../controlador/altas/alta_voluntario.php");
}

$conexion  = crearConexionBD();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Alta de voluntario</title>
</head>

<body>
    <?php include("../../vista/header.php");


    if (alta_ayuda($conexion, $voluntario)) {
        ?>
    <p>Todo ha ido bien </p>
    <?php 
} else {
    echo "El voluntario ya existe.";
}
?>


    </main>
    <?php cerrarConexionBD($conexion); ?>
    <?php include("../../vista/footer.php");  ?>
</body>

</html> 