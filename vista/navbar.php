<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
?>
<div class="topnav" id="myTopnav">
    <a href="http://localhost:81/project-caritas/vista/listas/lista_usuario.php"> Lista de usuarios</a>
    <a href="http://localhost:81/project-caritas/vista/listas/lista_cita.php">Lista de citas</a>
    <a href="http://localhost:81/project-caritas/vista/listas/lista_ayuda.php">Lista de ayudas</a>
    <?php if (isset($_SESSION["nombreusuario"]) and ($_SESSION["permiso"] == "Sí")) {

        echo '<a href="http://localhost:81/project-caritas/vista/listas/lista_voluntario.php">Lista de voluntarios</a>';
    }
    ?>
    <a href="http://localhost:81/project-caritas/controlador/altas/alta_usuario.php">Añadir usuario</a>
    <a href="http://localhost:81/project-caritas/controlador/altas/alta_cita.php">Añadir cita</a>
    <a href="http://localhost:81/project-caritas/controlador/altas/alta_ayuda.php">Añadir ayuda</a>
    <?php if (isset($_SESSION["nombreusuario"]) and ($_SESSION["permiso"] == "Sí")) {

        echo '<a href="http://localhost:81/project-caritas/controlador/altas/alta_voluntario.php">Añadir voluntario</a>';
    }
    ?>
        <?php if (isset($_SESSION["nombreusuario"])) {
            echo '<a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;">
            <img class="icono" src="http://localhost:81/project-caritas/vista/img/user_icon (16x16).png" alt="icono de usuario">'.$_SESSION["nombreusuario"].'</a>';
        } else {
            echo '<a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;">
            <img class="icono" src="http://localhost:81/project-caritas/vista/img/user_icon (16x16).png" alt="icono de usuario">Entre con su usuario</a>';
        }

        ?>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>