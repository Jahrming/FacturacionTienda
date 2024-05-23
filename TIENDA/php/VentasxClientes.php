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
        
        $sql="SELECT * from systemprofile ";
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
      header('Content-Type: text/html; charset=UTF-8');  
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA IMPORTBOOKS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

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

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'  action='ImprimirVentasxClientes.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">REPORTE VENTAS POR CLIENTES
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="submit" class="btn btn-primary btn-sm" title='Imprimir' action='ImprimirReporteVentas.php' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-print'></span></button>
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
                       <button style='color:#0080FF' id='btnBuscar' name='btnBuscar' class='btn btn-primary btn-md' title='' onClick="buscarVentasxClientes();" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
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
                <th bgcolor='#FFFF00' style='color: #0080FF' width='40%'><b><center>Colegio</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Cantidad</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Subtotal</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Descuento</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Iva</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Detalle</center></b></th>
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
      //  buscarVentasxClientes();
   }
   function buscarVentasxClientes(){
      var fechaInicio = document.getElementById('FechaInicio').value;
      var fechaFin = document.getElementById('FechaFin').value;
      var xSubtotal=0;
      var xDescuento=0;
      var xImpuesto=0;
      var xTotal=0;
      var xCantidades=0;
        //alert(Criterio+' '+buscarPor);
        $.ajax({
                  url: 'BuscarVentasxClientes.php',
                  data: {'fechaInicio': fechaInicio,'fechaFin': fechaFin},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i=0;
                   var html='';
                   var contador=0;
                   var nregs=data.data.length;
                   for(i=0;i<nregs;i++)
                   {
                     contador++;
                     html="<tr><td>"+data.data[i].DescripcionColegio+"</td>"+
                          "<td align='right'>"+parseFloat(data.data[i].Cantidad).toFixed(0)+"</td>"+
                          "<td align='right'>"+parseFloat(data.data[i].Subtotal).toFixed(2)+"</td>"+
                          "<td align='right'>"+parseFloat(data.data[i].Descuento).toFixed(2)+"</td>"+
                          "<td align='right'>"+parseFloat(data.data[i].Impuesto).toFixed(2)+"</td>"+
                          "<td align='right'>"+parseFloat(data.data[i].Total).toFixed(2)+"</td>"+
                          "<td><a href='#' ><span title='Detalle del Prodcuto'><img src='../img/detalle.png'></span></a></td></tr> ";
                         $('#respuesta').append(html);
                            xCantidades=xCantidades+parseFloat(data.data[i].Cantidad);
                            xSubtotal=xSubtotal+parseFloat(data.data[i].Subtotal);
	      					          xDescuento=xDescuento+parseFloat(data.data[i].Descuento);
	      					          xImpuesto=xImpuesto+parseFloat(data.data[i].Impuesto);
	      			              xTotal=xTotal+parseFloat(data.data[i].Total);
                   }
                    html="<tr><td bgcolor='#58FA82'>Totales </td>"+
                          "<td align='right' bgcolor='#58FA82'>"+xCantidades+'</td>'+
                          "<td align='right' bgcolor='#58FA82'>"+xSubtotal.toFixed(2)+"</td>"+
                          "<td align='right' bgcolor='#58FA82'>"+xDescuento.toFixed(2)+"</td>"+
                          "<td align='right' bgcolor='#58FA82'>"+xImpuesto.toFixed(2)+"</td>"+
                          "<td colspan='2' align='right' bgcolor='#58FA82'>"+xTotal.toFixed(2)+"</td></tr>";
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
