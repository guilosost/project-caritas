<?php
session_start();

include("../../modelo/gestionar/gestionar_voluntarios.php");
include("../../modelo/GestionBD.php");


if (isset($_SESSION["formulario_voluntario"])) {
    $voluntario = $_SESSION["formulario_voluntario"];
}else if (isset($_SESSION["voluntario"])) { 
    $voluntario = $_SESSION["voluntario"];
}else if (isset($_SESSION["voluntario-editar"])) { 
  $voluntario = $_SESSION["voluntario-editar"];
}else {
    Header("Location: ../../vista/listas/lista_voluntario.php");
}

$conexion  = crearConexionBD();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Alta de Voluntario: Resultado</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />

</head>

<head>
    <meta charset="utf-8">
    <title>Alta de voluntario</title>
</head>

<body>
    <?php include("../../vista/header.php");
    include("../../vista/navbar.php");
    if (isset($_SESSION["formulario_voluntario"])) {
        unset($_SESSION["formulario_voluntario"]);
        if (nuevo_voluntario($conexion, $voluntario)) {
            ?>
      <div class="flex">
        <div class="resultado">
          <p>El voluntario ha sido creado correctamente, redirigiendo al listado... </p>
        </div>
      </div>
      <meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_voluntario.php" />
    <?php
  } else {?>
    <div class="flex">
        <div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
          <p>El voluntario no ha sido creado, ha ocurrido un error inesperado.</p>
        </div>
      </div>
  <?php }
    }else if (isset($_SESSION["voluntario"])) { 
        unset($_SESSION["voluntario"]);
        if (editar_voluntario($conexion, $voluntario)) {
            ?>
            <div class="flex">
              <div class="resultado">
                <p>El voluntario ha sido editado correctamente, redirigiendo al listado... </p>
              </div>
            </div>
            <meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_voluntario.php" />
          <?php
        } else {?>
          <div class="flex">
              <div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
                <p>El voluntario no ha sido editado, ha ocurrido un error inesperado.</p>
              </div>
            </div>
        <?php }
    }else if (isset($_SESSION["voluntario-editar"])) { 
      unset($_SESSION["voluntario-editar"]);
      if (editar_voluntario2($conexion, $voluntario)) {
          ?>
          <meta http-equiv="refresh" content="0;url=http://localhost:81/project-caritas/vista/listas/lista_voluntario.php" />
        <?php
      } else {?>
        <div class="flex">
            <div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
              <p>El voluntario no ha sido editado vía JavaScript, ha ocurrido un error inesperado.</p>
            </div>
          </div>
      <?php }
  }
   
    ?>


    </main>
    <?php cerrarConexionBD($conexion);
    include("../../vista/footer.php");  ?>
</body>

</html> 