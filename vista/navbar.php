<?php 
if ($_SERVER['REQUEST_URI'] == #'/project-caritas/controlador/acceso/login.php')
 ''){} else { ?>

<div class="topnav" id="myTopnav">
    <a href="#home"> Lista de usuarios</a>
    <a href="#news">Lista de citas</a>
    <a href="#contact">Lista de ayudas</a>
    <a href="../altas/alta_usuario.php">Añadir usuario</a>
    <a href="../altas/alta_cita.php">Añadir cita</a>
    <a href="../altas/alta_ayuda.php">Añadir ayuda</a>
    <a href="../altas/alta_voluntario.php">Añadir voluntario</a>
    <a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;"><img class="icono" src='../../vista/img/user_icon (16x16).png' alt="icono de usuario">migyanari</a>
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

<?php 
} ?> 