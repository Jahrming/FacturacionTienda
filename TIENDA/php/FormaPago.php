
  <!-- Modal -->
    <script type='text/javascript' language='javascript' src='../js/funciones.js'>      </script>
    <script type='text/javascript' language='javascript' src='../js/alertifyjs/alertify.js'>  </script>
    <script type='text/javascript' language='javascript' src='../js/jquery.js'>         </script>
    <meta http-equiv='Content-Type' content='text/html'; charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
    <link rel='stylesheet' href='../css/estilos.css' >
    <link rel='stylesheet' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' href='../js/alertifyjs/css/alertify.css'>
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 

    </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <div class="modal" id="nuevoProducto" tabindex="-1" role="" aria-labelledby="myModalLabel">
    <div class="modal-body" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo producto</h4>
      </div>
                    
      <div class="modal-body">
                    <form class="form-group" method="post" id="guardar_producto" name="guardar_producto">
      <div id="resultados_ajax_productos"></div>
                        
                        
                            <div class="modal-body">
                                <div class='form-group col-md-2'>
                                    <label for="codigo" i class='glyphicon glyphicon-edit' class="col-sm-3 control-label">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required>
                                </div>
                                <div class='form-group col-md-6'>
                                    <label for="nombre" class="col-sm-3 control-label">Codigo Barrasxxxxx</label>
                                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" placeholder="Código de Barras" required maxlength="40" >
                                </div> 
                            </div>
                  
                        <div class="form-row">
                            <div class="modal-body">
                                 <div class='form-group col-md-12'>
                                    <label for="nombre" class="col-sm-3 control-label">Descripción Item</label>
                                    <textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required maxlength="255" ></textarea>
                                </div>                            
                            </div>
                        </div>
                      
                        <!-- Grupo Marva Linea presentacion costo -->
                        <div class="form-horizontal col-md-12">
                            
                                <div class='form-group col-md-2'>
                                    <label for="grupo" class="col-sm-3 control-label">Grupo</label>
                                    <select id="grupo"  name="grupo" class='form-control input-sm' required>
                                        <option value=''>Seleccionar</option>
                                    </select>
                                </div>
                                <div class='form-group col-xs-1'></div>                             
                          
                                <div class='form-group col-md-2'>
                                    <label for="marca" class="col-sm-3 control-label">Marca</label>
                                    <select id="marca"  name="marca" class='form-control input-sm' required>
                                        <option value=''>Seleccionar</option>
                                    </select>
                                </div>    
                                <div class='form-group col-xs-1'></div>       
                            
                                <div class='form-group col-md-2'>
                                    <label for="linea" class="col-sm-3 control-label">Linea</label>
                                    <select id="linea"  name="linea" class='form-control input-sm' required>
                                        <option value=''>Seleccionar</option>
                                    </select>
                                </div>                            
                                <div class='form-group col-xs-1'></div>       
                          
                                <div class='form-group col-md-2'>
                                    <label for="presentacion" class="col-sm-3 control-label">Presentación</label>
                                    <select id="presentacion"  name="presentacion" class='form-control input-sm' required>
                                        <option value=''>Seleccionar</option>
                                    </select>
                                </div>                            
                                <div class='form-group col-xs-1'></div>       
                                <div class='form-group col-md-2'>
                                    <label for="costo" class="col-sm-3 control-label">Costo</label>
                                    <input type="number" class="form-control input-sm" id="costo" name="costo" placeholder="Costo" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>        
                        </div>     
                        <div class="form-horizontal col-md-12">
                                <div class='form-group col-md-2'>
                                    <label for="precio" class="col-sm-3 control-label">Precio</label>
                                    <input type="number" class="form-control input-sm" id="precio" name="precioo" placeholder="Precio" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>                            
                                <div class='form-group col-xs-1'></div>                                    
                                <div class='form-group col-md-2'>
                                    <label for="maxdscto" class="col-sm-3 control-label">Max%Dscto.</label>
                                    <input type="number" class="form-control input-sm" id="maxdscto" name="maxdscto" placeholder="Máximo % desciento" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                    
                                <div class='form-group col-md-2'>
                                    <label for="fraccion" class="col-sm-3 control-label">Fracción</label>
                                    <input type="number" class="form-control input-sm" id="fraccion" name="fraccion" placeholder="Fracción" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                    
                                <div class='form-group col-md-2'>
                                    <label for="preciofraccion" class="col-sm-3 control-label">Prec.Fracción</label>
                                    <input type="number" class="form-control input-sm" id="preciofraccion" name="preciofraccion" placeholder="Precio por fracción" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>      
                                <div class='form-group col-md-2'>
                                    <label for="pvp" class="col-sm-3 control-label">P.V.P.</label>
                                    <input type="number" class="form-control input-sm" id="pvp" name="precioo" placeholder="pvp" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>   
                        </div>     
                        <div class="form-horizontal col-md-12">                        
                                <div class='form-group col-md-2'>
                                    <label for="fechaNovedad" class="col-sm-3 control-label">Fecha.Novedad</label>
                                    <input type="date" class="form-control input-sm" id="fechaNovedad" name="fechaNovedad" placeholder="Fecha Novedado" required >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                   
                                <div class='form-group col-md-2'>
                                    <label for="ubicacion" class="col-sm-3 control-label">Ubicación</label>
                                    <input type="number" class="form-control input-sm" id="ubicacion" name="ubicacion" placeholder="Ubicación" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                                                   
                                <div class='form-group col-md-2'>
                                    <label for="unimedida" class="col-sm-3 control-label">Und.Medida</label>
                                    <input type="number" class="form-control input-sm" id="unimedida" name="unimedida" placeholder="Unidad Medida" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                  
                                <div class='form-group col-md-2'>
                                    <label for="unidadempaque" class="col-sm-3 control-label">Und.Empaque</label>
                                    <input type="number" class="form-control input-sm" id="unidadempaque" name="unidadempaque" placeholder="Unidad Empaque" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                   
                                <div class='form-group col-md-2'>
                                    <label for="comision" class="col-sm-3 control-label">Comisión</label>
                                    <input type="number" class="form-control input-sm" id="comision" name="comision" placeholder="Comisión" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                        </div>
                        <div class="form-horizontal col-md-12">   
                                <div class='form-group col-md-2'>
                                    <label for="stockmax" class="col-sm-3 control-label">STCK.Máx.</label>
                                    <input type="number" class="form-control input-sm" id="stockmax" name="stockmax" placeholder="Stock Máximo" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>  
                                <div class='form-group col-md-2'>
                                    <label for="stockmino" class="col-sm-3 control-label">STCKMin.</label>
                                    <input type="number" class="form-control input-sm" id="stockmin" name=stockmin" placeholder="Stock Minimo" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div>                                  
                                <div class='form-group col-md-2'>
                                    <label for="dsctoprov" class="col-sm-3 control-label">Desc.Prov.</label>
                                    <input type="number" class="form-control input-sm" id="dsctoprov" name="dsctoprov" placeholder="Desto Proveedor" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div> 
                                <div class='form-group col-md-2'>
                                    <label for="costo2" class="col-sm-3 control-label">Costo2</label>
                                    <input type="number" class="form-control input-sm" id="Costo2" name="Costo2" placeholder="Costo 2" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                 <div class='form-group col-xs-1'></div> 
                                <div class='form-group col-md-2'>
                                    <label for="desctovta" class="col-sm-3 control-label">Desc.Vta</label>
                                    <input type="number" class="form-control input-sm" id="desctovta" name="desctovta" placeholder="Dsscto Vta" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                        </div>      
                        <div class="form-horizontal col-md-12">          
                                
                                <div class='form-group col-xs-1'></div> 
                                <div class='form-group col-md-2'>
                                    <label for="clasifi" class="col-sm-3 control-label">Clasificación</label>
                                    <input type="number" class="form-control input-sm" id="clasifi" name="clasifi" placeholder="Clasificación" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div> 
                                <div class='form-group col-md-2'>
                                    <label for="costo3" class="col-sm-3 control-label">Costo3</label>
                                    <input type="number" class="form-control input-sm" id="costo3" name="costo3" placeholder="Costo 3" required pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" >
                                </div>    
                                <div class='form-group col-xs-1'></div> 
                                <div class='form-group col-md-2'>
                                    <label for="estado" class="col-sm-3 control-label">Estado</label>
                                     <select class="form-control" id="estado" name="estado" required>
          <option value="">-- Selecciona estado --</option>
          <option value="A" selected>Activo</option>
          <option value="I">Inactivo</option>
                                    </select>
                                </div>    
                                <div class='form-group col-xs-1'></div> 

                        </div>

      
                        <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
                        </div>
                     </form>
    </div>
    </div>
  </div>
        </div>
