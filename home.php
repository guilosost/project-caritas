<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" type="text/css" href="prueba.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proyecto Cáritas</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png" />

</head>

<body background="background.png">
    <?php include("cabecera.php") ?>

    <div class="form">
        <h2 class="form-h2">Iniciar sesión</h2>

        <form action="/action_page.php">
            <div>
                <p class="form-text">Usuario:<p>
                        <input type="text" name="user">
            </div>

            <div>
                <p class="form-text">Contraseña:<p>
                        <input type="text" name="password">
            </div>
            <a class="button" type="submit">Iniciar sesión</a>
        </form>
    </div>

    
    <?php include("footer.php") ?>

</body>

</html> 