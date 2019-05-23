<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_citas.php");

if (isset($_SESSION["formulario_cita"])) {
  $cita = $_SESSION["formulario_cita"];
} else if (isset($_SESSION["cita"])) {
  $cita = $_SESSION["cita"];
} else {
  Header("Location: ../../vista/listas/lista_cita.php");
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
  <title>Alta de Cita: Resultado</title>
  <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />

</head>

<body>
  <?php include("../../vista/header.php");
  include("../../vista/navbar.php");
  if (isset($_SESSION["formulario_cita"])) {
    unset($_SESSION["formulario_cita"]);
    if (nueva_cita($conexion, $cita) == true) {
      $_SESSION['citaId'] = aux_IdentificaCita($conexion, $cita);
      ?>
      <div class="flex">
        <div class="resultado">
          <p>La cita ha sido creada correctamente, redirigiendo al listado... </p>
        </div>
      </div>
      <meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_cita.php" />
    <?php
  } else {?>
    <div class="flex">
        <div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
          <p>La cita no ha sido creada, ha ocurrido un error inesperado.</p>
        </div>
      </div>
  <?php }
} else if (isset($_SESSION["cita"])) {
  unset($_SESSION["cita"]);
  if (editar_cita($conexion, $cita)) {
    ?>
      <div class="flex">
        <div class="resultado">
          <p>La cita ha sido editada correctamente, redirigiendo al listado... </p>
        </div>
      </div>
      <meta http-equiv="refresh" content="3;url=http://localhost:81/project-caritas/vista/listas/lista_cita.php" />
    <?php
  } else {?>
    <div class="flex">
        <div class="resultado" style="background: rgba(224, 10, 10, 0.9);">
          <p>La cita no ha sido editada, ha ocurrido un error inesperado.</p>
        </div>
      </div>
  <?php
  }
}
?>

  <?php cerrarConexionBD($conexion); ?>
  <?php include("../../vista/footer.php");  ?>
</body>

</html>