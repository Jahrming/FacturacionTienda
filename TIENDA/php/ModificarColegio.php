<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       $IdInstitucion=$_REQUEST['IdColegio'];
       include("Conexion.php");    
       $sqlColegio="SELECT a.DescripcionColegio as DescripcionColegio,
                           a.ContactoColegio as ContactoColegio,
                           a.Ciudad as Ciudad,
                           a.DireccionColegio as DireccionColegio,
                           a.TelefonosColegio as Telefonos ,
                           a.Email as Email,
                           a.EstadoColegio as EstadoColegio ,
                           b.PorcentajeDescuento as porcentaje FROM colegios a ,referenciacolegio b".
                   " WHERE a.IdColegio=$IdInstitucion ".
                   "   AND a.IdColegio = b.IdColegio";

       $rs  = mysqli_query($conexion,$sqlColegio);
       $reg = mysqli_fetch_assoc($rs);
       $xNombreColegio         = $reg['DescripcionColegio'];
       $xNombreContacto        = $reg['ContactoColegio'];
       $xCiudad                = $reg['Ciudad'];
       $xDireccion             = $reg['DireccionColegio']; 
       $xTelefonos             = $reg['Telefonos'];
       $xEmail                 = $reg['Email'];
       $xEstado                = $reg['EstadoColegio'];
       $xPorcentaje            = $reg['porcentaje'];


/*
       $SqlCiudad="Select * from ciudades";
       $ResultCiudad=  mysqli_query($conexion, $SqlCiudad);
       while($reg_Ciudad=  mysqli_fetch_array($ResultCiudad))
       {
           $IdCiudad=$reg_Ciudad['IdCiudad'];
           $NombreCiudad=$reg_Ciudad['DescripcionCiudad'];
           $ListaCiudades.="<option value='".$IdCiudad."'>".$NombreCiudad."</option>";
       }    */
       
       $ListaEstados='';
       $SqlEstados="SELECT * FROM admestados where IdEstado = '$xEstado'";
       $rsestados= mysqli_query($conexion,$SqlEstados);
       $regEstados = mysqli_fetch_assoc($rsestados);
       $DescEstado = $regEstados['DescripcionEstado'];
       $ListaEstados.="<option value='".$xEstado."' Selected>".$DescEstado."</option>";

       $SqlEstados="SELECT * FROM admestados where IdEstado != '$xEstado'";
       $rsestados= mysqli_query($conexion,$SqlEstados);
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
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarColegio.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Colegio
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaColegios.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
          </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF' >Id Institución:</label>
                    <input style='color:#0080FF' type="text" name='IdInstitucion' class="form-control" id="IdInstitucion" placeholder readonly="yes" value="<?php  echo $IdInstitucion;?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-11">
                    <label style='color:#0080FF' >Nombre Institución:</label>
                    <input style='color:#0080FF' type="text" name='nombre' class="form-control" id="nombre" placeholder="Nombre Institución" value="<?php  echo $xNombreColegio;?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' >Nombre Contacto:</label>
                    <input style='color:#0080FF' type="text" name='nombreContacto' class="form-control" id="nombreContacto" placeholder="Nombre del Contacto Institución" value="<?php  echo $xNombreContacto;?>">
                  </div>
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' >Ciudad:</label>
                    <input style='color:#0080FF' type="text" name='Ciudad' class="form-control" id="Ciudad" placeholder="Ciudad donde esta la Institución" value="<?php  echo $xCiudad;?>">
                  </div>
                </div>                   
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Porcentaje Descuento %:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="porcentaje" name='porcentaje' step="0.01"  placeholder="Ingrese Porcentaje" value="<?php  echo $xPorcentaje;?>">             
                  </div>
                </div>                             
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="f_direccion">Dirección:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="direccion" name='direccion' placeholder="Ingrese Dirección" value="<?php  echo $xDireccion;?>">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_direccion">Teléfonos:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="Telefonos" name='Telefonos' placeholder="Ingrese Teléfonos" value="<?php  echo $xTelefonos;?>">
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_mail">Email:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php  echo $xEmail;?>">
                  </div>                  
                </div>   
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' >
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
   