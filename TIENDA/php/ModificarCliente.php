<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       $xIdCliente     =   $_REQUEST['IdCliente'];
       $xUsuario       =   $_SESSION["user"];

       $sql="Select * from clientes where IdCliente =$xIdCliente";
       $rs = mysqli_query($conexion,$sql);
       $reg= mysqli_fetch_assoc($rs);
       $xTipDoc               = $reg['IdTipoDocumento'];
       $xCedulaRuc            = $reg['CedulaRUC'];
       $xApellidos            = $reg['Apellidos'];
       $xNombres              = $reg['Nombres']; 
       $xNombreComercial      = $reg['NombreComercial'];
       $xFechaNac             = $reg['FechaNacimiento'];
       $xTelefonos            = $reg['Telefonos'];
       $xDireccion            = $reg['Direccion'];
       $xCiudad               = $reg['Ciudad'];
       $xIdPais               = $reg['Pais'];
       $xEmail                = $reg['Email'];
       $xEstado               = $reg['Estado'];

       $ListTipDoc='';
       $SqlTipDoc="Select * from admtipodocumento where IdTipoDocumento='".$xTipDoc."' and Estado='A'";

       $ResultTipDoc=  mysqli_query($conexion, $SqlTipDoc);
       $reg_TipDoc=  mysqli_fetch_assoc($ResultTipDoc);
       $DescTipDoc=utf8_encode($reg_TipDoc['DescripcionTipoDocumento']);
       $ListTipDoc.= "<option value='".$xTipDoc."' Selected>".$DescTipDoc."</option>";

       $SqlTipDoc="Select * from admtipodocumento where IdTipoDocumento!='$xTipDoc' and Estado='A'";
       $ResultTipDoc=  mysqli_query($conexion, $SqlTipDoc);
       while($reg_TipDoc=  mysqli_fetch_array($ResultTipDoc))
       { 
          $IdTipoDocumento=$reg_TipDoc['IdTipoDocumento'];
          $DescTipDoc=utf8_encode($reg_TipDoc['DescripcionTipoDocumento']);
          $ListTipDoc.=
              "<option value='".$IdTipoDocumento."'>".$DescTipDoc."</option>";
       }  


       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados where IdEstado ='$xEstado'";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $regEstados=  mysqli_fetch_assoc($rsestados);
       $DescripcionEstado=$regEstados['DescripcionEstado'];
       $ListaEstados.=
              "<option value='".$xEstado."' Selected>".$DescripcionEstado."</option>";       
       $SqlEstados="SELECT * FROM admestados where IdEstado !='$xEstado'";
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
       $SqlPaises="SELECT * FROM paises where IdPais=".$xIdPais;
       $rsPaises= mysqli_query($conexion,$SqlPaises);
       $regPaises=  mysqli_fetch_array($rsPaises);
       $IdPais=$regPaises['IdPais'];
       $DescripcionPais=$regPaises['DescripcionPais'];
       $ListaPaises.=
              "<option value='".$IdPais."'>".$DescripcionPais."</option>";       
       $SqlPaises="SELECT * FROM paises where IdPais !=".$xIdPais;
       $rsPaises= mysqli_query($conexion,$SqlPaises);
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarCliente.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar  Cliente
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaClientes.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-2">
                    <label style='color:#0080FF' for="IdProducto">Id Cliente</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="IdCliente" name="IdCliente" readonly="yes" value='<?php echo $xIdCliente;?>' >
                  </div>

                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_TipDoc">Tipo Documento:</label>
                    <select style='color:#0080FF' readonly="yes" id='IdTipDoc' name='IdTipDoc' class="form-control" required>
                        <?php
                           echo $ListTipDoc;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-7">
                    <label style='color:#0080FF'  for="f_NumDoc">Número Documento:</label>
                    <input style='color:#0080FF' type="text" readonly="yes" class="form-control" id="NumDoc" name="NumDoc" value='<?php echo $xCedulaRuc;?>'>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_Apellidos">Apellidos:</label>
                    <input style='color:#0080FF' type="text" name='Apellidos' class="form-control" id="Apellidos" placeholder="Ingrese Apellidos de CLiente" value='<?php echo $xApellidos;?>'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">Nombres: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Nombres" name='Nombres' placeholder="Ingrese Nombres de CLiente" value='<?php echo $xNombres;?>'>
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_RazonSocial">Razón Social:</label>
                    <input style='color:#0080FF' type="text" name='RazonSocial' class="form-control" id="RazonSocial" placeholder="Ingrese Razon Social de CLiente" value='<?php echo $xNombreComercial;?>'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_nombres">Dirección: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Direccion" name='Direccion' placeholder="Ingrese Dirección de CLiente" value='<?php echo $xDireccion;?>'>
                  </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF' for="f_RazonSocial">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" name='Telefonos' class="form-control" id="Telefonos" placeholder="Ingrese Teléfonos de CLiente" value='<?php echo $xTelefonos;?>'>
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_nombres">Ciudad: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Ciudad" name='Ciudad' placeholder="Ingrese Ciudad de CLiente" value='<?php echo $xCiudad;?>'>
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_pais">País: </label>
                    <select style='color:#0080FF' id='IdPais' name='IdPais' class="form-control" required>
                        <?php
                           echo $ListaPaises;
                         ?>
                    </select> 
                  </div>    
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_nombres">Fecha Nacimiento: </label>
                    <input style='color:#0080FF' type="date" class="form-control" id="FecNac" name='FecNac' placeholder="Ingrese Fecha Nacimiento" value='<?php echo $xFechaNac;?>'>
                  </div>                  
                <div class="form-row">     
                  <div class="form-group col-md-5">
                    <label style='color:#0080FF'  for="f_pais">Email: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Email" name='Email' placeholder="Ingrese Email de CLiente" value='<?php echo $xEmail;?>'>
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
   