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
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    </head>
    <body>
    <section   style='color:#0080FF; background-color: #FFBF00'>
        <center><h2>CONSULTA DE USUARIOS
           <?php echo "<button class='btn btn-primary btn-lg' title='Regresar' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
           <?php          
           echo "<button class='btn btn-primary btn-lg' title='Nuevo' style='font-size:20px;color:#0080FF;background-color: #FFBF00;border:none' onclick='window.location=\"NuevoUsuario.php\"' type='reset' ><span class='glyphicon glyphicon-file'></span></button> ";
           ?>
        </h2></center>
    </section>

     <section>
        <div id='tableContainer' class='tablaContainer'>
            <style>
                table {
                    font-family: 'Poppins', sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 12px;
                }
            </style>

            <table class='table table-bordered table-hover'  >
            <thead class='fixedHeader' >
                <tr >
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Id Usuario</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Nombres</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Tipo Usuario</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>@Mail</center></b></th>
                    <th bgcolor='#0080FF' style='color: #FFBF00'><b><center>Estado</center></b></th>
                    <th bgcolor='#FFBF00' style='color: #0080FF'><b><center>Modificar</center></b></th>
                </tr>
            </thead>
            <tbody class='scrollContent'>
                <?php 
                    $contador=0;
                    $StrSql="SELECT a.IdUsuario as IdUsuario,a.UsuarioApellidos as Apellidos,a.UsuarioNombres as Nombres,
                                    b.DescripcionTipoUsuario as DescTipoUsuario,
                                    a.UsuarioEmail as email ,a.Estado as estado from usuarios a,tipousuarios b
                            where a.IdTipoUsuario= b.IdTipoUsuario ";

                                   
                    $ResultSet=  mysqli_query($conexion, $StrSql);
                    while($registro=  mysqli_fetch_array($ResultSet))
                    {
                      $contador++;
                      $descEstado='';
                      if ($registro['estado']=='A'){
                         $descEstado='ACTIVO';
                      }
                      else
                      {
                         $descEstado='INACTIVO' ;
                      }
                      echo  
                      "<tr>
                        <td><center>".$registro['IdUsuario']."</center></td>                      
                        <td>".$registro['Apellidos']." ".$registro['Nombres']."</td>
                        <td>".$registro['DescTipoUsuario']."</td>
                        <td>".$registro['email']."</td>
                        <td>".$descEstado."</td>
                        <td><center><a href='ModificarUsuarios.php?IdUsuario=".$registro['IdUsuario']."'><img src='../img/usuarios.png'></a></center></td>
                  
                      </tr>";
                    }
                    if($contador==0)
                    {
                        echo "<h2>No existen usuarios</h2>";   
                    }?>
                </tbody>
                    
            </table>
           </div>   
          </section> 
        <p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
        </body>
    </html>
