
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

            $x_fecMov                   = $_POST['fecMov'];
           // $x_IdBodegaOrigen           = $_POST['BodegaOrigen'];
           // $x_IdBodegaDestino          = $_POST['BodegaDestino'];
            echo 'deedee'.$x_IdBodegaDestino;
                        echo 'oorri'.$IdBodegaOrigen;
            $x_Observacion              = $_POST['observacion'];
            $x_IdMovimiento             = $_POST['IdTransferencia'];
            $x_Estado                   = 'A';   
            $x_cantTrx                  = 0;
            $x_cantTrxStock             = 0;
            $x_Costo                    = 0;
            $x_IdBodegaOrigen           = '';
            $x_IdBodegaDestino           = '';
            $x_IdCodigoTraslado         = 'TE';            
            $sqlTipoMovimiento  = "select * from traslados where IdCodigoTraslado='$x_IdCodigoTraslado'";
            $rsTipoMovimiento   = mysqli_query($conexion,$sqlTipoMovimiento);
            $regTipoMovimiento  = mysqli_fetch_assoc($rsTipoMovimiento);
            $xSigno             = $regTipoMovimiento['Signo'];            
            #-----------obtengo datos de la transferencia -----------------
            $sql1="select * from movimientosinventarios where IdMovInventario=$x_IdMovimiento".
                    " and IdCodigoTraslado = 'TE' ".
                    " and EstadoMovimiento= 'P'";
            echo $sql1;
            $rs_sql1 = mysqli_query($conexion,$sql1);
            $r       = mysqli_fetch_assoc($rs_sql1);
            $x_IdBodegaOrigen = $r['IdBodegaOrigen'];
            $x_IdBodegaDestino =$r['IdBodegaDestino'] ;
            echo $x_IdBodegaOrigen.'-'.$x_IdBodegaDestino;
            #-------GRABA TRASLADO DE SALIDA ------------------------------#

            $sqlUpdate = "UPDATE movimientosinventarios SET EstadoMovimiento ='A'".
                         " WHERE IdMovInventario = $x_IdMovimiento ".
                         "   AND IdCodigoTraslado = 'TE'";
                         "   AND IdAlmacen = $x_IdAlmacen ";

            if($conexion->query($sqlUpdate)==TRUE)
            {

               ############################
               # Graba detalle            #
               ############################

               $i=0;
               for($i=0 ; $i<=$x_NumeroFilas; $i++)
               {      
                   $x_Secuencial           = $i;
                   $x_IdReferencia         = "IdReferencia".$i; 
                   $x_Cantidad             = "Cantidad".$i;
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
                   {   $x_Costo=0;   }
                        #---------------------------------------------------------------                       
                   if($v_IdReferencia!=null)
                   {     
                        $sqlStock         =   "SELECT * FROM stock where IdReferencia = $v_IdReferencia and IdAlmacen=$x_IdAlmacen";
                        echo $sqlStock;
                        $rs               =   mysqli_query($conexion,$sqlStock);
                        $regStock         =   mysqli_fetch_assoc($rs);
                        $xIdCodigo        =   $regStock['IdReferencia'];
                        $x_cantStock      =   $regStock['Stock']; if($x_cantStock==null){ $x_cantStock=0;}
                        $x_cantTrxStock   =   0;
                        $x_SaldoStock     =   0;
                    
                        #---------------------------------------------------------------------------------------------------#
                        #  Graba la transaccion en el detalle                   # 
                        #---------------------------------------------------------------------------------------------------#
                        # ----- Graba o actualiza en tabla Stock  -----#
                         $x_SaldoStock =   $x_cantStock + ($v_Cantidad * $xSigno);

                         $sql="UPDATE stock SET Stock = $x_SaldoStock WHERE IdReferencia=$v_IdReferencia ".
                                " and IdAlmacen = $x_IdAlmacen";
                                      
                         if($conexion->query($sql)==FALSE)
                        {   
                           $flagError=1;
                           $msgError= "Error al actualizar stock: .<br>".$sql." ".$conexion->error;
                        }  

                         echo $v_IdReferencia;echo ' id ref <br>';
                                         echo  $x_IdAlmacen;echo 'id alm <br>';
                                       echo    $x_IdBodegaDestino;echo ' bod dest<br>';
                                     echo      $x_IdMovimiento;echo ' mov<br>';
                                     echo      $x_IdCodigoTraslado;echo ' cod tras<br>';
                                     echo      $v_Cantidad;echo ' cant <br>';
                                     echo      $x_Costo;echo ' costo <br>';
                                     echo      $x_IdAlmacen;echo ' almacen <br>';
                                     echo      $x_Costo;echo ' costo <br>';


                         $sqlInsertHistrx= "INSERT INTO histrx VALUES(0,now(),$v_IdReferencia,".
                                           "$x_IdBodegaOrigen,$x_IdBodegaDestino,$x_IdMovimiento,'$x_IdCodigoTraslado',".
                                           "$v_Cantidad,$x_Costo,$x_IdAlmacen,$x_Costo)";
                         if($conexion->query($sqlInsertHistrx)==FALSE)
                         {
                                $flagError=1;
                                $msgError= "Error al grabar tabla histrx: .<br>".$sqlInsertHistrx.' '.$conexion->error;
                         }
                   }
               }

            }
            else
            {
                 $flagError=1;
                 $msgError= "Error al actualizar movimiento : .<br>".$sqlUpdate." ".$conexion->error;
            }
            #-------------graba Traslado de Entrada en bodega destino----------------# 


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
