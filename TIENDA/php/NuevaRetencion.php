<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $ListaUsuario='';
       $SqlUsuario="Select * from admusuarios where EstadoUsuario='A'";
       $rs=  mysqli_query($conexion, $SqlUsuario);
       while($regUsuario=  mysqli_fetch_array($rs))
       {
           $IdUsuario=$regUsuario['IdUsuario'];
           $NombreUsuario=$regUsuario['ApellidosUsuario'].' '.$regUsuario['NombresUsuario'];
           $ListaUsuario.="<option value='".$IdUsuario."'>".$NombreUsuario."</option>";
       }    
       $ListaPorcentajes='';
       $SqlPorcentajes="Select * from porcentajesRetenciones where Estado='A'";
       $rs=  mysqli_query($conexion, $SqlPorcentajes);
       while($regPorcentaje=  mysqli_fetch_array($rs))
       {
           $IdPorcentaje=$regPorcentaje['IdPorcentaje'];
           $ValorPorcentaje=$regPorcentaje['ValorPorcentaje']." "."%";
           $ListaPorcentajes.="<option value='".$IdPorcentaje."'>".$ValorPorcentaje."</option>";
       } 
       $ListaTurnos='';
       $SqlTurnos="Select * from turnos where EstadoTurno='A'";
       $rs=  mysqli_query($conexion, $SqlTurnos);
       while($regTurnos=  mysqli_fetch_array($rs))
       {
           $IdTurno=$regTurnos['IdTurno'];
           $DescTurno=$regTurnos['HoraInicio'].'-'.$regTurnos['HoraFin'];
           $ListaTurnos.="<option value='".$IdTurno."'>".$DescTurno."</option>";
       } 

       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados ";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $descEstado = $regEstados['DescripcionEstado'];
       while($regEstados=  mysqli_fetch_array($rsestados))
       {
           $IdEstado=$regEstados['IdEstado'];
           $DescripcionEstado=$regEstados['DescripcionEstado'];
           $ListaEstados.=
              "<option value='".$IdEstado."'>".$DescripcionEstado."</option>";
       }  

     } 
 ?>
       

<head>
			<title> SISTEMA IMPORTBOOKS</title>
			<script type='text/javascript' src='../js/funciones.js'> 					</script>
			<script type='text/javascript' src='../js/alertifyjs/alertify.js'> 	</script>
			<script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
			<meta http-equiv='Content-Type' content='text/html'; charset='utf-8'/>
			<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
			<link rel='stylesheet' href='../css/estilos.css' >
			<link rel='stylesheet' href='../css/bootstrap.min.css'>
			<link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />
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
</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarRetencion.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Retencion
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <input type='hidden' id='IdProveedor' name='IdProveedor' value=''>
                  <input type='hidden' id='CodigoImpuestoSRI' name='CodigoImpuestoSRI' value=''>
                  <input type='hidden' id='valorPorcentaje' name='valorPorcentaje' value=''>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">IdRetencion:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="IdRetencion" name="IdRetencion" placeholder="Número Retención" readonly="yes">
                  </div>    
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Secuencial SRI:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="sri" name="sri" placeholder="Número Secuencial SRI:" readonly="yes">
                  </div>                                    
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Numero Factura Proveedor:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="NumeroFactProveedor" name="NumeroFactProveedor" placeholder="Ingrese factura de proveedor">

                  </div>                  
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Proveedor:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="NombreProveedor" name="NombreProveedor" placeholder="Proveedor" >
                    <div id="sugerencias" class='list-group'></div>
                  </div>     
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">SubTotal:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="SubTotal" name="SubTotal" placeholder="SubTotal" readonly="yes">
                  </div>                       
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Iva:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="iva" name="iva" placeholder="Iva" readonly="yes">
                  </div>     
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Total:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="total" name="total" placeholder="Total" readonly="yes">
                  </div>     
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF' for="f_ruc">Porcentaje a Retener:</label>
                    <select style='color:#0080FF' id='IdPorcentaje' name='IdPorcentaje' class="form-control" onchange='getCalculaValorRetenido()' required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaPorcentajes;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Valor Retenido:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="valorRetenido" name="valorRetenido" placeholder="Valor Retenido" readonly="yes">
                  </div>     


                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">	
                    <label style='color:#0080FF' for="Turno">Fecha Retención:</label>
                    <input style='color:#0080FF' type="date" class="form-control" id="FechaAsignacion" name="FechaAsignacion" placeholder="Fecha Asignación" required>
                  </div>                  
                </div>


             </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>
   

<script type="text/javascript">


   function getCalculaValorRetenido(){
      var datosString='';
      var datosArray='';
      var descuento=0.00;
      if(window.XMLHttpRequest){
        xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject)
      {
        xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange=ObtieneValorRetenido;
      xhr.open('POST','getPorcentaje.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdPorcentaje="+document.getElementById('IdPorcentaje').value);

      function ObtieneValorRetenido(){
        if(xhr.readyState==4){
          if(xhr.status==200){
            datosString = this.responseText;
            datosArray = datosString.split('_;_');                 
            document.getElementById('valorPorcentaje').value=datosArray[1];
            document.getElementById('CodigoImpuestoSRI').value=datosArray[2];
            var valorPorcentaje=parseFloat(datosArray[1]);
            var valorIva = parseFloat(document.getElementById('iva').value);
            document.getElementById('valorRetenido').value= valorIva*(valorPorcentaje/100);
            
          }
        }
      }
   } 

$(document).ready(function(){
  $("#NombreProveedor").keyup(function(){
      var query = $(this).val();
      if(query.length>3)
      {
        $.ajax({
          url: 'retornaFacturasProveedores.php',
          method:  'POST',
          contentType: 'application/x-www-form-urlencoded',
          data: {'Criterio': query},
            success: function(data){
              $('#sugerencias').html(data);
              $('.list-group-item').on('click', function(){
                        
                        var NumeroFactProveedor     = $(this).attr('IdFactura');
                        var SubTotal        = $(this).attr('SubTotal');
                        var NombreProveedor = $(this).attr('NombreProveedor');
                        var Iva     = $(this).attr('Iva');
                        var Total     = $(this).attr('Total');
                        var Sri      = $(this).attr('Sri');

                        $('#NumeroFactProveedor').val(NumeroFactProveedor);
                        $('#SubTotal').val(SubTotal);
                        $('#NombreProveedor').val(NombreProveedor);
                        $('#iva').val(Iva);
                        $('#total').val(Total);
                        $('#sri').val(Sri);
                       // $('#IdTipDoc').removeAttr('disabled');
 //                       $('#IdTipDoc').empty();
                      //  var opciones = "<option value='C' selected>" + tipDoc  + '</option>';
                     //   document.getElementById("IdTipDoc").innerHTML = opciones;
                      //  $('#IdTipDoc').attr('disabled','disabled');
                        //$('#IdTipDoc').append("<option value='C' selected>"+TipDoc+"</option>");
                        $('.list-group-item').fadeOut(1000);
                });
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

  })
})
</script>