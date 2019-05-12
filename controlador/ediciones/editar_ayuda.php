<?php
session_start();

require_once("../../modelo/GestionBD.php");

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["ayuda"])) {
    $ayuda = $_SESSION["ayuda"];
} else {
    Header("Location:../../vista/listas/lista_ayuda.php");
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
    <script type="text/javascript" src="../../vista/js/jquery_form.js"></script>
    <!-- <script type="text/javascript" src="../../vista/js/validacion_usuario.js"></script> -->
    <script>
        
        function showHide(elm) {
            var comida = document.getElementById("comida");
            var economica = document.getElementById("economica");
            var curso = document.getElementById("curso");
            var trabajo = document.getElementById("trabajo");

            if (elm.value == 'bolsacomida') {
                comida.classList.remove('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'ayudaeconomica') {
                comida.classList.add('hide');
                economica.classList.remove('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'curso') {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.remove('hide');
                trabajo.classList.add('hide');
            } else if (elm.value == 'trabajo') {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.remove('hide');
            } else {
                comida.classList.add('hide');
                economica.classList.add('hide');
                curso.classList.add('hide');
                trabajo.classList.add('hide');
            }

        }
       
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
            <h2 class="form-h2">Información de la ayuda</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_ayuda.php" method="POST" id=altaAyuda name=altaAyuda>
                    <fieldset>
                        <legend>Información básica de la ayuda</legend>

                        <label for="tipoayuda">Selección del tipo de ayuda: </label>
                        <select class="celda" id="tipoayuda" onchange="showHide(this)" name="tipoayuda" size=1 required>
                            <option value="">Seleccionar...</option>
                            <option value="bolsacomida" <?php if ($ayuda['tipoayuda'] == 'bolsacomida') echo ' selected ';?>>Bolsa de comida </option>
                            <option value="ayudaeconomica" <?php if ($ayuda['tipoayuda'] == 'ayudaeconomica') echo ' selected ';?>>Ayuda económica  </option>
                            <option value="curso" <?php if ($ayuda['tipoayuda'] == 'curso') echo ' selected ';?>>Curso formativo  </option>
                            <option value="trabajo"  <?php if ($ayuda['tipoayuda'] == 'trabajo') echo ' selected ';?>>Propuesta de trabajo </option>
                        </select>
                         <br>
                        </select>
                        <br>

                        <label for="suministradapor" required>Suministrada por:</label>
                        <input class="celda" name="suministradapor" type="text" maxlength="40" value="<?php echo $ayuda['suministradapor']; ?>" /><br>
                        
                        <br>
                        <label for="concedida" required>¿Está la ayuda concedida?:</label>
                        <input type="radio" name="concedida" value="Sí"  <?php if ($ayuda['concedida'] == 'Sí') echo ' checked '; ?>>Sí
                        <input type="radio" name="concedida" value="No"  <?php if ($ayuda['concedida'] == 'No ') echo ' checked '; ?>>No<br>

                    </fieldset>

                    <div id="comida" >
                        <br>
                        <fieldset>
                            <legend>Información de la bolsa de comida</legend>

                            <label for="bebe">¿Debe contener productos para bebé?:</label>
                            <input type="radio" name="bebe" value="Sí"  <?php if ($ayuda['bebe'] == 'Sí') echo ' checked '; ?>>Sí
                            <input type="radio" name="bebe" value="No" <?php if ($ayuda['bebe'] == 'No ') echo ' checked '; ?>>No  <br>

                            <label for="niño">¿Debe contener productos para niños?:</label>
                            <input type="radio" name="niño" value="Sí"  <?php if ($ayuda['niño'] == 'Sí') echo ' checked '; ?>>Sí 
                            <input type="radio" name="niño" value="No" <?php if ($ayuda['niño'] == 'No ') echo ' checked '; ?>>No<br>
                        </fieldset>
                    </div>

                    <div id="economica" >
                        <br>
                        <fieldset>
                            <legend>Información de la ayuda económica</legend>
                            <label for="cantidad">Cantidad (€): </label>
                            <input class="celda" name="cantidad" type="number" value="<?php echo $ayuda['cantidad']; ?>" /><br>

                            <label for="motivo">Motivo:</label>
                            <input class="celda" name="motivo" type="text" value="<?php echo $ayuda['motivo']; ?>"/><br>

                            <label for="prioridad">¿Esta ayuda tiene prioridad?:</label>
                            <input type="radio" name="prioridad" value="Sí"  <?php if ($ayuda['prioridad'] == 'Sí') echo ' checked '; ?>>Sí
                            <input type="radio" name="prioridad" value="No"  <?php if ($ayuda['prioridad'] == 'No ') echo ' checked '; ?>>No<br>
                        </fieldset>
                    </div>

                    <!--<div id="curso" class="hide">
                        <br>
                        <fieldset>
                            <legend>Información del curso</legend>
                            <label for="profesor">Profesor: </label>
                            <input class="celda" name="profesor" type="text" maxlength="50" value="<?php echo $ayuda['cantidad']; ?>"/><br>

                            <label for="materia">Materia del curso: </label>
                            <input class="celda" name="materia" type="text" maxlength="50" /><br>
                            </select>

                            <label for="fechacomienzo">Fecha comienzo:</label>
                            <input name="fechacomienzo" type="date" value="<?php $formulario['fechacomienzo'] ?>" /><br>

                            <label for="fechafin">Fecha final:</label>
                            <input name="fechafin" type="date" value="<?php $formulario['fechafin'] ?>" /><br>

                            <label for="numerosesiones">Número de sesiones: </label>
                            <input name="numerosesiones" type="number" value="<?php $formulario['numerosesiones'] ?>" /><br>

                            <label for="numeroalumnosmaximo">Número de alumnos: </label>
                            <input name="numeroalumnosmaximo" type="number" value="<?php $formulario['numeroalumnosmaximo'] ?>" /><br>
                        </fieldset>
                    </div> -->

                    <div id="trabajo" >
                        <br>
                        <fieldset>
                            <legend>Información del trabajo</legend>

                            <label for="descripcion">Descripción: </label>
                            <textarea class="fillable" name="descripcion" maxlength="50" value="<?php echo $ayuda['descripcion']; ?>"></textarea><br>

                            <label for="empresa">Empresa/persona que contrata:</label>
                            <input class="celda" name="empresa" type="text" maxlength="30" value="<?php echo $ayuda['empresa']; ?>"/><br>

                            <label for="salarioaproximado">Salario aproximado:</label>
                            <input class="celda" name="salarioaproximado" type="text" maxlength="50" value="<?php echo $ayuda['salarioaproximado']; ?>" /><br>

                            </label>
                        </fieldset>
                    </div>

                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="location.href='../../vista/listas/lista_ayuda.php'">Cancelar</a>
                        <input  type="submit" value="Editar" >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var frmvalidator = new Validator("altaAyuda");

        frmvalidator.EnableMsgsTogether();
        var tipo = document.forms["altaAyuda"]["tipoayuda"].value;
        
        frmvalidator.addValidation("tipoayuda", "req", "Introduzca el tipo de ayuda");

        frmvalidator.addValidation("suministradapor", "req", "Introduzca el proveedor de la ayuda");
        //frmvalidator.addValidation("suministradapor", "alphabetic_space", "el proveedor de la ayuda debe de constar de letras y espacios");

        frmvalidator.addValidation("concedida", "selone_radio", "Introduzca si la ayuda está concedida");

        if (tipo == "bolsacomida") {
        frmvalidator.addValidation("bebe", "selone_radio", "Introduzca si el solicitante tiene a un bebé");

        frmvalidator.addValidation("nino", "selone_radio", "Introduzca si el solicitante tiene niños");

        }else if (tipo == "ayudaeconomica"){
        frmvalidator.addValidation("cantidad", "req", "Introduzca la cantidad");
        frmvalidator.addValidation("cantidad", "num", "La cantidad debe de ser numérica");

        frmvalidator.addValidation("prioridad", "selone_radio", "Introduzca si posee prioridad");

        frmvalidator.addValidation("motivo", "req", "Introduzca el motivo de la ayuda");
        frmvalidator.addValidation("motivo", "alphabetic_space", "Introduzca el motivo de la ayuda");

        }else if (tipo == "trabajo"){
        frmvalidator.addValidation("salarioaproximado", "req", "Introduzca un salario");
        frmvalidator.addValidation("salarioaproximado", "num", "Introduzca un número como salario");

        frmvalidator.addValidation("descripcion", "req", "Introduzca la descripción del trabajo");
        frmvalidator.addValidation("descripcion", "alphabetic_space", "Introduzca la descripción del trabajo");

        frmvalidator.addValidation("empresa", "req", "Introduzca la empresa");
        frmvalidator.addValidation("empresa", "alphabetic_space", "Introduzca la empresa");

        }
    </script> 
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html>