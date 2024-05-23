


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
            $msgError = "";
            $conexion->autocommit(FALSE);       
            $x_usuario                  = $_SESSION['user'];
            $x_NumeroFilas              = $_POST['NumeroFilas'];
            $x_FacturaSri               = $_POST['FacturaSri'];
            $x_FechaFactura             = $_POST['FecFactura'];
            $x_IdProveedor              = $_POST['IdProveedor'];
            $x_SubTotal                 = $_POST['SubTotalPrincipal'];
            $x_Descuento                = $_POST['DescuentoPrincipal'];
            $x_Iva                      = $_POST['IvaPrincipal'];
            $x_TotalFactura             = $_POST['TotalFactura'];   
            $x_IdFormaPago              = $_POST['IdFormaPagoProveedor'];
            $x_EstadoFinan              = $_POST['IdEstadoFinanciero'];
            $x_IdBanco                  = $_POST['IdBanco'];
            $x_Referencia                  = $_POST['Referencia'];

            $x_Estado                   = 'A';   
            $x_IdAlmacen                = $_SESSION['idalmacen'];
            $x_IdBodega = '';

            //#-------------Detalle factura Proveedor------------
            //$xCantidadItems                         = $_POST['CantidadItems'];
            $xReferencias                           = $_POST['Items'];
            $xPrecios                               = $_POST['Precios'];
            $xCantidades                            = $_POST['Cantidad'];
            $xTotalBrutoLinea                       = $_POST['TotalBruto'];
            $xDescuentoLinea                        = $_POST['Descuento'];
            $xSubtotalLinea                         = $_POST['Subtotal'];
            $xIvaLinea                              = $_POST['Iva'];
           // $xTotalLinea                            = $_POST['TotalLinea'];       
            $xCostoCompra                           = $_POST['CostoUnitario'];                   



            $sqlBodegas="select * from almacenes where IdAlmacen= $x_IdAlmacen";
            $rsBodegas = mysqli_query($conexion,$sqlBodegas);
            $regBodega = mysqli_fetch_assoc($rsBodegas);
            $x_IdBodega = $regBodega['IdBodega'];


            $sqlInsert = "INSERT INTO factprov VALUES(0,'$x_FacturaSri','$x_FechaFactura', 
                                                        $x_IdProveedor,$x_SubTotal,
                                                        $x_Descuento,$x_Iva,
                                                        $x_TotalFactura,$x_IdFormaPago,$x_IdAlmacen,$x_IdBodega,
                                                        '$x_EstadoFinan','$x_Estado','$x_usuario',DATE_SUB(NOW(), INTERVAL 5 HOUR),$x_IdBanco,'','$x_Referencia')"; 
                                                    // echo $sqlInsert; 
            if($conexion->query($sqlInsert)==TRUE)
            {

               $last_id=$conexion->insert_id; 
               $x_IdFacturaProveedor   = $last_id;
               ######--- Graba detalle -----#######
               $SqlInsertDetalle='';
               $i=0;
               for($i=0;$i<$x_NumeroFilas;$i++)
               {  
                  $x_Secuencial           = $i+1;


                  $v_IdReferencia         = $xReferencias[$i];
                  $v_Cantidad             = $xCantidades[$i];
                  $v_PrecioCompra         = $xPrecios[$i];
                  $v_TotalBrutoLinea      = $xTotalBrutoLinea[$i];
                  $v_DescuentoLinea       = $xDescuentoLinea[$i];
                  $v_SubtotalLinea        = $xSubtotalLinea[$i];
                  $v_IvaLinea             = $xIvaLinea[$i];
                  $v_TotalLinea           = ($v_PrecioCompra*$v_Cantidad)-$v_DescuentoLinea ;
                  //$v_CostoReferencia      = $xCostoCompra[$i];
         

                  /* $v_IdReferencia.'-'.         
                  $v_Cantidad             .'-'.
                  $v_PrecioCompra         .'-'.
                  $v_TotalBrutoLinea      .'-'.
                  $v_DescuentoLinea       .'-'.
                  $v_SubtotalLinea        .'-'.
                  $v_IvaLinea             .'-'.
                  $v_TotalLinea           .'-'.
                  $v_CostoReferencia      ;*/
                  if($v_IdReferencia!=null)
                  { 
                    #----- Graba en detalle de la factura ------------------#
/*                    $SqlInsertDetalle="INSERT INTO factprovdetalle VALUES($x_IdAlmacen,$x_IdBodega,".
                                                   "$x_IdFacturaProveedor,$x_Secuencial,$v_IdReferencia,$v_Cantidad,".
                                                   round($v_PrecioCompra,4).",".round($v_TotalBrutoLinea,4).",".
                                                   round($v_DescuentoLinea,4).",".round($v_SubtotalLinea,4).",".
                                                   round($v_IvaLinea,4).",".round($v_TotalLinea,4).")";*/

                    //Esto es solo para compuvargas                                                 
                    $SqlInsertDetalle="INSERT INTO factprovdetalle VALUES($x_IdAlmacen,$x_IdBodega,".
                                                   "$x_IdFacturaProveedor,$x_Secuencial,$v_IdReferencia,$v_Cantidad,".
                                                   round($v_PrecioCompra,4).",".round($v_TotalBrutoLinea,4).",".
                                                   round($v_DescuentoLinea,4).",".round($v_SubtotalLinea,4).",".
                                                   round($v_IvaLinea,4).",".round($v_TotalLinea,4).")";
                                if($conexion->query($SqlInsertDetalle)==TRUE)
                                {
                                           #-------Sacar costo promedio en base a la suma de la cants en los almacenes -------
                                          $sqlSumStock = "SELECT sum(Stock) as sumstock FROM stock where IdReferencia = $v_IdReferencia ";

                                          $rsSumStock = mysqli_query($conexion,$sqlSumStock);
                                          $regSumStock = mysqli_fetch_assoc($rsSumStock);
                                          $xcantStock = $regSumStock['sumstock'];
                                          //echo $xcantStock.' xcanrsotck';
                                          $sqlRefe ="SELECT * FROM referencias WHERE IdReferencia= $v_IdReferencia";
                                         // echo $sqlRefe;
                                          $rsRefe = mysqli_query($conexion,$sqlRefe);
                                          $regRefe= mysqli_fetch_assoc($rsRefe);
                                          #-----costo1-------------------
                                          #$xCosto1 =round($v_PrecioCompra,4);
                                          # solo para compuvargas
                                          $xCosto1 =round(($v_PrecioCompra + ($v_IvaLinea/$v_Cantidad)),4);
                                          #-----ultimo costo ------------
                                          $xUltimoCosto   = $regRefe['Costo1'];
                                          $xUltimoCostoPromedio = $regRefe['CostoPromedio'];
                                          #-----costo promedio -----------
                                          $xCostoPromedio = (($xCosto1* $v_Cantidad)+($xUltimoCosto * $xcantStock))/($v_Cantidad+$xcantStock);
 
                                          //$CantidadFinal = $xStock+$v_Cantidad;
                                          //$CostoTotal = $v_PrecioCompra*$CantidadFinal;
                                          //$CostoPromedio = $CostoTotal/$CantidadFinal;
                                          $sqlUpdateReferencias="UPDATE referencias SET Costo1        = $xCosto1,
                                                                             UltimoCosto   = $xUltimoCosto 

                                                                             #CostoPromedio = $xCostoPromedio#
                                                                           
                                                                      WHERE IdReferencia = $v_IdReferencia ";
                                                                      echo $sqlUpdate;

                                        #--------------------------------------------------------------------
                                         if ($conexion->query($sqlUpdateReferencias)==FALSE)
                                         {
                                                 $flagError=1;
                                                 $msgError= "Error al grabar en costos en tabla referencias : .<br>".$sqlUpdateReferencias.' '.$conexion->error;
                                         } 
                                         else
                                         {
                                              ##--------Actualiza saldos si no existe los crea ----------#
                                              $sqlStock = "SELECT * FROM stock where IdReferencia = $v_IdReferencia and IdAlmacen = $x_IdAlmacen";
                                              $rs = mysqli_query($conexion,$sqlStock);
                                              $regStock = mysqli_fetch_assoc($rs);
                                              $xIdCodigo = $regStock['IdReferencia'];
                                              $xSaldo    = $regStock['Stock'];
                                              $sql="UPDATE stock SET Stock = ($v_Cantidad+$xSaldo) ".
                                                   " WHERE IdReferencia=$v_IdReferencia".
                                                   "   AND IdAlmacen = $x_IdAlmacen";
                                            //  echo $sql;      
                                              if ($conexion->query($sql)==FALSE)
                                              { 
                                                 $flagError=1;
                                                 $msgError= "Error al grabar actualizar costo: .<br>".$sql.' '.$conexion->error;
                                              }
                                              else
                                              {///###########histrx-----#----- Graba en histrx  ------------------#                                                  
                                                $sqlInsertHistrx= "INSERT INTO histrx VALUES('0',NOW(),$v_IdReferencia,$x_IdAlmacen,$x_IdAlmacen,$x_IdFacturaProveedor,'CO',$v_Cantidad,$xCosto1,$x_IdAlmacen,$xCosto1)";
                                                        if($conexion->query($sqlInsertHistrx)==FALSE)
                                                        {
                                                            $flagError=1;
                                                            $msgError= "Error al grabar histrx: .<br>".$sqlInsertHistrx.' '.$conexion->error;
                                                        }
                                                   ####-----------fin de grabar en histrx --------------------------                                                
                                                  ///------fin histrx  
                                              }
                                         }

                                }
                                else
                                {
                                    $flagError=1;
                                    $msgError= "Error al grabar  detalle: .<br>".$SqlInsertDetalle.' '.$conexion->error;
                                }
                    #-----------fin de grabar el detalle ------------------------------------
                                  
                }           
              
                    ///***********************series
                     // $cantSeriesCompra = 0;
                     // $sqlxs="select * from tmp_numeros_serie_co ";
                     // $rsxs = mysqli_query($conexion,$sqlxs);
         
                     //  while($regs = mysqli_fetch_array($rsxs))
                     //  {
                     //      $cantSeriesCompra = $cantSeriesCompra+1;
                     //  }
                     //  if($cantSeriesCompra > 0)
                     //  {


                       //}             
                 }
               ##########--------GRabar numeros de serie ------------------------------
                         $sqlInsertNumerosSerie='';
                         $sqlInsertNumerosSerie = "INSERT INTO comprasitemsseries SELECT '$x_IdFacturaProveedor',
                         IdAlmacen,IdReferencia,NumeroSerie,UserName,NOW() from tmp_numeros_serie_co where NumeroSerie is not null";
                                        //   echo $sqlInsertNumerosSerie;
                                            //    " WHERE IdAlmacen = $x_IdAlmacen ".
                                            //    "   AND UserName = '$x_usuario' ";
                           if($conexion->query($sqlInsertNumerosSerie)==FALSE)
                           {
                             $flagError=1;
                           //  echo $sqlInsertNumerosSerie;
                             $msgError= "Error al grabar los numeros de Serie ".$sqlInsertNumerosSerie." Error al grabar números de Serie: ".$sqlInsertNumerosSerie.' '.$conexion->error;
                           }    


            }
            else
            {
               $flagError=1;
               $msgError= "Error al grabar factura proveedor : .<br>".$sqlInsert.'-'.$conexion->error;
            }
        if($msgError==null)
        { 
          $flagError=0;
       
          //$msgError=$sqlInsertNumerosSerie;
          $msgError=$x_IdFacturaProveedor;
          //$msgError=$sqlInsertNumerosSerie.' '.$cantSeriesCo;
        }
        if($flagError==1)
        {
           $conexion->rollback();
        }
        else
        {
           $conexion->commit();
        }
        echo $msgError;
   }
?>
