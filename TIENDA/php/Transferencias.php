<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $v_numCedula='';
        $v_nombres='';
        $v_valor='';
        $xIdAlmacen = $_SESSION['idalmacen'];
        #--------datos del local ----------------------------------------
        $sql="SELECT * from systemprofile where IdEmpresa = $xIdAlmacen";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        #--------datos del la bodega ----------------------------------------
        $sql="SELECT * from almacenes where IdAlmacen = $xIdAlmacen";
        $rsAlmacen       =  mysqli_query($conexion, $sql);
        $regAlmacen =  mysqli_fetch_assoc($rsAlmacen);      
        $xIdBodega = $regAlmacen['IdBodega'];  
        #---------transferencias pendientes de mi almacen----------------------
        $ListaTransferencias='';
        $sqlTransferencias="select * from movimientosinventarios,almacenes ".
                           " where movimientosinventarios.IdAlmacen= $xIdAlmacen ".
                           "   and movimientosinventarios.IdCodigoTraslado = 'TE'".
                           "   and movimientosinventarios.EstadoMovimiento = 'P'".
                           "   and movimientosinventarios.IdBodegaOrigen=almacenes.IdAlmacen";
        $rsTrans = mysqli_query($conexion,$sqlTransferencias);
        while($regTrans = mysqli_fetch_array($rsTrans))
        {
           $ListaTransferencias.="<option value='".$regTrans['IdMovInventario']."'>".$regTrans['IdMovInventario'].'-'.$regTrans['DescripcionAlmacen']."</option>";
        }

       #---------Bodegas de Origen  ---------#
       $ListaB0='';
       $ListaBD='';
       $SqlBodegas="Select * from almacenes where IdAlmacen=$xIdAlmacen ";       
       $rsBO=  mysqli_query($conexion, $SqlBodegas);
       while($rBO=  mysqli_fetch_array($rsBO))
       {
           $IdBodega=$rBO['IdAlmacen'];
           $DescBodega=$rBO['DescripcionAlmacen'];
       }  


       #---------Bodegas de Origen y Destino ---------#
/*       $SqlBodegas="Select * from bodegas where EstadoBodega='A' ";       
       $ResultBodegas=  mysqli_query($conexion, $SqlBodegas);
       while($reg_Bodegas=  mysqli_fetch_array($ResultBodegas))
       {
           $IdBodega=$reg_Bodegas['IdBodega'];
           $DescBodega=$reg_Bodegas['DescripcionBodega'];
           $ListaBodegas.=
              "<option value='".$IdBodega."'>".$DescBodega."</option>";
       }  
*/

      }
  
?>
<!DOCTYPE html>
<html>
  <head>
<!--     <title> SISTEMA COMPUVARGAS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> -->
    <?php include('head.php'); ?>

  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body >

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action="GrabarTrasladoEntrada.php" >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size:20px;color:#0080FF;font-weight:bold;">Transferencias de Entrada
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Grabar' onClick='trampa();' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  >
                      <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>
                      <div class="form-group col-md-3">
                        <label style='color:#0080FF'  for="TipoMov">Movimientos Pendientes:</label>
                        <select style='color:#0080FF' id='IdTransferencia' name='IdTransferencia' class="form-control" required="yes" onchange="buscarMov();retornaFecAlm();" onkeypress="return pulsar(event)">
                            <option value=''>Seleecionar</option>
                            <?php
                               echo $ListaTransferencias;
                             ?>
                        </select> 
                      </div>
                       <div class="form-group col-md-2">
                          <label style='color:#0080FF'  for="f_apellidos">Fecha Transf:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Fecha" name='Fecha' readonly="yes" >
                      </div>
                       <div class="form-group col-md-3">
                          <label style='color:#0080FF'  for="BodegaOrigen">Bodega Origen:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="BodegaOrigen" name='BodegaOrigen'  readonly >
                      </div>   
                       <div class="form-group col-md-3">
                          <label style='color:#0080FF'  for="BodegaDestino">Bodega Destino:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="BodegaDestino" name='BodegaDestino'  readonly >
                      </div>                        
                                    
 				 </div>


              </div>        

             </div>              
          </div>            
        </div>   
     </div>

  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >Detalle de Items</div>
       <div class="panel-body" style="width:100%; display:block;">

 
           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   
            <?php
               $iconoEliminar = 'glyphicon glyphicon-trash';
               $codigoHtml= "<span class='".$iconoEliminar."'></span>";
            ?>
            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Item</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Barra</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='30%'><b><center>Descripción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Cant.</center></b></th>
              </tr>
            </thead>
            <tbody id='respuesta'>


            </tbody>
        </table>    
     </div>
  </div>
</div>

 </form>
</section>
<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>


<script type="text/javascript">




function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 

var i=0;


function desabilita()
{
  $('#Codigo').val('0');
}

function buscarMov()
{
    var IdMov = document.getElementById('IdTransferencia').value;
        //setearTabla();
        $.ajax({

                  url: 'RetornaDatosMovInv.php',
                  data: {'IdMov': IdMov},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i        =   0;
                   var html     =   '';
                   var contador =   0;
                   var nregs    =   data.IdReferencia.length;

                   for(i=0;i<nregs;i++)
                   {
                     contador++;
                    // alert(contador);
                    html="<tr><td><input type='text'  name='IdReferencia"+i+"' value='"+data.IdReferencia[i]+"' readonly='yes'></td>"+
                          "<td>"+data.CodigoBarra[i]+"</td>"+
                          "<td>"+data.Descripcion[i]+"</td>"+
                          "<td><input type='text'  name='Cantidad"+i+"' value='"+data.Cantidad[i]+"' readonly='yes'></td></tr>";
                         $('#respuesta').append(html);
                         $('#NumeroFilas').val(i);
                   }
                  }                  
                })
                .done(function() {
                  console.log("success");
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });                        
      
    }


function retornaFecAlm()
{   var DatosString ='';
    var DatosAray ='';
    var IdMov = document.getElementById('IdTransferencia').value;
        //setearTabla();
        $.ajax({

                  url: 'RetornaFecAlm.php',
                  data: {'IdMov': IdMov},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'text',

                  success: function(data)
                  {
                   var i        =   0;
                   var html     =   '';
                   var contador =   0;
                   DatosString  =  data;
                   DatosArray   =  DatosString.split('_;_');
                   $('#Fecha').val(DatosArray[0]);
                   $('#BodegaDestino').val(DatosArray[1]);   
                   $('#BodegaOrigen').val(DatosArray[1]);     
               
             
                  }                  
                })
                .done(function() {
                  console.log("success");

                })
                .fail(function() {
                  console.log("error");
                  alert('error');
                })
                .always(function() {
                  console.log("complete");
                });                        
      
    }




</script>
</html> 

   