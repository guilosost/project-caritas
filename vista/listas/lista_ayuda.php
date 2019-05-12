<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_ayudas.php");
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

$conexion = crearConexionBD();

// La consulta que ha de paginarse
// , COMIDAS.BEBE, COMIDAS.NIÑO, AYUDASECONOMICAS.CANTIDAD, AYUDASECONOMICAS.PRIORIDAD, CURSOS.MATERIA, TRABAJOS.EMPRESA, TRABAJOS.SALARIOAPROXIMADO
// , COMIDAS, AYUDASECONOMICAS, CURSOS, TRABAJOS
// , PRIORIDAD, MATERIA, SALARIOAPROXIMADO
$query = 'SELECT * '
    . 'FROM AYUDAS '
    . 'ORDER BY CONCEDIDA ASC';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="./js/boton.js"></script>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <title>Gestión de Cáritas: Lista de Usuarios</title>
</head>

<body>

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
                    <a href="lista_ayuda.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
                <?php
            } ?>
            </div>



            <form method="get" action="lista_ayuda.php">

                <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />

                Mostrando

                <input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus" />

                entradas de <?php echo $total_registros ?>

                <input type="submit" value="Cambiar">

            </form>

        </nav>



        <?php

        foreach ($filas as $fila) {
            
            
            $comida = getComida($conexion, $fila["OID_A"]);
            $ayuda_economica = getAyudaEconomica($conexion, $fila["OID_A"]); 
            $trabajo = getTrabajo($conexion, $fila["OID_A"]);

            ?>

            
            <article class="ayuda">

                <form method="post" action="../../vista/mostrar/mostrar_ayuda.php">

                    <div class="fila_ayuda">

                        <div class="datos_ayuda">

                            <input id="oid_a" name="oid_a" value="<?php echo $fila["OID_A"]; ?>" type="hidden"/> 

                            <input id="CONCEDIDA" name="CONCEDIDA" value="<?php echo $fila["CONCEDIDA"]; ?>" />

                            <input id="SUMINISTRADAPOR" name="SUMINISTRADAPOR" value="<?php echo $fila["SUMINISTRADAPOR"]; ?>" />

                            <input id="BEBE" name="BEBE" value="<?php echo $comida["BEBE"];?>" type="hidden" />
                            <input id="NIÑO" name="NIÑO" value="<?php echo $comida["NIÑO"]; ?>" type="hidden" />

                            <input id="CANTIDAD" name="CANTIDAD" value="<?php echo $ayuda_economica["CANTIDAD"]; ?>" type="hidden"/>
                            <input id="PRIORIDAD" name="MOTIVO" value="<?php echo $ayuda_economica["MOTIVO"]; ?>" type="hidden"/>
                            <input id="MOTIVO" name="PRIORIDAD" value="<?php echo $ayuda_economica["PRIORIDAD"]; ?>" type="hidden"/>

                            <input id="DESCRIPCION" name="DESCRIPCION" value="<?php echo $trabajo["DESCRIPCION"]; ?>" type="hidden"/>
                            <input id="EMPRESA" name="EMPRESA" value="<?php echo $trabajo["EMPRESA"]; ?>" type="hidden"/>
                            <input id="SALARIOAPROXIMADO" name="SALARIOAPROXIMADO" value="<?php echo $trabajo["SALARIOAPROXIMADO"]; ?>" type="hidden"/>

                            <input type="submit" value="mostrar">
                           

                        </div>
                    </div>
                </form>
            </article>
        <?php
    } ?>
    </main>
    <?php
    include_once("../footer.php");
    ?>

</body>

</html>