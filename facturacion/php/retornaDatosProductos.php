<?php
    //SESION_START();
    $html = "";
    include('Conexion.php');
    $nombre = $_POST["nombreProducto"];
    $sql = "SELECT idProducto, descripcionProducto,precioProducto,costoProducto,stockProducto ".
             " FROM productos where descripcionProducto like '%".$nombre."%'  " ;
        $rs = mysqli_query($conexion,$sql);
        while($row= mysqli_fetch_array($rs))
        { //$html = "<a href='#' class='list-group-item' idCliente='cli1' value='cli2'>ahora si</a>";
          $html.="<a href='#' class='list-group-item' idProducto='".$row['idProducto']."' value='".$row['descripcionProducto']."' pvp=".$row['precioProducto']." onclick=\"retornaDatosProducto(".$row['idProducto'].",'".$row['descripcionProducto']."','".$row['precioProducto']."')\">".$row['descripcionProducto']."</a>";
        }
    echo $html;
