<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {

            include("Conexion.php");
            
            $v_usuario                  = $_SESSION['user'];
            $v_NumeroFilas              = $_POST['numeroFilas'];
            $v_IdRepresentante          = $_POST['IdRepresentante'];
            $v_IdRegistroMatricula      = $_POST['IdRegistroMatricula'];
            $v_TotalBruto               = $_POST['subtotal'];
            $v_Iva                      = $_POST['iva'];
            $v_TotalPago                = $_POST['total'];           
            $v_IdCurso                  = $_POST['IdCurso'];     

            $sqlInsert="INSERT INTO pagos VALUES(0,$v_IdRegistroMatricula,$v_IdRepresentante,now(),now(),'$v_usuario',$v_TotalBruto,0,$v_Iva,$v_TotalPago)";
            echo $sqlInsert;
            if($conexion->query($sqlInsert)==TRUE)
            {

                $last_id=$conexion->insert_id;
                /*#################
                // Graba detalle
                */#################
                $SqlInsertDetalle='';
                $i=0;

                for($i=1;$i<=$v_NumeroFilas;$i++)
                {
                    $IdPago = $last_id;
                    $tipoObligacion = "TipoObligacion".$i;
                    $secObligacion  = "Secuencia".$i;
                    $valor          = "Valor".$i;
                    $campo          = 'chkbox'.$i;

                    if(isset($_POST[$campo]) && 
                       isset($_POST[$valor]) && 
                       isset($_POST[$secObligacion]) &&
                       isset($_POST[$tipoObligacion]))
                    {
                            $x_tipoObligacion = $_POST[$tipoObligacion];
                            $x_tipoObligacion = substr($x_tipoObligacion, 0,1);
                            $x_secObligacion  = $_POST[$secObligacion];
                            $x_valor          = $_POST[$valor];
                            $v_check = $_POST[$campo];
                            if($v_check==1)
                            {
                              $SqlInsertDetalle=
                              "INSERT INTO pagosdetalle VALUES($IdPago,$v_IdRegistroMatricula,'$x_tipoObligacion',$x_secObligacion,$x_valor)";
                                if($conexion->query($SqlInsertDetalle)==TRUE)
                                {
                                    $sqlUpdate="UPDATE registroobligaciones ".
                                                 " SET ValorPagado=$x_valor,ValorPendiente=0,".
                                                     " FechaRegistroPago=now(),Estado='C' ".
                                               " WHERE IdRegistroMatricula = $v_IdRegistroMatricula ".
                                               "   AND SecuencialObligacion = $x_secObligacion ";

                                    if ($conexion->query($sqlUpdate)==TRUE)/////
                                    { 
                                            header('Location:Mensajes.php?mensaje=Materia actualizada exitosamente&Destino=RegistroPagos.php' );
                                    }
                                    else
                                    {
                                         echo "Error al grabar: .<br>".$conexion->error;
                                    }                                   
                                    header('Location:Mensajes.php?mensaje=Pagos Registrados correctamente&Destino=ImpresionRecibo.php?IdPago='.$IdPago);

                header( $headerLink);

                                }
                                else
                                {
                                     echo "Error al grabar: .<br>".$conexion->error;
                                }
                            }
                        }

                }          
            }
            else
            {
               echo "Error al grabar: .<br>".$conexion->error; 
            }


    }

            $conexion->close();

