<html lang="en">

<head>
<script type='text/javascript' src='../js/funciones.js'> 					</script>
<script type='text/javascript' src='../js/alertifyjs/alertify.js'> 	</script>
<script type='text/javascript' language='javascript' src='../js/jquery.js'> </script>
<meta http-equiv='Content-Type' content='text/html' charset='utf-8'/>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'/>
					<link rel='stylesheet' href='../css/estilos.css' >
					<link rel='stylesheet' href='../css/bootstrap.min.css'>
					<link rel='stylesheet' href='../js/alertifyjs/css/alertify.css' />
</head>
<body onload='return inicio(\"nuevo_alumno\")'>
        <section>
        <form id='formulario' class='form-horizontal' role='form' method='POST' enctype='multipart/form-data' action='graba_alumno.php'>

                <button class='btn btn-primary' title='Regresar' onClick='window.location=\"cargando.php?programa=alumnos.php\"' type='button'> <span class='glyphicon glyphicon-backward'></span> </button>

                <button id='btn_grabar' class='btn btn-primary' title='Grabar' onclick='return valida_cedula(\"alumnos\",\"nuevo\")' type='submit'><span class='glyphicon glyphicon-floppy-disk'></span></button>

                <button class='btn btn-primary' title='Limpiar' onclick='return inicio(\"nuevo_alumno\")' type='reset' ><span class='glyphicon glyphicon-refresh'></span></button>

                <center> <h2 style='color:#0431B4' id='titulo'> usuarios </h2> </center>
                <br>
                <div class='row'>
                        <div class='form-group'>
                                <label for='f_cedula' class='col-lg-1 control-label'>Cédula : </label>
                            <div class='col-xs-2'>
                                     <input type='text' id='f_cedula' name='f_cedula' maxlength='10' 
                                        class='form-control input-sm' onKeyPress='' placeholder='Ingrese Cédula' required>
                                </div>
                                <label for='f_apellidos' class='col-lg-1 control-label'>Apellidos :  </label>
                                <div class='col-xs-3'>
                                        <input type='text' id='f_apellidos' name='f_apellidos' maxlength='45'  onKeyPress='return soloLetras(event)' placeholder='Ingrese Apellidos' class='form-control input-sm' required >
                                </div>
                                <label for='f_nombres' class='col-lg-1 control-label'>Nombres :  </label>
                                <div class='col-xs-3'>
                                        <input type='text' id='f_nombres' name='f_nombres' maxlength='45' 
                                                onKeyPress='return soloLetras(event)' placeholder='Ingrese Nombres' class='form-control input-sm' required>
                                </div>
                        </div>

                        <div class='form-group'>			 			
                                <label for='f_direccion' class='col-lg-1 control-label'>Dirección :  </label>
                                <div class='col-xs-6'>
                                        <input type='text' id='f_direccion' name='f_direccion' maxlength='75' placeholder='Ingrese Dirección Domicilio' class='form-control input-sm' required> 
                                </div>
                                <label for='f_lugar_nacimiento' class='col-lg-1 control-label'>Pais Nac. :  </label>
                                <div class='col-xs-3'>
                                        <select id='f_lugar_nacimiento' name='f_lugar_nacimiento' 
                                                class='form-control input-sm' required>
                                                <option value='' selected hidden> Pais Nacimiento </option>
                                                ".$cb_paises."
                                        </select>
                                </div>
                        </div>

                        <div class='form-group'>			 			
                                <label for='f_mail' class='col-lg-1 control-label'>Mail :  </label>
                                <div class='col-xs-3'>
                                        <input type='email' id='f_mail' name='f_mail' maxlength='80' placeholder='Ingrese Email' class='form-control input-sm' required>
                                </div>
                                <label for='f_sexo' class='col-lg-1 control-label'>Sexo :  </label>
                                <div class='col-xs-2'>
                                        <select id='f_sexo' name='f_sexo' class='form-control input-sm' required>
                                                <option value='' disabled selected hidden> Sexo </option>
                                                ".$cb_sexos."
                                        </select>
                                </div>
                                <label for='f_colegio' class='col-lg-1 control-label'>Colegio :  </label>
                                <div class='col-xs-3'>
                                        <select id='f_colegio' name='f_colegio' class='form-control input-sm' required>
                                                <option value='' disabled selected hidden> Seleccione Colegio </option>
                                                ".$cb_colegios."
                                        </select>
                                </div>
                        </div>

                        <div class='form-group'>			 			
                                <label for='f_convencional' class='col-lg-1 control-label'> Fono :  </label>
                                <div class='col-xs-2'>
                                        <input type='type' id='f_convencional' name='f_convencional' maxlength='15' placeholder='Ingrese Fono Convencional' class='form-control input-sm' required>
                                </div>
                                <label for='f_movil' class='col-lg-2 control-label'> Celular :  </label>
                                <div class='col-xs-2'>
                                        <input type='type' id='f_movil' name='f_movil' maxlength='40' placeholder='Ingrese Fono Celular ' class='form-control input-sm' required>
                                </div>
                                <label for='f_fecnac' class='col-lg-1 control-label'>F.Nacimiento:  </label>
                                <div class='col-xs-2'>
                                        <input type='date' id='f_fecnac' name='f_fecnac' class='form-control input-sm' required>
                                </div>
                        </div>

                        <div class='form-group'>
                                <label for='f_etnia' class='col-lg-1 control-label'> Etnia :  </label>
                                <div class='col-xs-2'>
                                        <select id='f_etnia' name='f_etnia' class='form-control input-sm' required>
                                                <option value='' disabled selected hidden> Seleccione Etnia </option>
                                                ".$cb_etnias."
                                        </select>
                                </div>
                                <label for='f_foto' class='col-lg-2 control-label'> Foto :  </label>
                                <div class='col-xs-3'>
                                        <input type='file' id='f_foto' name='f_foto' accept='image/png, .jpeg, .jpg, image/gif' class='form-control input-sm' >
                                </div>
                        </div>

                        <div class='form-group'>
                                <center>
                                        <p style='color: #ffffff; background-color: #FA58F4'> EN CASO DE EMERGENCIA </p>
                                </center>
                                <br>
                                <label for='f_enfermedad' class='col-lg-1 control-label'> Discapacitado: </label>
                                <div class='col-xs-1'>
                                        <select id='f_enfermedad' name='f_enfermedad' class='form-control input-sm' required>
                                                <option value='N'> No </option>
                                                <option value='S'> Si </option>
                                        </select>
                                </div>
                                <label for='f_carnet' class='col-lg-1 control-label'> C. Conadis :  </label>
                                <div class='col-xs-2'>
                                        <input type='type' id='f_carnet' name='f_carnet' maxlength='15' placeholder='Ingrese Numero Carnet' class='form-control input-sm' >
                                </div>
                                <label for='f_contacto' class='col-lg-1 control-label'> Contacto :  </label>
                                <div class='col-xs-2'>
                                        <input type='type' id='f_contacto' name='f_contacto' maxlength='40' placeholder='Ingrese Contacto ' class='form-control input-sm' required>
                                </div>
                                <label for='f_fono_contacto' class='col-lg-1 control-label'>Fono Cont.:  </label>
                                <div class='col-xs-2'>
                                        <input type='text' id='f_fono_contacto' name='f_fono_contacto' maxlength='40' placeholder='Ingrese Fono Contacto' class='form-control input-sm' required>
                                </div>
                        </div>

                        <div class='form-group'>
                                <center>
                                        <p style='color: #ffffff; background-color: #5858FA'> DONDE TRABAJA </p>
                                </center>
                                <br>
                                <label for='f_trabaja' class='col-lg-1 control-label'>Trabaja ? :  </label>
                                <div class='col-xs-1'>
                                        <select id='f_trabaja' name='f_trabaja' class='form-control input-sm' required>
                                                <option value='S'> Si </option>
                                                <option value='N'> No </option>
                                        </select>
                                </div>
                                <label for='f_empresa' class='col-lg-1 control-label'>Empresa :  </label>
                                <div class='col-xs-5'>
                                        <input type='text' id='f_empresa' name='f_empresa' maxlength='80' placeholder='Ingrese Nombre Empresa' class='form-control input-sm' required>
                                </div>
                                <label for='f_fono_empresa' class='col-lg-1 control-label'>Fono Emp.:  </label>
                                <div class='col-xs-2'>
                                        <input type='text' id='f_fono_empresa' name='f_fono_empresa' maxlength='40' placeholder='Ingrese Fono Empresa' class='form-control input-sm' required>
                                </div>
                        </div>					

                        <div class='form-group'>
                                <center>
                                        <p style='color: #ffffff; background-color: orange'> DONDE SUFRAGA </p>
                                </center>
                                <br>
                                <label for='CboProvincias' class='col-lg-2 control-label'>Provincia :  </label>
                                <div class='col-xs-2'>
                                        <select id='CboProvincias' name='CboProvincias' class='form-control input-sm' 
                                        onchange='carga_cantones()' required>
                                                <option value='' selected hidden> Seleccione Provincia </option>
                                                ".$cb_provincias."
                                        </select>
                                </div>
                                <label for='CboCantones' class='col-lg-1 control-label'>Canton :  </label>
                                <div class='col-xs-2'>
                                        <select id='CboCantones' name='CboCantones' class='form-control input-sm'
                                                onchange='carga_parroquias()' required>
                                                <option value='' selected hidden> Seleccione Canton </option>
                                        </select>
                                </div>
                                <label for='CboParroquias' class='col-lg-1 control-label'> Parroquia :  </label>
                                <div class='col-xs-2'>
                                        <select id='CboParroquias' name='CboParroquias' class='form-control input-sm'>
                                                <option value='' selected hidden> Seleccione Parroquia </option>
                                        </select>
                                </div>
                        </div>
                </div>

        </form>
        </section>
        <p style='font-size:16pt;color:red' id='mi_mensaje' name='mi_mensaje'>  </p>
</body></html>
				

