<?php
session_start();
//include(dirname(__DIR__).'/GestionBD.php');
require_once("../../modelo/GestionBD.php");

if (!isset($_SESSION["formulario"])) {
    $formulario['nombre'] = "";
    $formulario['password'] = "";
    $formulario['permisos'] = "";
  
    $_SESSION["formulario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario"];
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de Voluntario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
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

    <div class="form">
        <h2 class="form-h2">Alta de Voluntario</h2>
        <div class="form-alta">
            <form action="../../controlador/acciones/accion_voluntario.php" method="POST">
                <fieldset>
                    <legend>Información básica del Voluntario</legend>

                    <label for="nombre" required>Nombre:</label>
                    <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $formulario['nombre']; ?>" required />

                    <label for="password" required>password:</label>
                    <input name="password" type="text" maxlength="50" value="<?php echo $formulario['password']; ?>" required /><br>

                    <label for="permisos">permisos:</label>
                    <input class="celda" name="permisos"   value="<?php echo $formulario['password']; ?>" required /><br>
                    <select>

                  
                        <option value="Administrador">Voluntario es admin del sistema </option>
                        <option value="Voluntario">Permisos de voluntario </option>
                        
                    </select>
                    <br>
                    

                </fieldset>
                <br>

            </form>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html> 