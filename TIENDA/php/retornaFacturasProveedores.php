


<?php
    SESSION_START();
    if(!isset($_SESSION['user']))
    {
        header("location:../index.php");
    }
    else
    {
       include("Conexion.php");  
        $_usuario=$_SESSION['user'];
        $v_criterio= $_POST['Criterio'];
        $html='';
        $sql   ="SELECT a.IdFacturaProveedor Factura,a.subtotal SubTotal,a.iva Iva,a.total Total,a.IdFacturaProveedorSRI SRI,".
                     "  b.descripcionProveedor NombreProveedor FROM factprov a ".
                " INNER JOIN proveedores b ON b.idproveedor = a.idproveedor ".
                " AND a.idFacturaProveedor NOT IN (SELECT IdFactURAProveedor FROM Retenciones ".
                                                    " WHERE estado = 'A') ".
                  " AND ( b.DescripcionProveedor LIKE '%".$v_criterio."%')";
             

//'<div><a class="suggest-element" data="'.utf8_encode($row['name']).'" id="product'.$row['id_product'].'">'.utf8_encode($row['name']).'</a></div>'
//<a class="suggest-element" data="'.$lawyer['studies'].'" id="service'.$lawyer['dni'].'">'.utf8_encode($lawyer['studies']).'</a>

        $rs       =  mysqli_query($conexion, $sql);
        //$html.="<ul id='cliente-list'>";
        
        //AAAAAAA$html.="<ul class='list-unstyle'>";
        while($row = mysqli_fetch_array($rs))
        { 
          //$html.="<li onClick=selectCliente('".$row['Id']."';)>".$row["Nombres"]."</li>";
            $html.="<a href='#' class='list-group-item' IdFactura='".$row['Factura']."' SubTotal='".$row['SubTotal']."' Iva='".$row['Iva']."' NombreProveedor='".$row['NombreProveedor']."' Sri='".$row['SRI']."' Total='".$row['Total']."' value='".$row['NombreProveedor']."'>".$row['NombreProveedor']."| Fact. SRI: ".$row['SRI']." | No.Interno: ".$row['Factura']." | Total:".$row['Total']." | Iva: ".$row['Iva']."</a>";
 
             //$arreglo['IdCliente']=$row['Refe'];
           //$arreglo['Ruc']=$row['Ruc'];
          //$arreglo['Nombres']=$row['Nombres'];
           // $arreglo['Telefono']=$row['Telefono'];
           // array_push($return_arr, $arreglo);
        
         }
        
         //$html.="</ul>";
         echo $html;

          //echo json_encode($return_arr);



    }


