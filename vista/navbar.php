<?php 
if ($_SERVER['REQUEST_URI'] == '/../../controlador/acceso/login.php') {} else { ?>

<div class="topnav" id="myTopnav">
    <a href="#home"> Lista de usuarios</a>
    <a href="#news">Lista de citas</a>
    <a href="#contact">Lista de ayudas</a>
    <a href="../../controlador/altas/alta_usuario.php">Añadir usuario</a>
    <a href="#about">Añadir cita</a>
    <a href="#about">Añadir ayuda</a>
    <a href="#about">Añadir voluntario</a>
<<<<<<< HEAD
    <a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;"><img class="icono" src='../../vista/img/user_icon (16x16).png' alt="icono de usuario">migyanari</a>
=======
    <a href="" style="float: right; font-weight: bold; border: 1.5px solid white; border-right: none; margin-bottom: -3px;">
    <img class="icono" src='../../vista/img/user_icon.png' alt="icono de usuario">migyanari</a>
>>>>>>> f8773134ffc039456910e4a1efd5f65c63f761ea
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