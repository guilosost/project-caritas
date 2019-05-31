<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/GestionBD.php");
require_once(GESTIONAR . "gestionar_usuarios.php");
require_once(VISTA . "/paginacion_consulta.php");

$conexion = crearConexionBD();
if (is_null($_SESSION["nombreusuario"]) or empty($_SESSION["nombreusuario"])) {
    Header("Location: ../../controlador/acceso/login.php");
}

unset($_SESSION["formulario_usuario"]);
unset($_SESSION["usuario"]);

$usuario["dni"] = "";
$usuario["nombre"] = "";
$usuario["apellidos"] = "";
$usuario["telefono"] = "";
$usuario["ingresos"] = "";
$usuario["sitlaboral"] = "";
$usuario["solicitante"] = "";
$_SESSION["usuario-eliminar"] = $usuario;
$_SESSION["usuario-editar"] = $usuario;

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
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />
    <title>Lista de Usuarios</title>
</head>
<script>
    function editar(dni) {
        document.getElementsByName("editares").forEach(function(x) {
            x.classList.add("hide");
        });
        document.getElementsByName("ths").forEach(function(y) {
            y.classList.add("less_padding");
        });
        document.getElementsByName("tds").forEach(function(z) {
            z.classList.add("less_padding");
        });
    
        console.log("Dentro");
        console.log(dni + "-PERMISO");
        document.getElementById(dni + "-EDITAROFF").classList.add("hide");
        document.getElementById(dni + "-EDITARON").classList.remove("hide");
        var apellidos = document.getElementById(dni + "-apellidos").innerHTML;
        var nombre = document.getElementById(dni + "-nombre").innerHTML;
        var telefono = document.getElementById(dni + "-telefono").innerHTML;
        var ingresos = document.getElementById(dni + "-ingresos").innerHTML;

        var s = document.getElementById(dni + "-sitlaboral").innerHTML;
        var sitlaboral = '<select class="celda" id="SITLABORALPREV" size=1>' +
            '<option value="No es relevante"';
        if (s == "No es relevante") {
            sitlaboral = sitlaboral + " selected";
        }
        sitlaboral = sitlaboral + '>No es relevante</option><option value="En paro"';
        if (s == "En paro") {
            sitlaboral = sitlaboral + " selected";
        }
        sitlaboral = sitlaboral + '>En paro</option><option value="Trabajando"';
        if (s == "Trabajando") {
            sitlaboral = sitlaboral + " selected";
        }

        sitlaboral = sitlaboral + '>Trabajando</option>';
        document.getElementById(dni + "-apellidos").innerHTML = '<input class="editcelda" id="APELLIDOSPREV" type="text" maxlength="20" value="' + apellidos + '" />';
        document.getElementById(dni + "-nombre").innerHTML = '<input class="editcelda" id="NOMBREPREV" type="text" maxlength="13" value="' + nombre + '" />';
        document.getElementById(dni + "-telefono").innerHTML = '<input class="editcelda" id="TELEFONOPREV" type="text" maxlength="9" value="' + telefono + '" />';
        document.getElementById(dni + "-ingresos").innerHTML = '<input class="editcelda" id="INGRESOSPREV" type="text" maxlength="3" value="' + ingresos + '" />';
        document.getElementById(dni + "-sitlaboral").innerHTML = sitlaboral;
    }

    function mandar(dni) {
        var f = document.createElement("form");
        f.setAttribute('method', "post");
        f.setAttribute('id', "edicion_dinamica");
        f.setAttribute('class', "hide");
        f.setAttribute('action', "../../controlador/acciones/accion_usuario.php");

        var i = document.createElement("input"); //input element, text
        i.setAttribute('type', "text");
        i.setAttribute('name', "apellidos");
        i.setAttribute('id', "apellidos_din");
        var valorApellidos = document.getElementById("APELLIDOSPREV").value;
        f.appendChild(i);

        var j = document.createElement("input");
        j.setAttribute('type', "text");
        j.setAttribute('name', "nombre");
        j.setAttribute('id', "nombre_din");
        var valorNombre = document.getElementById("NOMBREPREV").value;
        f.appendChild(j);

        var k = document.createElement("input");
        k.setAttribute('type', "text");
        k.setAttribute('name', "telefono");
        k.setAttribute('id', "telefono_din");
        var valorTelefono = document.getElementById("TELEFONOPREV").value;
        f.appendChild(k);

        var l = document.createElement("input");
        l.setAttribute('type', "text");
        l.setAttribute('name', "ingresos");
        l.setAttribute('id', "ingresos_din");
        var valorIngresos = document.getElementById("INGRESOSPREV").value;
        f.appendChild(l);

        var m = document.createElement("input");
        m.setAttribute('type', "text");
        m.setAttribute('name', "sitlaboral");
        m.setAttribute('id', "sitlaboral_din");
        var valorSitlaboral = document.getElementById("SITLABORALPREV").value;
        f.appendChild(m);

        var d = document.createElement("input");
        d.setAttribute('type', "text");
        d.setAttribute('name', "dni");
        d.setAttribute('id', "dni_din");
        f.appendChild(d);

        var s = document.createElement("input");
        s.setAttribute('type', "text");
        s.setAttribute('name', "solicitante");
        s.setAttribute('id', "solicitante_din");
        solicitante = document.getElementById(dni + "-SOLICITANTE").value;
        f.appendChild(s);

        document.getElementsByTagName('body')[0].appendChild(f);
        document.getElementById("apellidos_din").value = valorApellidos;
        document.getElementById("nombre_din").value = valorNombre;
        document.getElementById("telefono_din").value = valorTelefono;
        document.getElementById("ingresos_din").value = valorIngresos;
        document.getElementById("sitlaboral_din").value = valorSitlaboral;
        document.getElementById("dni_din").value = dni;
        document.getElementById("solicitante_din").value = solicitante;
        minusvalia = document.getElementById(dni + "-MINUSVALIA").value;

        console.log(document.getElementById("apellidos_din").value);
        console.log(document.getElementById("nombre_din").value);
        console.log(document.getElementById("telefono_din").value);
        console.log(document.getElementById("ingresos_din").value);
        console.log(document.getElementById("sitlaboral_din").value);
        console.log(document.getElementById("dni_din").value);
        console.log(document.getElementById("solicitante_din").value);

        let regex = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
        let regex2 = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
        
        if (valorApellidos.length == 0) {
            alert("Introduzca los apellidos.");
        } else if (!regex.exec(valorApellidos)) {
            alert('Los apellidos deben contener letras y espacios.');
        
        } else if (valorNombre.length == 0) {
            alert('Introduzca el nombre.');
        } else if (!regex2.exec(valorNombre)) {
            alert('El nombre debe contener letras y espacios.');
        
        } else if (valorTelefono.length == 0 || !(valorTelefono.length == 9)) {
            alert('Introduzca un número de teléfono.');
        } else if (isNaN(valorTelefono) || valorTelefono[0] === '-' || valorTelefono[0] === '+') {
            alert('El teléfono debe contener solo números.');
        
        } else if (valorIngresos.length == 0) {
            alert('Introduzca los ingresos');
        } else if (isNaN(valorIngresos) || valorIngresos[0] === '-' || valorIngresos[0] === '+') {
            alert('Los ingresos deben contener solo números.');
        } else if (valorSitlaboral === "En paro" && !(valorIngresos === "672")) {
            alert("Los ingresos no son los esperados estando en paro.");
        } else if (minusvalia === 'Sí' && !(valorIngresos > 0)) {
            alert("Los ingresos no son los esperados ya que el usuario presenta una minusvalía.")
        
        } else {
            document.getElementById("edicion_dinamica").submit();
        }
    }

    function cancelar(dni) {
        document.getElementsByName("editares").forEach(function(x) {
            x.classList.remove("hide");
        });
        document.getElementsByName("ths").forEach(function(y) {
            y.classList.remove("less_padding");
        });
        document.getElementsByName("tds").forEach(function(z) {
            z.classList.remove("less_padding");
        });

        console.log("Cancelando");
        console.log(dni);
        document.getElementById(dni + "-EDITARON").classList.add("hide");
        document.getElementById(dni + "-EDITAROFF").classList.remove("hide");
        var apellidos = document.getElementById(dni + "-OLDAPELLIDOS").value;
        var nombre = document.getElementById(dni + "-OLDNOMBRE").value;
        var telefono = document.getElementById(dni + "-OLDTELEFONO").value;
        var ingresos = document.getElementById(dni + "-OLDINGRESOS").value;
        var sitlaboral = document.getElementById(dni + "-OLDSITUACIONLABORAL").value;
        document.getElementById(dni + "-apellidos").innerHTML = apellidos;
        document.getElementById(dni + "-nombre").innerHTML = nombre;
        document.getElementById(dni + "-telefono").innerHTML = telefono;
        document.getElementById(dni + "-ingresos").innerHTML = ingresos;
        document.getElementById(dni + "-sitlaboral").innerHTML = sitlaboral;
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
            <table>
                <caption>Lista de Usuarios</caption>
                <tr>
                    <th name="ths">DNI</th>
                    <th name="ths">Apellidos</th>
                    <th name="ths">Nombre</th>
                    <th name="ths">Teléfono</th>
                    <th name="ths">Ingresos</th>
                    <th name="ths">Situación laboral</th>
                    <th name="ths">Fecha de nacimiento</th>
                    <th name="ths">Solicitante</th>
                    <th name="ths">Opciones</th>
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
                                        <td name="tds"><?php echo $fila["DNI"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-apellidos"><?php echo $fila["APELLIDOS"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-nombre"><?php echo $fila["NOMBRE"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-telefono"><?php echo $fila["TELEFONO"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-ingresos"><?php echo $fila["INGRESOS"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-sitlaboral"><?php echo $fila["SITUACIONLABORAL"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-fechanac"><?php echo $arrayFecha[0]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-solicitante"><?php echo $fila["SOLICITANTE"]; ?></td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-EDITAROFF">
                                            <button id="mostrar" class="botonTabla" onclick="mandar(this)"><img src="http://localhost:81/project-caritas/vista/img/icono_lupa(40x36).png" alt="icono de mostrar"></button>
                                            <a name="editares" class="botonTabla" type=edit onclick="editar('<?php echo $fila['DNI']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="eliminar('<?php echo $fila['DNI']; ?>', '<?php echo $fila['SOLICITANTE']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_delete(40x36).png" alt="icono de borrar"></a>
                                        </td>
                                        <td name="tds" id="<?php echo $fila["DNI"]; ?>-EDITARON" class="hide">
                                            <a class="botonTabla" type=edit onclick="mandar('<?php echo $fila['DNI']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_lapiz(40x36).png" alt="icono de editar"></a>
                                            <a class="botonTabla" type=edit onclick="cancelar('<?php echo $fila['DNI']; ?>')"><img src="http://localhost:81/project-caritas/vista/img/icono_cancel(40x36).png" alt="icono de cancelar"></a>
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

                                    <input id="<?php echo $fila['DNI']; ?>-SOLICITANTE" name="SOLICITANTE" value="<?php echo $fila["SOLICITANTE"]; ?>" type="hidden" />

                                    <input id="PARENTESCO" name="PARENTESCO" value="<?php echo $fila["PARENTESCO"]; ?>" type="hidden" />

                                    <input id="<?php echo $fila['DNI']; ?>-MINUSVALIA" name="MINUSVALIA" value="<?php echo $fila["MINUSVALIA"]; ?>" type="hidden" />

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