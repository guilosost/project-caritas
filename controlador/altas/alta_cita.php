<?php
session_start();
require_once("/../../modelo/gestionBD.php");

if (!isset($_SESSION["formulario"])) {
    $formulario['fechacita'] = "";
    $formulario['objetivo'] = "";
    $formulario['nombrev'] = "";
    $formulario['observaciones'] = "";
    $formulario['dni'] = "";
    $_SESSION["formulario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario"];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de Cita</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");

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

    <div class="form">
        <h2 class="form-h2">Alta de cita</h2>
        <div class="form-alta">
            <form action="accion_cita.php" method="POST">
                <label for="dni" required>DNI del solicitante:</label>
                <input class="celda" name="dni" type="text" required />

                <--! AQUI LA FECHACITA QUE SALGA DEBERÍA SER LA ACTUAL -->
                    <label for="fechacita" required>FechaCita:</label>
                    <input name="fechacita" type="date" required /><br>

                    <label for="objetivo">Objetivo de la cita:</label>
                    <input class="celda" name="objetivo" type="text" required />

                    <label for="email">Ingresos:</label>
                    <input class="celda" name="email" type="text" required /><br>

                    <label for="observaciones">Observaciones:</label>
                    <input class="celda" name="observaciones" type="text" rows="10" cols="30" required /><br>

                    <label for="nombrev">Nombre del voluntario: </label>
                    <input class="celda" name="observaciones" type="text" value=<?php echo "$_SESSION[usuario]" ?>required /><br>

                    <a class="confirm" type="submit">Dar de alta</a>
                    <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancel</a>

            </form>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html> 