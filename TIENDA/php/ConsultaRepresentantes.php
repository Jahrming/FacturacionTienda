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
        <script type='text/javascript' src='../js/funciones.js'> 					</script>
        <script type='text/javascript' src='../js/alertifyjs/alertify.js'> 	</script>
        <script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
        <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
        <link rel='stylesheet' href='../css/estilos.css' >
        <link rel='stylesheet' href='../css/bootstrap.min.css'>
        <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />
    </head>

    <section style='color:#0080FF; background-color: #FFBF00'>
        <center><h2>CONSULTA DE REPRESENTANTES
           <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
           <?php          
           echo "<button class='btn btn-primary btn-lg' title='Nuevo' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onclick='window.location=\"NuevoRepresentante.php\"' type='reset' ><span class='glyphicon glyphicon-file'></span></button> ";?>
        </h2></center>
    </section >



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
            <thead class='fixedHeader' >
                <tr >
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Id Alumno</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Cédula</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Nombres</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Dirección</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Teléfonos</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>M@ail</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Estado</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Modificar</center></b></th>
                </tr>
            </thead>
                <tbody class='scrollContent'>
                    <?php 
                        $contador=0;
                        $StrSql="SELECT * from representantes ORDER BY Apellidos,Nombres ";
                                       
                        $ResultSet=  mysqli_query($conexion, $StrSql);
                        while($registro=  mysqli_fetch_array($ResultSet))
                        {
                          $contador++;
                          //$IdTicket=$registro['Ticket'];
                          echo  

                          "<tr>
                            <td><center>".$registro['IdRepresentante']."</center></td>       
                            <td><center>".$registro['cedula']."</center></td>                
                            <td>".$registro['apellidos']." ".$registro['nombres']."</td>
                            <td>".$registro['direccion']."</td>
                            <td>".$registro['telefonos']."</td>
                            <td>".$registro['mail']."</td>
                            <td>".$registro['estado']."</td>
                            <td><center><a href=ModificarRepresentante.php?IdRepresentante=".$registro['IdRepresentante']."><img src='../img/usuarios.png'></a></center></td>
                      
                          </tr>";
                        }
                        if($contador==0)
                        {
                            echo "<h2>No existen representantes</h2>";   
                        }
                        echo "</tbody>";
                        ?>
                </tbody>
            </table>
           </div>    
          </section>
        <p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
        </body>
    </html>

