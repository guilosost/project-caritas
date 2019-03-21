<?php
 if($_SERVER['REQUEST_URI'] =='/IISSI2/project-caritas/controlador/altas/alta_cita.php') { ?>

<div class="navbar">
    <div class="bars2"><p class="navtext">Lista de usuarios</p></div>
    <div class="bars2"><p class="navtext">Lista de citas</p></div>
    <div class="bars2"><p class="navtext">Lista de ayudas</p></div>

    <div class="bars2"><p class="navtext">Añadir usuario</p></div>
    <div class="bars2"><p class="navtext">Añadir cita</p></div>
    <div class="bars2"><p class="navtext">Añadir ayuda</p></div>
    <div class="bars2"><p class="navtext">Añadir voluntario</p></div>
    <div class="bars2"><p class="navtext"><img src='../../vista/img/user_icon.png' alt="icono de usuario">migyanari</p></div>
</div>

 <?php } else if($_SERVER['REQUEST_URI'] =='/IISSI2/project-caritas/controlador/acceso/login.php') {

} else {?>
      
<div class="navbar">
    <div class="bars"><p class="navtext">Lista de usuarios</p></div>
    <div class="bars"><p class="navtext">Lista de citas</p></div>
    <div class="bars"><p class="navtext">Lista de ayudas</p></div>

    <div class="bars"><p class="navtext">Añadir usuario</p></div>
    <div class="bars"><p class="navtext">Añadir cita</p></div>
    <div class="bars"><p class="navtext">Añadir ayuda</p></div>
    <div class="bars"><p class="navtext">Añadir voluntario</p></div>
    <div class="bars"><p class="navtext"><img src='../../vista/img/user_icon.png' alt="icono de usuario">migyanari</p></div>
</div>
<?php }?>