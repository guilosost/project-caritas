<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_usuarios.php");
require_once(VISTA . "/paginacion_consulta.php");

$conexion = crearConexionBD();
unset($_SESSION["formulario_usuario"]);
if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

$usuario["dni"] = "";
$usuario["solicitante"] = "";
$_SESSION["usuario"] = $usuario;

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <script type="text/javascript" src="./js/boton.js"></script> -->
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <title>Lista de Usuarios</title>
</head>
<script>
        function editar(dni) {
            console.log("Dentro");
            console.log(dni + "-DNI");
            

    /*     <input id="APELLIDOS" name="APELLIDOS" value=" echo $fila["APELLIDOS"]; ?>" type="text" />
     <input id="NOMBRE" name="NOMBRE" value="echo $fila["NOMBRE"]; ?>" type="text" />
    <input id="TELEFONO" name="TELEFONO" value=" echo $fila["TELEFONO"]; ?>" type="text" />
    <input id="INGRESOS" name="INGRESOS" value=" echo $fila["INGRESOS"]; ?>" type="text" />
<input id="SITUACIONLABORAL" name="SITUACIONLABORAL" value=" echo $fila["SITUACIONLABORAL"]; ?>" type="text" /> */

            document.getElementById(dni + "-apellidos").innerHTML = "";
            document.getElementById(dni + "-nombre").innerHTML = "";
            document.getElementById(dni + "-telefono").innerHTML = "";
            document.getElementById(dni + "-ingresos").innerHTML = "";
            document.getElementById(dni + "-sitlaboral").innerHTML = "";
            document.getElementById(dni + "-fechanac").innerHTML = "";
            document.getElementById(dni + "-solicitante").innerHTML = "";
        }

        function eliminar(dni, sol) {
            console.log("Borrado: " + dni + ", sol: " + sol);
            document.getElementById("DNI-eliminar").value = dni;
            document.getElementById("SOLICITANTE-eliminar").value = sol;
            console.log(document.getElementById("DNI-eliminar").value);
            console.log(document.getElementById("SOLICITANTE-eliminar").value);
            document.getElementById("eliminar_usuario").submit();
        }
    </script>
<body>
    <?php
    include_once("../header.php");
    include_once("../navbar.php");
    ?>
    <main>

        <div style=" margin-left: -0.6%; margin-right: -0.6%;">
            <table style="width:100%">
                <caption>Lista de Usuarios</caption>
                <tr>
                    <th>DNI</th>
                    <th>Apellidos</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Ingresos</th>
                    <th>Situación laboral</th>
                    <th>Fecha de nacimiento</th>
                    <th>Solicitante</th>
                    <th>Opciones</th>
                </tr>

                <?php

                foreach ($filas as $fila) {

                    $f = fechasUsuario($conexion, $fila["DNI"]);
                    $f2 = implode("|", $f);
                    $arrayFecha = explode("|", $f2);


                    ?>

                    <form id="formulario" method="post" action="../../vista/mostrar/mostrar_usuario.php">
                        <article class="usuario">
                            <div class="fila_usuario">
                                <div class="datos_usuario">
                                    <tr>
                                        <td id="<?php echo $fila["DNI"]; ?>-DNI"><?php echo $fila["DNI"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-apellidos"><?php echo $fila["APELLIDOS"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-nombre"><?php echo $fila["NOMBRE"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-telefono"><?php echo $fila["TELEFONO"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-ingresos"><?php echo $fila["INGRESOS"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-sitlaboral"><?php echo $fila["SITUACIONLABORAL"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-fechanac"><?php echo $arrayFecha[0]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-solicitante"><?php echo $fila["SOLICITANTE"]; ?></td>
                                        <td>
                                            <button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['DNI']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de mostrar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['DNI']; ?>', '<?php echo $fila['SOLICITANTE']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de mostrar"></a>
                                        </td>
                                    </tr>

                                    <input id="DNI" name="DNI" value="<?php echo $fila["DNI"]; ?>" type="hidden" />

                                    <input id="APELLIDOS" name="APELLIDOS" value="<?php echo $fila["APELLIDOS"]; ?>" type="hidden" />

                                    <input id="NOMBRE" name="NOMBRE" value="<?php echo $fila["NOMBRE"]; ?>" type="hidden" />

                                    <input id="TELEFONO" name="TELEFONO" value="<?php echo $fila["TELEFONO"]; ?>" type="hidden" />

                                    <input id="INGRESOS" name="INGRESOS" value="<?php echo $fila["INGRESOS"]; ?>" type="hidden" />

                                    <input id="SITUACIONLABORAL" name="SITUACIONLABORAL" value="<?php echo $fila["SITUACIONLABORAL"]; ?>" type="hidden" />

                                    <input id="ESTUDIOS" name="ESTUDIOS" value="<?php echo $fila["ESTUDIOS"]; ?>" type="hidden" />

                                    <input id="GENERO" name="GENERO" value="<?php echo $fila["SEXO"]; ?>" type="hidden" />

                                    <input id="FECHANAC" name="FECHANAC" value="<?php echo $arrayFecha[0]; ?>" type="hidden" />

                                    <input id="PROTECCIONDATOS" name="PROTECCIONDATOS" value="<?php echo $fila["PROTECCIONDATOS"]; ?>" type="hidden" />

                                    <input id="SOLICITANTE" name="SOLICITANTE" value="<?php echo $fila["SOLICITANTE"]; ?>" type="hidden" />

                                    <input id="PARENTESCO" name="PARENTESCO" value="<?php echo $fila["PARENTESCO"]; ?>" type="hidden" />

                                    <input id="MINUSVALIA" name="MINUSVALIA" value="<?php echo $fila["MINUSVALIA"]; ?>" type="hidden" />

                                    <input id="DNI_SO" name="DNI_SO" value="<?php echo $fila["DNI_SO"]; ?>" type="hidden" />

                                    <?php
                                    $uf = unidadfamiliar_solicitante($conexion, $fila["OID_UF"]); ?>

                                    <input id="oid_uf" name="oid_uf" value="<?php echo $fila["OID_UF"]; ?>" type="hidden" />
                                    <input id="poblacion" name="poblacion" value="<?php echo $uf["POBLACION"]; ?>" type="hidden" />
                                    <input id="domicilio" name="domicilio" value="<?php echo $uf["DOMICILIO"]; ?>" type="hidden" />
                                    <input id="codigopostal" name="codigopostal" value="<?php echo $uf["CODIGOPOSTAL"]; ?>" type="hidden" />
                                    <input id="gastosfamilia" name="gastosfamilia" value="<?php echo $uf["GASTOSFAMILIA"]; ?>" type="hidden" />

                                </div>
                        </article>
                    </form>
                <?php
            } ?>

            </table>
        </div>
        <form id="eliminar_usuario" action="../../controlador/eliminaciones/elimina_usuario.php" method="POST">
        <input id="DNI-eliminar" name="dni" type="hidden" />
        <input id="SOLICITANTE-eliminar" name="solicitante" type="hidden" />
        </form>

        <nav>
            <div class="enlaces">
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

            <div class="mostrando">
                <form method="get" action="lista_usuario.php">

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