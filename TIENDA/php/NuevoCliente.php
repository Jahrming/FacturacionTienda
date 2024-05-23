<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
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
       $ListaPaises='';
       $SqlPaises="SELECT * FROM paises ";
       $rsPaises= mysqli_query($conexion,$SqlPaises);
       $descPais = $regPaises['DescripcionPais'];
       while($regPaises=  mysqli_fetch_array($rsPaises))
       {
           $IdPais=$regPaises['IdPais'];
           $DescripcionPais=$regPaises['DescripcionPais'];
           $ListaPaises.=
              "<option value='".$IdPais."'>".$DescripcionPais."</option>";
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarCliente.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Cliente
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaClientes.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="IdProducto">Id Cliente</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="IdCliente" name="IdCliente" readonly="yes" >
                  </div>

                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_TipDoc">Tipo Documento:</label>
                    <select style='color:#0080FF' id='IdTipDoc' name='IdTipDoc' class="form-control" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListTipDoc;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-7">
                    <label style='color:#0080FF'  for="f_NumDoc">Número Documento:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="NumDoc" name="NumDoc" >
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_Apellidos">Apellidos:</label>
                    <input style='color:#0080FF' type="text" name='Apellidos' class="form-control" id="Apellidos" placeholder="Ingrese Apellidos de CLiente">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">Nombres: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Nombres" name='Nombres' placeholder="Ingrese Nombres de CLiente">
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_RazonSocial">Razón Social:</label>
                    <input style='color:#0080FF' type="text" name='RazonSocial' class="form-control" id="RazonSocial" placeholder="Ingrese Razon Social de CLiente">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">Dirección: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Direccion" name='Direccion' placeholder="Ingrese Dirección de CLiente">
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF' for="f_RazonSocial">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" name='Telefonos' class="form-control" id="Telefonos" placeholder="Ingrese Teléfonos de CLiente">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_nombres">Ciudad: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Ciudad" name='Ciudad' placeholder="Ingrese Ciudad de CLiente">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_pais">País: </label>
                    <select style='color:#0080FF' id='IdPais' name='IdPais' class="form-control" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaPaises;
                         ?>
                    </select> 
                  </div>    
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_nombres">Fecha Nacimiento: </label>
                    <input style='color:#0080FF' type="date" class="form-control" id="FecNac" name='FecNac' placeholder="Ingrese Fecha Nacimiento">
                  </div>                  
                <div class="form-row">     
                  <div class="form-group col-md-5">
                    <label style='color:#0080FF'  for="f_pais">Email: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Email" name='Email' placeholder="Ingrese Email de CLiente">
                  </div>                           
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF' for="estado">&nbsp&nbspEstado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
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
   