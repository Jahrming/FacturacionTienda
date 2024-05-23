<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");   
       $x_usuario = $_SESSION['user'];

       $x_IdCaja  = $_REQUEST['IdCaja'];
       $sqlCaja="select * from cajas where IdCaja=$x_IdCaja";

       $rsCaja= mysqli_query($conexion,$sqlCaja);
       $regCaja= mysqli_fetch_assoc($rsCaja);
       $xIdAlmacen = $regCaja['IdAlmacen'];
       $xDescCaja = $regCaja['DescripcionCaja'];
       $xEstado = $regCaja['EstadoCaja'];



       
       $ListaAlmacenes='';
       $SqlAlmacenes="SELECT * FROM almacenes where IdAlmacen = $xIdAlmacen";
       $rsAlmacenes= mysqli_query($conexion,$SqlAlmacenes);
       $regAlmacenes = mysqli_fetch_assoc($rsAlmacenes);
       $DescAlmacen = $regAlmacenes['DescripcionAlmacen'];
       $ListaAlmacenes.="<option value='".$xEstado."' Selected>".$DescAlmacen."</option>";

       $SqlAlmacenes="SELECT * FROM where IdAlmacen != $xIdAlmacen";
       $rsAlmacenes= mysqli_query($conexion,$SqlAlmacenes);
       while($regAlmacenes=  mysqli_fetch_array($rsAlmacenes))
       {
           $IdAlmacen=$regAlmacenes['IdAlmacen'];
           $DescripcionAlmacen=$regAlmacenes['DescripcionAlmacen'];
           $ListaAlmacenes.=
              "<option value='".$IdAlmacen."'>".$DescripcionAlmacen."</option>";
       }  
  
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
       
<!DOCTYPE html>
<html>
<head>
  <?php include('head.php'); ?>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarCaja.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Caja
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaCajas.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:75%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_usuario">Id Caja:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="IdCaja" name="IdCaja" readonly="yes" value="<?php echo $x_IdCaja;?>"  >
                  </div>

                 <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Almacenes:</label>
                      <select style='color:#0080FF' id='IdAlmacen' name='IdAlmacen' class='form-control' required='yes' >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaAlmacenes;
                         ?>
                      </select>          
                 </div>
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="f_usuario">Descripción Caja:</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="DescripcionCaja" name="DescripcionCaja" placeholder="Descripción Caja" value='<?php echo $xDescCaja;?>'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='EstadoCaja' name='EstadoCaja' class='form-control' required' >
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
   