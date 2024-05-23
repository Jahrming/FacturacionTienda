<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $strsql="select * from SriSecuencial where IdTipoDocumento=3";
        $rs=  mysqli_query($conexion, $strsql);
        $regSecSri  =  mysqli_fetch_assoc($rs);
        $x_SecSri=$regSecSri['SecuencialSRI'];        

        $x_usuarioGraba         = $_SESSION['user'];
        $x_IdFacProveedor= $_POST['NumeroFactProveedor'];
        $x_NumeroCompletoFactura=$_POST['sri'];
        $x_SubTotal= $_POST['SubTotal'];
        $x_Iva=$_POST['iva'];
        $x_Total=$_POST['total'];
        $x_IdPorcentajeRetenido=$_POST['IdPorcentaje'];
        $x_ValorRetenido=$_POST['valorRetenido'];
        $x_Fecha=$_POST['fechaRetencion'];
        $conexion->autocommit(FALSE);
        $SqlInsert="insert into Retenciones values(0,
                                                 $x_IdFacProveedor,
                                                 $x_NumeroCompletoFactura,
                                                 $x_SecSri,
                                                 $x_SubTotal,
                                                 $x_Iva,
                                                 $x_Total,
                                                 $x_IdPorcentajeRetenido,".
                                                 round($x_ValorRetenido,4).",
                                                 '$x_Fecha',
                                                 'A',
                                                 DATE_SUB(NOW(), INTERVAL 5 HOUR),
                                                 '$x_usuarioGraba')";

            if ($conexion->query($SqlInsert)==TRUE)
            {
                $last_id=$conexion->insert_id;

                $sqlUpdateSecSRI="UPDATE SriSecuencial SET SecuencialSRI=$x_SecSri+1,IdMovInterno=$last_id where IdTipoDocumento=3";
                if($conexion->query($sqlUpdateSecSRI)==TRUE)
                {
                    $msgError='';
                }   
                else
                {
                    $msgError.= "Error al actualizar secuencial SRI: .<br>".$conexion->error;
                }
                if ($msgError=='')
                {
                   header('Location:Mensajes.php?mensaje=Retención grabada exitosamente&Destino=ConsultaRetenciones.php' ); 
                   $conexion->commit();
                   //generaXML_fe($IdMov); 
                }
                else
                {
                   $conexion->rollback();
                }
            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       