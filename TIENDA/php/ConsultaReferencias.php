<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $xIdAlmacen = $_SESSION['idalmacen'];
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
<body >

<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'>  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">CONSULTA DE PRODUCTOS
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='fa fa-hand-o-left'></span> </button>";?>
              <?php if($PermisoCrear=='S')
                  {
                    echo "<button class='btn btn-primary btn-sm' title='Nuevo' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"NuevoProducto.php\"' type='button'> <span class='".$IconoCrear."'></span> </button>";
                  }?>
                  <button class='btn btn-primary btn-sm' title='Buscar Producto' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick="window.location='BuscarProducto.php'" type='button'> <span class='fa fa-search'></span> </button>
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
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Id</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Descripción</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Marca</center></b></th>     
                               
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Pvp</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Stk Local 1</center></b></th>       
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Stk Local 2</center></b></th>    
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Estado</center></b></th>                                      
                    <th  bgcolor='#FFFF00' style='color: #0080FF'><b><center>Acciones</center></b></th>
                                            
                </tr>
            </thead>
            <tbody class='scrollContent'  >
                <?php 
                    $contador=0;
                    $StrSql="SELECT referencias.IdReferencia as Id,
                                    DescripcionReferencia as nombre,
                                    marcas.DescripcionMarca as nombremarca,
                                    pvpfinal as pvp,
                                    DescripcionProveedor as nombreproveedor,
                                    Estado  as Estado,
                                   (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=1 and stock.IdReferencia=referencias.IdReferencia) stock_local1,
                                   (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=2 and stock.IdReferencia=referencias.IdReferencia) stock_local2     
                        FROM    referencias
                        LEFT OUTER JOIN marcas ON  marcas.IdMarca = referencias.IdMarca 
                        LEFT OUTER JOIN proveedores ON referencias.IdProveedor = proveedores.IdProveedor";

               
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
                      "<tr style='color: #045FB4' >
                        <td style='color: #045FB4'><center>".$registro['Id']."</center></td>   
                        <td style='color: #045FB4'>".utf8_encode($registro['nombre'])."</td>  
                        <td style='color: #045FB4'>".$registro['nombremarca']."</td> 
                        <td style='color: #045FB4'>".$registro['pvp']."</td>      
                        <td style='color: #045FB4'>".$registro['stock_local1']."</td>        
                        <td style='color: #045FB4'>".$registro['stock_local2']."</td>   
                        <td style='color: #045FB4'>".$descEstado."</td>";
                      echo "<td><center>";
                      if($PermisoModificar=='S'){
                        echo "<a href=ModificarProducto.php?IdReferencia=".$registro['Id']."><span style='color: #40FF00' class='".$IconoModificar."'></span></a>";
                      }
                      echo "&nbsp&nbsp";
                      if($PermisoEliminar=='S'){
                        echo "<a href=EliminarProducto.php?IdReferencia=".$registro['Id']."><span  style='color: #FF0040' class='".$IconoEliminar."'></span></a>";
                      }
                      echo "</td></tr>";

                    }
                    if($contador==0)
                    {
                        echo "<h2>No existen Productos</h2>";   
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


