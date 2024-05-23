

<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
        header('Content-Type: text/html; charset=UTF-8');  
        include("Conexion.php");  
        $_usuario=$_SESSION['user'];
        $IdMov= $_POST['IdMov'];
        $IdAlmacen = $_SESSION['idalmacen'];        
        $html='';
        $sql   ="SELECT r.IdReferencia Refe,r.CodigoBarra CodigoBarra,r.DescripcionReferencia Descripcion,".
                " md.Cantidad Cantidad FROM movimientosinventarios m,movimientosinventariosdetalle md,".
                " referencias r WHERE m.IdMovInventario=md.IdMovInventario AND ".
                " md.IdReferencia = r.IdReferencia AND ".
                " md.IdMovInventario = $IdMov AND ".
                " m.IdAlmacen = $IdAlmacen ";


        $rs       =  mysqli_query($conexion, $sql);

       while ($reg= mysqli_fetch_array($rs) ) 
         {
            //$arreglo['data'][]= $reg;    
            $arreglo['IdReferencia'][]= $reg['Refe'];
            $arreglo['CodigoBarra'][]= $reg['CodigoBarra'];
            $arreglo['Descripcion'][]= utf8_encode($reg['Descripcion']);
            $arreglo['Cantidad'][]= $reg['Cantidad'];

        }
       echo json_encode($arreglo);
 
  }
      



