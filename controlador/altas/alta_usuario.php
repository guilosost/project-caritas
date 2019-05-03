<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (!isset($_SESSION["formulario_usuario"])) {
    $formulario['nombre'] = "";
    $formulario['apellidos'] = "";
    $formulario['dni'] = "";
    $formulario['fechaNac'] = "";
    $formulario['email'] = "";
    $formulario['telefono'] = "";
    $formulario['genero'] = "";
    $formulario['minusvalia'] = "";
    $formulario['sitlaboral'] = "";
    $formulario['proteccionDatos'] = "";
    $formulario['solicitante'] = "";
    $formulario['parentesco'] = "";
    $formulario['ingresos'] = "";
    $formulario['estudios'] = "";
    $formulario['poblacion'] = "";
    $formulario['domicilio'] = "";
    $formulario['gastosfamilia'] = "";
    $formulario['codigopostal'] = "";
    $formulario['dniSol'] = "";
    $_SESSION["formulario_usuario"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_usuario"];
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
    <title>Alta de Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type = "text/javascript" src = "../../vista/js/jquery_form.js" ></script>
    <script type = "text/javascript" src = "../../vista/js/validacion_usuario.js" ></script> 

    <script>
        <!--
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
        <script>
//    	$(document).ready(function() {
//		$("#altaUsuario").on("submit", function() {
//            validarCalle();
//        });
//    });
    
        //-->
    </script>
     <script src="../../vista/js/gen_validatorv4.js" type="text/javascript"></script>
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
                <form action="../../controlador/acciones/accion_usuario.php" id="altaUsuario" method="POST" >
                    <fieldset>
                        <legend>Información básica del usuario</legend>

                        <label for="nombre" required>Nombre:</label>
                        <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $formulario['nombre']; ?>"  />

                        <label for="apellidos" required>Apellidos:</label>
                        <input name="apellidos" type="text" maxlength="50" value="<?php echo $formulario['apellidos']; ?>" required /><br>

                        <label for="dni">DNI:</label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php echo $formulario['dni']; ?>" required /><br>

                        <label for="fechaNac">Fecha de nacimiento:</label>
                        <input name="fechaNac" type="date" value="<?php echo $formulario['fechaNac']; ?>" onchange="return validateDate();" required /><br>

                        <label for="genero">Género: </label>
                        <input type="radio" name="genero" value="Masculino" <?php if ($formulario['genero'] == 'Masculino') echo ' checked '; ?>> Hombre
                        <input type="radio" name="genero" value="Femenino" <?php if ($formulario['genero'] == 'Femenino') echo ' checked '; ?>> Mujer<br>

                        <label for="email">Correo electrónico:</label>
                        <input class="celda" name="email" type="text" value="<?php echo $formulario['email']; ?>" required /><br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $formulario['telefono']; ?>" required /><br>

                        <label for="estudios">Estudios: </label>
                        <select class="celda" value="000" name="estudios" size=1 required>
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
                        <select class="celda" value="000"name="sitlaboral" size=1 required>
                            <option value="No es relevante">No es relevante </option>
                            <option value="En paro">Desempleado </option>
                            <option value="Trabajando">Trabajando </option>
                        </select>
                        <br>

                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $formulario['ingresos']; ?>" required /><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($formulario['minusvalia'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($formulario['minusvalia'] == 'No') echo ' checked '; ?>>No<br>

                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio" id="solicitar" name="solicitante"  onclick="showHide(this)" value="Sí" <?php if ($formulario['solicitante'] == 'Sí') echo ' checked '; ?>> Sí
                        <input type="radio" id="familiar" name="solicitante"  onclick="showHide(this)" value="No" <?php if ($formulario['solicitante'] == 'No') echo ' checked '; ?>> No<br>

                    </fieldset>
                    <div  id="esSolicitante" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información básica del solicitante</legend>

                            <label for="gastosfamilia">Gastos de la familia:</label>
                            <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php echo $formulario['gastosfamilia']; ?>" /><br>

                            <label for="poblacion">Población:</label>
                            <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php echo $formulario['poblacion']; ?>" /><br>

                            <label for="domicilio">Dirección del domicilio:</label>
                            <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php echo $formulario['domicilio']; ?>" /><br>

                            <label for="codigopostal">Código postal:</label>
                            <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php echo $formulario['codigopostal']; ?>" /><br>

                            <label for="proteccionDatos">
                            <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($formulario['proteccionDatos'] == 'Sí') echo ' checked '; ?>>De acuerdo con la Ley de Protección de Datos
                            </label>
                        </fieldset>
                    </div>

                    <div id="esFamiliar" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información básica del familiar</legend>

                            <label for="dniSol">DNI del solicitante:</label>
                            <input class="celda" name="dniSol" type="text" maxlength="9" value="<?php echo $formulario['dniSol']; ?>" /><br>

                            <label for='parentesco'>Parentesco con el solicitante:</label>
                            <input name='parentesco' type='text' value="<?php echo $formulario['parentesco']; ?>" /><br>
                        </fieldset>
                    </div>

                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_usuario.php'">Cancelar</a>
                        <input type="submit" value="Dar de alta" >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script  type="text/javascript">
    var frmvalidator = new Validator("altaUsuario");
    var solicitante = document.forms["altaUsuario"]["solicitante"].value;
    var poblacion = document.forms["altaUsuario"]["poblacion"].value;
    
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("nombre","req","Introduzca el nombre");
    frmvalidator.addValidation("nombre","alphabetic_space","El nombre debe de constar de letras y espacios");

    frmvalidator.addValidation("apellidos","req","Introduzca los apellidos");
    frmvalidator.addValidation("apellidos","alphabetic_space","Los apellidos deben de constar de letras y espacios");

    frmvalidator.addValidation("dni","req","Introduzca el dni");
    frmvalidator.addValidation("dni","regexp=^[0-9]{8}[A-Z]$","Introduzca un dni de la forma 12345678A");

    frmvalidator.addValidation("fechaNac","req","Introduzca la fecha de nacimiento");

    frmvalidator.addValidation("genero","selone_radio","Introduzca el género");

    frmvalidator.addValidation("email","req","Introduzca el email");
    frmvalidator.addValidation("email","email","Introduca un email válido");

    frmvalidator.addValidation("telefono","req","Introduzca el teléfono");
    frmvalidator.addValidation("telefono","regexp=^[0-9]{9}$","Introduzca un número de teléfono válido");

    frmvalidator.addValidation("estudios","dontselect=000","Introduzca el nivel de estudios");

    frmvalidator.addValidation("sitlaboral","dontselect=000","Introduzca la situación laboral del usuario");

    frmvalidator.addValidation("ingresos","req","Introduzca los ingresos");
    frmvalidator.addValidation("ingresos","num","Introduzca un valor numérico en los ingresos");
    frmvalidator.addValidation("ingresos","lt=1000","Los ingresos no deben de superar los 1000 euros");

    frmvalidator.addValidation("minusvalia","selone_radio","Introduzca si posee alguna minusvalia");

    frmvalidator.addValidation("solicitante","selone_radio","Introduzca si el usuario es solicitante");
    
    if(solicitante =="Sí"){
        frmvalidator.addValidation("gastosfamilia","req","Introduzca los gastos de la familia");
        frmvalidator.addValidation("gastosfamilia","num","Introduzca un valor numérico en los gastos familiares");

        frmvalidator.addValidation("poblacion","req","Introduzca la población");
        frmvalidator.addValidation("poblacion","alphabetic_space","La población debe de constar de letras y espacios");

        frmvalidator.addValidation("domicilio","req","Introduzca el domicilio");

        frmvalidator.addValidation("codigopostal","req","Introduzca el código postal");
        frmvalidator.addValidation("codigopostal","regexp=^[0-9]{5}$","Introduzca un código postal válido");

        frmvalidator.addValidation("proteccionDatos","shouldselchk=on","El solicitante debe de aceptar la Ley de Protección de Datos");

    }else if(solicitante =="No"){
        frmvalidator.addValidation("dniSol","req","Introduzca el dni del solicitante");
        frmvalidator.addValidation("parentesco","req","Introduzca el aprentesco co el solicitante");
    }
    </script>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>