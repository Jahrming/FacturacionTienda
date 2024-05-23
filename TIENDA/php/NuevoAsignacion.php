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

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarAsignacion.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Asignación de Cajas
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaAsignacion.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF' for="f_ruc">Caja</label>
                    <select style='color:#0080FF' id='IdCaja' name='IdCaja' class="form-control" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaCajas;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-8">
                    <label style='color:#0080FF' for="inputPassword4">Cajero:</label>
                    <select style='color:#0080FF' id='IdCajero' name='IdCajero' class="form-control" id="cc" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaUsuario;
                         ?>
                    </select> 
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">	
                    <label style='color:#0080FF' for="Turno">Turno:</label>
                    <select style='color:#0080FF' id='IdTurno' name='IdTurno' class="form-control" id="cc" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaTurnos;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-6">	
                    <label style='color:#0080FF' for="Turno">Fecha Asignación:</label>
                    <input style='color:#0080FF' type="date" class="form-control" id="FechaAsignacion" name="FechaAsignacion" placeholder="Fecha Asignación">
                  </div>                  
                </div>


                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Base:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="base" name="base" placeholder="Base">
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
   