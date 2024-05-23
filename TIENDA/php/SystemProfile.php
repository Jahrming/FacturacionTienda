<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $ListaFormasPago='';
       $x_usuario    = $_SESSION['user'];
       $x_IdAlmacen  = $_SESSION['idalmacen'];

       $sqlParametros = "select * from systemprofile where IdEmpresa= $x_IdAlmacen";
       $rs                  = mysqli_query($conexion,$sqlParametros);
       $reg                 = mysqli_fetch_assoc($rs);
       $ruc                 = $reg['RUC'];
       $nombreEmpresa       = $reg['NombreEmpresa'];
       $direccion           = $reg['Direccion'];
       $telefonos           = $reg['Telefonos'];
       $iva                 = $reg['Iva'];
       $efectivo            = $reg['SoloEfectivo'];
       $asignarCajero       = $reg['AsignarCajero'];
       $Denominacion        = $reg['DenominacionMonedas'];
       $gerente             = $reg['Gerente'];
       $xemail              = $reg['email'];
       $nombreComercial     = $reg['NombreComercial'];
       $ListaFormasPago     = '';
       $ListaAsignarCajero  = '';
       $ListaDenominacion   = '';

       if($efectivo=="S")
       {
         $ListaFormasPago="<option value='S' Selected>Si</option>";
         $ListaFormasPago.="<option value='N' >Varias Formas</option>";
       }
       else
       {
         $ListaFormasPago="<option value='N' Selected>Varias Formas de Pago</option>";
         $ListaFormasPago.="<option value='S' >Si</option>";
       }
       if($asignarCajero=="S")
       {
         $ListaAsignarCajero="<option value='S' Selected>Si</option>";
         $ListaAsignarCajero.="<option value='N' >No</option>";
       }
       else
       {
         $ListaAsignarCajero="<option value='N' Selected>No</option>";
         $ListaAsignarCajero.="<option value='S' >Si</option>";
       }
       if($Denominacion=="S")
       {
         $ListaDenominacion="<option value='S' Selected>Si</option>";
         $ListaDenominacion.="<option value='N' >No</option>";
       }
       else
       {
         $ListaDenominacion="<option value='N' Selected>No</option>";
         $ListaDenominacion.="<option value='S' >Si</option>";
       }
      } 
 ?>
       

<head>
<?php include('head.php') ; ?>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarSystemProfile.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>System Profile
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_ruc">RUC/Cédula</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC" readonly="yes" value='<?php echo $ruc;?>'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_ruc">Nombre Comercial</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="nombreComercial" name="nombreComercial" placeholder="Nombre Comercial"  value='<?php echo $nombreComercial;?>'>
                  </div>                  
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="inputPassword4">Descripción Razon Social:</label>
                    <input style='color:#0080FF' type="text" name='nombre' class="form-control" id="nombre" placeholder="Nombre Empresa"  value='<?php echo $nombreEmpresa;?>' >
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="inputPassword4">Representante Legal:</label>
                    <input style='color:#0080FF' type="text" name='repLegal' class="form-control" id="repLegal" placeholder="Nombre Empresa"  value='<?php echo $gerente;?>' >
                  </div>                  
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Dirección:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="direccion" name='direccion' placeholder="Ingrese Dirección" value='<?php echo $direccion;?>'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name="Telefonos" placeholder="Teléfonos" value='<?php echo $telefonos;?>' >
                  </div>                 
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_direccion">Iva:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="iva" name='iva' placeholder="Valor del Iva" value='<?php echo $iva;?>'>
                 </div>
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Formas de Pago: Solo Efectivo?:</label>
                        <select style='color:#0080FF' id='soloEfectivo' name='soloEfectivo' class="form-control" required="yes">
                          <?php echo $ListaFormasPago;?>
                        </select> 
                  </div>        
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Asignar Cajeros?:</label>
                        <select style='color:#0080FF' id='asignarCajero' name='asignarCajero' class="form-control" required="yes">
                          <?php echo $ListaAsignarCajero;?>
                        </select> 
                  </div>            
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF'  for="f_telefonos">Denominación de monedas:</label>
                        <select style='color:#0080FF' id='denominacionMondedas' name='denominacionMondedas' class="form-control" required="yes">
                          <?php echo $ListaDenominacion;?>
                        </select> 
                  </div> 
                </div>
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF'  for="f_direccion">Email:</label>
                    <input style='color:#0080FF' type="text"  class="form-control" id="email" name='email' placeholder="Correo Electrónico" value='<?php echo $xemail;?>'>
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
   