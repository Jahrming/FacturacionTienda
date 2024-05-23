<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");   
       #----- cajero a cuadrar -----------------
       $ListaAsignacion; 
       $SqlControlCaja="select a.IdAsignacion as IdAsignacion, a.IdCaja as Caja,a.IdTurno as Turno,a.IdCajero as Cajero, ".
       					" concat(b.ApellidosUsuario,' ',b.NombresUsuario) as NombreCajero, c.DescripcionCaja as NombreCaja " .
       					" from controlcaja a, admusuarios b, cajas c ".
       					" where a.IdCajero = b.IdUsuario ".
       					"    and a.IdCaja = c.IdCaja ".
                "    and a.EstadoAsignacion != 'C' ";
       $rs= mysqli_query($conexion,$SqlControlCaja);
       while($regControlCaja = mysqli_fetch_array($rs))
       {
       	  $IdAsignacion = $regControlCaja['IdAsignacion'];
       	  $Descripcion =  $regControlCaja['NombreCaja'].' '.$regControlCaja['NombreCajero'];
       	  $ListaAsignacion.="<option value='".$IdAsignacion."'>".$Descripcion."</option>";
       }

       $ListaUsuario='';
       $SqlUsuario="Select * from admusuarios where EstadoUsuario='A'";
       $rs=  mysqli_query($conexion, $SqlUsuario);
       while($regUsuario=  mysqli_fetch_array($rs))
       {
           $IdUsuario=$regUsuario['IdUsuario'];
           $NombreUsuario=$regUsuario['ApellidosUsuario'].' '.$regUsuario['NombresUsuario'];
           $ListaUsuario.="<option value='".$IdUsuario."'>".$NombreUsuario."</option>";
       }    
       $ListaCajas='';
       $SqlCajas="Select * from cajas where EstadoCaja='A'";
       $rs=  mysqli_query($conexion, $SqlCajas);
       while($regCajas=  mysqli_fetch_array($rs))
       {
           $IdCaja=$regCajas['IdCaja'];
           $DescCaja=$regCajas['DescripcionCaja'];
           $ListaCajas.="<option value='".$IdCaja."'>".$DescCaja."</option>";
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

       $SqlSistema="SELECT * FROM systemprofile ";
       $rsSistema= mysqli_query($conexion,$SqlSistema);
       $regSistema=  mysqli_fetch_assoc($rsSistema);
       $xDenominacion= $regSistema['DenominacionMonedas'];

     } 
 ?>
       
<!DOCTYPE html>
<html>
<head>
			<title> SISTEMA IMPORTBOOKS</title>
      <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
      <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
      <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
      <link rel='stylesheet' href='../css/estilos.css' >
      <link rel='stylesheet' href='../css/bootstrap.css'>
      <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body onload="confirmaDenominacion();">
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarCuadre.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Cierre de Cajas

<button class='btn btn-primary btn-sm' title='Regresar' style='font-size:18px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"../inicio/menu.php\"' type='button'> <span class='glyphicon glyphicon-backward'> </button>
";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                  	<input type='hidden' id='Denominaciones' value='<?php echo $xDenominacion;?>'>
                    <label style='color:#0080FF' for="caja">Cajero a Cuadrar</label>
                    <select style='color:#0080FF' id='IdAsignacion' name='IdAsignacion' class="form-control" required >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaAsignacion;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Valor Ventas Efectivo:</label>
                    <input style='color:#0080FF' type='number' step='0.01' class='form-control' id='ValorVentasEfectivo' name='ValorVentasEfectivo' placeholder='Valor Efectivo' onkeyup='CalculaTotal();' value='0' >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' >Cantidad Ventas T/C:</label>
                    <input style='color:#0080FF' type='number' class='form-control' id='CantidadTC' name='CantidadTC' placeholder='Cantidad Efectivo' value='0'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' >Valor Ventas T/C:</label>
                    <input style='color:#0080FF' type='number' step='0.01' class="form-control" id="ValorTC" name="ValorTC" placeholder="Valor TC" onkeyup="CalculaTotal();" value="0">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Cantidad Ventas Cheques:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="CantidadCheques" name="CantidadCheques" placeholder="Cantidad Cheques" >
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Valor Ventas Cheques:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="ValorCheques" name="ValorCheques" placeholder="Valor Cheques" onkeyup="CalculaTotal();" value="0">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Cantidad Ventas Credito:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="CantidadCredito" name="CantidadCredito" placeholder="Cantidad Credito" >
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Valor Ventas Credito:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="ValorCredito" name="ValorCredito" placeholder="Valor Credito"  onkeyup="CalculaTotal();" value="0">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Cantidad Ventas Vales:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="CantidadVales" name="CantidadVales" placeholder="Cantidad Vales" >
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Valor Ventas Vales:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="ValorVales" name="ValorVales" placeholder="Valor Vales" onkeyup="CalculaTotal();" value="0">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Base:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Base" name="Base" placeholder="Cantidad Vales" onkeyup="CalculaTotal();" value="0">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="">Total:</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Total" name="Total" readonly="yes" placeholder="Cantidad Vales" >
                  </div>                  
                </div>                
              </div>            
          </div>   
          <!----Detalle de monedas--->
        <div class='panel panel-default'>
            <div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Denominaciones de Billetes y Monedas</div>   
        </div>
        <div class="panel-body">
            <div class="panel-body" style="width:75%; float:left; display:block;"> 
             <div class="form-row">Billetes</div>
              <div class="form-row">   
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">100</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad100" name="Cantidad100" placeholder="Cantidad Billetes 100" >
                </div>
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">50</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad50" name="Cantidad50" placeholder="Cantidad Billetes 50" >
                </div>
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">20</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad20" name="Cantidad20" placeholder="Cantidad Billetes 20" >
                </div>     
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">10</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad10" name="Cantidad10" placeholder="Cantidad Billetes 10" >
                </div>     
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">5</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad5" name="Cantidad5" placeholder="Cantidad Billetes 5" >
                </div>   
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">1</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Cantidad1" name="Cantidad1" placeholder="Cantidad Billetes 1" >
                </div>                                                                           
              </div> 
              <div class="form-row">Monedas</div> 
              <div class="form-row">   
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$1</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas1" name="Monedas1" placeholder="Cantidad Monedas $1" >
                </div>
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$0.50</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas050" name="Monedas050" placeholder="Cantidad Monedas $0.5" >
                </div>
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$0.25</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas025" name="Monedas025" placeholder="Cantidad Monedas $0.25" >
                </div>     
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$0.10</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas010" name="Monedas010" placeholder="Cantidad Monedas $0.10" >
                </div>        
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$0.05</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas005" name="Monedas005" placeholder="Cantidad Monedas $0.05" >
                </div>   
                <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="">$0.01</label>
                    <input style='color:#0080FF' type="number" class="form-control" id="Monedas001" name="Monedas001" placeholder="Cantidad Monedas 0.01" >
                </div>                                                                           
              </div>               
            </div>
        </div> 
        <!----Fin detalle monedas --->                   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
</html>

<script type="text/javascript">

function CalculaTotal()
{
   var TotalCuadreManual=0;
   var TotalEfectivo=document.getElementById('ValorVentasEfectivo').value;
   var TotalCheques=document.getElementById('ValorCheques').value;
   var TotalTC=document.getElementById('ValorTC').value;
   var TotalCredito=document.getElementById('ValorCredito').value;
   var TotalVales=document.getElementById('ValorVales').value;
   var Base=document.getElementById('Base').value;
   var Total=parseFloat(TotalEfectivo)+parseFloat(TotalCheques)+parseFloat(TotalTC)+parseFloat(TotalCredito)+parseFloat(TotalVales)+parseFloat(Base);
  //alert(Total);
  document.getElementById('Total').value=Total;
   
}

function CuantasEfectivo(){
      var vtasEfectivo=0;
      var Criterio=document.getElementById('IdAsignacion').value;
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= cantidadVtasEfectivo;
      xhr.open('POST','RetornaCuantasEfectivo.php',false);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdAsignacion="+Criterio);
      function cantidadVtasEfectivo()
      {
         if(xhr.readyState==4)
            {
              if(xhr.status==200)
                {
                  vtasEfectivo = this.responseText;
                  document.getElementById('CantidadVtasEfectivo').value=parseInt(vtasEfectivo);
                }
            }
      }
   }
         
function confirmaDenominacion() {
    if(document.getElementById('Denominaciones').value=='N')
    {
      
    	 document.getElementById('Cantidad100').disabled=true;
    	 document.getElementById('Cantidad50').disabled=true;
    	 document.getElementById('Cantidad20').disabled=true;
    	 document.getElementById('Cantidad10').disabled=true;
    	 document.getElementById('Cantidad5').disabled=true;
    	 document.getElementById('Cantidad1').disabled=true;
    	 document.getElementById('Monedas1').disabled=true;
    	 document.getElementById('Monedas050').disabled=true;
    	 document.getElementById('Monedas025').disabled=true;
    	 document.getElementById('Monedas010').disabled=true;
    	 document.getElementById('Monedas005').disabled=true;
    	 document.getElementById('Monedas001').disabled=true;
    }
  }


  
   </script>