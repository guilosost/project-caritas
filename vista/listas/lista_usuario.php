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
$_SESSION["usuario-eliminar"] = $usuario;

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
        console.log(dni + "-PERMISO");
        document.getElementById(dni + "-EDITAROFF").classList.add("hide");
        document.getElementById(dni + "-EDITARON").classList.remove("hide");
        var apellidos = document.getElementById(dni + "-apellidos").innerHTML;
        var nombre = document.getElementById(dni + "-nombre").innerHTML;
        var telefono = document.getElementById(dni + "-telefono").innerHTML;
        var ingresos = document.getElementById(dni + "-ingresos").innerHTML;

        var s = document.getElementById(dni + "-solicitante").innerHTML;
        var sitlaboral = '<select class="celda" id="SOLICITANTEPREV" size=1>' +
            '<option value="Sí"';
        if (s == "Sí") {sitlaboral = sitlaboral + " selected";}
        sitlaboral = sitlaboral + '>Sí</option><option value="No"';
        if (s == "No ") {sitlaboral = sitlaboral + " selected";}

        sitlaboral = sitlaboral + '>No</option>';
        document.getElementById(dni + "-apellidos").innerHTML = '<input class="editcelda" id="APELLIDOSPREV" type="text" maxlength="13" value="' + apellidos + '" />';
        document.getElementById(dni + "-nombre").innerHTML = '<input class="editcelda" id="NOMBREPREV" type="text" maxlength="13" value="' + nombre + '" />';
        document.getElementById(dni + "-telefono").innerHTML = '<input class="editcelda" id="TELEFONOPREV" type="text" maxlength="13" value="' + telefono + '" />';
        document.getElementById(dni + "-ingresos").innerHTML = '<input class="editcelda" id="INGRESOSPREV" type="text" maxlength="13" value="' + ingresos + '" />';
        document.getElementById(dni + "-solicitante").innerHTML = sitlaboral;
    }

    function mandar(dni) {
        var f = document.createElement("form");
        f.setAttribute('method', "post");
        f.setAttribute('id', "edicion_dinamica");
        f.setAttribute('class', "hide");
        f.setAttribute('action', "../../controlador/acciones/accion_voluntario.php");

        var i = document.createElement("input"); //input element, text
        i.setAttribute('type', "text");
        i.setAttribute('name', "permiso");
        i.setAttribute('id', "permiso_din");
        var valorPermiso = document.getElementById("PERMISOPREV").value;
        f.appendChild(i);

        var j = document.createElement("input");
        j.setAttribute('type', "text");
        j.setAttribute('name', "nombrev");
        j.setAttribute('id', "nombrev_din");
        f.appendChild(j);

        document.getElementsByTagName('body')[0].appendChild(f);
        document.getElementById("nombrev_din").value = nombrev;
        document.getElementById("permiso_din").value = valorPermiso;

        console.log(document.getElementById("nombrev_din").value)
        console.log(document.getElementById("permiso_din").value)
        //document.getElementById("edicion_dinamica").submit();
    }

    function cancelar(dni) {
        console.log("Cancelando");
        console.log(dni);
        document.getElementById(dni + "-EDITARON").classList.add("hide");
        document.getElementById(dni + "-EDITAROFF").classList.remove("hide");
        var apellidos = document.getElementById(dni + "-OLDAPELLIDOS").value;
        var nombre = document.getElementById(dni + "-OLDNOMBRE").value;
        var telefono = document.getElementById(dni + "-OLDTELEFONO").value;
        var ingresos = document.getElementById(dni + "-OLDINGRESOS").value;
        var sitlaboral = document.getElementById(dni + "-OLDSITUACIONLABORAL").value;
        var fechanac = document.getElementById(dni + "-OLDFECHANAC").value;
        var solicitante = document.getElementById(dni + "-OLDSOLICITANTE").value;
        document.getElementById(dni + "-apellidos").innerHTML = apellidos;
        document.getElementById(dni + "-nombre").innerHTML = nombre;
        document.getElementById(dni + "-telefono").innerHTML = telefono;
        document.getElementById(dni + "-ingresos").innerHTML = ingresos;
        document.getElementById(dni + "-sitlaboral").innerHTML = sitlaboral;
        document.getElementById(dni + "-fechanac").innerHTML = fechanac;
        document.getElementById(dni + "-solicitante").innerHTML = solicitante;
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
                                        <td><?php echo $fila["DNI"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-apellidos"><?php echo $fila["APELLIDOS"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-nombre"><?php echo $fila["NOMBRE"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-telefono"><?php echo $fila["TELEFONO"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-ingresos"><?php echo $fila["INGRESOS"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-sitlaboral"><?php echo $fila["SITUACIONLABORAL"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-fechanac"><?php echo $arrayFecha[0]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-solicitante"><?php echo $fila["SOLICITANTE"]; ?></td>
                                        <td id="<?php echo $fila["DNI"]; ?>-EDITAROFF">
                                            <button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a class="botonTabla" type=edit onclick="editar('<?php echo $fila['DNI']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de mostrar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['DNI']; ?>', '<?php echo $fila['SOLICITANTE']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de mostrar"></a>
                                        </td>
                                        <td id="<?php echo $fila["DNI"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['DNI']; ?>')">SÍ</a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['DNI']; ?>')">NO</a>
                                        </td>
                                    </tr>

                                    <input id="DNI" name="DNI" value="<?php echo $fila["DNI"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDAPELLIDOS" name="APELLIDOS" value="<?php echo $fila["APELLIDOS"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDNOMBRE" name="NOMBRE" value="<?php echo $fila["NOMBRE"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDTELEFONO" name="TELEFONO" value="<?php echo $fila["TELEFONO"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDINGRESOS" name="INGRESOS" value="<?php echo $fila["INGRESOS"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDSITUACIONLABORAL" name="SITUACIONLABORAL" value="<?php echo $fila["SITUACIONLABORAL"]; ?>" type="hidden" />

                                    <input id="ESTUDIOS" name="ESTUDIOS" value="<?php echo $fila["ESTUDIOS"]; ?>" type="hidden" />

                                    <input id="GENERO" name="GENERO" value="<?php echo $fila["SEXO"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDFECHANAC" name="FECHANAC" value="<?php echo $arrayFecha[0]; ?>" type="hidden" />

                                    <input id="PROTECCIONDATOS" name="PROTECCIONDATOS" value="<?php echo $fila["PROTECCIONDATOS"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-OLDSOLICITANTE" name="SOLICITANTE" value="<?php echo $fila["SOLICITANTE"]; ?>" type="hidden" />

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