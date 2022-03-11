<!DOCTYPE html>
<html lang="es">

<head>
    <title>Fase 3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<body>

    <header>
        <h1>Estadísticas de Videojuegos</h1>
    </header>

    <nav>
        <?php
        echo '<a href="?link=datos" name="datos">Consulta de datos</a>';
        if (isset($_SESSION["sesionIniciada"])) {
            echo '<a href="?link=insertar" name="insertar">Inserción de datos</a>';
            echo '<a href="?link=mod" name="mod">Modificar datos</a>';
            echo '<a href="?link=delete" name="delete">Borrar entrada</a>';
        } else {
            echo '<a href="?link=login" class="Login" name="login">Login</a>';
        }
        ?>
    </nav>

    <main>
        <section>