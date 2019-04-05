<?php
//ARREGLAR QUE NO SALEN LOS ICONOS BIEN Y QUE LOS LINKS DEL NAVBAR NO VAN
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/header-footer.css">
    <link rel="stylesheet" type="text/css" href="css/button.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
</head>
<body background="img/background.png">
<?php
    include_once($_SERVER['DOCUMENT_ROOT'].'/project-caritas/rutas.php');
    include(VISTA."/header.php");
    include(VISTA."/navbar.php");
?>

 <?php
    include(VISTA."/footer.php");
?>
</body>

</html>