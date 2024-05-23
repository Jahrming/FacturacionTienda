<?php
    include("Conexion.php");


    $CodigoHtml= " 
    <!DOCTYPE html>
            <html lang='es'>
                    <head>
                            <script type='text/javascript' src='../js/funciones.js'> </script>
                            <script type='text/javascript' src='../js/alertify.js/lib/alertify.js'> </script>
                            <title> SISTEMA ACADEMICO </title>
                            <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
                            <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
                            <link rel='stylesheet' href='../css/estilos.css' >
                            <link rel='stylesheet' href='../css/bootstrap.min.css'>
                            <link rel='stylesheet' href='../js/alertify.js/themes/alertify.core.css' />
                            <link rel='stylesheet' href='../js/alertify.js/themes/alertify.default.css' />
                    </head>
                    <body>
                            <div class='container'> <center><b> Consulta de Alumnos por Apellidos </b> </center> </div>
                            <center> <h2 style='color:#0431B4' id='titulo'> Busqueda de Alumnos </h2> </center>
                    <section>
                            <form method='post' action='MostrarAlumnos.php'>
                                    <input type='text' placeholder='Ingrese Apellidos' name='apellidos'  />

                                    <button name='buscar' type='submit'>Buscar</button>
                            </form>";

    echo $CodigoHtml;
