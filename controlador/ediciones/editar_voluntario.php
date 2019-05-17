<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["voluntario"])) {
    $voluntario = $_SESSION["voluntario"];
} else {
    Header("Location:../../vista/listas/lista_voluntario.php");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Voluntario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <!-- <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script> -->
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
    <script type = "text/javascript" src = "../../vista/js/validacion_voluntario.js" ></script>
</head>

<body background="../../vista/img/background.png">
<script>
        
    		$(document).ready(function() {
			$("#altaVoluntario").on("submit", function() {
				return validateForm();
            });
            $("#pass").on("keyup", function() {
				// Calculo el color
				passwordColor();
			});
        });
</script>
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
            <h2 class="form-h2">Editando voluntario</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_voluntario.php" method="POST" id=altaVoluntario name=altaVoluntario>
                    <fieldset>
                        <legend>Información básica del voluntario</legend>

                        <label for="nombrev" >Nombre del voluntario:</label>
                        <input class="celda" name="nombrev" type="text" maxlength="40" value="<?php echo $voluntario['nombrev']; ?>"  readonly /><br>

                        <label for="contraseña" required>Contraseña del voluntario:</label>
                        <input class="celda"  id="pass" name="contraseña" type="contraseña" maxlength="40" value="<?php echo $voluntario['contraseña']; ?>" oninput="passwordValidation();"/><br>
                        
                        <label for="password2" required>Repita la contraseña:</label>
                        <input id="confirmpass" name="password2" type="password" maxlength="50" value="<?php echo $voluntario['contraseña']; ?>" oninput="passwordConfirmation();" required /><br>

                        <label for="permiso" required>Permiso del voluntario:</label>
                        <input type="radio" name="permiso" value="Sí"<?php if ($voluntario['permiso']=="Sí") echo "checked"?>> Administrador
                        <input type="radio" name="permiso" value="No"<?php if ($voluntario['permiso']=="No ") echo "cheked"?>> Voluntario estándar<br>

                    </fieldset>

                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_voluntario.php'">Cancelar</a>
                        <input  type="submit" value="Editar" >
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