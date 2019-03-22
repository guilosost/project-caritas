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
      
<div class="topnav" id="myTopnav">
    <a href="#home" class="active">Lista de usuarios</a>
    <a href="#news">Lista de citas</a>
    <a href="#contact">Lista de ayudas</a>
    <a href="#about">Añadir usuario</a>
    <a href="#about">Añadir cita</a>
    <a href="#about">Añadir ayuda</a>
    <a href="#about">Añadir voluntario</a>
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

<?php }?>