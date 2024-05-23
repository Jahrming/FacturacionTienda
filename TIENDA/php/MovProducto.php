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
        $xIdAlmacen   = $_SESSION['idalmacen'];
        
        $sql="SELECT * from systemprofile where IdEmpresa= $xIdAlmacen ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);

      }
      header('Content-Type: text/html; charset=UTF-8');  
  
?>
<!DOCTYPE html>
<html>
  <?php include('head.php'); ?>
<!--   <head>
    <title> SISTEMA IMPORTBOOKS</title>
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


  </head> -->
<!---   <body onload='return inicio(\"\")'>    -->
<body>

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data'  >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">MOVIMIENTOS DE UN PRODUCTO
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";?>
              <button type="button" class="btn btn-primary btn-sm" title='Imprimir' action='ImprimirMovimientoProducto.php' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-print'></span></button>
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                  <div class="form-row"  >
                    <div class="form-group col-md-3">
                      <input type='hidden' name='saldoinicial' id='saldoinicial' value='0'>
                          <input type='hidden' id='IdReferencia' name='IdReferencia' value=''>
                          <input type='hidden' id='CargaIva' name='CargaIva' value=''>
                          <input type='hidden' id='Iva' name='Iva' value=''>
                          <input type='hidden' id='Existe' name='Existe' value=''>  
                          <input type='hidden' id='Precio' name='' value=''>    
                          <input type='hidden' id='Iva' name='Iva' value=''>    

                      <label style='color:#0080FF' for='inicio' class=''>Fecha Inicio: </label>
                      <input style='color:#0080FF' type="date" onkeypress="return pulsar(event)" class="form-control" id="FechaInicio" name='FechaInicio' required="yes">
                    </div>

                  <div class="form-group col-md-3">
                          <label style='color:#0080FF' for="f_codigo">Item:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Codigo" name='Codigo' placeholder="Código Barra" required="yes" onkeydown="capturaKey(event);">
                  </div>
                  <div class="form-group col-md-5">
                      <label style='color:#0080FF'  for="f_apellidos">Descripción:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="NombreProducto" name='NombreProducto' readonly="yes">
                  </div>      
                  <div class="form-group col-md-1">
                      <label style='color:#FFFFFF' for="f_buscar">Find</label>
                      <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="calcularSaldoInicial();" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
                  </div>                                     
               </div>          
          </div>              
       </div>            
    </div>   
  </div>
  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 12px;color:#0080FF;font-weight:bold;" >MOVIMIENTOS</div>
       <div class="panel-body" style="width:100%; display:block;">

           <table class='table table-bordered table-hover' id='tabla1'>
              <style> table {font-family: arial, 'Times New Roman', Times, serif;
                           border-collapse: collapse;
                           width: 80%;
                           font-size: 12px;}
            </style>   

            <thead class='fixedHeader' >
              <tr>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='9%'><b><center>Fecha</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Transacción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Bodega Origen</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='14%'><b><center>Bodega Destino</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='20%'><b><center>Observación</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Cantidad</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Stock Final</center></b></th>
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

   function capturaKey(event){
     var tecla= event.which|| event.keyCode;
     if (tecla==13){
       VerificaProducto();
          if(existeProducto==1)
          {
             document.getElementById('add').focus();    
          }
          else
          {
            alert('Item no existe');
            document.getElementById('Codigo').value=null;
            document.getElementById('Codigo').focus();
          }
          existeProducto=0;
        }
  
     

   }

   function setearTablaMovs(){
     var numFilas =   document.getElementById('tabla1').rows.length;
     var j=0;
     if(numFilas>1){
           for(j=1;j<numFilas;j++)
          {
             document.getElementById('tabla1').deleteRow('1');
          }
     }
      //  buscarVentasxClientes();
   }
   function calcularSaldoInicial()
   {
      var fechaInicio = document.getElementById('FechaInicio').value;
      var xsaldoInicial =0;
      setearTablaMovs();
        //alert(Criterio+' '+buscarPor);
        $.ajax({
                  url: 'calcularSaldoInicial.php',
                  data: {'fechaInicio': fechaInicio,'IdReferencia':document.getElementById('IdReferencia').value},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'html',

                  success: function(data)
                  {
                   var html='';
                   var xsaldoInicial=parseFloat(data);
                   style='color:#2E64FE;'
                   html="<tr><td colspan='5' style='font-weight: bold;color:#2E64FE;'>Saldo Inicial al "+fechaInicio+" : </td>"+
                   "<td colspan='2'  align='right' bgcolor='#C6F870' style='color:#2E64FE;'>"+xsaldoInicial.toFixed(2)+"</tr>";
                   document.getElementById('saldoinicial').value=xsaldoInicial;
                   $('#respuesta').append(html);
                   }
                })
                .done(function() {
                  console.log("success");
                  buscarMovProducto();
                })
                .fail(function() {
                  console.log("error");
                })
                .always(function() {
                  console.log("complete");
                });
                        
    }
      function VerificaProducto(){

      var datosString ='';
      var datosArray ='';   
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= ObtenerDatos;
      xhr.open('POST','RetornaDatosProducto.php',false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("Codigo="+document.getElementById('Codigo').value);

      function ObtenerDatos()
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
                    //document.getElementById('Precio').value         = datosArray[3];
                    //document.getElementById('CargaIva').value       = datosArray[4];
                    //document.getElementById('Iva').value            = datosArray[5];
                  //alert('eciste por si'+document.getElementById('Existe').value);
                  } 
                }
            }
      }
   }

   function buscarMovProducto(){
      var fechaInicio = document.getElementById('FechaInicio').value;
      var v_saldoInicial = document.getElementById('saldoinicial').value;
        //alert(Criterio+' '+buscarPor);
      $.ajax({
                  url: 'buscarMovProductos.php',
                  data: {'fechaInicio': fechaInicio,'IdReferencia':document.getElementById('IdReferencia').value},
                  type: 'POST',
                  contentType: 'application/x-www-form-urlencoded',
                  dataType: 'JSON',

                  success: function(data)
                  {
                   var i        =  0;
                   var html     =  '';
                   var html2    =  '';
                   var contador =  0;
                   var nregs    =  data.DescripcionTraslado.length;
                   var v_saldo  =  parseFloat(v_saldoInicial);
                   for(i=0;i<nregs;i++)
                   {
                     contador++;
                     v_saldo = v_saldo +  parseFloat(data.cantidad[i]);
                     if(data.Observacion[i]==null)
                     {
                      data.Observacion[i]='';
                     }

                     html="<tr><td style='color:#2E64FE;'>"+data.FechaTrx[i]+"</td>"+
                          "<td align='left'  style='color:#2E64FE;'>"+data.DescripcionTraslado[i]+"</td>"+
                          "<td align='left'  style='color:#2E64FE;'>"+data.BodegaOrigen[i]+"</td>"+
                          "<td align='left'  style='color:#2E64FE;'>"+data.BodegaDestino[i]+"</td>"+
                          "<td align='left'  style='color:#2E64FE;'>"+data.Observacion[i]+"</td>"+
                          "<td align='right' style='color:#2E64FE;'>"+parseFloat(data.cantidad[i]).toFixed(2)+"</td>";
                          if(v_saldo<=0)
                          {
                            html2="<td align='right' bgcolor='#FB2F76' style='color:#2E64FE;'>"+v_saldo+"</td></tr> ";
                          }
                          else
                          {  
                            html2="<td align='right' bgcolor='#C6F870' style='color:#2E64FE;'>"+v_saldo+"</td></tr> ";
                          }
                          html=html+html2;

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
        $('#btnBuscar').click((setearTablaMovs));

    })

</script>
