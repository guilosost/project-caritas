<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
?>
<div class="topnav" id="myTopnav">
    <a href="<?php echo VISTA.'listas/lista_usuario.php'?>"> Lista de usuarios</a>
    <a href="../../vista/listas/lista_cita.php">Lista de citas</a>
    <a href="../../vista/listas/lista_ayuda.php">Lista de ayudas</a>
    <a href="http://localhost:81/project-caritas/controlador/altas/alta_usuario.php">Añadir usuario</a>
    <a href="http://localhost:81/project-caritas/controlador/altas/alta_cita.php">Añadir cita</a>
    <a href="../../controlador/altas/alta_ayuda.php">Añadir ayuda</a>
    <a href="../../controlador/altas/alta_voluntario.php">Añadir voluntario</a>
    <a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;"><img class="icono" src="http://localhost:81/project-caritas/vista/img/user_icon (16x16).png" 
    alt="icono de usuario"><?php if (isset($_SESSION["nombreusuario"])){
        echo $_SESSION["nombreusuario"];
    }else{
        echo"Entre con su usuario";
     } 
     
     ?></a>
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