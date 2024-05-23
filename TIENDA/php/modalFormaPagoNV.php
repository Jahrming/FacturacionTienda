<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $ListaFormaPago='';
       $SqlFormaPago="Select * from formapago where IdFormaPago in (1,7) and EstadoFormaPago='A'";
       $ResultFormaPago=  mysqli_query($conexion, $SqlFormaPago);
       while($reg_FormaPago=  mysqli_fetch_array($ResultFormaPago))
       {
           $IdFormaPago=$reg_FormaPago['IdFormaPago'];
           $DescFormaPago=$reg_FormaPago['DescripcionFormaPago'];
           $Icono=$reg_FormaPago['Icono'];
           $ListaFormaPago.=
              "<option value='".$IdFormaPago."'>".$DescFormaPago."</option>";
       }  
       $ListaBancos='';
       $SqlBancos="Select * from bancos where EstadoBanco='A'";
       $ResultBancos=  mysqli_query($conexion, $SqlBancos);
       while($reg_Bancos=  mysqli_fetch_array($ResultBancos))
       {
           $IdBanco=$reg_Bancos['IdBanco'];
           $DescBanco=$reg_Bancos['DescripcionBanco'];
           $ListaBancos.=
              "<option value='".$IdBanco."'>".$DescBanco."</option>";
       }  
       $ListaTarjetas='';
       $SqlTarjetas="Select * from tarjetas where EstadoTarjeta='A'";
       $ResultTarjetas=  mysqli_query($conexion, $SqlTarjetas);
       while($reg_Tarjetas=  mysqli_fetch_array($ResultTarjetas))
       {
           $IdTarjeta=$reg_Tarjetas['IdTarjeta'];
           $DescTarjeta=$reg_Tarjetas['DescripcionTarjeta'];
           $ListaTarjetas.=
              "<option value='".$IdTarjeta."'>".$DescTarjeta."</option>";
       }         
     } 
 ?>


<!DOCTYPE html>
<html>
<head>
    <title> SISTEMA IMPORTBOOKS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type='text/javascript' src='../js/funciones.js'>          </script>
	<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
	    <link rel='stylesheet' href='../css/bootstrap.css'>
         
</head>
<body onload="copiaValores();">

<div style="font-family: 'Poppins', sans-serif; font-size: 11px;" class="modal fade" id="forma-pago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Forma de Pago	</h4>
			</div>
      <form  method="POST" >
                <br>
                <div class="form-row">
                     <div class="form-group col-md-4">
                         <input type='hidden' id='numeroFilasFormaPago' value='0'>
                         <label style='color:#0080FF' for="formapago">Forma de Pago:</label>
	                       <select style='color:#0080FF' id='IdFormaPago' name='IdFormaPago' class="form-control" required  onchange="activaElementos();" >
	                        <option value=''>Seleccionar</option>
	                        <?php
	                           echo $ListaFormaPago;
	                         ?>
	                       </select> 
                	   </div>
                     <div class="form-group col-md-4">
                        <label style='color:#0080FF' >Tarjeta:</label>
                        <select style='color:#0080FF' id='IdTarjeta' name='IdTarjeta' class="form-control" required>
                            <option value=''>Seleccionar</option>
                            <?php
                               echo $ListaTarjetas;
                             ?>
                        </select> 
                     </div>
                     <div class="form-group col-md-4">
                        <label style='color:#0080FF' for="Bancos">Banco:</label>
                        <select style='color:#0080FF' id='IdBanco' name='IdBanco' class="form-control" required>
                            <option value=''>Seleccionar</option>
                            <?php
                               echo $ListaBancos;
                             ?>
                        </select> 
                     </div>
	              </div>
                <div class="form-row">
                      <div class="form-group col-md-6">
                          <label style='color:#0080FF' for="Bancos">Número:</label>
                          <input type="number" id='numeroTarjeta' name='numeroTarjeta' class="form-control" required size="16">
                      </div>                 
                      <div class="form-group col-md-4">
                      	  <label style='color:#0080FF' for="Recibidor">Valor Recibido:</label>
  	                      <input type="number" id='valorRecibido' name='valorRecibido' class="form-control" step="0.01"  >
  	                  </div>  
  	                  <div class="form-group col-md-2">
	                       <label style='color:#FFFFFF' for="f_add">add</label>
	                       <input type='button' name='addFormaPago' id='addFormaPago' class='btn btn-primary btn-sm' value='Add' onclick="addsFormaPago();calculaSaldos();" >
	                    </div>  	                  
                </div>    	 
                <div class="form-row">  
                      <div class="form-group col-md-4">
                    	   <label style='color:#0080FF' for="Valor">Total a Pagar:</label>
	                       <input type="number" id='ValorPagar' name='ValorPagar' class="form-control" readonly="yes" >
	                    </div>	                  	
                      <div class="form-group col-md-4">
                      	   <label style='color:#0080FF' for="Cambio">Cambio:</label>
  	                       <input type="number" id='Cambio' name='Cambio' class="form-control" readonly="yes" value='0'>
  	                  </div>	
                      <div class="form-group col-md-4">
                      	   <label style='color:#0080FF' for="Cambio">Saldo Pendiente:</label>
  	                       <input type="number" id='saldoPendiente' name='saldoPendiente' class="form-control" readonly="yes">
  	                  </div>
    	         </div>
                <?php
                   $iconoEliminar = 'glyphicon glyphicon-trash';
                   $codigoHtml= "<span class='".$iconoEliminar."'></span>";
                ?>
                  <div id='tableContainer' class='tablaContainer'>
                    <table class='table table-bordered table-hover' id='tablaFormasPago' >
                      <tr  style='color: #0040FF;background-color:#FFFF00;'>
                        <td width="75%"  style='padding: 5px;'><center> <b>Formas Pago</b></center></td>
                        <td width="20%" style='padding: 5px;'><center>  <b>Valor</b></center></td>
                        <td width="5%" style='padding: 5px;'><center><?php echo $codigoHtml;?></center></td>
                      </tr>                    
                    </table>             
                  </div>
		          <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-primary" onclick="saveNV();trampa();" >Grabar</button>
		          </div>
     </div>
    </div>
  </div>
</body>
</html>
<script type="text/javascript">
    var arrTiposFormaPago=new Array();
    var arrValorFormaPago=new Array();
    var arrIdBanco=new Array();
    var arrIdTarjeta=new Array();
    var arrNumeroTarjeta=new Array();
    var nfilasFormasPago;
    var IdCliente     = null;
    var IdEmpresa;  
    var Cedula        = null;
    var nFilasFactura;
    var subTotal ;
    var iva ;
    var descuento ;
    var totalFactura ;
    var arr_elementoIdReferencia =new Array();
    var arr_elementoPrecio =new Array();
    var arr_elementoCantidad=new Array();
    var arr_elementoTotalBruto=new Array();
    var arr_elementoDescuento =new Array();
    var arr_elementoSubtotal =new Array();
    var arr_elementoIva =new Array();
    var arr_elementoTotalLinea =new Array();
    var nuevoCantidadFilas = 0;
    var nFilasFormaPagoFinal=0;

  function copiaValores()
  {
     document.getElementById('ValorPagar').value=document.getElementById('TotalFactura').value;
  }

  function saveNV()
  { 
    IdCliente = $('#IdCliente').val();
    IdEmpresa = $('#IdColegio').val();
    Cedula = $('#Cedula').val();
    nFilasFactura = $('#NumeroFilas').val();
    subTotal = $('#SubTotalPrincipal').val();
  //  iva =$('#IvaPrincipal').val();
    descuento =$('#DescuentoPrincipal').val();
    totalFactura = $('#TotalFactura').val();
  	var i=0;
  	var j=0;
    var jj=0;
  	var elementoIdFormaPago;
  	var elementoValorFormaPago;
    var elementoIdBanco;
    var elementoIdTarjeta;
    var elementoNumeroTarjeta;
    //---------Detalle factura
    var elementoIdReferencia;
    var elementoPrecio;
    var elementoCantidad;
    var elementoTotalBruto;
    var elementoDescuento;
    var elementoSubtotal;
   // var elementoIva ;
    var elementoTotalLinea;
  	//nfilasFormasPago= $('#tablaFormasPago tr')   //.length;

    nfilasFormasPago= $('#numeroFilasFormaPago').val();   //.length;
    //alert(nfilasFormasPago);
  	for(i=1;i<=nfilasFormasPago;i++)
  	{
  	  elementoIdFormaPago='IdFormaPago'+i;
      elementoIdBanco = 'IdBanco'+i;
      elementoIdTarjeta = 'IdTarjeta'+i;
      elementoNumeroTarjeta = 'numeroTarjeta'+i;
      elementoValorFormaPago='ValorTipoFormaPago'+i;

      if(document.getElementById(elementoIdFormaPago))
      {    
           nFilasFormaPagoFinal++;
            arrTiposFormaPago.push(document.getElementById(elementoIdFormaPago).value);
      }
       if(document.getElementById(elementoIdBanco))
      {   
          arrIdBanco.push(document.getElementById(elementoIdBanco).value);
      }
      if(document.getElementById(elementoIdTarjeta))
      {      
          arrIdTarjeta.push(document.getElementById(elementoIdTarjeta).value);
      }
      if(document.getElementById(elementoNumeroTarjeta))
      {      
          arrNumeroTarjeta.push(document.getElementById(elementoNumeroTarjeta).value);
      }
      if(document.getElementById(elementoValorFormaPago))
      {      
          arrValorFormaPago.push(document.getElementById(elementoValorFormaPago).value);
      }      

      j++;
  	}
    for(i=1;i<=(nFilasFactura);i++)
    {
      elementoIdReferencia="IdReferencia"+i;
      elementoPrecio = "Precio"+i;
      elementoCantidad = "Cantidad"+i;
      elementoTotalBruto= "TotalBruto"+i;
      elementoDescuento = "Descuento"+i;
      elementoSubtotal = "Subtotal"+i;
  //    elementoIva = "Iva"+i;
      elementoTotalLinea = "TotalLinea"+i;
      if(document.getElementById(elementoIdReferencia))
      {
          nuevoCantidadFilas++;
          arr_elementoIdReferencia.push(document.getElementById(elementoIdReferencia).value);
      }
      if(document.getElementById(elementoPrecio))
      {      
          arr_elementoPrecio.push(document.getElementById(elementoPrecio).value);
      }
      if(document.getElementById(elementoCantidad))
      {      
          arr_elementoCantidad.push(document.getElementById(elementoCantidad).value);
      }
      if(document.getElementById(elementoTotalBruto))
      {      
          arr_elementoTotalBruto.push(document.getElementById(elementoTotalBruto).value);
      }
      if(document.getElementById(elementoDescuento))
      {
          arr_elementoDescuento.push( document.getElementById(elementoDescuento).value);
      }
      if(document.getElementById(elementoDescuento))
      {      
          arr_elementoSubtotal.push(  document.getElementById(elementoDescuento).value);
      }
      /*if(document.getElementById(elementoIva))
      {      
          arr_elementoIva.push(document.getElementById(elementoIva).value);
      }*/
      if(document.getElementById(elementoTotalLinea))
      {
          arr_elementoTotalLinea.push(document.getElementById(elementoTotalLinea).value);
        }
    }
    if(IdCliente==null || IdCliente=="")
    {
        grabarCliente();
    }

    grabarNV();

  }

 function grabarCliente(){

      var datosString   =   '';
      var datosArray    =   new Array();
      var IdTipDoc      =   $('#IdTipDoc').val();
      var Cedula        =   $('#Cedula').val();
      var NombreCliente =   $('#NombreCliente').val();
      var Telefonos     =   $('#Telefonos').val();
      var Direccion     =   $('#Direccion').val();
      var Email         =   $('#Email').val();
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= ObtenerDatosClienteNuevo;
      xhr.open('POST','GrabarClienteFac.php',false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(
        "IdTipDoc="+IdTipDoc+"&NumDoc="+Cedula+"&NombreCliente="+NombreCliente+"&Telefonos="+Telefonos+"&Direccion="+Direccion+"&Email="+Email);


      function ObtenerDatosClienteNuevo()
      {
         if(xhr.readyState==4)
            {
              if(xhr.status==200)
                { 
                   datosString    =   this.responseText;
                   datosArray     =   datosString.split('_;_');  
                   IdCliente      =   datosArray[0];
                   Cedula         =   datosArray[1];
                   //alert("datos string "+ datosString);
                  /// alert("idcliemte : "+datosArray[0]+"cedula :"+datosArray[1])
                }
            }
      }
 }



  function grabarNV(){

        $.ajax({
        type: 'POST',
        dataType:'html',  
        url: 'GrabarNotaVenta.php',
        data: { 'formasPago':arrTiposFormaPago,'Bancos': arrIdBanco,'Tarjetas':arrIdTarjeta,
                'NumerosTarjetas':arrNumeroTarjeta,'ValoresFormasPago':arrValorFormaPago,
                'CuantasFomasPago':nFilasFormaPagoFinal,'CantidadItems':nuevoCantidadFilas,
                'IdCliente':IdCliente,'IdEmpresa':IdEmpresa, 'Cedula':Cedula,'SubTotalFactura':subTotal,'DescuentoFactura':descuento,
                'IvaFactura':0,'TotalFactura':totalFactura,'Items':arr_elementoIdReferencia,
                'Precios': arr_elementoPrecio,'Cantidad':arr_elementoCantidad,'TotalBruto':arr_elementoTotalBruto,
                'Descuento': arr_elementoDescuento,'Subtotal':arr_elementoSubtotal,
                'TotalLinea':arr_elementoTotalLinea},
        success: function(resp){  
            $("#forma-pago").modal('hide');//ocultamos el modal
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            alert("El comprobante de Venta No: "+resp+" se ha generado con éxtio");
            //window.location="http://www.google.es"; 
            window.open("ImpresionNuevaNV.php?IdMov="+resp);
            location.reload();
        }
    })
    .done(function() {
      console.log("success");
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      console.log("ERROR");
    })
    .always(function() {
      console.log("complete");
    });

}

</script>
