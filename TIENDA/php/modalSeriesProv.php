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
     echo 'ffewfwf';
 ?>


<!DOCTYPE html>
<html>
<body >

<div style="font-family: 'Poppins', sans-serif; font-size: 11px;" class="modal fade" id="seriesProv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Registro de Números de Serie </h5>
      </div>
      <form  method="POST" >
                <br>
                <div class="form-row">
                     <input type='hidden' id='numerosFilasSeries' value='0'>
                     <div class="form-group col-md-8">
                         <input type='hidden' id='inputNumeroSerie' value=''>
                         <input type='hidden' id='cantidadItems' value=''>
                         <input type="text" id='IdCodigoItem' name='IdCodigoItem' class="form-control" readonly="yes" size="5">
                         <!--<input type="text" id='NombreItem' name='NombreItem' class="form-control" readonly="yes" >   -->                       
                     </div>
                </div>
                <div class="form-row">                     
                     <div class="form-group col-md-8">
     
                          <label style='color:#0080FF' for="Bancos">Número Serie:</label>
                          <input type="text" id='numeroSerie' name='numeroSerie' class="form-control" required size="30">                         
                     </div>
 

                     <div class="form-group col-md-1">
                         <label style='color:#FFFFFF' for="f_add">add</label>
                         <input type='button' name='addNumerosSerie' id='addNumerosSerie' class='btn btn-primary btn-sm' value='Add' onclick="addSeries();" >
                     </div>                     
                </div>       
                <?php
                   $iconoEliminar = 'glyphicon glyphicon-trash';
                   $codigoHtml= "<span class='".$iconoEliminar."'></span>";
                ?>
                  <div id='tableContainer' class='tablaContainer'>
                    <table class='table table-bordered table-hover' id='tablaNumerosSerie' >
                      <tr  style='color: #0040FF;background-color:#FFFF00;'>
                        <td width="75%"  style='padding: 5px;'><center> <b>Números de Serie</b></center></td>
                        <td width="5%" style='padding: 5px;'><center><?php echo $codigoHtml;?></center></td>
                      </tr>                    
                    </table>             
                  </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_grabaSeries" onclick="saveNumeroSerieTemp();" >Grabar</button>
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

  function saveNumeroSerieTemp()
  { 

      var i = 0;
      idItem        = $('#inputNumeroSerie').val();
      cntItems      = $('#cantidadItems').val();
      nfilasSeries  = $('#numerosFilasSeries').val();  
   //   alert('cantidad numer series'+nfilasSeries);

      for(i=1;i<=nfilasSeries;i++)
      {
        var elementoNumeroSerie = '';
        elementoNumeroSerie='IdNumeroSerie_'+i;

        //alert elementoNumeroSerie;
        //ert(document.getElementById(elementoNumeroSerie).value);
        if(document.getElementById(elementoNumeroSerie))
        {    
             arrSeries.push(document.getElementById(elementoNumeroSerie).value);
        }
        
      }

      grabarSeriesTemp(idItem,nfilasSeries);

      //for(i=1;i<=nfilasSeries;i++)
      //{
        arrSeries.splice(0,cntItems);
      //}
      $('#numerosFilasSeries').val(0);    


  }

 

  function grabarSeriesTemp(Id,nfilasSeries){
        $.ajax({
        type: 'POST',
        dataType:'html',  
        url: 'GrabarSeries.php',
        data: { 'NumerosSerie':arrSeries,'CodigoItem':Id,'Cantidad':nfilasSeries},
        success: function(resp){  
            $("#series").modal('hide');//ocultamos el modal
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
