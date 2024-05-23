<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       
       include("Conexion.php");    
       #------------------------------------------------/
       $codigoAlmacen = $_SESSION['idalmacen'];
       $sqlProfile = "select * from systemprofile where IdEmpresa=$codigoAlmacen";
       //echo $sqlProfile;
       $rsProfile= mysqli_query($conexion,$sqlProfile);
       $regProfile = mysqli_fetch_array($rsProfile);
       //$a = $regProfile['RUC'];
       $porciva = $regProfile['Iva'];
       //echo 'iba'.$porciva.$a;
       ### ----- SubCategorias ------ ####
       $ListaSubCategorias='';
       $SqlSubCategoria="Select * from subcategorias where
                         EstadoSubCategoria='A' ORDER BY DescripcionSubCategoria ";
       $ResultSubCategorias=  mysqli_query($conexion, $SqlSubCategoria);
       while($reg_SubCategorias=  mysqli_fetch_array($ResultSubCategorias))
       {
           $IdSubCategoria=$reg_SubCategorias['IdSubCategoria'];
           $DescSubCategoria=$reg_SubCategorias['DescripcionSubCategoria'];
           $ListaSubCategorias.=
              "<option value='".$IdSubCategoria."'>".$DescSubCategoria."</option>";
       }  



       $ListaCategorias='';
       $SqlCategorias="Select * from categorias where EstadoCategoria='A'  ORDER BY DescripcionCategoria";
       $ResultCategorias=  mysqli_query($conexion, $SqlCategorias);
       while($reg_Categorias=  mysqli_fetch_array($ResultCategorias))
       {
           $IdCategoria=$reg_Categorias['IdCategoria'];
           $DescCategoria=$reg_Categorias['DescripcionCategoria'];
           $ListaCategorias=$ListaCategorias.
              "<option value='".$IdCategoria."'>".$DescCategoria."</option>";
       }  
       $ListaMarcas='';
       $SqlMarcas="Select * from marcas where EstadoMarca='A' Order By DescripcionMarca ";
       $ResultMarcas=  mysqli_query($conexion, $SqlMarcas);
       while($reg_Marcas=  mysqli_fetch_array($ResultMarcas))
       {
           $IdMarca=$reg_Marcas['IdMarca'];
           $DescMarca=$reg_Marcas['DescripcionMarca'];
           $ListaMarcas=$ListaMarcas.
              "<option value='".$IdMarca."'>".$DescMarca."</option>";
       }  
       $ListaProveedores='';
       $SqlProveedores="Select * from proveedores where EstadoProveedor='A' Order by DescripcionProveedor";
       $ResultProveedores=  mysqli_query($conexion, $SqlProveedores);
       while($reg_Proveedores=  mysqli_fetch_array($ResultProveedores))
       {
           $IdProveedor=$reg_Proveedores['IdProveedor'];
           $DescProveedor=$reg_Proveedores['DescripcionProveedor'];
           $ListaProveedores.=
              "<option value='".$IdProveedor."'>".$DescProveedor."</option>";
       }  

       $ListaNiveles='';
       $SqlNiveles="Select * from niveles where EstadoNivel='A'";
       $ResultNiveles=  mysqli_query($conexion, $SqlNiveles);
       while($reg_Niveles=  mysqli_fetch_array($ResultNiveles))
       {
           $IdNivel=$reg_Niveles['IdNivel'];
           $DescNivel=$reg_Niveles['DescripcionNivel'];
           $ListaNiveles.=
              "<option value='".$IdNivel."'>".$DescNivel."</option>";
       } 

       $ListaUbicacion='';
       $SqlUbicacion="Select * from ubicacion where EstadoUbicacion='A'";
       $ResultUbicacion=  mysqli_query($conexion, $SqlUbicacion);
       while($reg_Ubicacion=  mysqli_fetch_array($ResultUbicacion))
       {
           $IdUbicacion=$reg_Ubicacion['IdPercha'];
           $DescUbicacion='Columna '.$reg_Ubicacion['Columna'].' Fila '.$reg_Ubicacion['Fila'] ;
           $ListaUbicacion.=
              "<option value='".$IdUbicacion."'>".$DescUbicacion."</option>";
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
   <?php include('head.php'); ?>
</head>
<!---   <body onload='return inicio(\"\")'>    -->
<body>
<section>
  <form id='formulario' name='formulario'  role='form' method='POST' enctype='multipart/form-data' action='GrabarProducto.php'>  
      <div class='container'>
        <div class='panel panel-default'>
                    <?php include('headmsg.php'); ?>
            <?php echo"<div class='panel-heading' style='font-size: 20px;color:#0080FF;font-weight:bold;'>Nuevo Producto
              <button class='btn btn-primary btn-sm' title='Regresar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' onClick='window.location=\"ConsultaReferencias.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span></button>";?>
            <?php echo"<button class='btn btn-primary btn-sm' title='Grabar' style='font-size:16px;color:#0080FF;background-color:    #FFBF00;border:none' type='submit'> <span class='glyphicon glyphicon-floppy-disk'></span> </button>";?>
              <button class='btn btn-primary btn-sm' title='Limpiar' style='font-size:16px;color:#0080FF;background-color:#FFBF00;border:none' type='button'><span class='glyphicon glyphicon-refresh'></span> </button>                 
            </div>
          <div class="panel-body">
              <div class="panel-body" style="width:100%; float:left; display:block;"> 
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="IdProducto">Id Producto</label>
                    <input type="hidden" class="form-control" id="porcIva" name="porcIva" value='<?php echo $porciva; ?>'>
                    <input style='color:#0080FF' type="text" class="form-control" id="IdProducto" name="IdProducto" readonly="yes" onblur='return VerificarDatosUsuario()'>
                  </div>
                  <div class="form-group col-md-6">
                    <label style='color:#0080FF' for="codigoBarra">Code Bar:</label>
                    <input style='color:#0080FF' type="text" name='codigoBarra' class="form-control" id="codigoBarra" placeholder="Ingrese código de Barra" 
                    onkeypress="verficaBarra(event)">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF'  for="nombreProducto">Descripción Producto: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="nombreProducto" name='nombreProducto' maxlength="300" placeholder="ingrese descripción del Producto">
                  </div>
                  <!--
                  <div class="form-group col-md-2">
                    <label style='color:#0080FF'  for="f_apellidos">Niveles: </label>
                    <select style='color:#0080FF' id='IdNivel' name='IdNivel' class="form-control" >
                        <option value=''>Seleccionar</option>
                        <?php
                           //echo $ListaNiveles;
                         ?>
                    </select> 
                  </div>  -->                
                </div> 
                <div class="form-row">
<!--                   <div class="form-group col-md-6">
                    <label style='color:#0080FF'  for="f_ISBN">ISBN: </label>
                    <input style='color:#0080FF' type="text" class="form-control" id="isbn" name='isbn' placeholder="Ingrese código ISBN del producto">
                  </div> -->
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_categoria">Categoría:</label>
                    <select style='color:#0080FF' id='IdCategoria' name='IdCategoria' class="form-control" >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaCategorias;
                         ?>
                    </select> 
                  </div>
                  <div class="form-group col-md-3">                    
                    <label style='color:#0080FF'  for="f_subcategoria">SubCategoria:</label>
                    <select style='color:#0080FF' id='IdSubCategoria' name='IdSubCategoria' class="form-control"  required>
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaSubCategorias;
                         ?>
                    </select> 
                  </div>   
                </div>    
               <div class="form-row">
                  <div class="form-group col-md-3">                    
                    <label style='color:#0080FF'  for="f_editorial">Marca:</label>
                    <select style='color:#0080FF' id='IdMarca' name='IdMarca' class="form-control"  >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaMarcas;
                         ?>
                    </select> 
                  </div>
                               
<!--                   <div class="form-group col-md-3">                    
                    <label style='color:#0080FF'  for="f_editorial">Editorial:</label>
                    <select style='color:#0080FF' id='IdEditorial' name='IdEditorial' class="form-control"  >
                        <option value=''>Seleccionar</option>
                        <?php
                           //echo $ListaEditorial;
                         ?>
                    </select> 
                  </div> -->
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_proveedor">Proveedor:</label>
                    <select style='color:#0080FF' id='IdProveedor' name='IdProveedor' class="form-control" >
                        <option value=''>Seleccionar</option>
                        <?php
                           echo $ListaProveedores;
                         ?>
                    </select> 
                  </div>
<!--                   <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_anio">Año Publicación:</label>
                    <input style='color:#0080FF' type="number" step="1" class="form-control" id="anio" name='anio' placeholder="Año Publicación" value='' >
                  </div>
                 </div>
 -->                <div class="form-row">   
<!--                   <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_autor">Autor:</label>
                    <select style='color:#0080FF' id='IdAutor' name='IdAutor' class="form-control" >
                        <option value=''>Seleccionar</option>
                        <?php
                           //echo $ListaAutores;
                         ?>
                    </select> 
                  </div>    -->               
                   <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_costo1">Costo 1:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="costo1" name='costo1' placeholder="Costo 1" value='0'>
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_costo2">Costo Promedio:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="costoPromedio" name='costoPromedio' placeholder="Costo 1"  value='0'>
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_ultimocosto">Último Costo:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="ultimoCosto" name='ultimoCosto' placeholder="Último Costo"  value='0'>
                  </div>
                <div class="form-row">      
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_descuento">Descuento:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="descuento" name='descuento' placeholder="descuento"  value='0'>
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_precio">P.V.P.:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="precio" name='precio' placeholder="P.V.P."  value='0' >
                    <!---onKeyUp='CalculaPrecioFinal()' onChange='CalculaPrecioFinal()' onBlur='CalculaPrecioFinal()'  -->
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_iva">I.V.A.:</label>
                    <select style='color:#0080FF' id='IVA' name='IVA' class="form-control" required  value='0'>
                        <option value='S' selected="S">Si</option>
                        <option value='N'>No</option>

                    </select> 
                  </div>
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_precio">Pvp Final:</label>
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="preciofinal" name='preciofinal' placeholder="P.V.P."  value='0' onkeydown="calcularPVP()" onblur="calcularPVP()" onchange="calcularPVP()" onkeypress="calcularPVP()" onkeyup="calcularPVP()">
                  </div>                  
                  <div class="form-group col-md-3">
                    <label style='color:#0080FF'  for="f_ubicacion">Ubicación:</label>
                    <select style='color:#0080FF' id='Ubicacion' name='Ubicacion' class="form-control"  value='0'>
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
                    <input style='color:#0080FF' type="number" step="0.01" class="form-control" id="stock" name='stock' readonly='yes' placeholder="Stock"  value='0'>
                  </div>                      
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label style='color:#0080FF' for="estado">&nbsp&nbspEstado:</label>
                      <select style='color:#0080FF' id='Estado' name='Estado' class='form-control' required="yes">
                        <?php
                           echo $ListaEstados;
                         ?>
                      </select>          
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label style='color:#0080FF' for="estado">Descripcion Amplia:</label>
                    <textarea style='color:#0080FF' rows="10" cols="50" class="form-control" id="DescripcionAmplia" name='DescripcionAmplia' cols placeholder="Ingrese una descripción Amplia si desea"  ></textarea>
                  </div>
                </div>

              </div>            
          </div>   
        </div>
  
 </form>
</section>

<p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>

<script type="text/javascript">
  function verficaBarra(e)
  {
    //var longcedula= $('#CodigoBarra').val().length;
    var ean= document.getElementById('codigoBarra').value;    
    var longean= ean.length;
    if (e.keyCode==13)
    {
       if(longean>=4)
       {


            if(window.XMLHttpRequest)
            {
                xhr= new XMLHttpRequest();
            }
            else if(window.ActiveXObject){
               xhr=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xhr.onreadystatechange= retornaDatosProducto;
            xhr.open('POST','retornaDatosProductos.php',false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("CodigoBarra="+document.getElementById('codigoBarra').value);
            function retornaDatosProducto()
            {

             if(xhr.readyState==4)
                {
                  if(xhr.status==200)
                    {
                      DatosString = this.responseText;
                      if(DatosString ==0)
                      {
                          //alert('Cédula de Cliente no existe');
                      }
                      else
                      {
                          datosArray  =  DatosString.split('_;_');  
                          //$('#IdCliente').val(datosArray[0]);
                          //$('#Cedula').val(datosArray[1]);
                          //$('#NombreCliente').val(datosArray[2]);
                          //$('#Telefono').val(datosArray[3]);   
                          //$('#Email').val(datosArray[4]);  
                          //$('#Direccion').val(datosArray[5]); 
                         
                         alert('Codigo de Barra : '+datosArray[0]+ '-' + datosArray[1] + ' Ya existe registrado ese codigo de barra');
                         //document.getElementById('codigoBarra').focus(focusOption);
                         
                         // documfeent.getElementById('CodigoBarra').focus();
                      }
                    }
                }
             }
       }
       else
       {
          document.getElementById('nombreProducto').focus();
       }
    }
  }


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

</body>
</html>
   