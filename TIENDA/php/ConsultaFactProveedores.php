


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
        $x_IdAlmacen  =   $_SESSION['idalmacen'];        
        $sql="SELECT * from systemprofile where IdEmpresa= $x_IdAlmacen";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 





      }
     // header('Content-Type: text/html; charset=UTF-8');  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include('head.php'); ?>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">


  </head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'  action='DescargarXML.php'>  
      <div class='container'>
        <div class='panel panel-default'>
                              <?php include('headmsg.php'); ?>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;" width="75%">CONSULTA DE FACTURAS DE PROVEEDORES
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Descargar Archivo XML' action='DescargarXML.php' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-save'></span></button>
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  >
                    <div class="form-group col-md-5">
                      <label style='color:#0080FF' for='inicio' class=''>Fecha Inicio: </label>
                      <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FechaInicio" name='FechaInicio' required="yes">
                    </div>
                    <div class="form-group col-md-5">
                      <label style='color:#0080FF' for='fin' class=''>Fecha Fin: </label>
                      <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FechaFin" name='FechaFin' required="yes">
                    </div>   
                    <div class="form-group col-md-1">
                       <label style='color:#FFFFFF' for="f_buscar">Bus</label>
                       <button class='btn btn-primary btn-md' name='btnBuscar' id='btnBuscar'  type='button' title='Buscar' onClick='buscarFacturasProveedores();' style='color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-search'></span></button>                       
                    </div>                           
               </div>          
          </div>              
       </div>            
    </div>   
  </div>
  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >RESULTADOS BÚSQUEDA</div>
       <div class="panel-body" style="width:100%; display:block;">

           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   



            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Almacen</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='13%'><b><center>Fecha</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Proveedor</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>No. Mov</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Fact SRI</center></b></th>                
                <th bgcolor='#FFFF00' style='color: #0080FF' width='8%'><b><center>SubTotal</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='8%'><b><center>Descuento</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='8%'><b><center>Iva</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='8%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Acciones</center></b></th>
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
   function setearTabla(){
     var numFilas =   document.getElementById('tabla1').rows.length;
     var j=0;
    // alert(numFilas);
     if(numFilas>1){
           for(j=1;j<numFilas;j++)
          {
             document.getElementById('tabla1').deleteRow('1');
          }
     }
   }
   function buscarFacturasProveedores(){
      var fechaInicio = document.getElementById('FechaInicio').value;
      var fechaFin = document.getElementById('FechaFin').value;

        //alert(Criterio+' '+buscarPor);
        $.ajax({
                  url: 'BuscarFactProvxFechas1.php',
                  data: {'fechaInicio': fechaInicio,'fechaFin': fechaFin},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i=0;
                   var html='';
                   var contador=0;
                   var nregs=data.Fecha.length;
                   var comando;
                   for(i=0;i<nregs;i++)
                   {
             
                    contador++;

                    comando = 'ImpresionFactProv.php?IdFact='+data.IdFacturaProveedor[i];
                       // alert(comando);

                     var sub = parseFloat(data.Subtotal[i]);  
                     var desc = parseFloat(data.Descuento[i]);
                     var imp  = parseFloat(data.Iva[i]);
                     var tot  = parseFloat(data.Total[i]);
                   html="<tr><td style='color:#000000'>"+data.DescripcionAlmacen[i]+"</td>"+
                          "<td style='color:#000000'>"+data.Fecha[i]+'</td>'+
                          "<td style='color:#000000'>"+data.RUC[i]+'-'+data.DescripcionProveedor[i]+'</td>'+
                          "<td style='color:#000000; text-align:right;'>"+data.IdFacturaProveedor[i]+'</td>'+
                          "<td style='color:#100719; text-align:right;'>"+data.IdFacturaProveedorSRI[i]+'</td>'+
                          "<td style='color:#100719; text-align:right;'>"+sub.toFixed(2)+'</td>'+
                          "<td style='color:#100719; text-align:right;'>"+desc.toFixed(2)+'</td>'+
                          "<td style='color:#100719; text-align:right;'>"+imp.toFixed(2)+'</td>'+
                          "<td style='color:#100719; text-align:right;'>"+tot.toFixed(2)+'</td>'+
                          "<td style='color:#100719'><a href='#' onClick=popup_detalle_factura_proveedor('"+data.IdFacturaProveedor[i]+"') ><span title='Detalle de la Factura'><img src='../img/detalle.png'></span></a>&nbsp&nbsp"+
                               "<a href='"+comando+"' ><span title='Reimpresión Factura'><img src='../img/impresora.png'></span></a></td></tr> ";
                         $('#respuesta').append(html);
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

  
    $(document).ready(function() {
        $('#btnBuscar').click((setearTabla));

    })

</script>
