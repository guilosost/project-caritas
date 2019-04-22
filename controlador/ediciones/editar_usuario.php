<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
} else {
    Header("Location:../../vista/listas/lista_usuario.php");
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
    <title>Editar Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type = "text/javascript" src = "../../vista/js/jquery_form.js" ></script>
<!--    <script type = "text/javascript" src = "../../vista/js/validacion_usuario.js" ></script> -->
<script>
        
        function showHide(elm) {
            var solicitante = document.getElementById("esSolicitante");
            var familiar = document.getElementById("esFamiliar");
            
            if (elm.id == 'solicitar') {
                solicitante.classList.remove('hide');
                familiar.classList.add('hide');
            } else if (elm.id == 'familiar'){
                solicitante.classList.add('hide');
                familiar.classList.remove('hide');
            }
        }
        </script>
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
            <h2 class="form-h2">Alta de usuario</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_usuario.php" id="altaUsuario" method="POST">
                    <fieldset>
                        <legend>Información básica del usuario</legend>

                        <label for="nombre" required>Nombre:</label>
                        <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $usuario['nombre']; ?>" required />

                        <label for="apellidos" required>Apellidos:</label>
                        <input name="apellidos" type="text" maxlength="50" value="<?php echo $usuario['apellidos']; ?>" required /><br>

                        <label for="dni">DNI:</label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php echo $usuario['dni']; ?>" required /><br>

                        <label for="fechaNac">Fecha de nacimiento:</label>
                        <input name="fechaNac" type="date" value="<?php echo $usuario['fechaNac']; ?>" required /><br>

                        <label for="genero">Género: </label>
                        <input type="radio" name="genero" value="Masculino" <?php if ($usuario['genero'] == 'Masculino') echo ' checked '; ?>> Hombre
                        <input type="radio" name="genero" value="Femenino" <?php if ($usuario['genero'] == 'Femenino') echo ' checked '; ?>> Mujer<br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $usuario['telefono']; ?>" required /><br>

                        <label for="estudios">Estudios: </label>
                        <select class="celda" name="estudios" size=1 required>
                            <option value="No es relevante">No es relevante </option>
                            <option value="Sin estudios">Sin estudios </option>
                            <option value="Educacion primaria">Educación primaria </option>
                            <option value="Educacion secundaria">Educación secundaria </option>
                            <option value="Bachillerato">Bachillerato </option>
                            <option value="Grado medio">Grado medio </option>
                            <option value="Grado superior">Grado superior </option>
                            <option value="Grado universitario">Grado universitario </option>
                        </select>
                        <br>
                        <label for="sitlaboral">Situación laboral: </label>
                        <select class="celda" name="sitlaboral" size=1 required>
                            <option value="No es relevante">No es relevante </option>
                            <option value="En paro">Desempleado </option>
                            <option value="Trabajando">Trabajando </option>
                        </select>
                        <br>

                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $usuario['ingresos']; ?>" required /><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($usuario['minusvalia'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($usuario['minusvalia'] == 'No ') echo ' checked '; ?>>No<br>

                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio" id="solicitar" name="solicitante"  onclick="showHide(this)" value="Sí" <?php if ($usuario['solicitante'] == 'Sí') echo ' checked '; ?>> Sí
                        <input type="radio" id="familiar" name="solicitante"  onclick="showHide(this)" value="No" <?php if ($usuario['solicitante'] == 'No ') echo ' checked '; ?>> No<br>

                    </fieldset>
                    
                    <div  id="esSolicitante" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información básica del solicitante</legend>

                            <label for="gastosfamilia">Gastos de la familia:</label>
                            <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['gastosfamilia']; ?>" /><br>

                            <label for="poblacion">Población:</label>
                            <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['poblacion']; ?>" /><br>

                            <label for="domicilio">Dirección del domicilio:</label>
                            <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['domicilio']; ?>" /><br>

                            <label for="codigopostal">Código postal:</label>
                            <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php if ($usuario["solicitante"] == "Sí") echo $usuario['codigopostal']; ?>" /><br>

                            <label for="proteccionDatos">
                                <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($usuario["solicitante"] == "Sí") echo ' checked '; ?>>De acuerdo con la Ley de Protección de Datos
                            </label>
                        </fieldset>
                    </div>
                   
                    <div id="esFamiliar"  class="hide" >
                        <br>
                        <fieldset>
                            <legend>Información básica del familiar</legend>

                            <label for="dniSol">DNI del solicitante:</label>
                            <input class="celda" name="dniSol" type="text" maxlength="9" value="<?php if($usuario["solicitante"] == "No ") echo $usuario['dni_so']; ?>" /><br>

                            <label for='parentesco'>Parentesco con el solicitante:</label>
                            <input name='parentesco' type='text' value="<?php if($usuario["solicitante"] == "No ") echo $usuario['parentesco']; ?>" /><br>
                        </fieldset>
                    </div>
                   
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancelar</a>
                        <input type="submit" value="Editar">
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