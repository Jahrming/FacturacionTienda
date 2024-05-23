
<!DOCTYPE html>


<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
            include("Conexion.php");  
            $flagError=0;
            $conexion->autocommit(FALSE);       
            $x_usuario                  = $_SESSION['user'];
            $x_IdAlmacen                = $_SESSION['idalmacen'];
            $x_NumeroFilas              = $_POST['NumeroFilas'];
            $x_IdCodigoTraslado         = $_POST['IdCodigoTraslado'];
            $x_fecMov                   = $_POST['fecMov'];
            $x_IdBodegaOrigen           = $_POST['IdBodegaOrigen'];
            $x_IdBodegaDestino          = $_POST['IdBodegaDestino'];
            $x_Observacion              = $_POST['observacion'];
            $x_Estado                   = 'A';   
            $x_cantTrx                  = 0;
            $x_cantTrxStock             = 0;
            $x_Costo                    = 0;
            $sqlTipoMovimiento  = "select * from traslados where IdCodigoTraslado='$x_IdCodigoTraslado'";
            $rsTipoMovimiento   = mysqli_query($conexion,$sqlTipoMovimiento);
            $regTipoMovimiento  = mysqli_fetch_assoc($rsTipoMovimiento);
            #-------GRABA TRASLADO DE SALIDA ------------------------------#
            $xSigno             = $regTipoMovimiento['Signo'];
            $sqlInsert = "INSERT INTO movimientosinventarios VALUES(0,'$x_IdCodigoTraslado','$x_fecMov', 
                                                        $x_IdAlmacen,$x_IdBodegaOrigen,$x_IdBodegaOrigen,$x_IdBodegaDestino,
                                                        '$x_Observacion','$x_Estado',
                                                        '$x_usuario',DATE_SUB(NOW(), INTERVAL 5 HOUR))"; 

            if($conexion->query($sqlInsert)==TRUE)
            {
               $last_id=$conexion->insert_id; 
               $x_IdMovimiento   = $last_id;
               ############################
               # Graba detalle            #
               ############################

               $SqlInsertDetalle='';
               $i=0;

               #---------------------------------------------
               for($i=1 ; $i<=$x_NumeroFilas; $i++)
               {       
                         $x_Secuencial           = $i;
                         $x_IdReferencia         = "IdReferencia".$i; 
                         $x_Cantidad             = "Cantidad".$i;

                         if (isset($_POST[$x_IdReferencia])) 
                          {
                                 $v_IdReferencia         = $_POST[$x_IdReferencia];
                                 $v_Cantidad             = $_POST[$x_Cantidad];                            
                                  
                                 $x_Saldo                = 0;  // para las 2 tablas referencias y stock
                                 $x_cantRefe             = 0;  // cantidad de la tabla referencia
                                 $x_cantStock            = 0;  // cantidad de la tabla stock
                                 $x_Costo                = 0;

                                 #--------obtengo el costo-------------------------
                                 $sqlRef     =  "select * from referencias where IdReferencia=$v_IdReferencia";
                                 $rsRef      =  mysqli_query($conexion, $sqlRef) ;
                                 $rRef       =  mysqli_fetch_assoc($rsRef);
                                 $x_Costo    =  $rRef['Costo1'];
                                 if ($x_Costo ==NULL)
                                    $x_Costo=0;   
                                #---------------------------------------------------------------                       
                                if($v_IdReferencia!=null && $v_Cantidad!=null)
                                {     
                                            $sqlStock         =   "SELECT * FROM stock where IdReferencia = $v_IdReferencia and IdAlmacen=$x_IdAlmacen";
                                            $rs               =   mysqli_query($conexion,$sqlStock);
                                            $regStock         =   mysqli_fetch_assoc($rs);
                                            $xIdCodigo        =   $regStock['IdReferencia'];
                                            $x_cantStock      =   $regStock['Stock']; if($x_cantStock==null){ $x_cantStock=0;}
                                            $x_cantTrxStock   =   0;
                                            $x_SaldoStock     =   0;
                                        
                                            #---------------------------------------------------------------------------------------------------#
                                            #  Graba la transaccion en el detalle                   # 
                                            #---------------------------------------------------------------------------------------------------#
                                            $SqlInsertDetalle="INSERT INTO movimientosinventariosdetalle VALUES($x_IdMovimiento,
                                                                           $x_Secuencial,$v_IdReferencia,$v_Cantidad,$x_Costo)"; 
                                                                           echo       $SqlInsertDetalle;             
                                              if($conexion->query($SqlInsertDetalle)==TRUE)
                                              {
                                                    # ----- Graba o actualiza en tabla Stock  -----#
                                                          $x_SaldoStock =   $x_cantStock + ($v_Cantidad * $xSigno);
                                                          #--------  Graba en tabla stock  


                                                          $sql="UPDATE stock SET Stock = $x_SaldoStock WHERE IdReferencia=$v_IdReferencia ".
                                                                 " and IdAlmacen = $x_IdAlmacen";
                                                          
                                                          if($conexion->query($sql)==FALSE)
                                                          {   
                                                             $flagError=1;
                                                             $msgError= "Error al actualizar stock: .<br>".$sql." ".$conexion->error;
                                                          }  

                                                      $sqlInsertHistrx= "INSERT INTO histrx VALUES(0,DATE_SUB(NOW(), INTERVAL 5 HOUR),$v_IdReferencia,".
                                                                        "$x_IdAlmacen,$x_IdBodegaDestino,$x_IdMovimiento,'$x_IdCodigoTraslado',".
                                                                        "$v_Cantidad,$x_Costo,$x_IdAlmacen,$x_Costo)";
                                                      if($conexion->query($sqlInsertHistrx)==FALSE)
                                                      {
                                                             $flagError=1;
                                                             $msgError= "Error al grabar tabla histrx: .<br>".$sqlInsertHistrx.' '.$conexion->error;
                                                      }
                                              }
                                              else
                                              {
                                                  $flagError=1;
                                                  $msgError= "Error al grabar movimientosinventariosdetalle: .<br>".$SqlInsertDetalle." ".$conexion->error;
                                              }
                                }
                          }

               }
               #------------------------------------------------------
            }
            else
            {
                 $flagError=1;
                 $msgError= "Error al grabar: .<br>".$sqlInsert." ".$conexion->error;
            }
            #-------------graba Traslado de Entrada en bodega destino----------------# 

            if ($x_IdCodigoTraslado=='TS')
            {
                $x_IdAlmacenDestino= $x_IdBodegaDestino;
                $x_Estado = 'P';
                $x_IdCodigoTrasladoDestino = 'TE';
                $sqlInsert = "INSERT INTO movimientosinventarios VALUES(0,'$x_IdCodigoTrasladoDestino','$x_fecMov', 
                                                            $x_IdAlmacenDestino,$x_IdBodegaOrigen,$x_IdBodegaOrigen,$x_IdBodegaDestino,
                                                            '$x_Observacion','$x_Estado',
                                                            '$x_usuario',NOW())"; 
                                                            //     '$x_usuario',DATE_SUB(NOW(), INTERVAL 5 HOUR))"; 
                                                            echo $sqlInsert;
                if($conexion->query($sqlInsert)==TRUE)
                {
                   $last_idDestino=$conexion->insert_id; 
                   $x_IdMovimiento2   = $last_idDestino;
                   ############################
                   # Graba detalle            #
                   ############################
                   $SqlInsertDetalle='';
                   $i=0;
                   for($i=1 ; $i<=$x_NumeroFilas; $i++)
                   {      
                       $x_Secuencial           = $i;
                       $x_IdReferencia         = "IdReferencia".$i; 
                       $x_Cantidad             = "Cantidad".$i;
                       $v_IdReferencia         = $_POST[$x_IdReferencia];
                       $v_Cantidad             = $_POST[$x_Cantidad];
                       $x_Saldo                = 0;  // para las 2 tablas referencias y stock
                       $x_cantRefe             = 0;  // cantidad de la tabla referencia
                       $x_cantStock            = 0;  // cantidad de la tabla stock
                       #--------obtengo el costo-------------------------
                       $sqlRef     =  "select * from referencias where IdReferencia=$v_IdReferencia";
                       echo $sqlRef;
                       $rsRef      =  mysqli_query($conexion, $sqlRef) ;
                       $rRef       =  mysqli_fetch_assoc($rsRef);
                       $x_Costo    =  $rRef['Costo1'];

                       if ($x_Costo ==NULL)
                          $x_Costo=0;   
                        #-------------------------------------------------
                       if($v_IdReferencia!=null)
                       {     
                            #---------------------------------------------------------------------------------------------------#
                            #  Graba la transaccion en el detalle                   # 
                            #---------------------------------------------------------------------------------------------------#
                            $SqlInsertDetalle="INSERT INTO movimientosinventariosdetalle VALUES($x_IdMovimiento2,
                                                           $x_Secuencial,$v_IdReferencia,$v_Cantidad,$x_Costo)";                    
                              if($conexion->query($SqlInsertDetalle)==TRUE)
                              {

                              }
                              else
                              {
                                  $flagError=1;
                                  $msgError= "Error al grabar movimientosinventariosdetalle: .<br>".$SqlInsertDetalle." ".$conexion->error;
                              }

                       }

                   }
                }
                else
                {
                     $flagError=1;
                     $msgError= "Error al grabar: .<br>".$sqlInsert." ".$conexion->error;
                }
            }
            #-----FIN DE GRABAR EN EL DESTIBO

            if($flagError==0)
            {
                header('Location:MensajesFP.php?mensaje=Movimiento No. '.$x_IdMovimiento.' ingresada exitosamente&Destino=MovimientosInventarios.php&Destino2=ImpresionMovimiento.php?IdMovimiento='.$x_IdMovimiento);   
                  $conexion->commit();
            }
            else
            {
                echo $msgError;
                $conexion->rollback(); 
            }


            $conexion->close();
      }
