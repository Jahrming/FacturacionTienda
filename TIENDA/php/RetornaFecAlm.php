

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
        $sql   ="SELECT m.FechaMovimiento Fecha,d.DescripcionAlmacen Descripcion, 
                            o.DescripcionAlmacen BodegaOrigen 
                  FROM movimientosinventarios m,almacenes o, almacenes d 
                  WHERE m.IdMovInventario = $IdMov 
                  AND   m.IdAlmacen = d.IdAlmacen 
                  AND   o.IdAlmacen = m.IdBodegaOrigen";
                //echo $sql;
        $rs       =  mysqli_query($conexion, $sql);
        $reg= mysqli_fetch_assoc($rs);
        if ($reg['Descripcion']==null)
         {   echo 0;}
        else
        {
            echo implode("_;_",$reg);
        }
  }
      



