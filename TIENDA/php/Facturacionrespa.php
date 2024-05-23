<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        include("Conexion.php");   
        $x_usuario    =   $_SESSION['user'];
        
        $sql="SELECT * from systemprofile ";
        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs);
        $cobraIva =  $registro['CobraIva'];
        $ivaActual=  $registro['VigenteIva']; 
        $periodoLectivo = $registro['PeriodoLectivoActual'];
        $Asignacion =$registro['AsignarCajero'];
       
       $ListTipDoc='';
       $SqlTipDoc="Select * from admtipodocumento where Estado='A'";
       $ResultTipDoc=  mysqli_query($conexion, $SqlTipDoc);
       while($reg_TipDoc=  mysqli_fetch_array($ResultTipDoc))
       {
           $IdTipoDocumento=$reg_TipDoc['IdTipoDocumento'];
           $DescTipDoc=utf8_encode($reg_TipDoc['DescripcionTipoDocumento']);
           $ListTipDoc.=
              "<option value='".$IdTipoDocumento."'>".$DescTipDoc."</option>";
       }  

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
  
?>
<!DOCTYPE html>
<html>
  <head>
    <title> SISTEMA IMPORTBOOKS </title>
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

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
<body onload="confirmaAsignacion();">

<section>

  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' >  
      <div class='container'>
        <div class='panel panel-default'>
            <div class="panel-heading" style="font-size: 20px;color:#0080FF;font-weight:bold;">FACTURACIÓN
              <?php echo "<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:12px;color:#0080FF;background-color:    #FFFF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>";include('modalFormaPago.php');?>
              <button type="button" class="btn btn-primary btn-sm" title='Grabar' onClick='copiaValores();'  data-toggle="modal" data-target="#forma-pago"  style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-floppy-save'></span></button>
              <button class='btn btn-primary btn-sm' title='Limpiar btn-sm' onclick='' type='reset' style='font-size:12px;color:#0080FF;background-color:#FFFF00;border:none'><span class='glyphicon glyphicon-refresh'></span></button> 
            </div>
          <div class="panel-body" style="padding: 0px;">
              <div class="panel-body" style="width:75%; float:left; display:block;padding: 0px;"> 
                  <div class="form-row" style="padding: 4px;margin: 0px;" >
                      <input type='hidden' id='IdCliente' name='IdCiente' value=''>
                      <input type='hidden' id='CLienteNuevo' name='CLienteNuevo' value='N'>
                      <input type='hidden' id='Asignacion' name='Asignacion' value='<?php echo $Asignacion;?>'>
                      <input type='hidden' id='NumeroFilas' name='NumeroFilas' value='0'/>
                      <input type='hidden' id='ivaActual' name='ivaActual' value='<?php echo $ivaActual;?>' >
                      <div class="form-group col-md-2" style='padding: 4px;margin: 0px;'>
                        <label style='color:#0080FF;padding: 0px;margin: 0px;'  for="f_TipDoc">Tipo Documento:</label>
                          <select style='color:#0080FF;padding: 4px;margin: 0px;' id='IdTipDoc' name='IdTipDoc' class="form-control" disabled="yes">
                              <option value=''>Seleccionar</option>
                              <?php echo $ListTipDoc; ?>
                          </select> 
                      </div>
                      <div class="form-group col-md-2" style='padding: 4px;margin: 0px;'>
                          <label style='color:#0080FF;padding: 0px;margin: 0px;' for="f_cedula">Cédula/RUC:</label>
                          <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="Cedula" name='Cedula' placeholder="Cédula o RUC" onkeypress="buscarCliente(event)" onkeydown="buscarClienteTab(event)">
                      </div>                      
                     
                          <div class="form-group col-md-6" style='padding: 4px;margin: 0px;'>
                              <label style='color:#0080FF;padding: 0px;margin: 0px;'  for="f_apellidos">Nombre Cliente:</label>
                              <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="NombreCliente" name='NombreCliente' autocomplete="no">
                              <div id="sugerencias" class='list-group'></div>
                          </div>
                          
        

                      <div class="form-group col-md-2" style='padding: 4px;margin: 0px;'>
                              <label style='color:#0080FF;padding: 0px;margin: 0px;'  for="f_apellidos">Teléfono: </label>
                              <input style='color:#0080FF;padding: 0px;margin: 0px;' type="text" class="form-control" id="Telefono" name='Telefono' readonly="yes">
                      </div>    
                 </div>    

                  <div class="form-row" style="padding: 4px;margin: 0px;" >
                      <div class="form-group col-md-4" style='padding: 4px;margin: 0px;'>
                        <label style='color:#0080FF;padding: 0px;margin: 0px;' for="f_cedula">Email:</label>
                        <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="Email" name='Email' readonly="no" placeholder="ejemplo soyXavier@hotmail.com">
                      </div>                    

                      <div class="form-group col-md-5" style='padding:4px;margin: 0px;'>
                        <label style='color:#0080FF;padding: 0px;margin: 0px;' for="f_colegio">Empresa:</label>
                        <select style='color:#0080FF;padding: 4px;margin: 0px;' id='IdColegio' name='IdColegio' class="form-control" onchange='getPorceDescuento()' required="yes">
                          <option value=''>Seleccionar</option>
                            <?php
                               echo $ListaColegio;
                             ?>
                        </select> 
                      </div>
                      <div class="form-group col-md-3" style='padding: 4px;margin: 0px;'>
                              <label style='color:#0080FF;padding: 0px;margin: 0px;'  for="f_descuento">Descuento: </label>
                              <input style='color:#0080FF;padding: 4px;margin: 0px;text-align:right;' type="number" class="form-control" id="Descuento" name='Descuento' readonly="yes" value='0.00' step='0.01'>
                      </div>   
                  </div>
                  <div class="form-row" style="padding: 4px;margin: 0px;" >
                      <div class="form-group col-md-10" style='padding: 0px;margin: 0px;'>
                        <label style='color:#0080FF;padding: 0px;margin: 0px;' for="f_cedula">Dirección:</label>
                        <input style='color:#0080FF;padding: 4px;margin: 0px;' type="text" class="form-control" id="Direccion" name='Direccion' readonly="no" placeholder="Ingrese dirección domiciliaria">
                      </div>                      
                  </div>                  
              </div>
             
              <div class="panel-body" style="width:25%; float:left; display:block;background-color:#E6E6E6"> 
                  <div class="form-row" style="width:100%"  >
                    <style>
                        table {
                            font-family: 'Poppins', sans-serif;
                            /*border-collapse: collapse;*/
                            /*width: 100%;*/
                            font-size: 15px;
                        }
                    </style>
                    <table >
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspSubtotal:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='SubTotalPrincipal'  name='SubTotalPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspDscto:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='DescuentoPrincipal'  name='DescuentoPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspI.V.A.:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='IvaPrincipal'  name='IvaPrincipal' size='7' readonly style='border:none;width:100px;height:25px;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>
                      <tr style="font-size:23px;color:#0080FF;font-weight:bold;font-family: 'Poppins'"><td>&nbspTotal:</td><td>&nbsp</td><td style='background-color:#F7FE2E;font-size:25px'><input type='text' value='0.00' id='TotalFactura'  name='TotalFactura' size='7' readonly style='border:none;width:100px;height:25px;;text-align:right;color:#0080FF;background-color:#F7FE2E;'></td></tr>                      
                    </table>
                 </div>                                                                  
              </div>  
             </div>              
          </div>            
        </div>   

  <div class="container">
    <div class='panel panel-default'>
      <div class="panel-heading" style="font-size: 15px;color:#0080FF;font-weight:bold;" >DETALLE DE ITEMS</div>
       <div class="panel-body" style="width:100%; display:block;">

                <div class="form-row"  >
                  <div class="form-group col-md-2">
                          <input type='hidden' id='olrwm' name='olrwm' value='<?php  echo $x_usuario;?>'>
                          <input type='hidden' id='IdReferencia' name='IdReferencia' value=''>
                          <input type='hidden' id='CargaIva' name='CargaIva' value=''>
                          <input type='hidden' id='Iva' name='Iva' value=''>
                          <input type='hidden' id='Existe' name='Existe' value=''>

                          <label style='color:#0080FF' for="f_codigo">Item:</label>
                          <input style='color:#0080FF' type="text" class="form-control" id="Codigo" name='Codigo' placeholder="Código Barra" required="yes" onkeydown="capturaKey(event);">
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#FFFFFF' for="f_buscar">Find</label>
                      <button style='color:#0080FF' class='btn btn-primary btn-md' title='' onClick="popup('producto')" type='button'> <span class='glyphicon glyphicon-search' ></span> </button>
                  </div>
                  <div class="form-group col-md-5">
                      <label style='color:#0080FF'  for="f_apellidos">Descripción:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="NombreProducto" name='NombreProducto' readonly="yes">
                  </div>
                  <div class="form-group col-md-1">
                      <label style='color:#0080FF'  for="f_apellidos">Cant:</label>
                      <input style='color:#0080FF' type="number" step='0.1' class="form-control" id="Cantidad" name='Cantidad' value='1.0'  >
                  </div>
                  <div class="form-group col-md-2">
                      <label style='color:#0080FF'  for="f_apellidos">PVP:</label>
                      <input style='color:#0080FF' type="text" class="form-control" id="Precio" name='Precio' readonly="yes">
                  </div> 
                  <div class="form-group col-md-1">
                    <label style='color:#FFFFFF' for="f_add">add</label>
                    <input type='button' name='btnAgregar' id='add' class='btn btn-primary btn-sm' value='Add' onclick="addFilasFactura();" >
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
                <th bgcolor='#FFFF00' style='color: #0080FF' width='5%'><b><center>Item</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='10%'><b><center>Barra</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='35%'><b><center>Descripción</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='4%'><b><center>Cant.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>P.V.P.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Descuento</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Subtotal</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>I.V.A.</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='7%'><b><center>Total</center></b></th>
                <th bgcolor='#FFFF00' style='color: #0080FF' width='4%'><b><center><?php echo $codigoHtml;?></center></b></th>
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
   function getPorceDescuento(){
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
      xhr.onreadystatechange=ObtieneValor;
      xhr.open('POST','getDescuento.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdColegio="+document.getElementById('IdColegio').value);
      function ObtieneValor(){
        if(xhr.readyState==4){
          if(xhr.status==200){

            if(this.responseText==null){
              //alert(this.responseText);
               descuento=0.00;
            }
            else{
               descuento= parseFloat(this.responseText).toFixed(2);
            }
            document.getElementById('Descuento').value= descuento; 
          }
        }
      }
   } 

   var existeProducto=0;



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
                    document.getElementById('Precio').value         = datosArray[3];
                    document.getElementById('CargaIva').value       = datosArray[4];
                    document.getElementById('Iva').value            = datosArray[5];
                  //alert('eciste por si'+document.getElementById('Existe').value);
                  } 
                }
            }
      }
   }

function buscarClienteTab(e) { 
  
  var longcedula= $('#Cedula').val().length;
  if (window.event.keyCode==9)
  {
     if(longcedula>=10)
     {
          if(window.XMLHttpRequest)
          {
              xhr= new XMLHttpRequest();
          }
          else if(window.ActiveXObject){
             xhr=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xhr.onreadystatechange= retornaDatosCliente;
          xhr.open('POST','retornaDatosClientes2.php',false);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.send("CedulaCliente="+$('#Cedula').val());
          function retornaDatosCliente()
          {
           if(xhr.readyState==4)
              {
                if(xhr.status==200)
                  {
                    DatosString = this.responseText;
                    if(DatosString ==0)
                    {
                        alert('Cédula de Cliente no existe');
                    }
                    else
                    {
                        datosArray  =  DatosString.split('_;_');    
                        $('#IdCliente').val(datosArray[0]);
                        $('#Cedula').val(datosArray[1]);
                        $('#NombreCliente').val(datosArray[2]);
                        $('#Telefono').val(datosArray[3]);   
                        $('#Email').val(datosArray[4]);  
                        $('#Direccion').val(datosArray[5]); 
                    }
                  }
              }
           }
     }
     else
     {
        alert('Cédula o RUC invalido');
     }
  }
 }

function buscarCliente(e) { 
  var longcedula= $('#Cedula').val().length;
  tecla = (document.getElementById('Cedula')) ? e.keyCode :e.which; 
  if(tecla==13 )
  {
     if(longcedula>=10)
     {
          if(window.XMLHttpRequest)
          {
              xhr= new XMLHttpRequest();
          }
          else if(window.ActiveXObject){
             xhr=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xhr.onreadystatechange= retornaDatosCliente;
          xhr.open('POST','retornaDatosClientes2.php',false);
          xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          xhr.send("CedulaCliente="+$('#Cedula').val());
          function retornaDatosCliente()
          {
           if(xhr.readyState==4)
              {
                if(xhr.status==200)
                  {
                    DatosString = this.responseText;
                    if(DatosString ==0)
                    {
                        var confirmacion=confirm('Cédula de Cliente no existe desea crearlo?');
                        if (confirmacion){
                        	crearNuevoCliente();
                          $('#CLienteNuevo').val('S');
                        }
                    }
                    else
                    {
                        datosArray  =  DatosString.split('_;_');    
                        $('#IdCliente').val(datosArray[0]);
                        $('#Cedula').val(datosArray[1]);
                        $('#NombreCliente').val(datosArray[2]);
                        $('#Telefono').val(datosArray[3]);   
                        $('#Email').val(datosArray[4]);  
                        $('#Direccion').val(datosArray[5]); 
                    }
                  }
              }
           }
     }
     else
     {
        alert('Cédula o RUC invalido');
     }
  }

  
} 

function crearNuevoCliente()
{
	$('#IdTipDoc').removeAttr('disabled');
	$('#Telefono').removeAttr('readonly');
	$('#Email').removeAttr('readonly');
	$('#Direccion').removeAttr('readonly');


}


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
  
     
     if(tecla==113){
        addFilasFactura();
     }
   }

var i=0;
//#-----------------recalcula totales ------------------#
function recalculaTotal(){
            var xTotalBruto=0;
            var xTotalFactura=0;
            var xSubTotal=0;
            var xDescuento=0;
            var xIva = 0;
            $(this).closest('tr').remove();
            nfilas = $('#NumeroFilas').val();
               //alert('nfilas '+nfilas);
            for(i=1;i<=nfilas;i++){
                 var elementoTotalBruto=0;
                 var elementoDescuento=0;
                 var elementoSubTotal=0;
                 var elementoIva=0;
                 var elementoTotalLinea=0;
                 elementoTotalBruto='TotalBruto'+i;
                 elementoDescuento ='Descuento'+i;
                 elementoSubTotal = 'SubTotal'+i;
                 elementoIva = 'Iva'+i;
                 elementoTotalLinea='TotalLinea'+i;
                  if(document.getElementById(elementoTotalBruto))
                  {
                     xTotalBruto=xTotalBruto+ parseFloat(document.getElementById(elementoTotalBruto).value);
                  }
                  if(document.getElementById(elementoDescuento))
                  {
                     xDescuento=xDescuento+ parseFloat(document.getElementById(elementoDescuento).value);
                  }
                  xSubTotal=xSubTotal+(xTotalBruto - xDescuento);
                  if(document.getElementById(elementoIva))
                  {
                     xIva=xIva+ parseFloat(document.getElementById(elementoIva).value);
                  }
                  if(document.getElementById(elementoTotalLinea))
                  {
                     xTotalFactura=xTotalFactura+ parseFloat(document.getElementById(elementoTotalLinea).value);
                  }                                                      
               }
               $('#SubTotalPrincipal').val(xTotalBruto.toFixed(2));
               $('#DescuentoPrincipal').val(xDescuento.toFixed(2));
               $('#IvaPrincipal').val(xIva.toFixed(2));
               $('#TotalFactura').val(xTotalFactura.toFixed(2));
       }
//######----- Eliminar filas ------------#
        $(document).on('click','.eliminar',function(event){
            event.preventDefault();
            var xTotalBruto=0;
            var xTotalFactura=0;
            var xSubTotal=0;
            var xDescuento=0;
            var xIva = 0;
            $(this).closest('tr').remove();
               nfilas = $('#NumeroFilas').val();
               //alert('nfilas '+nfilas);
               for(i=1;i<=nfilas;i++){
                 var elementoTotalBruto=0;
                 var elementoDescuento=0;
                 var elementoSubTotal=0;
                 var elementoIva=0;
                 var elementoTotalLinea=0;
                 elementoTotalBruto='TotalBruto'+i;
                 elementoDescuento ='Descuento'+i;
                 elementoSubTotal = 'SubTotal'+i;
                 elementoIva = 'Iva'+i;
                 elementoTotalLinea='TotalLinea'+i;
                  if(document.getElementById(elementoTotalBruto))
                  {
                     xTotalBruto=xTotalBruto+ parseFloat(document.getElementById(elementoTotalBruto).value);
                  }
                  if(document.getElementById(elementoDescuento))
                  {
                     xDescuento=xDescuento+ parseFloat(document.getElementById(elementoDescuento).value);
                  }
                  xSubTotal=xSubTotal+(xTotalBruto - xDescuento);
                  if(document.getElementById(elementoIva))
                  {
                     xIva=xIva+ parseFloat(document.getElementById(elementoIva).value);
                  }
                  if(document.getElementById(elementoTotalLinea))
                  {
                     xTotalFactura=xTotalFactura+ parseFloat(document.getElementById(elementoTotalLinea).value);
                  }                                                      
               }
               $('#SubTotalPrincipal').val(xTotalBruto.toFixed(2));
               $('#DescuentoPrincipal').val(xDescuento.toFixed(2));
               $('#IvaPrincipal').val(xIva.toFixed(2));
               $('#TotalFactura').val(xTotalFactura.toFixed(2));

         }
            
        );

//######----- Eliminar filas formas de pago------------#
        $(document).on('click','.eliminarFormaPago',function(event){
            event.preventDefault();
            var xTotalFactura=0;
            var xTotalBruto=0;
            var xSubTotal=0;
            var xDescuento=0;
            $(this).closest('tr').remove();
               nfilas = $('#numeroFilasFormaPago').val();
               //alert('nfilas '+nfilas);
               for(i=1;i<=nfilas;i++){
                 var elementoTotalBruto=0;
                 elementoTotalBruto='TotalBruto'+i;

                  if(document.getElementById(elementoTotalBruto))
                  {
                     xTotalBruto=xTotalBruto+ parseFloat(document.getElementById(elementoTotalBruto).value);
                  }
                  xSubTotal=xSubTotal+(xTotalBruto - xDescuento);
                                             
               }
               $('#SubTotalPrincipal').val(xTotalBruto.toFixed(2));
         }           
        );


function trampa()
{
  $('#Codigo').val('0');
  //  location.reload();
}

function confirmaAsignacion(){
     var respuesta='';
     var asignacion=document.getElementById('Asignacion').value;
     if(asignacion=='S')
     {
        if(window.XMLHttpRequest){
            xhr= new XMLHttpRequest();
        }
        else if(window.ActiveXObject){
             xhr=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange= confirmar;
        xhr.open('POST','ConfirmaAsignacion.php',false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("Usuario="+document.getElementById('olrwm').value);
        function confirmar()
        {
           if(xhr.readyState==4)
              {
                if(xhr.status==200)
                  {
                    respuesta = this.responseText;
                    if(respuesta ==0)
                    {
                      alert('Usuario no registra asiganacion');
                      window.history.back();
                    }
                  }
              }
        }

     }
}
/*
$(function(){
    $('#NombreCliente').autocomplete({
      source:"retornaDatosCliente.php",
      minLength:2,
      select: function(event,ui){
        event.preventDefault();
        $('#NombreCliente').val(ui.item.Nombres);
      }
    });
});*/
//##############ESTE SI FUNCIONA A MEDNIA #############################333
/*$(document).ready(function(){
  
  $("#NombreCliente").keyup(function(){
     //var query=$('#NombreCliente').val();
    $.ajax({
    url: "retornaDatosCliente.php",
    type: "POST",
    data: {'Criterio':query},
    //beforeSend: function(){
      //$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
    //},
    success: function(data){
       $("#sugerencias").show();
      //$("#sugerencias").fadeIn(100).html(data);
       $("#sugerencias").html(data);
     // $("#search-box").css("background","#FFF");
    }
    });
  });
});*/
//##############ESTE SI FUNCIONA A MEDNIA #############################3*/


/*




$(document).ready(function() {
    $('#NombreCliente').on('keyup', function() {
        var query = $(this).val();    
        var dataString = query;

          $.ajax({
            type: "POST",
            url: "retornaDatosCliente.php",
            data: {'Criterio':query},
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencias').fadeIn(1000).html(data);
                //Al hacer click en alguna de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#NombreCliente').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencias').fadeOut(1000);
                        alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
                   }
               });
            
        }
    );
}); */
 /*$('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });*/
    
$(document).ready(function(){
  $("#NombreCliente").keyup(function(){
      var query = $(this).val();
      if(query.length>4)
      {
        $.ajax({
          url: 'retornaDatosCliente.php',
          method:  'POST',
          contentType: 'application/x-www-form-urlencoded',
          data: {'Criterio': query},
            success: function(data){
              $('#sugerencias').html(data);
              $('.list-group-item').on('click', function(){
                        
                        var IdCliente     = $(this).attr('id');
                        var Cedula        = $(this).attr('cedula');
                        var nombreCliente = $(this).attr('value');
                        var telefonos     = $(this).attr('telefonos');
                        var direccion     = $(this).attr('direccion');
                        var email         = $(this).attr('email');
                        var tipDoc        = $(this).attr('tipdoc');
                      // var tipdoc        = $(this).attr('tipdoc');
                        $('#NombreCliente').val(nombreCliente);
                        $('#IdCliente').val(IdCliente);
                        $('#Cedula').val(Cedula);
                        $('#Email').removeAttr('disabled');
                        $('#Email').val(email);
                        $('#Telefono').removeAttr('disabled');
                        $('#Telefono').val(telefonos);
                        $('#Direccion').removeAttr('disabled');
                        $('#Direccion').val(direccion);
                       // $('#IdTipDoc').removeAttr('disabled');
 //                       $('#IdTipDoc').empty();
                        $('#IdTipDoc').removeAttr('disabled');
                        var opciones = "<option value='C' selected>" + tipDoc  + '</option>';
                        document.getElementById("IdTipDoc").innerHTML = opciones;
                        $('#IdTipDoc').attr('disabled','disabled');
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

/*
$(document).on('click','li',function(){
    $('#NombreCliente').val($(this).text());
    $('#nombreClienteLista').fadeOut();
})*/

/*
    $(function() {
            $("#NombreCliente").autocomplete({

              source: "retornaDatosCliente.php",
              minLength: 2,
              select: function(event, data) {
                event.preventDefault();
                
                $('#CedulaCliente').val(data.item.Id);
                $('#NombreCliente').val(data.item.Nombres);
              //  $('#tel1').val(ui.item.telefono_cliente);
               // $('#mail').val(ui.item.email_cliente);
                                
                
               }
            });
          });*/

</script>
</html> 

   