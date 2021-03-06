<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once("../../modelo/GestionBD.php");
require_once(GESTIONAR . "gestionar_usuarios.php");
if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

$conexion = crearConexionBD();
$referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

unset($_SESSION["formulario_usuario"]);
unset($_SESSION["usuario-editar"]);
unset($_SESSION["usuario-eliminar"]);

if (!empty($referer) and $referer == "http://localhost:81/project-caritas/vista/listas/lista_usuario.php") {
        $usuario["dni"] = $_REQUEST["DNI"];
		$usuario["apellidos"] = $_REQUEST["APELLIDOS"];
		$usuario["nombre"] = $_REQUEST["NOMBRE"];
		$usuario["telefono"] = $_REQUEST["TELEFONO"];
		$usuario["ingresos"] = $_REQUEST["INGRESOS"];
		$usuario["sitlaboral"] = $_REQUEST["SITUACIONLABORAL"];
		$usuario["estudios"] = $_REQUEST["ESTUDIOS"];
		$usuario["genero"] = $_REQUEST["GENERO"];
		$usuario["fechaNac"] = $_REQUEST["FECHANAC"];
		$usuario["protecciondatos"] = $_REQUEST["PROTECCIONDATOS"];
		$usuario["solicitante"] = $_REQUEST["SOLICITANTE"];
		$usuario["parentesco"] = $_REQUEST["PARENTESCO"];
		$usuario["minusvalia"] = $_REQUEST["MINUSVALIA"];
		$usuario["dniSol"] = $_REQUEST["DNI_SO"];
		$usuario["poblacion"] = $_REQUEST["poblacion"];
		$usuario["domicilio"] = $_REQUEST["domicilio"];
		$usuario["codigopostal"] = $_REQUEST["codigopostal"];
		$usuario["gastosfamilia"] = $_REQUEST["gastosfamilia"];
		$usuario["oid_uf"] = $_REQUEST["oid_uf"];
		$_SESSION["usuario"] = $usuario;
}else{
    Header("Location: ../listas/lista_usuario.php");
}

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
    <title>Información del Usuario</title>
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
               <form action="../../controlador/eliminaciones/elimina_usuario.php" method="POST">
                    <fieldset>
                        <legend>Información del usuario</legend>
                        
                        <label for="nombre" required>Nombre:</label>
                        <input class="celda" name="nombre" type="text" maxlength="50" value="<?php echo $usuario['nombre']; ?>" required readonly />

                        <label for="apellidos" required>Apellidos:</label>
                        <input name="apellidos" type="text" maxlength="50" value="<?php echo $usuario['apellidos']; ?>" required readonly/><br>

                        <label for="dni">DNI:</label>
                        <input class="celda" name="dni" placeholder="12345678X" type="text" value="<?php echo $usuario['dni']; ?>" required readonly/><br>

                        <label for="fechaNac">Fecha de nacimiento:</label>
                        <input name="fechaNac" type="text" value="<?php echo $usuario['fechaNac']; ?>" required readonly/><br>

                        <label for="genero">Género: </label>
                        <input type="radio" name="genero" value="Masculino" <?php if ($usuario['genero'] == 'Masculino') echo ' checked '; ?> onclick="javascript: return false;" readonly> Hombre
                        <input type="radio" name="genero" value="Femenino" <?php if ($usuario['genero'] == 'Femenino') echo ' checked '; ?> onclick="javascript: return false;" readonly> Mujer<br>

                        <label for="telefono">Teléfono:</label>
                        <input class="celda" name="telefono" type="text" maxlength="10" value="<?php echo $usuario['telefono']; ?>" required readonly/><br>

                        <label for="estudios">Estudios: </label>
                        <input class="celda" name="estudios" type="text" maxlength="40" value="<?php echo $usuario['estudios']; ?>" readonly/><br>
                      
                        <label for="sitlaboral">Situación laboral: </label>
                        <input class="celda" name="sitlaboral" type="text" maxlength="40" value="<?php echo $usuario['sitlaboral']; ?>" readonly/><br>
                      
                        <label for="ingresos">Ingresos:</label>
                        <input name="ingresos" type="text" value="<?php echo $usuario['ingresos']; ?>" required readonly/><br>

                        <label for="minusvalia">¿El usuario tiene alguna discapacidad? </label>
                    
                        <input type="radio" name="minusvalia" value="Sí" <?php if ($usuario["minusvalia"] == "Sí") echo ' checked '; ?> onclick="javascript: return false;" readonly>Sí
                        <input type="radio" name="minusvalia" value="No" <?php if ($usuario["minusvalia"] == "No ") echo ' checked '; ?> onclick="javascript: return false;" readonly>No<br>
                        
                        <label for="solicitante">¿El usuario es solicitante? </label>
                        <input type="radio"  name="solicitante"   value="Sí" <?php if ($usuario['solicitante'] == "Sí") echo ' checked '; ?> onclick="javascript: return false;" readonly> Sí
                        <input type="radio"  name="solicitante"  value="No" <?php if ($usuario['solicitante'] == "No ") echo ' checked '; ?> onclick="javascript: return false;" readonly> No<br>

                    </fieldset>
                    <?php if ($usuario["solicitante"] == "Sí"){ ?>
                    <div  id="esSolicitante" > 
                        <br>
                        <fieldset>
                            <legend>Información básica del solicitante</legend>
                            
                            <label for="gastosfamilia">Gastos de la familia:</label>
                            <input class="celda" name="gastosfamilia" type="text" maxlength="13" value="<?php echo $usuario['gastosfamilia']; ?>" readonly/><br>

                            <label for="poblacion">Población:</label>
                            <input class="celda" name="poblacion" type="text" maxlength="30" value="<?php echo $usuario['poblacion']; ?>" readonly/><br>

                            <label for="domicilio">Dirección del domicilio:</label>
                            <input class="celda" name="domicilio" id="direccion" type="text" maxlength="50" value="<?php echo $usuario['domicilio']; ?>" readonly/><br>
                            
                            <label for="codigopostal">Código postal:</label>
                            <input class="celda" name="codigopostal" type="text" minlength="5" maxlength="5" value="<?php echo $usuario['codigopostal']; ?>" readonly/><br>
                            
                            <label for="proteccionDatos">
                                <input type="checkbox" name="proteccionDatos" value="Sí" style="align:center" <?php if ($usuario['solicitante'] == 'Sí') echo ' checked '; ?> onclick="javascript: return false;" readonly>De acuerdo con la Ley de Protección de Datos
                            </label>
                        </fieldset>
                    </div>
                    <?php }else{ ?>
                    <div id="esFamiliar" >
                        <br>
                        <fieldset>
                            <legend>Información básica del familiar</legend>

                            <label for="dniSol">DNI del solicitante:</label>
                            <input class="celda" name="dniSol" type="text" maxlength="9" value="<?php echo $usuario['dniSol']; ?>"readonly /><br>

                            <label for='parentesco'>Parentesco con el solicitante:</label>
                            <input name='parentesco' type='text' value="<?php echo $usuario['parentesco']; ?>" readonly/><br>
                        </fieldset>
                    </div>
                   <?php } ?>
                        <input style="float:left" type="submit" value="Eliminar" >
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_usuario.php'">Cancelar</a>
                        <input type="button" onclick="location.href='../../controlador/ediciones/editar_usuario.php'" value="Editar" />
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