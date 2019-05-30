<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_ayudas.php");
require_once(VISTA . "/paginacion_consulta.php");

$conexion = crearConexionBD();
unset($_SESSION["formulario_ayuda"]);

if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
    unset($_SESSION["usuario"]);
}


$ayuda["oid_a"] = "";
$ayuda["concedida"] = "";
$_SESSION["ayuda-eliminar"] = $ayuda;
$_SESSION["ayuda-editar"] = $ayuda;

// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
// ¿Hay una sesión activa?

if (!isset($tipo_ayuda))
    $tipo_ayuda = "todo";

if (isset($_SESSION["paginacion"]))
    $paginacion = $_SESSION["paginacion"];

$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);
$tipo_ayuda = isset($_GET["tipoayuda"]) ? (string)$_GET["tipoayuda"] : (isset($paginacion) ? (string)$paginacion["tipoayuda"] : "todo");

if ($pagina_seleccionada < 1)         $pagina_seleccionada = 1;
if ($pag_tam < 1)         $pag_tam = 5;

// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
unset($_SESSION["paginacion"]);

$conexion = crearConexionBD();

// La consulta que ha de paginarse

$query = 'SELECT * '
    . 'FROM AYUDAS';

$queryComida = 'SELECT * '
    . 'FROM AYUDAS JOIN COMIDAS ON ayudas.oid_a = comidas.oid_a ';

$queryEconomica = 'SELECT * '
    . 'FROM AYUDAS JOIN AYUDASECONOMICAS ON ayudas.oid_a = ayudaseconomicas.oid_a ';

$queryTrabajo = 'SELECT * '
    . 'FROM AYUDAS JOIN TRABAJOS ON ayudas.oid_a = trabajos.oid_a ';


// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
$total_registros_ayudas = total_consulta($conexion, $query);
$total_registros = (int)($total_registros_ayudas);
$total_paginas = (int)($total_registros / $pag_tam);

if ($total_registros % $pag_tam > 0)        $total_paginas++;

if ($pagina_seleccionada > $total_paginas)        $pagina_seleccionada = $total_paginas;

// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
$paginacion["PAG_NUM"] = $pagina_seleccionada;
$paginacion["PAG_TAM"] = $pag_tam;
$paginacion["tipoayuda"] = $tipo_ayuda;
$_SESSION["paginacion"] = $paginacion;

$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
$filasComida = consulta_paginada($conexion, $queryComida, $pagina_seleccionada, $pag_tam);
$filasEconomica = consulta_paginada($conexion, $queryEconomica, $pagina_seleccionada, $pag_tam);
$filasTrabajo = consulta_paginada($conexion, $queryTrabajo, $pagina_seleccionada, $pag_tam);


if ($paginacion["tipoayuda"] == "bolsacomida") {
    $filas = $filasComida;
    $total_registros_ayudas = total_consulta($conexion, $queryComida);
    $total_registros = (int)($total_registros_ayudas);
    $total_paginas = (int)($total_registros / $pag_tam);

    if ($total_registros % $pag_tam > 0)        $total_paginas++;
    if ($pagina_seleccionada > $total_paginas)        $pagina_seleccionada = $total_paginas;

} else if ($paginacion["tipoayuda"] == "ayudaeconomica") {
    $filas = $filasEconomica;
    $total_registros_ayudas = total_consulta($conexion, $queryEconomica);
    $total_registros = (int)($total_registros_ayudas);
    $total_paginas = (int)($total_registros / $pag_tam);

    if ($total_registros % $pag_tam > 0)        $total_paginas++;
    if ($pagina_seleccionada > $total_paginas)        $pagina_seleccionada = $total_paginas;

} else if ($paginacion["tipoayuda"] == "trabajo") {
    $filas = $filasTrabajo;
    $total_registros_ayudas = total_consulta($conexion, $queryTrabajo);
    $total_registros = (int)($total_registros_ayudas);
    $total_paginas = (int)($total_registros / $pag_tam);

    if ($total_registros % $pag_tam > 0)        $total_paginas++;
    if ($pagina_seleccionada > $total_paginas)        $pagina_seleccionada = $total_paginas;

}

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
    <title>Lista de Ayudas</title>
    <script>
        function submit() {
            document.forms["filtro"].submit();
        }
        
        function editar(oid_a) {
            console.log("Dentro");
            console.log(oid_a + "-CONCEDIDA");
            document.getElementById(oid_a + "-EDITAROFF").classList.add("hide");
            document.getElementById(oid_a + "-EDITARON").classList.remove("hide");
            var concedida = document.getElementById(oid_a).innerHTML;
            var string = '<select class="celda" id="CONCEDIDAPREV" size=1>' +
                '<option value="Sí"';

                if (concedida == "Sí") {
                string = string + " selected";
            }

            string = string + '>Sí</option><option value="No"';

            if (concedida == "No ") {
                string = string + " selected";
            }

            string = string + '>No</option>';
            document.getElementById(oid_a).innerHTML = string;
        }

        function mandar(oid_a) {
            var f = document.createElement("form");
            f.setAttribute('method', "post");
            f.setAttribute('id', "edicion_dinamica");
            f.setAttribute('class', "hide");
            f.setAttribute('action', "../../controlador/acciones/accion_ayuda.php");

            var i = document.createElement("input"); //input element, text
            i.setAttribute('type', "text");
            i.setAttribute('name', "concedida");
            i.setAttribute('id', "concedida_din");
            var valorConcedida = document.getElementById("CONCEDIDAPREV").value;
            f.appendChild(i);

            var j = document.createElement("input");
            j.setAttribute('type', "text");
            j.setAttribute('name', "oid_a");
            j.setAttribute('id', "oid_a_din");
            f.appendChild(j);

            document.getElementsByTagName('body')[0].appendChild(f);
            document.getElementById("oid_a_din").value = oid_a;
            document.getElementById("concedida_din").value = valorConcedida;

            console.log(document.getElementById("oid_a_din").value);
            console.log(document.getElementById("concedida_din").value);
            document.getElementById("edicion_dinamica").submit();
        }

        function cancelar(oid_a) {
            console.log("Cancelando");
            console.log(oid_a + "-CONCEDIDA");
            document.getElementById(oid_a + "-EDITARON").classList.add("hide");
            document.getElementById(oid_a + "-EDITAROFF").classList.remove("hide");
            var concedida = document.getElementById(oid_a + "-CONCEDIDA").value;
            document.getElementById(oid_a).innerHTML = concedida;
        }

        function eliminar(oid_a) {
            console.log("Borrado: " + oid_a);
            document.getElementById("OID_A-eliminar").value = oid_a;
            document.getElementById("eliminar_ayuda").submit();
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
            <table style="width:100%">
                <caption>Lista de Ayudas</caption>
                <tr>
                    <?php 
                    if ($paginacion["tipoayuda"] == "todo") { ?>
                        <th>Tipo</th>
                        <th>DNI</th>
                        <th>Concedida</th>
                        <th>Suministrada por</th>
                        <th>Opciones</th>
                    <?php } else if ($paginacion["tipoayuda"] == "bolsacomida") { ?>
                        <th>Tipo</th>
                        <th>DNI</th>
                        <th>Concedida</th>
                        <th>Suministrada por</th>
                        <th>Comida para bebé</th>
                        <th>Comida para niño</th>
                        <th>Opciones</th>
                    <?php } else if ($paginacion["tipoayuda"] == "ayudaeconomica") { ?>
                        <th>Tipo</th>
                        <th>DNI</th>
                        <th>Concedida</th>
                        <th>Suministrada por</th>
                        <th>Importe de la ayuda</th>
                        <th>Motivo</th>
                        <th>Prioridad</th>
                        <th>Opciones</th>
                    <?php } else { ?>
                        <th>Tipo</th>
                        <th>DNI</th>
                        <th>Concedida</th>
                        <th>Suministrada por</th>
                        <th>Empresa que contrata</th>
                        <th>Salario aproximado</th>
                        <th>Opciones</th>
                    <?php } ?>
                </tr>

                <?php
                foreach ($filas as $fila) {
                    $comida = getComida($conexion, $fila["OID_A"]);
                    $ayuda_economica = getAyudaEconomica($conexion, $fila["OID_A"]);
                    $trabajo = getTrabajo($conexion, $fila["OID_A"]);
                    $cita = getCita($conexion, $fila["OID_C"]);
                    ?>
                    <form method="post" action="../../vista/mostrar/mostrar_ayuda.php">
                        <article class="ayuda">
                            <div class="fila_ayuda">
                                <div class="datos_ayuda">

                                    <tr>
                                        <?php if ($paginacion["tipoayuda"] == "bolsacomida") {
                                            echo "<td>Comida</td>";
                                            echo "<td> " . $cita['DNI']  . "</td>";
                                            echo "<td id=". $fila['OID_A'] .">" . $fila['CONCEDIDA'] . "</td>";
                                            echo "<td>" . $fila['SUMINISTRADAPOR'] . "</td>";
                                            echo "<td>" . $comida['BEBE'] . "</td>";
                                            echo "<td>" . $comida['NIÑO'] . "</td>"; ?>
                                            <td id="<?php echo $fila["OID_A"]; ?>-EDITAROFF"><button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["OID_A"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
                                        </td>
                                       <?php } else if ($paginacion["tipoayuda"] == "ayudaeconomica") {
                                            echo "<td>Económica</td>";
                                            echo "<td> " . $cita['DNI']  . "</td>";
                                            echo "<td id=". $fila['OID_A'] .">" . $fila['CONCEDIDA'] . "</td>";
                                            echo "<td>" . $fila['SUMINISTRADAPOR'] . "</td>";
                                            echo "<td>" . $ayuda_economica['CANTIDAD'] . "</td>";
                                            echo "<td>" . $ayuda_economica['MOTIVO'] . "</td>";
                                            echo "<td>" . $ayuda_economica['PRIORIDAD'] . "</td>"; ?>
                                            <td id="<?php echo $fila["OID_A"]; ?>-EDITAROFF"><button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["OID_A"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
                                        </td>
                                       <?php } else if ($paginacion["tipoayuda"] == "trabajo") {
                                            echo "<td>Trabajo</td>";
                                            echo "<td> " . $cita['DNI']  . "</td>";
                                            echo "<td id=". $fila['OID_A'] .">" . $fila['CONCEDIDA'] . "</td>";
                                            echo "<td>" . $fila['SUMINISTRADAPOR'] . "</td>";
                                            echo "<td>" . $trabajo['EMPRESA'] . "</td>";
                                            echo "<td>" . $trabajo['SALARIOAPROXIMADO'] . "</td>"; ?>
                                            <td id="<?php echo $fila["OID_A"]; ?>-EDITAROFF"><button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["OID_A"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
                                        </td>
                                       <?php } else {
                                            if(isset($comida['BEBE'])) echo "<td>Comida</td>"; else if(isset($ayuda_economica['MOTIVO'])) echo "<td>Económica</td>"; else echo "<td>Trabajo</td>";
                                            echo "<td> " . $cita['DNI']  . "</td>";
                                            echo "<td id=". $fila['OID_A'] .">" . $fila['CONCEDIDA'] . "</td>";
                                            echo "<td>" . $fila['SUMINISTRADAPOR'] . "</td>"; ?>
                                            <td id="<?php echo $fila["OID_A"]; ?>-EDITAROFF"><button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["OID_A"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['OID_A']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
                                        </td>
                                       <?php }

                                        ?>
                                        <input id="oid_a" name="oid_a" value="<?php echo $fila["OID_A"]; ?>" type="hidden" />
                                        <input id="oid_c" name="oid_c" value="<?php echo $fila["OID_C"]; ?>" type="hidden" />

                                        <input id="<?php echo $comida["OID_A"]; ?>-CONCEDIDA" name="CONCEDIDA" value="<?php echo $fila["CONCEDIDA"]; ?>" type="hidden" />

                                        <input id="SUMINISTRADAPOR" name="SUMINISTRADAPOR" value="<?php echo $fila["SUMINISTRADAPOR"]; ?>" type="hidden" />

                                        <input id="BEBE" name="BEBE" value="<?php echo $comida["BEBE"]; ?>" type="hidden" />
                                        <input id="NIÑO" name="NIÑO" value="<?php echo $comida["NIÑO"]; ?>" type="hidden" />

                                        <input id="CANTIDAD" name="CANTIDAD" value="<?php echo $ayuda_economica["CANTIDAD"]; ?>" type="hidden" />
                                        <input id="MOTIVO" name="MOTIVO" value="<?php echo $ayuda_economica["MOTIVO"]; ?>" type="hidden" />
                                        <input id="PRIORIDAD" name="PRIORIDAD" value="<?php echo $ayuda_economica["PRIORIDAD"]; ?>" type="hidden" />

                                        <input id="DESCRIPCION" name="DESCRIPCION" value="<?php echo $trabajo["DESCRIPCION"]; ?>" type="hidden" />
                                        <input id="EMPRESA" name="EMPRESA" value="<?php echo $trabajo["EMPRESA"]; ?>" type="hidden" />
                                        <input id="SALARIOAPROXIMADO" name="SALARIOAPROXIMADO" value="<?php echo $trabajo["SALARIOAPROXIMADO"]; ?>" type="hidden" />

                                </div>
                            </div>
                        </article>
                    </form>
                <?php
            } ?>

            </table>
        </div>
        <nav>

        <form id="eliminar_ayuda" action="../../controlador/eliminaciones/elimina_ayuda.php" method="POST">
            <input id="OID_A-eliminar" name="oid_a" type="hidden" />
        </form>

            <div class="enlaces">
                <?php
                for (
                    $pagina = 1;
                    $pagina <= $total_paginas;
                    $pagina++
                )
                    if ($pagina == $pagina_seleccionada) {     ?>
                    <span class="current"><?php echo $pagina; ?></span>
                <?php
            } else { ?>
                    <a href="lista_ayuda.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
                <?php
            } ?>
            </div>

            <div class="mostrando">
                <form method="get" action="lista_ayuda.php">
                    <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />
                    Mostrando
                    <input id="PAG_TAM" name="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam; ?>" autofocus="autofocus" />
                    entradas de <?php echo $total_registros ?>
                    <input type="submit" style="float: none" value="Cambiar">
            </div>

            <div class="mostrando">
                <select class="celda" id="tipoayuda" onchange="submit()" name="tipoayuda" size=1 autofocus="autofocus" required>
                    <option value="todo" <?php if ($paginacion['tipoayuda'] == 'todo') echo ' selected '; ?>>Mostrar todo</option>
                    <option value="bolsacomida" <?php if ($paginacion['tipoayuda'] == 'bolsacomida') echo ' selected '; ?>>Bolsas de comida</option>
                    <option value="ayudaeconomica" <?php if ($paginacion['tipoayuda'] == 'ayudaeconomica') echo ' selected '; ?>>Ayudas económicas</option>
                    <option value="trabajo" <?php if ($paginacion['tipoayuda'] == 'trabajo') echo ' selected '; ?>>Propuestas de trabajo</option>
                </select>
                </form>
            </div>
        </nav>
    </main>
    <?php
    include_once("../footer.php");
    ?>

</body>

</html>