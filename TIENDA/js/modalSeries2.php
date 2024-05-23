<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    

     } 

 ?>


<!DOCTYPE html>
<html>
<body >

<div style="font-family: 'Poppins', sans-serif; font-size: 11px;" class="modal fade" id="seriesProv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myModalLabel">Registro de Números de Serie Proveedores</h5>
			</div>
      <form  method="POST" >
                <br>
                <div class="form-row">
                     <input type='hidden' id='numerosFilasSeriesPr' value=''>
                     <div class="form-group col-md-8">
                         <input type='hidden' id='inputNumeroSeriePr' value=''>
                         <input type='hidden' id='cantidadItems' value=''>
                         <input type="text" id='IdCodigoItem' name='IdCodigoItem' class="form-control" readonly="yes" size="5">
                         <!--<input type="text" id='NombreItem' name='NombreItem' class="form-control" readonly="yes" >   -->                       
                     </div>
                </div>
                <div class="form-row">                     
                     <div class="form-group col-md-8">
     
                          <label style='color:#0080FF' for="Bancos">Número Serie:</label>
                          <input type="text" id='numeroSerie' name='numeroSerie' class="form-control" required size="30" onkeypress='return pulsar(event)'>                         
                	   </div>
 

  	                 <div class="form-group col-md-1">
	                       <label style='color:#FFFFFF' for="f_add">add</label>
	                       <input type='button' name='addNumerosSerie' id='addNumerosSerie' class='btn btn-primary btn-sm' value='Add' onclick="addSeriesPr();" >
	                   </div>  	                  
                </div>    	 
                <?php
                   $iconoEliminar = 'glyphicon glyphicon-trash';
                   $codigoHtml= "<span class='".$iconoEliminar."'></span>";
                ?>
                  <div id='tableContainer' class='tablaContainer'>
                    <table class='table table-bordered table-hover' id='tablaNumerosSeriePr' >
                      <tr  style='color: #0040FF;background-color:#FFFF00;'>
                        <td width="75%"  style='padding: 5px;'><center> <b>Números de Serie</b></center></td>
                        <td width="5%" style='padding: 5px;'><center><?php echo $codigoHtml;?></center></td>
                      </tr>                    
                    </table>             
                  </div>
		          <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-primary" id="btn_grabaSeries" onclick="saveNumeroSerieTempPr();" >Grabar</button>
		          </div>
     </div>
    </div>
  </div>
</body>
</html>
<script type="text/javascript">
    var arrSeries    =new Array();
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

  function saveNumeroSerieTempPr()
  { 
     alert('dentro serie temp');
      var i = 0;
      idItem        = $('#inputNumeroSeriePr').val();
      alert(idItem);
      cntItems      = $('#cantidadItems').val();
      nfilasSeries  = $('#numerosFilasSeriesPr').val();  
   //   alert('cantidad numer series'+nfilasSeries);
      //alert(nfilasSeries);
    	for(i=1;i<=nfilasSeries;i++)
    	{
        var elementoNumeroSerie = '';
    	  elementoNumeroSerie='IdNumeroSerie_'+i;
        alert('elemenro serie'+elementoNumeroSerie);

        //alert elementoNumeroSerie;
        //ert(document.getElementById(elementoNumeroSerie).value);
        if(document.getElementById(elementoNumeroSerie))
        {    
            alert('agregando arreglo');
             arrSeries.push(document.getElementById(elementoNumeroSerie).value);
        }
        
    	}


      grabarSeriesTempPr(idItem,nfilasSeries);
      $('#numerosFilasSeriesPr').val(0);
  }

 

  function grabarSeriesTempPr(Id,nfilasSeries){
    alert('id'+Id);
    //alert(arrSeries[0]);
    //alert(arrSeries[1]);
    //alert(arrSeries[0]);
    alert('por aca ando');
        $.ajax({
        type: 'POST',
        dataType:'html',  
        url: 'GrabarSeriesPr.php',
        data: { 'NumerosSerie':arrSeries,'CodigoItem':Id,'Cantidad':nfilasSeries},
        success: function(resp){  
            $("#seriesProv").modal('hide');//ocultamos el modal
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            //window.location="http://www.google.es"; 
            //window.open("ImpresionFactura.php?IdMov="+resp);
            //location.reload();
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
