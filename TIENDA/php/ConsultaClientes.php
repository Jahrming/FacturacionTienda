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
    <?php include('head.php'); ?>

  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'>  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">CONSULTA DE CLIENTES
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='fa fa-hand-o-left'></span> </button>";?>
              <?php if($PermisoCrear=='S')
                  {
                    echo "<button class='btn btn-primary btn-sm' title='Nuevo' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"NuevoCliente.php\"' type='button'> <span class='".$IconoCrear."'></span> </button>";
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
                    <th width="3%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Id</center></b></th>
                    <th width="10%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Tipo Doc</center></b></th>
                    <th width="7%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Número</center></b></th>
                    <th width="30%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Nombres</center></b></th>
                    <th width="9%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>FeC nac</center></b></th>
                    <th width="20%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Email</center></b></th>
                    <th width="25%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Dirección</center></b></th>
                    <th width="7%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Teléfonos</center></b></th>
                    <th width="7%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Estado</center></b></th>
                    <th width="7%" bgcolor='#FFBF00' style='color: #0080FF'><b><center>Acciones</center></b></th>
                </tr>
            </thead>
            <tbody class='scrollContent'  >
                <?php 
                    $contador=0;
                    $StrSql="SELECT a.IdCliente as IdCliente ,b.DescripcionTipoDocumento as TipDoc,
                                    a.CedulaRuc as NumDoc,a.Apellidos as Apellidos,a.Nombres as Nombres,
                                    a.FechaNacimiento as FecNac,a.Email as Email,a.Direccion as Direccion,
                                    a.Telefonos as Telefonos,a.estado as Estado 
                              FROM clientes a ,admtipodocumento b 
                              WHERE a.IdTipoDocumento = b.IdTipoDocumento ";
                                                            
                    $ResultSet=  mysqli_query($conexion, $StrSql);
                    while($registro=  mysqli_fetch_array($ResultSet))
                    {
                      $contador++;
                      $v_Estado=$registro['Estado'];
                      $SqlEstados="SELECT * FROM admestados WHERE IdEstado='$v_Estado'";
                      $rsestados= mysqli_query($conexion,$SqlEstados);
                      $regEstados = mysqli_fetch_assoc($rsestados);
                      $descEstado = $regEstados['DescripcionEstado'];

                      echo  
                      "<tr style='color: #0080FF'>
                        <td><center>".$registro['IdCliente']."</center></td>   
                        <td>".utf8_encode($registro['TipDoc'])."</td>                   
                        <td>".$registro['NumDoc']."</td>
                        <td>".$registro['Apellidos'].' '.$registro['Nombres']."</td>
                        <td>".$registro['FecNac']."</td>
                        <td>".$registro['Email']."</td>
                        <td>".$registro['Direccion']."</td>
                        <td>".$registro['Telefonos']."</td>
                        <td>".$descEstado."</td>";
                      echo "<td><center>";
                      if($PermisoModificar=='S'){
                        echo "<a href=ModificarCliente.php?IdCliente=".$registro['IdCliente']."><span class='".$IconoModificar."'></span></a>";
                      }
                      echo "&nbsp&nbsp";
                      if($PermisoEliminar=='S'){
                        echo "<a href=EliminarCliente.php?IdCliente=".$registro['IdCliente']."><span class='".$IconoEliminar."'></span></a>";
                      }
                      echo "</td></tr>";

                    }
                    if($contador==0)
                    {
                        echo "<h2>No existen Clientes</h2>";   
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


