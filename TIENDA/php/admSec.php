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
                              <?php include('headmsg.php'); ?>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">Secuencias de Documentos
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
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Almacen</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='25%'><b><center>Razón Social</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='13%'><b><center>R.U.C.</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Tipo Documento</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>No Interno</center></b></th>     
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Secuencial SRI</center></b></th>
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Estado</center></b></th>                                        
                    <th  bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Acciones</center></b></th>
                                            
                </tr>
            </thead>
            <tbody class='scrollContent'  >
                <?php 
                    $contador=0;
                    $StrSql="Select almacenes.IdAlmacen IdAlmacen,srisecuencial.IdTipoDocumento IdTipDoc,DescripcionAlmacen,RUC,DescripcionTipoDocumento, ".
                            " IdMovInterno,SecuencialSRI,'A' Estado,NombreEmpresa ".
                            " from srisecuencial, almacenes, systemprofile,tipodocumento ".
                            " where systemprofile.IdEmpresa = almacenes.IdAlmacen ".
                            "   and srisecuencial.IdAlmacen =  almacenes.IdAlmacen ".
                            "   and tipodocumento.IdTipoDocumento= srisecuencial.IdTipoDocumento order by almacenes.IdAlmacen,srisecuencial.IdTipoDocumento";

               
                    $ResultSet=  mysqli_query($conexion, $StrSql);
                    while($registro=  mysqli_fetch_array($ResultSet))
                    {
                      $contador++;
                      $v_Estado=$registro['Estado'];
                      $SqlEstados="SELECT * FROM admestados WHERE IdEstado='$v_Estado'";
                      $rsestados= mysqli_query($conexion,$SqlEstados);
                      $regEstados = mysqli_fetch_assoc($rsestados);
                      $descEstado = $regEstados['DescripcionEstado'];
                      if ($v_usuario=='admin')
                      {   
                           echo  
                            "<tr>".
                              "<td style='color: #045FB4'>".utf8_encode($registro['DescripcionAlmacen'])."</td>". 
                              "<td style='color: #045FB4'>".utf8_encode($registro['NombreEmpresa'])."</td>".
                              "<td style='color: #045FB4'>".$registro['RUC']."</td>".                          
                              "<td style='color: #045FB4'>".$registro['DescripcionTipoDocumento']."</td>".
                              "<td style='color: #045FB4'>".$registro['IdMovInterno']."</td>".  
                              "<td style='color: #045FB4'><input type='hidden' id='idalmacen".$contador."' value='".$registro['IdAlmacen']."'><input type='hidden' id='idtipdoc".$contador."' value='".$registro['IdTipDoc']."'><input type='number' id='Secuencial".$contador."'  value='".$registro['SecuencialSRI']."'  disabled='yes'></td>".   

                              "<td style='color: #045FB4'>".$descEstado."</td>".

                              "<td ><a ><span  style='color: #01DF01' class='glyphicon glyphicon-edit' onClick='habilitaControl(".$contador.")' ></span></a>
                   
                             
                                &nbsp&nbsp
                             
                                <a ><span  style='color: #FF0040' class='glyphicon glyphicon-floppy-disk' onClick='actualizaSecuencial(".$contador.")' type='button'></span></a>";
                            "</center></td></tr>";
                    }
                    else
                    {
                           echo  
                            "<tr>".
                              "<td style='color: #045FB4'>".utf8_encode($registro['DescripcionAlmacen'])."</td>". 
                              "<td style='color: #045FB4'>".utf8_encode($registro['NombreEmpresa'])."</td>".
                              "<td style='color: #045FB4'>".$registro['RUC']."</td>".                          
                              "<td style='color: #045FB4'>".$registro['DescripcionTipoDocumento']."</td>".
                              "<td style='color: #045FB4'>".$registro['IdMovInterno']."</td>".  
                              "<td style='color: #045FB4'><input type='hidden' id='idalmacen".$contador."' value='".$registro['IdAlmacen']."'><input type='hidden' id='idtipdoc".$contador."' value='".$registro['IdTipDoc']."'><input type='number' id='Secuencial".$contador."'  value='".$registro['SecuencialSRI']."'  disabled='yes'></td>".   

                              "<td style='color: #045FB4'>".$descEstado."</td>".

                              "<td ><a ><span  style='color: #01DF01' class='glyphicon glyphicon-edit'  ></span></a>
                   
                             
                                &nbsp&nbsp
                             
                                <a ><span  style='color: #FF0040' class='glyphicon glyphicon-floppy-disk'  type='button'></span></a>";
                            "</center></td></tr>";                      
                    }

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


<script type="text/javascript">
  function habilitaControl(numero_fila)
  {
     var elemento_1 = "Secuencial"+numero_fila;

    
     //document.getElementById(elemento_1).disabled=false;
   //  document.getElementByName(isabled = false;
     document.getElementById(elemento_1).disabled= false; 
  //    document.getElementById(elemento_1).disabled= false; 

  }
   function actualizaSecuencial(numero_fila)
  {
     var IdAlmacen = 'idalmacen'+numero_fila;
     var IdTipDoc  = 'idtipdoc'+numero_fila;
     var Secuencial = 'Secuencial'+numero_fila;

     var valIdAlmacen=document.getElementById(IdAlmacen).value;
     var valIdTipDoc = document.getElementById(IdTipDoc).value;
     var valSecuencial = document.getElementById(Secuencial).value;




        $.ajax({
          url: 'actualizaSecuencia.php',
          method:  'POST',
          contentType: 'application/x-www-form-urlencoded',
          data: {'IdTipoDoc': valIdTipDoc,'IdAlmacen':valIdAlmacen,'Secuencial':valSecuencial},
            success: function(data){
              alert(data);

            }
        })
        .done(function() {
          document.getElementById(Secuencial).value=valSecuencial;
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
       
      



     //document.getElementById(elemento_1).disabled=false;
   //  document.getElementByName(isabled = false;
     document.getElementById(elemento_1).disabled= true; 
  //    document.getElementById(elemento_1).disabled= false; 

  } 
</script>