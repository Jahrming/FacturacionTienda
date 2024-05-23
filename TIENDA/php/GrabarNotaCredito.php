


<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        include('generaXML.php');
        #---- Datos del sistema --------------------------#
        $xUsuario         = $_SESSION['user'];
        $xIdAlmacen       = 1;
        $Flag_Error       = '';
        $xIdAsignacion    = 0;
        $xIdCaja          = 1;
        $sqlProfileSistema= "select * from systemprofile";
        $rs             = mysqli_query($conexion,$sqlProfileSistema);
        $reg            = mysqli_fetch_assoc($rs);
        $IvaActual      = $reg['Iva'];
        $RucEmpresa     = $reg['RUC'];
        $Telefonos      = $reg['Telefonos'];
        $Direccion      = $reg['Direccion'];
        $AsignarCajero  = $reg['AsignarCajero'];
        $sqlSecSRI      = "select * from SriSecuencial";
        $rssri          = mysqli_query($conexion,$sqlSecSRI);
        $regsri         = mysqli_fetch_assoc($rssri);        
        $xSriSecuencial  = $regsri['SecuencialSRI'];
        $sqlUsuarios    = "select * from admusuarios where username = '$xUsuario'";
        $rsUsuarios     = mysqli_query($conexion,$sqlUsuarios);
        $regUsuarios    = mysqli_fetch_assoc($rsUsuarios);
        $xIdUsuario     = $regUsuarios['IdUsuario'];
        if($AsignarCajero=='S')
        {
          $SqlAsignacion="select IdAsignacion, IdCaja from controlcaja ".
                        " where  IdCajero = '$xIdUsuario' and EstadoAsignacion='A' ";
          $rsAsignacion   = mysqli_query($conexion,$SqlAsignacion);
          $regAsignacion  = mysqli_fetch_assoc($rsAsignacion);
          $xIdAsignacion  = $regAsignacion['IdAsignacion'];
          $xIdCaja        = $regAsignacion['IdCaja'];
        }
        else
        {
          $xIdAsignacion=0;
          $xIdCaja =1;
        }
        #-------------------------------------------------
        $j=0;
        $TipDoc                                 = '1';
        #--- Formas de Pago ------------------------------------------------#
        $xNumeroFormasPago                      = $_POST['CuantasFomasPago'];
        $xFormasPago                            = $_POST['formasPago'];
        $xBancos                                = $_POST['Bancos'];
        $xTarjetas                              = $_POST['Tarjetas'];
        $xNumerosTarjetas                       = $_POST['NumerosTarjetas'];
        $xValoresFormasPago                     = $_POST['ValoresFormasPago'];
        #--- Factura Cabecera ----------------------------------------------#
        $xIdCliente                             = $_POST['IdCliente'];
        $xIdEmpresa							    = $_POST['IdEmpresa'];
        if($xIdEmpresa==null)
        {
          $xIdEmpresa=0;
        }
        $xCedula                                = $_POST['Cedula'];
        $xSubtotal                              = $_POST['SubTotalFactura'];
        $xDescuento                             = $_POST['DescuentoFactura'];
        $xIva                                   = $_POST['IvaFactura'];
        $xTotalFactura                          = $_POST['TotalFactura'];
        #----Factura Detalle------------------------------------------------#
        $xCantidadItems                         = $_POST['CantidadItems'];
        $xReferencias                           = $_POST['Items'];
        $xPrecios                               = $_POST['Precios'];
        $xCantidades                            = $_POST['Cantidad'];
        $xTotalBrutoLinea                       = $_POST['TotalBruto'];
        $xDescuentoLinea                        = $_POST['Descuento'];
        $xSubtotalLinea                         = $_POST['Subtotal'];
        $xIvaLinea                              = $_POST['Iva'];
        $xTotalLinea                            = $_POST['TotalLinea'];
        $xCostoVenta                            = 0;
        $stockFinal                             = 0;

        #---------Inicia la transaccion ------------------------------------
        $flagError=0;
        $conexion->autocommit(FALSE);
        #-----------------Graba Cabercera ----------------------------------#
        $sqlInsert="INSERT INTO movta VALUES($TipDoc,$xIdCaja,0,now(),$xSubtotal,$xDescuento,$xIva,$xTotalFactura,$xIdAsignacion,$xIdAlmacen,$xIdCliente,$xIdEmpresa,$xSriSecuencial,'A','$xUsuario',now())";
        if($conexion->query($sqlInsert)==TRUE)
        {
          $last_id=$conexion->insert_id;
          #----------Graba detalle------------------
          $sqlInsertDetalle='';
          $i=0;
          $j=0;
          $NumeroItems=$xCantidadItems-1;
          $IdMov  = $last_id;
          for($i=0;$i<=$NumeroItems;$i++)
          {
                $j++;
                #------Tabla referencias -------#
                $sqlReferencias     = "select * from referencias where IdReferencia=".$xReferencias[$i];
                $rs                 = mysqli_query($conexion,$sqlReferencias);
                $reg                = mysqli_fetch_assoc($rs);
                $xCostoVenta        = $reg['CostoPromedio'];
                $xStockReferencia   = $reg['Stock'];
                $IdMov              = $last_id;
                $stockReferencias   = $reg['Stock']-$xCantidades[$i];
                #-----------------Tabla Stock ------------------------#
                $sqlStock     = "select * from stock where IdAlmacen='1' AND IdBodega='1' AND IdReferencia=$xReferencias[$i]";
                $rsStock      = mysqli_query($conexion,$sqlStock);
                $regStock     = mysqli_fetch_assoc($rsStock);                
                $stock        = $regStock['stock']-$xCantidades[$i];
                $sqlInsertDetalle   = "INSERT INTO movref VALUES('$TipDoc',$xIdCaja,$IdMov,$j,$xReferencias[$i],$xCantidades[$i],$xPrecios[$i],$xTotalBrutoLinea[$i],$xDescuentoLinea[$i],$xSubtotalLinea[$i],$xIvaLinea[$i],$xTotalLinea[$i],$IvaActual,0,$xCostoVenta)";
                  
                    if($conexion->query($sqlInsertDetalle)==TRUE)
                    {
                        $sqlUpdateStock="UPDATE stock SET stock=$stock WHERE IdAlmacen='1' AND IdBodega='1' AND IdReferencia=$xReferencias[$i]"; 
                        if($conexion->query($sqlUpdateStock)==TRUE)
                        {
                        }   
                        else
                        {
                             $flagError=1;
                             $msgError.= "Error al grabar stock: .<br>".$conexion->error;
                        }


                        #---------Graba en histrx -----------------------------
                        $sqlInsertHistrx= "INSERT INTO histrx VALUES('0',now(),$xReferencias[$i],$xIdAlmacen,$xIdAlmacen,$IdMov,'VM',$xCantidades[$i],$xCostoVenta,$xIdAlmacen,$xCostoVenta)";
                        if($conexion->query($sqlInsertHistrx)==TRUE)
                        {
                           $sqlUpdateSecSRI="UPDATE SriSecuencial SET SecuencialSRI=$xSriSecuencial+1,IdMovInterno=$IdMov";
                            if($conexion->query($sqlUpdateSecSRI)==TRUE)
                            {
                            }   
                            else
                            {
                                 $flagError=1;
                                 $msgError.= "Error al actualizar serial SRI: .<br>".$conexion->error;
                            }

                        }
                        else
                        {
                          $flagError=1;
                          $msgError.= "Error al grabar histrx: .<br>".$conexion->error;
                        }
                        #------------------------------------------------------
                    }
                    else
                    {
                        $flagError=1;
                        $msgError="Error al grabar detalle de factura";
                    }
          }
          ####################################################################
          #--------------- F o r m a s   d e   P a g o   --------------------#
          ####################################################################
          //$xNumeroFormasPago--;
          $j=0;
          for($i=0;$i<=($xNumeroFormasPago-1);$i++)
          {
                $j++;
                $sqlInsertFormasPago='';
                $sqlInsertCtasxCobrar='';
                switch ($xFormasPago[$i])
                {
                  case '1':
                    $sqlInsertFormasPago="INSERT INTO formapagofactura (IdAlmacen,IdMovta,IdSecuencial,IdFormaPago,
                                                                Valor,aud_usuario_proc,aud_fecha_proc,Estado)
                                        VALUES($xIdAlmacen,$IdMov,$j,$xFormasPago[$i],
                                            $xValoresFormasPago[$i],'$xUsuario',now(),'A')";
                    break;
                  case '4':   #---
                       $sqlInsertFormasPago="INSERT INTO formapagofactura(IdAlmacen,IdMovta,IdSecuencial,IdFormaPago,
                                                  IdBanco,Numero,Valor,aud_usuario_proc,aud_fecha_proc,Estado)
                                        VALUES($xIdAlmacen,$IdMov,$j,$xFormasPago[$i],$xBancos[$i],
                                                $xNumerosTarjetas[$i],$xValoresFormasPago[$i],'$xUsuario',now(),'A')";
                    break;
                  case '5':
                       $sqlInsertFormasPago="INSERT INTO formapagofactura VALUES($xIdAlmacen,$IdMov,$j,$xFormasPago[$i],
                                    $xBancos[$i],$xTarjetas[$i],$xNumerosTarjetas[$i],$xValoresFormasPago[$i],
                                    '$xUsuario',now(),'A')";  
                    break;
                  case '7':
                       $sqlInsertFormasPago="INSERT INTO formapagofactura(IdAlmacen,IdMovta,IdSecuencial,IdFormaPago,
                                                  Valor,aud_usuario_proc,aud_fecha_proc,Estado)
                                        VALUES($xIdAlmacen,$IdMov,$j,$xFormasPago[$i],
                                                $xValoresFormasPago[$i],'$xUsuario',now(),'A')";      
                        $sqlInsertCtasxCobrar="INSERT INTO ctasxcobrar(
                          IdMov,IdEmpresa,IdCliente,IdAlmacen,FechaMov,ValorFactura,Estado,aud_usuario_proc,aud_fecha_proc)
                                        VALUES(
                          $IdMov,$xIdEmpresa,$xIdCliente,$xIdAlmacen,now(),$xTotalFactura,'P','$xUsuario',now())";

                   break;
                }
                if ($conexion->query($sqlInsertFormasPago)==TRUE)
                {  //if($j==$xNumeroFormasPago)
                    if($xFormasPago[$i]=='7')
                    {
                      if ($conexion->query($sqlInsertCtasxCobrar)==TRUE)
                      {
                      }
                      else
                      {
                        $flagError=1;
                        $msgError=$conexion->error;
                      }
                    }
                }   
                else
                {   $flagError=1;
                    $msgError= "cuantas formas de pago ".$xNumeroFormasPago." Error al grabar formas de Pago: .<br>".$sqlInsertFormasPago.' '.$conexion->error;
                }  
          } 
          #-------------- F i n   d e   F o r m a s   d e   P a g o   -------#
        } 
        else
        { 
          $flagError=1;
          $msgError.= "Error al grabar movta de Pago: .<br>". $sqlInsert. '  '.$conexion->error;
        }
        if($msgError==null)
        {
           $msgError=$IdMov ;
        }
        if($flagError==1)
        {
           $conexion->rollback();
        }
        else
        {
           $conexion->commit();
           generaXML_fe($IdMov);
        }
        echo $msgError;
    }
    
