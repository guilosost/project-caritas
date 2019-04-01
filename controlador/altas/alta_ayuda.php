<?php
session_start();
//include(dirname(__DIR__).'/GestionBD.php');
require_once("../../modelo/GestionBD.php");

if (!isset($_SESSION["formulario"])) {
    $formulario['suministradapor'] = "";
    $formulario['concedida'] = "";
    $formulario['bebe'] = "";
    $formulario['niño'] = "";
    $formulario['cantidad'] = "";
    $formulario['motivo'] = "";
    $formulario['prioridad'] = "";
    $formulario['profesor'] = "";
    $formulario['materia'] = "";
    $formulario['fechacomienzo'] = "";
    $formulario['fechafin'] = "";
    $formulario['numerosesiones'] = "";
    $formulario['horasporsesion'] = "";
    $formulario['numeroalumnosactuales'] = "";
    $formulario['numeroalumnosmaximo'] = "";
    $formulario['lugar'] = "";
    $formulario['descripcion'] = "";
    $formulario['empresa'] = "";
    $formulario['salarioaproximado'] = "";
    $_SESSION["formularioUsuario"] = $formulario;
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
    <title>Alta de Ayuda</title>
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
        <h2 class="form-h2">Alta de ayuda</h2>
        <div class="form-alta">
            <form action="../../controlador/acciones/accion_usuario.php" method="POST">
                <fieldset>
                    <legend>Información básica de la ayuda</legend>

                    <label for="tipoayuda">Seleccion el tipo de ayuda: </label>
                    <select class="celda" name="tipoayuda" size=1 required>
                        <option value="bolsacomida">Bolsa de comida </option>
                        <option value="ayudaeconomica">Ayuda económica </option>
                        <option value="curso">Curso </option>
                        <option value="trabajo">Propuesta de trabajo </option>
                        <option value="Educacion secundaria">Educación secundaria </option>

                        <option value="Grado medio">Grado medio </option>
                        <option value="Grado superior">Grado superior </option>
                        <option value="Grado universitario">Grado universitario </option>
                    </select>
                    <label for="suministradapor" required>Suministrada por:</label>
                    <select class="celda" name="suministradapor" size=1 required>
                        <option value="Cáritas San Juan de Aznalfarache">Cáritas San Juan de Aznalfarache </option>
                        <option value="Diocesana Sevilla">Diocesana Sevilla </option>
                        <option value="Otro">Otro </option>
                    </select>
                    <label for="concedida" required>¿Está la ayuda concedida?:</label>
                    <input type="radio" name="concedida" value="Sí">Sí
                    <input type="radio" name="concedida" value="No">No<br>

                </fieldset>

                <fieldset>
                    <legend>Información de la bolsa de comida</legend>

                    <label for="bebe">¿Debe contener productos para bebé?:</label>
                    <input type="radio" name="bebe" value="Sí">Sí
                    <input type="radio" name="bebe" value="No">No<br>

                    <label for="niño">¿Debe contener productos para niños?:</label>
                    <input type="radio" name="niño" value="Sí">Sí
                    <input type="radio" name="niño" value="No">No<br>
                </fieldset>
                <fieldset>
                    <legend>Información de la ayuda económica</legend>
                    <label for="cantidad">Cantidad(€): </label>
                    <input class="celda" name="cantidad" type="text" value="<?php echo $formulario['cantidad']; ?>" /><br>

                    <label for="motivo">Motivo:</label>
                    <input class="celda" name="motivo" type="text" value="<?php echo $formulario['motivo']; ?>" /><br>

                    <label for="prioridad">Esta ayuda necesita prioridad:</label>
                    <input type="radio" name="prioridad" value="Sí">Sí
                    <input type="radio" name="prioridad" value="No">No<br>
                </fieldset>
                <fieldset>
                    <legend>Información del curso</legend>
                    <label for="profesor">Profesor: </label>
                    <input class="celda" name="profesor" type="text" maxlength="50" value="<?php echo $formulario['profesor']; ?>" /><br>

                    <label for="materia">Materia del curso: </label>
                    <input class="celda" name="materia" type="text" maxlength="50" value="<?php echo $formulario['materia']; ?>" /><br>
                    </select>

                    <label for="fechacomienzo">Fecha comienzo:</label>
                    <input name="fechacomienzo" type="date" value="<?php $formulario['fechacomienzo'] ?>" /><br>

                    <label for="fechafin">Fecha final:</label>
                    <input name="fechafinal" type="date" value="<?php $formulario['fechafinal'] ?>" /><br>

                    <label for="numerosesiones">Número de sesiones: </label>
                    <input name="fechafinal" type="number" value="<?php $formulario['numerosesiones'] ?>" /><br>

                    <label for="numeroalumnosmaximo">Número de sesiones: </label>
                    <input name="numeroalumnosmaximo" type="number" value="<?php $formulario['numeroalumnosmaximo'] ?>" /><br>

                </fieldset>
                <br>

                <fieldset>
                    <legend>Trabajo</legend>

                    <label for="descripcion">Descripción del trabajo: </label>
                    <input class="celda" name="descripcion" type="text" maxlength="50" value="<?php echo $formulario['descripcion']; ?>" /><br>

                    <label for="empresa">Empresa o Persona que contrata:</label>
                    <input class="celda" name="empresa" type="text" maxlength="30" value="<?php echo $formulario['empresa']; ?>" /><br>

                    <label for="salarioaproximado">Salario aproximado:</label>
                    <input class="celda" name="domicilio" type="text" maxlength="50" value="<?php echo $formulario['domicilio']; ?>" /><br>

                    </label>
                </fieldset>
                <!--ARREGLAR CSS DEL BOTÓN SUBMIT, EL OTRO NO FUNCIONABA-->
                <input type="submit" value="Confirmar">
                <!--<a class="confirm" type="submit">Dar de alta</a>-->
                <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancelar</a>
            </form>
        </div>
    </div>
    <?php
    include("../../vista/footer.php");
    cerrarConexionBD($conexion);
    ?>
</body>

</html> 