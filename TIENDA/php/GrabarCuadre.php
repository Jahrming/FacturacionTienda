<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

        include("Conexion.php");
        #---- Datos del sistema --------------------------#
        $xUsuario         = $_SESSION['user'];
        $xIdAlmacen       = 1;
        $Flag_Error       = '';
        $xIdCaja          = 1;
        $xFechaAsignacion = null;
        $xBase            = null;
        $sqlProfileSistema= "select * from systemprofile";
        $rs             = mysqli_query($conexion,$sqlProfileSistema);
        $reg            = mysqli_fetch_assoc($rs);
        $IvaActual      = $reg['Iva'];
        $RucEmpresa     = $reg['RUC'];
        $Telefonos      = $reg['Telefonos'];
        $Direccion      = $reg['Direccion'];
        $AsignarCajero  = $reg['AsignarCajero'];
        $xIdAsignacion  = $_POST['IdAsignacion'];

        if($AsignarCajero=='S')
        {
          $SqlAsignacion="select IdAsignacion, IdCaja,Base from controlcaja 
                           where IdAsignacion = '$xIdAsignacion' ";
          $rsAsignacion=mysqli_query($conexion,$SqlAsignacion);
          $regAsig=mysqli_fetch_assoc($rsAsignacion);
          $xIdCaja = $reg['IdCaja'];
          $xBase=$reg['Base'];
          #----------------------------------------------------------------------
          $TipDoc                                 = '1';
          #----------------------------------------------------------------------
          #----------------Tipo de Cuadre 'M'= Manual 'S'= Sistema
          $xTipoCuadre = 'M';
          #--- Ventas Efectivo ------------------------------------------------#
          $xValorVentasEfectivo                   = $_POST['ValorVentasEfectivo'];
          #----Ventas con Cheques ---------------------------------------------#
          $xCantidadVentasCheques                 = $_POST['CantidadCheques'];
          $xValorVentasCheques                    = $_POST['ValorCheques'];
          #----Ventas con TC ---------------------------------------------#
          $xCantidadVentasTC                      = $_POST['CantidadTC'];
          $xValorVentasTC                         = $_POST['ValorTC'];
          #----Ventas con Credito ---------------------------------------------#
          $xCantidadVentasCredito                 = $_POST['CantidadCredito'];
          $xValorVentasCredito                    = $_POST['ValorCredito'];
          #----Ventas con Vales u otros ---------------------------------------------#
          $xCantidadVentasVales                  = $_POST['CantidadVales'];
          $xValorVentasVales                     = $_POST['ValorVales'];
          $xTotal                                = $_POST['Total'];
          $xBase                                 = $_POST['Base'];

          
          #########################################################################
          #---------Inicia la transaccion ----------------------------------------#        
          #########################################################################
          $flagError=0;
          //$conexion->autocommit(FALSE);
          #---Arma sqlInsert para grabar cuadre-----------------------------------#
          $sqlInsertCuadreManual="INSERT INTO cuadrescaja VALUES($xIdAsignacion,'M',now(),$xValorVentasEfectivo,
                                  $xCantidadVentasCheques,$xValorVentasCheques,$xCantidadVentasTC,
                                  $xValorVentasTC,$xCantidadVentasCredito,$xValorVentasCredito,
                                  $xCantidadVentasVales,$xCantidadVentasVales,$contadorNV,$xTotalNV,$contadorNC,0,
                                  $xTotal,'$xUsuario',now())";
                                  echo $sqlInsertCuadreManual;
          if($conexion->query($sqlInsertCuadreManual)==FALSE)
          {
             $flagError=1;
             $msgError.= "Error al grabar cuadre manual .<br>".$conexion->error;  
             echo $msgError;            
          }
          else
          { 
            #------Cuadre por sistema------------------------------------#
            $xSigno             =1;   
            $xTotalEfectivo     =0;    
            $xTotalCheque       =0;            
            $xTotalTC           =0; 
            $xTotalCredito      =0;           
            $xTotalVales        =0;       
            $xSubtotalSistema   =0;        
            $xDescuentoSistema  =0;
            $xImpuestoSistema   =0;        
            $xTotalSistema      =0;     
            $xCantidadCheques   =0;        
            $xCantidadTC        =0;
            $xCantidadCreditos  =0;       
            $xCantidadVales     =0;    
            $contadorFA         =0;             
            $contadorNC         =0; 
            $contadorNV         =0;

            $strCuadreSistema="SELECT movta.TipDoc as TipDoc,movta.SubTotal as SubTotal,".
                                   "  movta.Descuento as Descuento,movta.Impuesto as Impto,".
                                   "  movta.Total as Total,formapagofactura.IdFormaPago as FormaPago,".
                                   "  formapagofactura.valor as ValorFormaPago ".
                               " FROM movta, formapagofactura ".
                               " WHERE movta.IdAsignacion = ".$xIdAsignacion.
                                " AND formapagofactura.IdMovta = movta.IdMov ";
              $rsCuadreSistema = mysqli_query($conexion,$strCuadreSistema);     
              while($regCuadreSistema= mysqli_fetch_array($rsCuadreSistema))
              {
                 if($regCuadreSistema['TipDoc']==3){ $contadorNC++; $xSigno=-1;}
                 if($regCuadreSistema['TipDoc']==1){ $contadorFA++; $xSigno=1;}
                 if($regCuadreSistema['TipDoc']==2){ $contadorNV++; $xSigno=1;}

                   #---Efectivo------#
                   if($regCuadreSistema['TipDoc']==1 OR $regCuadreSistema['TipDoc']==3)
                   { 
                     if($regCuadreSistema['FormaPago']==1)
                     {
                       $xTotalEfectivo=$xTotalEfectivo+($regCuadreSistema['ValorFormaPago']*$xSigno);
                       $xTotalSistema= $xTotalSistema+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     }  
                   }
                   #----- efectivo NV ------#
                   if($regCuadreSistema['TipDoc']==2)
                   { 
                     if($regCuadreSistema['FormaPago']==1)
                     {
                       $xTotalNV=$xTotalNV+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     }  
                   }                   
                   #---TC------#
                   if($regCuadreSistema['FormaPago']==4)
                   {
                     $xTotalTC=$xTotalTC+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xTotalSistema= $xTotalSistema+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xCantidadTC++;
                   }  
                   #---Cheques------#
                   if($regCuadreSistema['FormaPago']==5)
                   {
                     $xTotalCheque=$xTotalCheque+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xTotalSistema= $xTotalSistema+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xCantidadCheques++;
                   }
                   if($regCuadreSistema['FormaPago']==7)
                   {
                     $xTotalCredito=$xTotalCredito+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xTotalSistema= $xTotalSistema+($regCuadreSistema['ValorFormaPago']*$xSigno);
                     $xCantidadCreditos++;
                   }  
                   $xSigno=1;                              
               } 
               $xTotal=$xTotalEfectivo+$xTotalCheque+$xTotalTC+$xTotalCredito+$xTotalVales+$xBase;
               $sqlInsertCuadreSistemas="INSERT INTO cuadrescaja VALUES($xIdAsignacion,'S',now(),
                        $xTotalEfectivo,$xCantidadCheques,$xTotalCheque,$xCantidadTC,
                                  $xTotalTC,$xCantidadCreditos,$xTotalCredito,
                                  $xCantidadVales,$xTotalVales,$contadorNV,$xTotalNV,$contadorNC,0,$xTotal,'$xUsuario',now())";
                                  echo $sqlInsertCuadreSistemas;
                      if($conexion->query($sqlInsertCuadreSistemas)==TRUE)
                      {
                          $sqlUpdateControlCaja="UPDATE controlcaja SET EstadoAsignacion='C' 
                                       WHERE  IdAsignacion=$xIdAsignacion ";
                          if($conexion->query($sqlUpdateControlCaja)==TRUE)
                          {  //echo 'grabafo';
                             //   header('Location:Mensajes.php?mensaje=Cuadre de Caja Generado Exitosamente&Destino=ImpresionCuadre.php?IdAsignacion='.$xIdAsignacion);
                             header('Location:MensajesFP.php?mensaje=Cuadre generado exitosamente&Destino=../inicio/menu.php&Destino2=ImpresionCuadre.php?IdAsignacion='.$xIdAsignacion.'&CantFa='.$contadorFA."&CantNc=".$contadorNC."&CantNv=".$contadorNV);
                          }
                          else
                          {
                             $flagError=1;
                             $msgError= "Error al grabar cuadre caja Automático: .<br>".$sqlUpdateControlCaja." ".$conexion->error;  
                             echo $msgError;
                          }
  
                      }
                      else
                      {
                         $flagError=1;
                         $msgError= "Error al grabar cuadre caja Automático: .<br>".$sqlInsertCuadreSistemas." ".$conexion->error;  
                         echo $msgError;            
                      }                                             
              }
        }    

        else
        {
          $xIdAsignacion=0;
          $xIdCaja =1;
        }
        if($flagError==1)
        {
           $conexion->rollback();
        }
        else
        {
           $conexion->commit();
        }
}
                                                   
