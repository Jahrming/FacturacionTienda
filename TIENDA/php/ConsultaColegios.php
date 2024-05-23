<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $v_usuario =  $_SESSION['user'];
        //captura atributos
        $IconoCrear='';
        $IconoModificar='';
        $PermisoCrear='';
        $PermisoModificar='';
        $PermisoEliminar='';
        $sqlattrib="select * from admusuarios a,admtipousuario b,admpermisosprogramas c
                    where a.UserName = '$v_usuario' 
                      and a.IdTipoUsuario = b.IdTipoUsuario
                      and b.IdTipoUsuario = c.IdTipoUsuario";
        $rsAttrib= mysqli_query($conexion,$sqlattrib);
        $reg = mysqli_fetch_assoc($rsAttrib);
        if($reg['Crear']=='S')
        {
          $PermisoCrear='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='C'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoCrear=$regIcono['IconAtributo'];
        }
        if($reg['Modificar']=='S')
        {
          $PermisoModificar='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='U'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoModificar=$regIcono['IconAtributo'];
        }
        if($reg['Eliminar']=='S')
        {
          $PermisoEliminar='S';
          $sqlIconos="select * from iconosatributos where IdAtributo='D'";
          $rsIcono=mysqli_query($conexion,$sqlIconos);
          $regIcono= mysqli_fetch_assoc($rsIcono);
          $IconoEliminar=$regIcono['IconAtributo'];
        }        
        
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];
      }


?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA ACADEMICO </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
    <link href="../css_temas/helper.css" rel="stylesheet">
    <link href="../css_temas/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body >

<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'>  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">CONSULTA DE COLEGIOS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='fa fa-hand-o-left'></span> </button>";?>
              <?php if($PermisoCrear=='S')
                  {
                    echo "<button class='btn btn-primary btn-sm' title='Nuevo' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"NuevoColegio.php\"' type='button'> <span class='".$IconoCrear."'></span> </button>";
                  }?>
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
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
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Id </center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Descripción</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Contacto</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Ciudad</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Descuento</center></b></th>
                     <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Teléfonos</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Estado</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Acciones</center></b></th>
                </tr>
            </thead>
            <tbody class='scrollContent'  >
                <?php 
                    $contador=0;
                    $StrSql="SELECT * FROM colegios inner join referenciacolegio  ".
                            " on colegios.IdColegio = referenciacolegio.IdColegio ";
                                                           
                    $ResultSet=  mysqli_query($conexion, $StrSql);
                    while($registro=  mysqli_fetch_array($ResultSet))
                    {
                      $contador++;
                      $v_Estado=$registro['EstadoColegio'];
                      $SqlEstados="SELECT * FROM admestados WHERE IdEstado='$v_Estado'";
                      $rsestados= mysqli_query($conexion,$SqlEstados);
                      $regEstados = mysqli_fetch_assoc($rsestados);
                      $descEstado = $regEstados['DescripcionEstado'];

                      echo  
                      "<tr style='color: #045FB4' >
                        <td style='color: #045FB4'><center>".$registro['IdColegio']."</center></td>   
                        <td style='color: #045FB4'>".utf8_encode($registro['DescripcionColegio'])."</td>  
                        <td style='color: #045FB4'>".$registro['ContactoColegio']."</td> 
                        <td style='color: #045FB4'>".$registro['Ciudad']."</td>
                        <td style='color: #045FB4'>".$registro['PorcentajeDescuento']."</td>
                        <td style='color: #045FB4'>".$registro['TelefonosColegio']."</td>                 
                        <td style='color: #045FB4'>".$descEstado."</td>";
                      echo "<td><center>";
                      if($PermisoModificar=='S'){
                        echo "<a href=ModificarColegio.php?IdColegio=".$registro['IdColegio']."><span style='color: #40FF00' class='".$IconoModificar."'></span></a>";
                      }
                      echo "&nbsp&nbsp";
                      if($PermisoEliminar=='S'){
                        echo "<a href=EliminarColegio.php?IdColegio=".$registro['IdColegio']."><span  style='color: #FF0040' class='".$IconoEliminar."'></span></a>";
                      }
                      echo "</td></tr>";

                    }
                    if($contador==0)
                    {
                        echo "<h2>No existen Colegios</h2>";   
                    }?>
                </tbody>               
            </table>
              </div>
          </div>            
        </div>   
     </div>
 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


