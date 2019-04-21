<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_usuarios.php");
require_once(VISTA . "/paginacion_consulta.php");

$conexion = crearConexionBD();

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
    unset($_SESSION["usuario"]);
}

// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
// ¿Hay una sesión activa?
if (isset($_SESSION["paginacion"]))
    $paginacion = $_SESSION["paginacion"];

$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);

if ($pagina_seleccionada < 1)         $pagina_seleccionada = 1;
if ($pag_tam < 1)         $pag_tam = 5;

// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
unset($_SESSION["paginacion"]);

// La consulta que ha de paginarse
$query = 'SELECT *'
    . 'FROM USUARIOS ';

// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
$total_registros = total_consulta($conexion, $query);
$total_paginas = (int)($total_registros / $pag_tam);

if ($total_registros % $pag_tam > 0)        $total_paginas++;

if ($pagina_seleccionada > $total_paginas)        $pagina_seleccionada = $total_paginas;

// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
$paginacion["PAG_NUM"] = $pagina_seleccionada;
$paginacion["PAG_TAM"] = $pag_tam;
$_SESSION["paginacion"] = $paginacion;

$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);

cerrarConexionBD($conexion);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="../../vista/css/header-footer.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/button.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/form.css">
    <link rel="stylesheet" type="text/css" href="../../vista/css/navbar.css">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="./js/boton.js"></script>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <title>Lista de Usuarios</title>
    <script>
    function muestra() {
            $_SESSION["usuario"] = $fila["DNI"];
            Header("Location: ../mostrar/mostrar_usuario.php"); 
        }
    </script>
</head>

<body>
<script>
//    	$(document).ready(function() {
//		$("#altaUsuario").on("submit", function() {
//            validarCalle();
//        });
//    });
$("#mostrar").onclick = muestra() {
            $_SESSION["usuario"] = $fila["DNI"];
            Header("Location: ../mostrar/mostrar_usuario.php"); 
        };

</script>
    <?php
    include_once("../header.php");
    include_once("../navbar.php");
    ?>
    <main>
        <nav>
            <div id="enlaces">
                <?php
                for ($pagina = 1; $pagina <= $total_paginas; $pagina++)

                    if ($pagina == $pagina_seleccionada) {     ?>

                    <span class="current"><?php echo $pagina; ?></span>
                <?php
            } else { ?>
                    <a href="lista_usuario.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
                <?php
            } ?>
            </div>



            <form method="get" action="lista_usuario.php">

                <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />

                Mostrando

                <input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam; ?>" autofocus="autofocus" />

                entradas de <?php echo $total_registros ?>

                <input type="submit" value="Cambiar">

            </form>

        </nav>



        <?php

        foreach ($filas as $fila) {

            ?>

            <form method="post" action="../../controlador/cargas/carga_usuario.php">

            <article class="usuario">

                

                    <div class="fila_usuario">

                        <div class="datos_usuario">

                            <input id="DNI" name="DNI" value="<?php echo $fila["DNI"]; ?>" />

                            <input id="APELLIDOS" name="APELLIDOS" value="<?php echo $fila["APELLIDOS"]; ?>" />

                            <input id="NOMBRE" name="NOMBRE" value="<?php echo $fila["NOMBRE"]; ?>" />

                            <input id="TELEFONO" name="TELEFONO" value="<?php echo $fila["TELEFONO"]; ?>" />

                            <input id="INGRESOS" name="INGRESOS" value="<?php echo $fila["INGRESOS"]; ?>" />

                            <input id="SITUACIONLABORAL" name="SITUACIONLABORAL" value="<?php echo $fila["SITUACIONLABORAL"]; ?>" />
                            
                            <input id="ESTUDIOS" name="ESTUDIOS" value="<?php echo $fila["ESTUDIOS"]; ?>" type="hidden" />

                            <input id="GENERO" name="GENERO" value="<?php echo $fila["SEXO"]; ?>" type="hidden"/>

                            <input id="FECHANAC" name="FECHANAC" value="<?php echo $fila["FECHANACIMIENTO"]; ?>"type="hidden" />
                            
                            <input id="PROTECCIONDATOS" name="PROTECCIONDATOS" value="<?php echo $fila["PROTECCIONDATOS"]; ?>"type="hidden" />

                            <input id="SOLICITANTE" name="SOLICITANTE" value="<?php echo $fila["SOLICITANTE"]; ?>" type="hidden"/>
                            <?php

                            # Todo este bloque está comentado porque no le he encontrado utilidad xd
                            # Si veis que sirve para algo comentadlo

                            ?>

                            <!-- Editando nombre -->

                            <!--    <h3><input id="NOMBRE" name="NOMBRE" type="text" value="<?php echo $fila["NOMBRE"]; ?>" /> </h3>-->

                            <!--  <h4><?php echo $fila["NOMBRE"] . " " . $fila["APELLIDOS"]; ?></h4>-->

                            <?php

                            ?>

                            <!-- Mostrando nombre -->

                            <!--  <input id="nombre" name="nombre" type="hidden" value="<?php echo $fila["nombre"]; ?>" />-->

                            <!--<div class="nombre"><b><?php echo $fila["NOMBRE"]; ?></b></div>-->

                            <!-- <div class="usuario">By <em><?php echo $fila["NOMBRE"] . " " . $fila["APELLIDOS"]; ?></em></div> -->

                            <?php

                            ?>

                        </div>


                        <!-- Los botones están comentados por estética hasta que los arregle Yanes y no deformen la tabla -->
                        <!-- <div id="botones_fila">-->

    
                        <button type="submit">mostrar</button>
                                              <!--  <input id="mostrar" name="mostrar" type=button  onclick="muestra()" value="mostrar">    -->                                
                                            <!--
                                                <button id="editar" name="editar" type="submit" class="editar_fila">

                                                    <img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar usuario">

                                                </button>

                                   

                                    <button id="borrar" name="borrar" type="submit" class="editar_fila">

                                        <img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar usuario">

                                    </button>
                                </div> -->
                    </div>
                
            </article>
        <?php
    } ?>
    </main>
    <?php
    include_once("../footer.php");
    ?>

</body>

</html>