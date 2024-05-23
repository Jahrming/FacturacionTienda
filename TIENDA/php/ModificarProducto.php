<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    

       $xIdReferencia     =   $_REQUEST['IdReferencia'];
       $xUsuario          =   $_SESSION["user"];
       $xIdAlmacen        =   $_SESSION['idalmacen'];

       $sqlProfile = "select * from systemprofile where IdEmpresa=$xIdAlmacen";
       //echo $sqlProfile;
       $rsProfile= mysqli_query($conexion,$sqlProfile);
       $regProfile = mysqli_fetch_array($rsProfile);
       //$a = $regProfile['RUC'];
       $porciva = $regProfile['Iva'];

       $sql="Select * from referencias where IdReferencia=$xIdReferencia ";
       $rs = mysqli_query($conexion,$sql);
       $reg= mysqli_fetch_assoc($rs);
       $xCodigoBarra            = $reg['CodigoBarra'];
       $xDescripcionReferencia  = $reg['DescripcionReferencia'];
       $xIdMarca                = $reg['IdMarca'];
       $xIdEditorial            = $reg['IdEditorial'];
       $xAnioEdicion            = $reg['AnioEdicion'];
       $xIdAutor                = $reg['IdAutor'];
       $xIdCategoria            = $reg['IdCategoria'];
       $xIdSubCategoria         = $reg['IdSubCategoria'];
       $xIdProveedor            = $reg['IdProveedor'];
       $IdNivel                 = $reg['IdNivel'];
       $xIsbn                   = $reg['Isbn'];
       $xCosto1                 = $reg['Costo1'];
       $xCostoPromedio          = $reg['CostoPromedio'];
       $xUltimoCosto            = $reg['UltimoCosto'];
       $xDescuento              = $reg['Descuento'];
       $xPvp                    = $reg['Pvp'];
       $xCargaIva               = $reg['CargaIva'];
       $xIdUbicacion            = $reg['IdUbicacion'];
       $xStock                  = $reg['Stock'];
       $xEstado                 = $reg['Estado'];
       $xDescAmplia             = $reg['descripcionamplia'];
       $xPrecioFinal            = $reg['pvpfinal'];       
       if($xUltimoCosto==null)
       {
        $xUltimoCosto=0;
       }

       if($xCosto1==null)
       {
          $xCosto1=0;
       }
       if($xCosto2==null)
       {
          $xCosto2=0;
       }
       if($xUltimoCostoCosto==null)
       {
          $xUltimoCostoCosto=0;
       }
       if($xIdUbicacion==null)
       {
          $xIdUbicacion=0;
       }
       if($xAnioEdicion==null)
       {
          $xAnioEdicion=0;
       }
       if($xCostoPromedio==null)
       {
         $xCostoPromedio=0;
       }
       if($xDescuento==null)
       {
         $xDescuento=0;
       }
       if($xPvp==null)
       {
         $xPvp=0;
       }   
       if($xPrecioFinal==null)
       {
         $xPrecioFinal=0;
       }          
          
       ### ----- Editorial ------ ####
/*       $ListaEditorial='';
       $SqlEditorial="Select * from editorial where IdEditorial=$xIdEditorial 
                         and EstadoEditorial='A'";
       $ResultEditorial=  mysqli_query($conexion, $SqlEditorial);
       $reg_Editorial  =  mysqli_fetch_assoc($ResultEditorial);
       $IdEditorial    =  $reg_Editorial['IdEditorial'];
       $DescEditorial  =  $reg_Editorial['DescripcionEditorial'];
       $ListaEditorial.= "<option value='".$IdEditorial."' Selected>".$DescEditorial."</option>";
       $SqlEditorial="Select * from editorial where IdEditorial !=$xIdEditorial 
                         and EstadoEditorial='A'";
       $ResultEditorial=  mysqli_query($conexion, $SqlEditorial);
       while($reg_Editorial=  mysqli_fetch_array($ResultEditorial))
       {
           $IdEditorial=$reg_Editorial['IdEditorial'];
           $DescEditorial=$reg_Editorial['DescripcionEditorial'];
           $ListaEditorial.=
              "<option value='".$IdEditorial."'>".$DescEditorial."</option>";
       }    */  

       ### ----- Marcas ------ ####
       $ListaMarca='';
       If($xIdMarca ==null)
       {
          $xIdMarca=0;
       }
       $SqlMarca="Select * from marcas where IdMarca = $xIdMarca 
                         and EstadoMarca='A'";
       $ResultMarca=  mysqli_query($conexion, $SqlMarca);
       $reg_Marca  =  mysqli_fetch_assoc($ResultMarca);
       $IdMarca    =  $reg_Marca['IdMarca'];
       $DescMarca  =  $reg_Marca['DescripcionMarca'];
       if($IdMarca!=0)
       { 
        $ListaMarca.= "<option value='".$IdMarca."' Selected>".$DescMarca."</option>";
       }
       $SqlMarca="Select * from marcas where IdMarca !=$xIdMarca 
                         and EstadoMarca='A'";
       $ResultMarca=  mysqli_query($conexion, $SqlMarca);
       while($reg_Marca=  mysqli_fetch_array($ResultMarca))
       {
           $IdMarca=$reg_Marca['IdMarca'];
           $DescMarca=$reg_Marca['DescripcionMarca'];
           $ListaMarca.=
              "<option value='".$IdMarca."'>".$DescMarca."</option>";
       }      
/*       ### ----- Autores ------ ####
       $ListaAutores='';
       If($xIdAutor ==null)
       {
          $xIdAutor=0;
       }
       $SqlAutores="Select * from autores where IdAutor = $xIdAutor
                         and EstadoAutor='A'";
       $ResultAutores=  mysqli_query($conexion, $SqlAutores);
       $reg_Autores  =  mysqli_fetch_assoc($ResultAutores);
       $IdAutor    =  $reg_Autores['IdAutor'];
       $DescAutor  =  $reg_Autores['DescripcionAutor'];
       $ListaAutores.= "<option value='".$IdAutor."' Selected>".$DescAutor."</option>";
       $SqlAutores="Select * from autores where IdAutor !=$xIdAutor 
                         and EstadoAutor='A'";
       $ResultAutores=  mysqli_query($conexion, $SqlAutores);
       while($reg_Autores=  mysqli_fetch_array($ResultAutores))
       {
           $IdAutor=$reg_Autores['IdAutor'];
           $DescAutores=$reg_Autores['DescripcionAutor'];
           $ListaAutores.=
              "<option value='".$IdAutor."'>".$DescAutor."</option>";
       }      
*/       ### ----- Categorias ------ ####
       $ListaCategorias='';
       If($xIdCategoria ==null)
       {
          $xIdCategoria=0;
       }
       $SqlCategorias="Select * from categorias where IdCategoria = $xIdCategoria
                         and EstadoCategoria='A'";
       $ResultCategorias=  mysqli_query($conexion, $SqlCategorias);
       $reg_Categorias  =  mysqli_fetch_assoc($ResultCategorias);
       $IdCategoria    =  $reg_Categorias['IdCategoria'];
       $DescCategoria  =  $reg_Categorias['DescripcionCategoria'];
       $ListaCategorias.= "<option value='".$IdCategoria."' Selected>".$DescCategoria."</option>";
       $SqlCategorias="Select * from categorias where IdCategoria != $xIdCategoria 
                         and EstadoCategoria='A'";
       $ResultCategorias=  mysqli_query($conexion, $SqlCategorias);
       while($reg_Categorias=  mysqli_fetch_array($ResultCategorias))
       {
           $IdCategoria=$reg_Categorias['IdCategoria'];
           $DescCategoria=$reg_Categorias['DescripcionCategoria'];
           $ListaCategorias.=
              "<option value='".$IdCategoria."'>".$DescCategoria."</option>";
       }     
/*       #---------- Niveles -------------------------------
       $ListaNiveles='';
       If($xIdNivel ==null)
       {
          $xIdNivel=0;
       }
       $SqlNiveles="Select * from niveles where IdNivel = $xIdNivel
                         and EstadoNivel='A'";
       $ResultNiveles=  mysqli_query($conexion, $SqlNiveles);
       $reg_Niveles  =  mysqli_fetch_assoc($ResultNiveles);
       $IdNivel    =  $reg_Niveles['IdNivel'];
       $DescNivel  =  $reg_Niveles['DescripcionNivel'];
       $ListaNiveles.= "<option value='".$IdNivel."' Selected>".$DescNivel."</option>";
       $SqlNiveles="Select * from niveles where IdNivel != $xIdNivel 
                         and EstadoNivel='A'";
       $ResultNiveles=  mysqli_query($conexion, $SqlNiveles);
       while($reg_Niveles=  mysqli_fetch_array($ResultNiveles))
       {
           $IdNivel=$reg_Niveles['IdNivel'];
           $DescNivel=$reg_Niveles['DescripcionNivel'];
           $ListaNiveles.=
              "<option value='".$IdNivel."'>".$DescNivel."</option>";
       }       */ 
       ### ----- SubCategorias ------ ####
       $ListaSubCategorias='';
       If($xIdSubCategoria ==null)
       {
          $xIdSubCategoria=0;
       }
       $SqlSubCategorias="Select * from subcategorias where IdSubCategoria = $xIdSubCategoria
                         and EstadoSubCategoria='A'";
       $ResultSubCategorias=  mysqli_query($conexion, $SqlSubCategorias);
       $reg_SubCategorias  =  mysqli_fetch_assoc($ResultSubCategorias);
       $IdSubCategoria    =  $reg_SubCategorias['IdSubCategoria'];
       $DescSubCategoria  =  $reg_SubCategorias['DescripcionSubCategoria'];
       $ListaSubCategoria.= "<option value='".$IdSubCategoria."' Selected>".$DescSubCategoria."</option>";
       $SqlSubCategorias="Select * from subcategorias where IdSubCategoria !=$xIdSubCategoria 
                         and EstadoSubCategoria='A'";
       $ResultSubCategorias=  mysqli_query($conexion, $SqlSubCategorias);
       while($reg_SubCategorias=  mysqli_fetch_array($ResultSubCategorias))
       {
           $IdSubCategoria=$reg_SubCategorias['IdSubCategoria'];
           $DescSubCategoria=$reg_SubCategorias['DescripcionSubCategoria'];
           $ListaSubCategoria.=
              "<option value='".$IdSubCategoria."'>".$DescSubCategoria."</option>";
       }  
       ###------   Proveedores------------####
       $ListaProveedores='';
       If($xIdProveedor ==null)
       {
          $xIdProveedor=0;
       }       
       $SqlProveedores="Select * from proveedores where IdProveedor=$xIdProveedor and EstadoProveedor='A'";
       $ResultProveedores=  mysqli_query($conexion, $SqlProveedores);
       $reg_Proveedores = mysqli_fetch_assoc($ResultProveedores);
       $IdProveedor = $reg_Proveedores['IdProveedor'];
       $DescProveedor = $reg_Proveedores['DescripcionProveedor'];
       if($IdProveedor!=0)
        { 
            $ListaProveedores.="<option value='".$IdProveedor."' Selected>".$DescProveedor."</option>";
       }
       $SqlProveedores="Select * from proveedores where IdProveedor != $xIdProveedor and EstadoProveedor='A'";       
       $ResultProveedores=  mysqli_query($conexion, $SqlProveedores);
       while($reg_Proveedores=  mysqli_fetch_array($ResultProveedores))
       {
           $IdProveedor=$reg_Proveedores['IdProveedor'];
           $DescProveedor=$reg_Proveedores['DescripcionProveedor'];
           $ListaProveedores.=
              "<option value='".$IdProveedor."'>".$DescProveedor."</option>";
       }  
       ###------   Carga iva------------####
       $ListaCargaIva='';   
       if($xCargaIva=='S')
       {
       		$ListaCargaIva="<option value='".$xCargaIva."' Selected>SI</option>";
       		$ListaCargaIva.="<option value='N'>NO</option>";
       }
       else
       {
       		$ListaCargaIva="<option value='".$xCargaIva."' Selected>NO</option>";
       		$ListaCargaIva.="<option value='S'>SI</option>";
       }
       
      ###------   Ubicacion------------####

       $ListaUbicacion='';
       If($xIdUbicacion ==null)
       {
          $xIdUbicacion=0;
       }          
       $SqlUbicacion="Select * from ubicacion where IdPercha= $xIdUbicacion and EstadoUbicacion='A'";
       $ResultUbicacion=  mysqli_query($conexion, $SqlUbicacion);
       $reg_Ubicacion = mysqli_fetch_assoc($ResultUbicacion);
       $IdUbicacion=$reg_Ubicacion['IdPercha'];
       if($xIdUbicacion !=0)
       {
         $DescUbicacion='Columna '.$reg_Ubicacion['Columna'].' Fila '.$reg_Ubicacion['Fila'] ;
         $ListaUbicacion.="<option value='".$IdUbicacion."' Selected>".$DescUbicacion."</option>";        
       }

       $SqlUbicacion="Select * from ubicacion where IdPercha != $xIdUbicacion and EstadoUbicacion='A'";
       $ResultUbicacion=  mysqli_query($conexion, $SqlUbicacion);
       while($reg_Ubicacion=  mysqli_fetch_array($ResultUbicacion))
       {
           $IdUbicacion=$reg_Ubicacion['IdPercha'];
           $DescUbicacion='Columna '.$reg_Ubicacion['Columna'].' Fila '.$reg_Ubicacion['Fila'] ;
           $ListaUbicacion.=
              "<option value='".$IdUbicacion."'>".$DescUbicacion."</option>";
       }  
       ##### ---------- Estados -----------#############
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
      ######-----------Stock---------------------------------####
       $sqlStock="select * from stock where IdReferencia=$xIdReferencia and IdAlmacen= $xIdAlmacen";
       $rStock = mysqli_query($conexion,$sqlStock);
       $recordStock = mysqli_fetch_assoc($rStock);
       $xStock = $recordStock['Stock'];

    }
      
 ?>
       

<head>
   <?php include('head.php'); ?>

</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='ActualizarProducto.php'>  
      <div class='container'>
        <div class='panel panel-default'>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Modificar Producto
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaReferencias.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <input type='hidden' id='porcIva' value='<?php echo $porciva;?>' >
                    <label style='color:#0080FF' for="IdProducto">Id Producto</label>
                    <input style='color:#0080FF' type="text" class="form-control" id="IdProducto" name="IdProducto" readonly="yes" value='<?php echo $xIdReferencia;?>'  onblur='return VerificarDatosUsuario()'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="codigoBarra">Code Bar:</label>
                    <input style='color:#0080FF' type="text" name='codigoBarra' class="form-control" id="codigoBarra" placeholder="Ingrese código de Barra" onkeypress="return pulsar(event)" value='<?php echo $xCodigoBarra;?>'>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-10">
                    <label style='color:#0080FF'  for="f_apellidos">Descripción Producto: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="nombreProducto" name='nombreProducto' placeholder="ingrese descripción del Producto" value='<?php echo $xDescripcionReferencia;?>'>
                  </div>
<!--                   <div class="form-group col-md-2">
                    <label style='color:#0080FF'  for="f_apellidos">Niveles: </label>
                     <select style='color:#0080FF' id='IdNivel' name='IdNivel' class="form-control" required="yes">
                        <option value=''>Seleccionar</option>
                        <?php
                           //echo $ListaNiveles;
                         ?>
                    </select> 
                  </div>      -->             
                </div> 
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_categoria">Categoría:</label>
                    <select style='color:#0080FF' id='IdCategoria' onkeypress="return pulsar(event)" name='IdCategoria' class="form-control" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaCategorias;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-3">                    
                    <label style='color:#0080FF'  for="f_subcategoria">SubCategoria:</label>
                    <select style='color:#0080FF' id='IdSubCategoria' onkeypress="return pulsar(event)" name='IdSubCategoria' class="form-control"  required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaSubCategoria;
                         ?>
                    </select> 
                  </div>   
                </div>    
               <div class="form-row">
                  <div class="form-group col-md-3">                    
                    <label style='color:#0080FF'  for="f_editorial">Marca:</label>
                    <select style='color:#0080FF' id='IdMarca' name='IdMarca' onkeypress="return pulsar(event)" class="form-control"  required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaMarca;
                         ?>
                    </select> 
                  </div>
                               
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_proveedor">Proveedor:</label>
                    <select style='color:#0080FF' id='IdProveedor' name='IdProveedor' onkeypress="return pulsar(event)" class="form-control" required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaProveedores;
                         ?>
                    </select> 

                 </div>
                <div class="form-row">   
               
                   <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_costo1">Costo 1:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="costo1" name='costo1' placeholder="Costo 1" value='<?php echo $xCosto1;?>' required="yes">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_costo2">Costo Promedio:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="costoPromedio" name='costoPromedio' placeholder="Costo 1" value='<?php echo $xCostoPromedio;?>' required="yes">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_ultimocosto">Último Costo:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="ultimoCosto" name='ultimoCosto' placeholder="Último Costo"value='<?php echo $xUltimoCosto;?>' required="yes">
                  </div>
                <div class="form-row">      
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_descuento">Descuento:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="descuento" name='descuento' placeholder="descuento" value='<?php echo $xDescuento;?>' required="yes">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_precio">P.V.P.:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="precio" name='precio' placeholder="P.V.P." value='<?php echo $xPvp;?>' required="yes">
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_iva">I.V.A.:</label>
                    <select style='color:#0080FF' id='IVA' name='IVA' class="form-control" onkeypress="return pulsar(event)" required>
                        <?php
                           echo $ListaCargaIva;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_precio">Pvp Final:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="preciofinal" name='preciofinal' placeholder="P.V.P."  value='<?php echo $xPrecioFinal;?>' onkeydown="calcularPVP()" onblur="calcularPVP()" onchange="calcularPVP()" onkeypress="calcularPVP()" onkeyup="calcularPVP()">
                  </div>                     
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_ubicacion">Ubicación:</label>
                    <select style='color:#0080FF' id='Ubicacion' name='Ubicacion' onkeypress="return pulsar(event)" class="form-control" >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaUbicacion;
                         ?>
                    </select> 
                  </div>
                </div>
                <div class="form-row">  
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_stock">Stock:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" onkeypress="return pulsar(event)" id="stock" name='stock' readonly='yes' placeholder="Stock" value='<?php echo $xStock;?>'>
                  </div>                      
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF' for="estado">Estado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' onkeypress="return pulsar(event)" class='form-control' required="yes">
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' for="estado">Descripcion Amplia:</label>
                    <textarea style='color:#0080FF' rows="5" cols="80" class="form-control" id="DescripcionAmplia" name='DescripcionAmplia' maxlength="300" placeholder="Ingrese una descripción Amplia si desea"  ><?php echo $xDescAmplia; ?></textarea>
                  </div>
                </div>

              </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body>
<script type="text/javascript">
  
   function calcularPVP()
 {
  //alert('calcularpvp');
    var preciofinal = parseFloat(document.getElementById('preciofinal').value);
    var iva    = parseFloat(document.getElementById('porcIva').value);
    var porcentajecompleto = 100 + iva;
    var preciobase = 0;
    var valorIva = 0;

   // alert('precio final ' + preciofinal + "  " + "iva " + iva);
    //alert('por completo ' + porcentajecompleto);
    preciobase= (preciofinal *100)/ porcentajecompleto;


    document.getElementById('precio').value=preciobase.toFixed(2);
    //alert(preciobase);

 }
</script>
</html>
   