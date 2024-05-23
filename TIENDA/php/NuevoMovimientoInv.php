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

       #---------Movimientos de inventarios ---------#
       $SqlTraslados="Select * from traslados where IdCodigoTraslado not in ('NC','CO','VM','TE') and Estado='A' ";       
       $ResultTraslados=  mysqli_query($conexion, $SqlTraslados);
       while($reg_Traslados=  mysqli_fetch_array($ResultTraslados))
       {
           $IdCodigoTraslado=$reg_Traslados['IdCodigoTraslado'];
           $DescTraslado=$reg_Traslados['DescripcionTraslado'];
           $ListaTraslados.=
              "<option value='".$IdCodigoTraslado."'>".$DescTraslado."</option>";
       }  
       #---------Bodegas de Origen  ---------#
       $ListaB0='';
       $ListaBD='';
       $SqlBodegas="Select * from bodegas where IdBodega=$xIdBodega ";       
       $rsBO=  mysqli_query($conexion, $SqlBodegas);
       while($rBO=  mysqli_fetch_array($rsBO))
       {
           $IdBodega=$rBO['IdBodega'];
           $DescBodega=$rBO['DescripcionBodega'];
           $ListaB0.=
              "<option value='".$IdBodega."'>".$DescBodega."</option>";
       }  
       #---------Bodegas de destino  ---------#
       $SqlBodegas="Select * from bodegas "; //where IdBodega $xIdBodega ";       
       $rsBD=  mysqli_query($conexion, $SqlBodegas);
       while($rBD=  mysqli_fetch_array($rsBD))
       {
           $IdBodegaD=$rBD['IdBodega'];
           $DescBodegaD=$rBD['DescripcionBodega'];
           $ListaBD.=
              "<option value='".$IdBodegaD."'>".$DescBodegaD."</option>";
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
    <?php include('head.php'); ?>

       <link rel='stylesheet' href='../css/estilos.css' >
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
        input{
          padding: 3px;
          margin: 3px;
        }
        ul{
          float: left;
          background-color: #eee;
          cursor:pointer;
        }
        li{
          float: left;
          padding: 12px;
        }
        #sugerencias {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
        #filtrarProductos {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
 
        #sugerencias .suggest-element {
                background-color: #EEEEEE;
                border-top: 1px solid #d6d4d4;
                cursor: pointer;
                padding: 8px;
                width: 400%;
                float: left;
        }

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">




  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body >

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action="GrabarMovimientoInventarios.php" >  
      <div class='container'>
        <div class='panel panel-default'>
        	          <?php include('headmsg.php'); ?>
            <div class="panel-heading" style="font-size:20px;color:#0080FF;font-weight:bold;">MOVIMIENTOS DE INVENTARIOS (NUEVO)
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Grabar' onClick='trampa();' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </div>
          <div class="panel-body" style="padding: 0px;">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  style="padding: 4px;margin: 0px;">
                      <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>

                      <div class="form-group col-md-3" style='padding: 4px;margin: 0px;'>
                        <label style='color:#0080FF'  for="TipoMov">Tipo Movimiento:</label>
                        <select style='color:#0080FF' id='IdCodigoTraslado' name='IdCodigoTraslado' class="form-control" required="yes" onkeypress="return pulsar(event)">
                            <option value=''>Seleecionar</option>
                            <?php
                               echo $ListaTraslados;
                             ?>
                        </select> 
                      </div>

                      <div class="form-group col-md-3" style='padding: 4px;margin: 0px;'>
                              <label style='color:#0080FF'  for="FechaMov" >Fecha Movimiento: </label>
                              <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="fecMov" name='fecMov' required="yes">
                      </div> 

                      <div class="form-group col-md-3" style='padding: 4px;margin: 0px;'>
                        <label style='color:#0080FF'  for="TipoMov">Bodegas Origen:</label>
                        <select style='color:#0080FF' id='IdBodegaOrigen' name='IdBodegaOrigen' class="form-control" required="yes" onkeypress="return pulsar(event)">
                            <?php
                               echo $ListaB0;
                             ?>
                        </select> 
                      </div>     

                      <div class="form-group col-md-3" style='padding: 4px;margin: 0px;'>
                        <label style='color:#0080FF'  for="TipoMov">Bodegas Destino:</label>
                        <select style='color:#0080FF' id='IdBodegaDestino' name='IdBodegaDestino' class="form-control" required="yes" onkeypress="return pulsar(event)">
                            <option value=''>Seleecionar</option>
                            <?php
                               echo $ListaBD;
                             ?>
                        </select> 
                      </div>                                                                                                  
                 </div> 
                  <div class="form-row"  >
                      <div class="form-group col-md-12" style='padding: 2px;margin: 0px;'>
                          <label style='color:#0080FF'  for="TipoMov">Observación:</label>
                          <textarea  class="form-control" style="margin: 0px; width: 550px; " name="observacion" placeholder="Ingrese algu comentario u observación"></textarea>
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

                <div class="form-row"  >
                  <div class="form-group col-md-2">
                          <input type='hidden' id='IdReferencia' name='IdReferencia' value=''>
                          <input type='hidden' id='Existe' name='Existe' value=''>
                          <input type='hidden' id='Precio' name='' value=''>    
                          <input type='hidden' id='Iva' name='Iva' value=''>    
                          <label style='color:#0080FF' for="f_codigo">Item:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Codigo" name='Codigo' placeholder="Código Barra" required="yes" onkeypress='return pulsar(event)' onkeydown="capturaKey(event);">
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#FFFFFF' for="f_buscar">Find</label>
                      <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('producto')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
                  </div>
                  <div class="form-group col-md-5">
                      <label style='color:#0080FF'  for="f_apellidos">Descripción:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="NombreProducto" name='NombreProducto' readonly="yes">
                  </div>
                  <div class="form-group col-md-3">
                      <label style='color:#0080FF'  for="f_apellidos">Cant:</label>
                      <input style='color:#0080FF' type="number" step='1' onkeypress="return pulsar(event)" class="form-control" id="Cantidad" name='Cantidad' value='1.0'  >
                  </div>
                  <div class="form-group col-md-1">
                    <label style='color:#FFFFFF' for="f_add">add</label>
                    <input type='button' name='btnAgregar' id='add' class='btn btn-primary btn-sm' value='Add' onclick="addFilasMovimientosInventarios();" >
                  </div>
               </div>
 
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
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center><?php echo $codigoHtml;?></center></b></th>
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
   var xhr;
   var existeProducto=0;

      function VerificaProductoMov(){

      var datosString ='';
      var datosArray ='';   
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= ObtenerDatosItem;
      xhr.open('POST','RetornaDatosProductoCompra.php',false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("Codigo="+document.getElementById('Codigo').value);

      function ObtenerDatosItem()
      {
         if(xhr.readyState==4)
            {
              if(xhr.status==200)
                {
                  datosString    = this.responseText;
                  if(datosString==0)
                  {
                    existeProducto = 0;
                    //document.getElementById('Codigo').focus();
                  }
                  else
                  { 
                    datosArray  =  datosString.split('_;_');      
                    existeProducto = 1;
                    document.getElementById('IdReferencia').value   = datosArray[0];
                    document.getElementById('Codigo').value         = datosArray[1];
                    document.getElementById('NombreProducto').value = datosArray[2];
                  //alert('eciste por si'+document.getElementById('Existe').value);
                  } 
                }
            }
      }
   }


   function capturaKey(event){
     var tecla= event.which|| event.keyCode;
     if (tecla==13){
       VerificaProductoMov();
          if(existeProducto==1)
          { addFilasMovimientosInventarios();
             //document.getElementById('add').focus();   
             document.getElementById('Cantidad').value=1; 
             
          }
          else
          {
            alert('Item no existe');
            document.getElementById('Codigo').value=null;
            document.getElementById('Codigo').focus();
          }
          existeProducto=0;
        }
  
   //  
     if(tecla==113){
       // addFilasMovimientosInventarios();
document.getElementById('Codigo').focus();

     }
   }


function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 

} 

var i=0;


  //######----- Eliminar filas ------------#
  $(document).on('click','.eliminar',function(event){
      event.preventDefault();
      $(this).closest('tr').remove();
      nfilas = $('#NumeroFilas').val();
     //alert('nfilas '+nfilas);
    }
  );

function trampa()
{
  $('#Codigo').val('0');
}

function desabilita()
{
  $('#Codigo').val('0');
}


           

</script>
</html> 

   