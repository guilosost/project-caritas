<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once("../../modelo/GestionBD.php");
require_once(GESTIONAR . "gestionar_usuarios.php");
if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}
$conexion = crearConexionBD();
$usuario = $_SESSION["usuario"];
unset($_SESSION["usuario"]);
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
    <title>Consulta Usuario</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <script type = "text/javascript" src = "../../vista/js/jquery_form.js" ></script>
<!--    <script type = "text/javascript" src = "../../vista/js/validacion_usuario.js" ></script> -->
</head>

<body background="../../vista/img/background.png">
    <?php
    include("../../vista/header.php");
    include("../../vista/navbar.php");
    ?>

    <div class="flex">
        <div class="form">
            <h2 class="form-h2">Información del usuario</h2>
            <div class="form-alta">
               
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

                        <label for="email">Correo electrónico:</label>
                        <input class="celda" name="email" type="text" value="<?php echo $usuario['email']; ?>" required /><br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $usuario['telefono']; ?>" required /><br>

                        <label for="estudios">Estudios: </label>
                        <select class="celda" name="estudios" size=1 required>
                            <option value="NULL">No es relevante </option>
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
                            <option value="NULL">No es relevante </option>
                            <option value="En paro">Desempleado </option>
                            <option value="Trabajando">Trabajando </option>
                        </select>
                        <br>

                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $usuario['ingresos']; ?>" required /><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($usuario['minusvalia'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($usuario['minusvalia'] == 'No') echo ' checked '; ?>>No<br>

                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio" id="solicitar" name="solicitante"  onclick="showHide(this)" value="Sí" <?php if ($formulario['solicitante'] == 'Sí') echo ' checked '; ?>> Sí
                        <input type="radio" id="familiar" name="solicitante"  onclick="showHide(this)" value="No" <?php if ($formulario['solicitante'] == 'No') echo ' checked '; ?>> No<br>

                    </fieldset>
                    <?php if ($usuario["solicitante"] == "Sí"){ ?>
                    <div  id="esSolicitante" class="hide"> 
                        <br>
                        <fieldset>
                            <legend>Información básica del solicitante</legend>
                            
                            <label for="gastosfamilia">Gastos de la familia:</label>
                            <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php echo $usuario['gastosfamilia']; ?>" /><br>

                            <label for="poblacion">Población:</label>
                            <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php echo $usuario['poblacion']; ?>" /><br>

                            <label for="domicilio">Dirección del domicilio:</label>
                            <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php echo $usuario['domicilio']; ?>" /><br>
                            
                            <label for="codigopostal">Código postal:</label>
                            <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php echo $usuario['codigopostal']; ?>" /><br>
                            
                            <label for="proteccionDatos">
                                <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($usuario['proteccionDatos'] == 'Sí') echo ' checked '; ?>>De acuerdo con la Ley de Protección de Datos
                            </label>
                        </fieldset>
                    </div>
                    <?php }else{ ?>
                    <div id="esFamiliar" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información básica del familiar</legend>

                            <label for="dniSol">DNI del solicitante:</label>
                            <input class="celda" name="dniSol" type="text" maxlength="9" value="<?php echo $usuario['dniSol']; ?>" /><br>

                            <label for='parentesco'>Parentesco con el solicitante:</label>
                            <input name='parentesco' type='text' value="<?php echo $usuario['parentesco']; ?>" /><br>
                        </fieldset>
                    </div>
                   <?php } ?>
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancelar</a>
                        <input type="submit" value="Dar de alta">
                    </div>
                
            </div>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>