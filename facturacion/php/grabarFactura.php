<?php
   include('conexion.php');
   $idCliente          = $_POST["codigoCliente"];
   $subTotal           = $_POST['subTotal'];
   $iva                = $_POST['iva'];
   $totalFactura       = $_POST['totalFactura'];
   $numeroFilas        = $_POST['numeroFilas'];
   $campoIdProduto     = '';
   $campoCantidad      = '';
   $campoSubTotalLinea = '';
   $campoPvp           = '';   
   $i = 0;
   $strSQL="insert into factura_cabecera values(0,$idCliente,now(),$subTotal,$iva,$totalFactura)";
   if($conexion->query($strSQL)==TRUE)
   {
        $idFactura= $conexion->insert_id;
        for($i=1;$i<=$numeroFilas;$i++)
        {
            $campoIdProducto    = "idProducto_".$i;
            $campoPvp           = "pvp_".$i;
            $campoSubTotalLinea = "subtotal_".$i;
            $campoCantidad      = "cant_".$i;
            $datoIdProducto     = $_POST[$campoIdProducto];
            $datoPvp            = $_POST[$campoPvp];
            $datoSubTotalLinea  = $_POST[$campoSubTotalLinea];
            $datoCantidad       = $_POST[$campoCantidad];
            $strSQL="insert into factura_detalle values($idFactura,$datoIdProducto,$datoCantidad,$datoPvp,$datoSubTotalLinea)";
            if($conexion->query($strSQL)==FALSE)
            {
                echo "ERROR AL GRABAR DETALLE LA FACTURA";
                break;
              }
              

        }
     echo "FACTURA GRABADA EXITOSAMENTE";
   }