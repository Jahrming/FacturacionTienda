


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
        $x_usuario    =   $_SESSION['user'];
        $x_IdAlmacen  =   $_SESSION['idalmacen'];
        $sql="SELECT * from systemprofile where IdEmpresa=$x_IdAlmacen";    
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];

       $ListaColegio='';
       $SqlColegios="Select * from colegios ";
       $ResultColegios=  mysqli_query($conexion, $SqlColegios);
       while($reg_Colegios=  mysqli_fetch_array($ResultColegios))
       {
           $IdColegio=$reg_Colegios['IdColegio'];
           $DescColegio=$reg_Colegios['DescripcionColegio'];
           $ListaColegio.=
              "<option value='".$IdColegio."'>".$DescColegio."</option>";
       }  


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
                      font-size: 10px;} 

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
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;" width="75%">REPORTE DE VENTA DETALLE COSTO/UTILIDAD
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
                       <button class='btn btn-primary btn-md' name='btnBuscar' id='btnBuscar'  type='button' title='Buscar' onClick='buscarFacturas();' style='color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-search'></span></button>                       
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
                           font-size: 11px;}
            </style>   



            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Almacen</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Fecha</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='12%'><b><center>Tipo Documento</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Ítem</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='35%'><b><center>Descripcion Ítem</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Sec.</center></b></th>     
                <th bgcolor='#FFFF00' style='color: #0080FF' width='4%'><b><center>Cant.</center></b></th>              
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Pvp</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Cst Vta</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='6%'><b><center>Utilidad</center></b></th>

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
   function buscarFacturas(){
      var fechaInicio = document.getElementById('FechaInicio').value;
      var fechaFin = document.getElementById('FechaFin').value;

        //alert(Criterio+' '+buscarPor);
        $.ajax({
                  url: 'BuscarVentasDet.php',
                  data: {'fechaInicio': fechaInicio,'fechaFin': fechaFin},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i=0;
                   var html='';
                   var contador=0;
                   var nregs=data.fecha.length;
                   var comando;
                   var costoVenta;
                   var precioVenta;
                   var canti;
                   var utilidad;
                   var totCanti=0;
                   var totPreVen=0;
                   var totCosVen=0;
                   var totUtilidad=0;
                   var totpvp =0;
                   var totcost = 0;
                   for(i=0;i<nregs;i++)
                   {
             
/*                    contador++;
                     if (data.TipDoc[i]=='1')
                     {
                        comando = 'ImpresionFactura.php?IdMov='+data.IdMov[i];
                       // alert(comando);
                     }
                     if (data.TipDoc[i]=='2')
                     {
                        comando = 'ImpresionNuevaNV.php?IdMov='+data.IdMov[i];
                      //  alert(comando);
                     }  */         
                     ///alert('fffee' + +data.TipDoc[i]);       
                    costoVenta =parseFloat(data.CostoVenta[i]);
                    precioVenta =parseFloat(data.Precio[i]);
                    canti =parseInt(data.Cantidad[i]);
                    
                    totpvp = precioVenta*canti;
                    totcost = costoVenta * canti;
                    utilidad = totpvp-totcost;
                    html="<tr><td style='color:#000000'>"+data.DescripcionAlmacen[i]+"</td>"+
                          "<td style='color:#000000'>"+data.fecha[i]+"</td>"+
                          "<td style='color:#000000'>"+data.DescripcionTipoDocumento[i]+"</td>"+
                          "<td style='color:#000000'>"+data.IdReferencia[i]+"</td>"+   
                          "<td style='color:#000000'>"+data.DescripcionReferencia[i]+"</td>"+                                              
                          "<td style='color:#000000'>"+data.FactSri[i]+"</td>"+            


                          "<td style='color:#000000; text-align:right;'>"+canti.toFixed(0)+"</td>"+
                          "<td style='color:#000000; text-align:right;'>"+totpvp.toFixed(2)+"</td>"+
                          "<td style='color:#000000; text-align:right;'>"+totcost.toFixed(2)+"</td>"+
                          "<td style='color:#000000; text-align:right;'>"+utilidad.toFixed(2)+"</td></tr>";

                        //  "<td style='color:#000000'><a href='#' onClick=popup_detalle_factura('"+data.IdMov[i]+"') ><span title='Detalle de la Factura'><img src='../img/detalle.png'></span></a>&nbsp&nbsp"+
                        //       "<a href='"+comando+"' ><span title='Reimpresión Factura'><img src='../img/impresora.png'></span></a></td></tr> ";
                         $('#respuesta').append(html);
		                   totCanti=totCanti+canti;
		                   totPreVen=totPreVen+totpvp;
		                   totCosVen=totCosVen+totcost;
                       totUtilidad=totPreVen-totCosVen;


                   } 
                    // totpvp = totCanti*
                     html="<tr><td colspan=6 style='color:#000000; text-align:right;'>Totales</td>"+
                     "<td style='color:#000000; text-align:right;'>"+totCanti.toFixed(0)+"</td>"+
                     "<td style='color:#000000; text-align:right;'>"+totPreVen.toFixed(2)+"</td>"+
                     "<td style='color:#000000; text-align:right;'>"+totCosVen.toFixed(2)+"</td>"+
                     "<td style='color:#000000; text-align:right;'>"+totUtilidad.toFixed(2)+"</td></tr>";
                     $('#respuesta').append(html);
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
