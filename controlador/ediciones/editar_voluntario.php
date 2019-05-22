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
    <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
    <script type = "text/javascript" src = "../../vista/js/validacion_voluntario.js" ></script>
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
                        <input class="celda"  id="pass" name="password" type="password" maxlength="40" value="<?php echo $voluntario['contraseña']; ?>" oninput="passwordValidation();"/><br>
                        <progress max="100" value ="0" id="strength" style=""></progress>
                        
                        <label for="password2" required>Repita la contraseña:</label>
                        <input id="confirmpass" name="password2" type="password" maxlength="50" value="<?php echo $voluntario['contraseña']; ?>" oninput="passwordConfirmation();" required /><br>

                        <label for="permiso" required>Permiso del voluntario:</label>
                        <input type="radio" name="permiso" value="Sí"<?php if ($voluntario['permiso'] == "Sí") echo "checked"?>> Administrador
                        <input type="radio" name="permiso" value="No"<?php if ($voluntario['permiso'] == "No ") echo "checked"?>> Voluntario estándar<br>

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
    <script type="text/javascript">
        var pass = document.getElementById("pass")
        pass.addEventListener('keyup', function(){
            checkPassword(pass.value);
        })

        function checkPassword(password){
            var strengthBar = document.getElementById("strength");
            var strength = 0;
            
            if(password.match(/[0-9]/)){
                strength +=1;
            }
            if(password.match(/^[A-Z Ñ]/)){
                strength +=1;
            }
            if(password.length > 8){
                strength +=1;
            }
            switch(strength){
                case 0:
                    strengthBar.value = 10;
                    break;
                case 1:
                    strengthBar.value = 40;
                    break;
                case 2:
                    strengthBar.value = 70;
                    break;
                case 3:
                    strengthBar.value = 100;
                    break;
            }
        }
    </script>
</body>

</html>