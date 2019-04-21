<?php 
session_start();
$_SESSION["usuario"] = $fila["DNI"];
Header("Location: ../../vista/mostrar/mostrar_usuario.php"); 
?>