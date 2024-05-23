<?php
    SESSION_START();
    
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
       $_usuario=$_SESSION['user'];
    }
?>
<!DOCTYPE html>
<html lang='es'>            
    <head>
        <title> SISTEMA ACADEMICO </title>
        <script type='text/javascript' src='../js/funciones.js'>                    </script>
        <script type='text/javascript' src='../js/alertifyjs/alertify.js'>  </script>
        <script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
        <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
        <link rel='stylesheet' href='../css/estilos.css' >
        <link rel='stylesheet' href='../css/bootstrap.min.css'>
        <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />
    </head>
    <body>   
    <section   style='color:#0080FF; background-color: #FFBF00'>
        <center><h2>CONSULTA DE CURSOS
           <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
           <?php          
           echo "<button class='btn btn-primary btn-lg' title='Nuevo' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onclick='window.location=\"NuevoCurso.php\"' type='reset' ><span class='glyphicon glyphicon-file'></span></button> ";
           ?>
        </h2></center>
    </section>

    <section>
        <div id='tableContainer' class='tablaContainer'>
            <style>
                table {
                    font-family: Verdana, 'Times New Roman',
                                 Times, serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 12px;
                }
            </style>

            <table class='table table-bordered table-hover'  >
            <thead class='fixedHeader'>
                <tr >
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Id Curso</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Curso</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Paralelo</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Formación</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Periodo Lectivo</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Modificar</center></b></th>
                </tr>
            </thead>
            <tbody class='scrollContent'>
              <?php 
                $contador=0;
                $StrSql="SELECT a.IdCurso as CodigoCurso,b.NivelDescripcion as Curso, ".
                             "  a.IdParalelo as paralelo,c.DescripcionFormacion as Formacion,".
                             "  d.AnioInicial as Inicio, d.AnioFinal as Fin from cursos a , niveles b , ".
                            "  formaciones c , periodoslectivo d,systemprofile e ".
                            " where a.IdNivel=b.idnivel ".
                            " and a.IdFormacion = c.IdFormacion ".
                            " and a.IdPeriodoLectivo = d.IdPeriodoLectivo  " .
                            " and e.PeriodoLectivoActual = a.IdPeriodoLectivo";

                $ResultSet=  mysqli_query($conexion, $StrSql);
                while($registro=  mysqli_fetch_array($ResultSet))
                {
                  $contador++;
                  echo "<tr>
                    <td><center>".$registro['CodigoCurso']."</center></td>
                    <td>".$registro['Curso']."</td>
                    <td>".$registro['paralelo']."</td>
                    <td>".$registro['Formacion']."</td>
                    <td>".$registro['Inicio']."-".$registro['Fin']."</td>   
                    <td><center><a href='ModificarCurso.php?IdCurso=".$registro['CodigoCurso']."'><img src='../img/usuarios.png'></a></center></td>                   
                  </tr>";
                }
                if($contador==0)
                {
                    echo "<h2>No existen cursos</h2>";   
                }
                echo "</tbody>";
                ?>
            </table>
           </div>
           </section>    
        <p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
    </body>
</html>
