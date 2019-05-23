<?php
session_start();
require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (!isset($_SESSION["formulario_voluntario"])) {
    $formulario['nombrev'] = "";
    $formulario['password'] = "";
    $formulario['permisos'] = "";

    $_SESSION["formulario_voluntario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_voluntario"];
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <script type="text/javascript" src="../../vista/js/validacion_voluntario.js"></script>
</head>

<body background="../../vista/img/background.png">
    <script>
        $(document).ready(function() {
            $("#altaVoluntario").on("submit", function() {
                return validateForm();
            });
        });
    </script>
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");
    ?>

    <div class="flex">
        <?php
        //Mostramos los errores del formulario enviado previamente
        if (isset($errores) && count($errores) > 0) {
            // echo "<script> error(); </script>";
            echo "<div class='error'>";
            echo "<h4> Errores en el formulario:</h4>";
            foreach ($errores as $error) {
                echo $error;
            }
            echo "</div>";
        }
        ?>
        <div class="form">
            <h2 class="form-h2">Alta de voluntario</h2>
            <div class="form-alta">
                <form id="AltaVoluntario" action="../../controlador/acciones/accion_voluntario.php" method="POST">
                    <fieldset>
                        <legend>Información básica del Voluntario</legend>

                        <label for="nombrev" required>Nombre:</label>
                        <input class="celda" name="nombrev" type="text" maxlength="50" style="margin-right: 4%;" required />
                        <progress max="100" value="0" id="strength" onchange="progressValue(this)"></progress>
                        <br>
                        <label for="password" required>Contraseña:</label>
                        <input id="pass" name="password" type="password" style="width: 25%;" maxlength="40" oninput="passwordValidation();" required />

                        <label for="password2" required>Repita la contraseña:</label>
                        <input id="confirmpass" name="password2" type="password" style="width: 25%;" maxlength="40" oninput="passwordConfirmation();" required />
                        <br>
                        <label for="permisos">Permisos:</label>
                        <input type="radio" name="permisos" value="Sí"> Administrador
                        <input type="radio" name="permisos" value="No"> Voluntario estándar<br>
                    </fieldset>
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_voluntario.php'">Cancelar</a>
                        <input type="submit" value="Dar de alta">
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
<script type="text/javascript">
    var pass = document.getElementById("pass")
    pass.addEventListener('keyup', function() {
        checkPassword(pass.value);
    })

    function barColor(color) {
        // Create our stylesheet
        var style = document.createElement('style');
        style.innerHTML =
            'progress::-webkit-progress-value {' +
            'border-radius: 12px;' +
            'background: ' + color + ';' +
            'box-shadow: inset 0 -2px 4px rgba(0,0,0,0.4), 0 2px 5px 0px rgba(0,0,0,0.3);' +
            '}';

        // Get the first script tag
        var ref = document.querySelector('script');

        // Insert our new styles before the first script tag
        ref.parentNode.insertBefore(style, ref);
    }

    function checkPassword(password) {
        var strengthBar = document.getElementById("strength");
        var strength = 0;

        if (password.match(/[0-9]/)) {
            strength += 1;
        }
        if (password.match(/^[A-Z Ñ]/)) {
            strength += 1;
        }
        if (password.length > 8) {
            strength += 1;
        }
        switch (strength) {
            case 0:
                strengthBar.value = 10;
                barColor('red');
                break;
            case 1:
                strengthBar.value = 40;
                barColor('orange');
                break;
            case 2:
                strengthBar.value = 70;
                barColor('yellow');
                break;
            case 3:
                strengthBar.value = 100;
                barColor('green');
                break;
        }
    }
</script>

</html>