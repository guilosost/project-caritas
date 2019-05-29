<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/project-caritas/rutas.php');
require_once(MODELO . "/gestionBD.php");
?>
<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Sobre nosotros</title>
    <link rel="shortcut icon" type="image/png" href="../../vista/img/favicon.png" />

	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="js/reveal.js/css/reset.css">
	<link rel="stylesheet" href="js/reveal.js/css/reveal.css">
	<link rel="stylesheet" href="js/reveal.js/css/theme/black.css" id="theme">
	<link rel="stylesheet" type="text/css" href="css/header-footer.css">
	<link rel="stylesheet" type="text/css" href="css/navbar.css">

	<!-- Theme used for syntax highlighting of code -->
	<link rel="stylesheet" href="js/reveal.js/lib/css/monokai.css">

	<!-- Printing and PDF exports -->
	<script>
		var link = document.createElement('link');
		link.rel = 'stylesheet';
		link.type = 'text/css';
		link.href = window.location.search.match(/print-pdf/gi) ? 'js/reveal.js/css/print/pdf.css' : 'js/reveal.js/css/print/paper.css';
		document.getElementsByTagName('head')[0].appendChild(link);
	</script>

	<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	<style>
		.topnav {
			margin-top: 13px;
			margin-bottom: -50px;
		}

		header {
			margin-top: 0;
			line-height: initial;
		}

		.logo-izq {
			padding-left: 8px;
		}

		.logo-dch {
			padding-right: 8px;
		}

		.reveal .progress {
			position: unset;
		}

		.reveal .controls {
			bottom: 11%;
		}
	</style>
</head>

<body onload="document.getElementById('theme').setAttribute('href','js/reveal.js/css/theme/league.css');">
	<?php
	include(VISTA . "header.php");
	include(VISTA . "navbar.php");
	?>
	<div class="reveal">

		<!-- Any section element inside of this container is displayed as a slide -->
		<div class="slides">
			<section>
				<h1>Project-Cáritas</h1>
				<h3>Sobre nosotros</h3>
				<p>
					<small>Created by <a href="http://hakim.se">Hakim El Hattab</a> and <a href="https://github.com/hakimel/reveal.js/graphs/contributors">contributors</a></small>
				</p>
			</section>

			<section>
				<section id="fragments">
					<h2>Formado por:</h2>
					<p class="fragment">Gonzalo Álvarez García</p>
					<p class="fragment">Guillermo Losada Ostos</p>
					<p class="fragment">Enrique Merino Valverde</p>
					<p class="fragment">Miguel Yanes Ariza</p>
				</section>
				<section>
					<h2>¿Quiénes somos?</h2>
					<p>Alumnos en pos de entender los entresijos de la informática e intentado aprobar IISSI con la mejor nota posible.</p>
				</section>
			</section>

			<section>
				<section>
					<h2>Origen</h2>
					<p>Este proyecto parte de la asignatura Introducción a la Ingeniería Informática del Software, impartida
						en la Escuela Superior de Ingeniería Informática de la Universidad de Sevilla.</p>
				</section>
				<section>
					<h2>¿El objetivo?</h2>
					<p>Crear una base de datos operativa en Oracle SQL Developer para finalmente hacer uso de ella a través
						de distintas funciones y procedimientos tanto de PHP como de JavaScript.</p>
					<a href="#" class="navigate-down">¿Te interesa?<br>
						<img width="17" height="23" data-src="http://localhost:81/project-caritas/vista/img/low_arrow.png" alt="Down arrow">
					</a>
				</section>
				<section data-background-iframe="https://www.informatica.us.es/" data-background-interactive>
				</section>
			</section>
			<section>
				<section>
					<h2>Desarrollo</h2>
					<p>Este proyecto sentó sus bases gracias a los contactos de Enrique Merino con la parroquia de San Juan de Aznalfarache.
						A través de varias reuniones con nuestro cliente en la parroquia pudimos modelar la base de datos en SQL, evaluada en
						el 1<sup>er</sup> cuatrimestre de la asignatura.
					</p>
				</section>
				<section>
					<h2>Desarrollo</h2>
					<p>En la actualidad el proyecto está finalizado, presentando una maravillosa interfaz de usuario con la que poder interactuar
						de forma fácil, sencilla e intuitiva con los numerosos elementos de la base de datos.
					</p>
				</section>
			</section>

			<section data-background="http://localhost:81/project-caritas/vista/img/Caritas.png">
			</section>
		</div>

	</div>

	<script src="js/reveal.js/js/reveal.js"></script>

	<script>
		// More info https://github.com/hakimel/reveal.js#configuration
		Reveal.initialize({
			controls: true,
			progress: true,
			center: true,
			hash: true,

			transition: 'slide', // none/fade/slide/convex/concave/zoom

			// More info https://github.com/hakimel/reveal.js#dependencies
			dependencies: [{
					src: 'js/reveal.js/plugin/markdown/marked.js',
					condition: function() {
						return !!document.querySelector('[data-markdown]');
					}
				},
				{
					src: 'js/reveal.js/plugin/markdown/markdown.js',
					condition: function() {
						return !!document.querySelector('[data-markdown]');
					}
				},
				{
					src: 'js/reveal.js/plugin/highlight/highlight.js',
					async: true
				},
				{
					src: 'js/reveal.js/plugin/search/search.js',
					async: true
				},
				{
					src: 'js/reveal.js/plugin/zoom-js/zoom.js',
					async: true
				},
				{
					src: 'js/reveal.js/plugin/notes/notes.js',
					async: true
				}
			]
		});
	</script>

</body>

</html>