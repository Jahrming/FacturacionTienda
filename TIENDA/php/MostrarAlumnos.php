<?php
    include("Conexion.php");

    $Apellidos=$_POST['apellidos'];
    $criterio= " like '%".$Apellidos."%'";
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

                            <table  class='table  table-bordered table-hover'>
                                    <tr bgcolor= '#3B83BD' style='color: rgb(246, 246, 246)'>
                                            <th> <center> Cédula  </center> </th>
                                            <th> <center> Apellidos  </center> </th>
                                            <th> <center> Nombres   </center> </th>
                                            <th> <center> Seleccionar   </center> </th>
                                   </tr>
    ";

    $StrSql="SELECT * FROM alumnos WHERE AlumnoApellidos $criterio ";

    echo $StrSql;
    $ResultSet=mysqli_query($conexion,$StrSql);
    while($Registro=  mysqli_fetch_array($ResultSet))
    {
            $Apellidos=$Registro['AlumnoApellidos'];
            $Nombres=$Registro['AlumnoNombres'];
            $Cedula=$Registro['AlumnoCedula'];
            $CodigoHtml=$CodigoHtml. "<tr>
            <td>".$Registro['AlumnoCedula']."</td>
            <td>".$Registro['AlumnoApellidos']."</td>
            <td>".$Registro['AlumnoNombres']."</td>
            <td><center><a href='RegistrarMatricula.php?Cedula=".$Cedula."&Apellidos=".$Apellidos."&Nombres=".$Nombres."'>Select</a></center></td>
            </tr>";
    }



    $CodigoHtml= $CodigoHtml."	
                            </table>

                             <input type='button' class='btn btn-primary btn-lg' onclick=' location.href=\"RegistroMatricula.php\" ' value='Regresar'/>
                    </section>
            </body>
    </html>
    ";
    echo $CodigoHtml;
?>