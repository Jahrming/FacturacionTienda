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
       $SqlFormaPago="Select * from formapago where EstadoFormaPago='A'";
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
      <link rel='stylesheet' href='../css2/bootstrap.css'>
         
</head>
<body >
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

  function saveFactura()
  { 
     var SaldoPendiente = 0;
     var ValoraPagar    = 0;
     SaldoPendiente  = $('#SaldoPendiente').val();
     ValoraPagar     = $('#ValorPagar').val();
     if (parseFloat(SaldoPendiente) > 0)
     {
       alert('No se puede grabar si tiene valores pendientes')
     }
     else
     {
      IdCliente = $('#IdCliente').val();
      IdEmpresa = $('#IdColegio').val();
      Cedula = $('#Cedula').val();
      nFilasFactura = $('#NumeroFilas').val();
      subTotal = $('#SubTotalPrincipal').val();
      iva =$('#IvaPrincipal').val();
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
      var elementoIva ;
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
        elementoIva = "Iva"+i;
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
        if(document.getElementById(elementoSubtotal))
        {      
            arr_elementoSubtotal.push(  document.getElementById(elementoSubtotal).value);
        }
        if(document.getElementById(elementoIva))
        {      
            arr_elementoIva.push(document.getElementById(elementoIva).value);
        }
        if(document.getElementById(elementoTotalLinea))
        {
            arr_elementoTotalLinea.push(document.getElementById(elementoTotalLinea).value);
          }
      }
      if(IdCliente==null || IdCliente=="")
      {
          grabarCliente();
      }

      grabarFactura();
    }

  }

 function grabarCliente(){

      var datosString   =   '';
      var datosArray    =   new Array();
      var IdTipDoc      =   $('#IdTipDoc').val();
      var Cedula        =   $('#Cedula').val();
      var NombreCliente =   $('#NombreCliente').val();
      var Telefonos     =   $('#Telefono').val();
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



  function grabarFactura(){
        $.ajax({
        type: 'POST',
        dataType:'html',  
        url: 'GrabarFactura.php',
        data: { 'formasPago':arrTiposFormaPago,'Bancos': arrIdBanco,'Tarjetas':arrIdTarjeta,
                'NumerosTarjetas':arrNumeroTarjeta,'ValoresFormasPago':arrValorFormaPago,
                'CuantasFomasPago':nFilasFormaPagoFinal,'CantidadItems':nuevoCantidadFilas,
                'IdCliente':IdCliente,'IdEmpresa':IdEmpresa, 'Cedula':Cedula,'SubTotalFactura':subTotal,'DescuentoFactura':descuento,
                'IvaFactura':iva,'TotalFactura':totalFactura,'Items':arr_elementoIdReferencia,
                'Precios': arr_elementoPrecio,'Cantidad':arr_elementoCantidad,'TotalBruto':arr_elementoTotalBruto,
                'Descuento': arr_elementoDescuento,'Subtotal':arr_elementoSubtotal,'Iva': arr_elementoIva,
                'TotalLinea':arr_elementoTotalLinea},
        success: function(resp){  
            $("#forma-pago").modal('hide');//ocultamos el modal
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            alert("La Factura "+resp+" se ha generado con éxito");
            //window.location="http://www.google.es"; 
            window.open("ImpresionFactura.php?IdMov="+resp);
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
