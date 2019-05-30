<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_citas.php");
require_once(VISTA . "/paginacion_consulta.php");

$conexion = crearConexionBD();

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

unset($_SESSION["formulario_cita"]);

$cita["oid_c"] = "";
$cita["fechacita"] = "";
$_SESSION["cita-eliminar"] = $cita;
$_SESSION["cita-editar"] = $cita;

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
$query = 'SELECT * '
    . 'FROM CITAS '
    . 'ORDER BY FECHACITA, DNI, NOMBREV ASC';

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
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <title>Lista de Citas</title>

    <script>
        function editar(oid_c) {
            console.log("Dentro");
            console.log(oid_c + "-FECHACITA");
            document.getElementById(oid_c + "-EDITAROFF").classList.add("hide");
            document.getElementById(oid_c + "-EDITARON").classList.remove("hide");
            var fech = document.getElementById(oid_c + "-FECHACITA2").value;
            var array = fech.split("/");
            var fechaCita = array[2] + "-" + array[1] + "-" + array[0];
            console.log(fechaCita);
            var string = '<input id="FECHACITAPREV" type="date" value="' + fechaCita + '"/>';
            document.getElementById(oid_c + "-FECHACITA").innerHTML = string;
        }

        function mandar(oid_c) {
            var f = document.createElement("form");
            f.setAttribute('method', "post");
            f.setAttribute('id', "edicion_dinamica");
            f.setAttribute('class', "hide");
            f.setAttribute('action', "../../controlador/acciones/accion_cita.php");

            var i = document.createElement("input"); //input element, text
            i.setAttribute('type', "text");
            i.setAttribute('name', "fechacita");
            i.setAttribute('id', "fechacita_din");
            var valorFechaCita = document.getElementById("FECHACITAPREV").value;
            f.appendChild(i);

            var j = document.createElement("input");
            j.setAttribute('type', "text");
            j.setAttribute('name', "oid_c");
            j.setAttribute('id', "oid_c_din");
            f.appendChild(j);

            document.getElementsByTagName('body')[0].appendChild(f);
            document.getElementById("oid_c_din").value = oid_c;
            document.getElementById("fechacita_din").value = valorFechaCita;

            console.log(document.getElementById("oid_c_din").value);
            console.log(document.getElementById("fechacita_din").value);
            document.getElementById("edicion_dinamica").submit();
        }

        function cancelar(oid_c) {
            console.log("Cancelando");
            console.log(oid_c + "-FECHACITA");
            document.getElementById(oid_c + "-EDITARON").classList.add("hide");
            document.getElementById(oid_c + "-EDITAROFF").classList.remove("hide");
            var fechaCita = document.getElementById(oid_c + "-OLDFECHACITA").value;
            document.getElementById(oid_c + "-FECHACITA").innerHTML = fechaCita;
        }

        function eliminar(oid_c) {
            console.log("Borrado: " + oid_c);
            document.getElementById("OID_C-eliminar").value = oid_c;
            console.log(document.getElementById("OID_C-eliminar").value);
            document.getElementById("eliminar_cita").submit();
        }
    </script>
</head>
<body>
    <?php
    include_once("../header.php");
    include_once("../navbar.php");
    ?>
    <main>

        <div style=" margin-left: -0.6%; margin-right: -0.6%;">
            <table>
                <caption>Lista de Citas</caption>
                <tr>
                    <th>DNI</th>
                    <th>Voluntario</th>
                    <th>Fecha</th>
                    <th>Objetivo</th>
                    <th>Opciones</th>
                </tr>
                <?php
                foreach ($filas as $fila) {
                    $f = fechasCita($conexion, $fila["OID_C"]);
                    $f2 = implode("|", $f);
                    $arrayFecha = explode("|", $f2);
                    ?>
                    <form method="post" action="../../vista/mostrar/mostrar_cita.php">
                        <article class="cita">
                            <div class="fila_cita">
                                <div class="datos_cita">
                                    <tr>
                                        <td><?php echo $fila["DNI"]; ?></td>
                                        <td><?php echo $fila["NOMBREV"]; ?></td>
                                        <td id="<?php echo $fila["OID_C"]; ?>-FECHACITA"><?php echo $fila["FECHACITA"]; ?></td>
                                        <td><?php echo $fila["OBJETIVO"]; ?></td>
                                        <td id="<?php echo $fila["OID_C"]; ?>-EDITAROFF"><button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['OID_C']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['OID_C']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["OID_C"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['OID_C']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['OID_C']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
                                        </td>
                                    </tr>
                                    <input id="DNI" name="DNI" value="<?php echo $fila["DNI"]; ?>" type="hidden" />

                                    <input id="NOMBREV" name="NOMBREV" value="<?php echo $fila["NOMBREV"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila["OID_C"]; ?>-OLDFECHACITA" name="OLDFECHACITA" value="<?php echo $fila["FECHACITA"]; ?>" type="hidden" />
                                    <input id="<?php echo $fila["OID_C"]; ?>-FECHACITA2" name="FECHACITA" value="<?php echo $arrayFecha[0]; ?>" type="hidden" />

                                    <input id="OBJETIVO" name="OBJETIVO" value="<?php echo $fila["OBJETIVO"]; ?>" type="hidden" />

                                    <input id="OBSERVACIONES" name="OBSERVACIONES" value="<?php echo $fila["OBSERVACIONES"]; ?>" type="hidden" />

                                    <input id="oid_c" name="oid_c" value="<?php echo $fila["OID_C"]; ?>" type="hidden" />

                                </div>
                        </article>
                    </form>
                <?php
            } ?>

            </table>
        </div>
        <nav>

        <form id="eliminar_cita" action="../../controlador/eliminaciones/elimina_cita.php" method="POST">
            <input id="OID_C-eliminar" name="oid_c" type="hidden" />
        </form>

            <div class="enlaces">
                <?php
                for ($pagina = 1; $pagina <= $total_paginas; $pagina++)

                    if ($pagina == $pagina_seleccionada) {     ?>

                    <span class="current"><?php echo $pagina; ?></span>
                <?php
            } else { ?>
                    <a href="lista_cita.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
                <?php
            } ?>
            </div>

            <div class="mostrando">
                <form method="get" action="lista_cita.php">

                    <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />

                    Mostrando

                    <input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam; ?>" autofocus="autofocus" />

                    entradas de <?php echo $total_registros ?>

                    <input type="submit" style="float: none" value="Cambiar">

                </form>
            </div>
        </nav>
    </main>
    <?php
    include_once("../footer.php");
    ?>

</body>

</html>