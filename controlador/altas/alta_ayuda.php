<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
require_once(MODELO."/GestionBD.php");

if (isset($_SESSION["formulario_login"])) {   
    Header("Location: ../../controlador/acceso/login.php");
}

if (!isset($_SESSION["formulario_ayuda"])) {
    $formulario['tipoayuda'] = "";
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
    $formulario['numeroalumnosactuales'] = "";
    $formulario['numeroalumnosmaximo'] = "";
    $formulario['descripcion'] = "";
    $formulario['empresa'] = "";
    $formulario['salarioaproximado'] = "";
    $_SESSION["formulario_ayuda"] = $formulario;
} else {
    $formulario = $_SESSION["formulario_ayuda"];
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

    <div class="flex">
        <div class="form">
            <h2 class="form-h2">Alta de ayuda</h2>
            <div class="form-alta">
                <form action="../../controlador/acciones/accion_ayuda.php" method="POST">
                    <fieldset>
                        <legend>Información básica de la ayuda</legend>

                        <label for="tipoayuda">Selección del tipo de ayuda: </label>
                        <select class="celda" name="tipoayuda" size=1 required>
                            <option value="">Seleccionar...</option>
                            <option value="bolsacomida">Bolsa de comida </option>
                            <option value="ayudaeconomica">Ayuda económica </option>
                            <option value="curso">Curso </option>
                            <option value="trabajo">Propuesta de trabajo </option>
                            <option value="Educacion secundaria">Educación secundaria </option>
                        </select>
                        <br>
                        <label for="suministradapor" required>Suministrada por:</label>
                        <select class="celda" name="suministradapor" size=1 required>
                            <option value="">Seleccionar...</option>
                            <option value="Cáritas San Juan de Aznalfarache">Cáritas San Juan de Aznalfarache </option>
                            <option value="Diocesana Sevilla">Diocesana Sevilla </option>
                            <option value="Otro">Otro </option>
                        </select>
                        <br>
                        <label for="concedida" required>¿Está la ayuda concedida?:</label>
                        <input type="radio" name="concedida" value="Sí">Sí
                        <input type="radio" name="concedida" value="No">No<br>

                    </fieldset>
                    <br>
                    <fieldset>
                        <legend>Información de la bolsa de comida</legend>

                        <label for="bebe">¿Debe contener productos para bebé?:</label>
                        <input type="radio" name="bebe" value="Sí">Sí
                        <input type="radio" name="bebe" value="No">No<br>

                        <label for="niño">¿Debe contener productos para niños?:</label>
                        <input type="radio" name="niño" value="Sí">Sí
                        <input type="radio" name="niño" value="No">No<br>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend>Información de la ayuda económica</legend>
                        <label for="cantidad">Cantidad (€): </label>
                        <input class="celda" name="cantidad" type="text" /><br>

                        <label for="motivo">Motivo:</label>
                        <input class="celda" name="motivo" type="text" /><br>

                        <label for="prioridad">¿Esta ayuda tiene prioridad?:</label>
                        <input type="radio" name="prioridad" value="Sí">Sí
                        <input type="radio" name="prioridad" value="No">No<br>
                    </fieldset>
                    <br>
                    <fieldset>
                        <legend>Información del curso</legend>
                        <label for="profesor">Profesor: </label>
                        <input class="celda" name="profesor" type="text" maxlength="50" /><br>

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
                    <br>
                    <fieldset>
                        <legend>Trabajo</legend>

                        <label for="descripcion">Descripción del trabajo: </label>
                        <textarea class="fillable" name="descripcion" maxlength="50"></textarea><br>

                        <label for="empresa">Empresa/persona que contrata:</label>
                        <input class="celda" name="empresa" type="text" maxlength="30" /><br>

                        <label for="salarioaproximado">Salario aproximado:</label>
                        <input class="celda" name="salarioaproximado" type="text" maxlength="50" /><br>

                        </label>
                    </fieldset>
                    <div class="botones">
                        <a class="cancel" type="cancel" onclick="javascript:window.location='www.google.es';">Cancelar</a>
                        <input type="submit" value="Confirmar">
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