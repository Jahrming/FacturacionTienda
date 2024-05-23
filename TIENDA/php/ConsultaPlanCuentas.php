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
  <head style="background-color: #A52A2A">
    <title> SISTEMA COMERCIAL </title>
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
<!---   <body onload='return inicio(\"\")'style="background-color: #FFA500">    -->
<body >
   
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'>  
      <div class='container'>



        <div class='panel panel-default'>
                            <div style="width:50%;font-size: 10px;color:#0080FF;font-weight:bold;">
                            	System ATICUS 1.0 - Admin - Administrador del Sistema - Contabilidad
            				</div>        	
            <div class="panel-heading" style="width:100%;font-size: 19px;color:#0080FF;font-weight:bold;">CONSULTA DE PLAN DE CUENTAS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='fa fa-hand-o-left'></span> </button>";?>
              <?php if($PermisoCrear=='S')
                  {
                    echo "<button class='btn btn-primary btn-sm' title='Nuevo' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"NuevoCuentaContable.php\"' type='button'> <span class='".$IconoCrear."'></span> </button>";
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
                    color: #0080FF;
                }
            </style>

            <table class='table table-bordered table-hover'  >
            <thead class='fixedHeader' >
                <tr >

                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Número Cuenta</center></b></th>
                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Descripción Cuenta</center></b></th>
                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Tipo Cuenta</center></b></th>
                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Nivel</center></b></th>                    
                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Estado</center></b></th>
                    <th bgcolor='#FE2E64' style='color: #01A9DB'><b><center>Acciones</center></b></th>
                </tr>
            </thead>
            <tbody class='scrollContent'  >
                <?php 
                    $espacios='';
                    $contador=0;
                    $StrSql="SELECT * FROM conplancuentas a ,contipocuenta b
                              WHERE a.CodigoTipoCuenta = b.CodigoTipoCuenta
                                AND a.estado = 'A' ";
                                                            
                    $ResultSet=  mysqli_query($conexion, $StrSql);
                    while($registro=  mysqli_fetch_array($ResultSet))
                    {
                      $espacios ='';
                      $contador++;
                      $v_Estado=$registro['Estado'];
                      $SqlEstados="SELECT * FROM admestados WHERE IdEstado='$v_Estado'";
                      $rsestados= mysqli_query($conexion,$SqlEstados);
                      $regEstados = mysqli_fetch_assoc($rsestados);
                      $descEstado = $regEstados['DescripcionEstado'];
                      if($registro['IdNivel']>1)
                      {
                      	for ($ii=2;$ii<=$registro['IdNivel'];$ii++)
                      	{
                      		$espacios.='&nbsp&nbsp&nbsp';
                      	}
                      }
                      
                      echo  
                      "<tr >
                
                        <td style='color: #0000FF'>".$registro['CuentaContable']."</td>
                        <td style='color: #0000FF'>".$registro['CuentaContable'].'&nbsp&nbsp'.$registro['DescripcionCuentaContable']."</td>
                        <td style='color: #0000FF'><center>".$registro['DescripcionTipoCuenta']."</center></td>   
                        <td style='color: #0000FF'>".$registro['IdNivel']."</td>                           
                        <td style='color: #0000FF'>".$descEstado."</td>";
                      echo "<td><center>";
                      if($PermisoModificar=='S'){
                        echo "<a href=ModificarCuenta.php?IdProveedor=".$registro['CuentaContable']."&IdEmpresa=".$xIdEmpresa."&Anio=".$registro['Anio']."><span class='".$IconoModificar."'></span></a>";
                      }
                      echo "&nbsp&nbsp";
                      if($PermisoEliminar=='S'){
                        echo "<a href=ModificarCuenta.php?IdProveedor=".$registro['CuentaContable']."&IdEmpresa=".$xIdEmpresa."&Anio=".$registro['Anio']."><span class='".$IconoEliminar."'></span></a>";
                      }
                      echo "</td></tr>";

                    }
                    if($contador==0)
                    {
                        echo "<h2>No existen Cuentas</h2>";   
                    }?>
                </tbody>               
            </table>
              </div>
          </div>            
        </div>   
     </div>

    </div>
 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


