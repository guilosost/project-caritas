<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
require_once(MODELO."/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {   
    Header("Location: ../../controlador/acceso/login.php");
}

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
    <script type = "text/javascript" src = "../../vista/js/jquery_form.js" ></script>
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
            <h2 class="form-h2">Alta de cita</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_cita.php" method="POST">
                    <label for="dni" required>DNI del solicitante:</label>
                    <input class="celda" name="dni" type="text" required /><br>

                    <label for="nombrev">Nombre del voluntario: </label>
                    <input class="celda" name="nombrev" type="text" value="<?php echo $_SESSION['nombreusuario']?>" required /><br>

                    <label for="fechacita" required>Fecha de la cita:</label>
                    <input class="celda" name="fechacita" type="date" value="<?php date("d/m/Y") ?>" required /><br>

                    <label for="objetivo">Objetivo de la cita:</label>
                    <input class="celda" name="objetivo" type="text" value="<?php echo $formulario['objetivo']; ?>" required /><br>

                    <label for="observaciones">Observaciones:</label><br>
                    <textarea class="fillable" name="observaciones" value="<?php echo $formulario['observaciones']; ?>"></textarea>

                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_cita.php'">Cancelar</a>
                        <input type="submit" value="Confirmar cita">
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