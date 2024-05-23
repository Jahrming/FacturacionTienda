


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
        $sql   ="SELECT descripciontipodocumento AS TipDoc, IdCliente AS Id,CedulaRUC AS Ruc,".
                  " CONCAT(IFNULL(Apellidos,''),IFNULL(Nombres,'')) AS Nombres,Telefonos AS Telefono,Email as email, ".
                  " direccion as direccion FROM clientes ".
                  " INNER JOIN admtipodocumento ON clientes.IDTIPODOCUMENTO = admtipodocumento.IDTIPODOCUMENTO ".
                  " AND (Apellidos LIKE '%".$v_criterio."%' or Nombres LIKE '%".$v_criterio."%')";
             

//'<div><a class="suggest-element" data="'.utf8_encode($row['name']).'" id="product'.$row['id_product'].'">'.utf8_encode($row['name']).'</a></div>'
//<a class="suggest-element" data="'.$lawyer['studies'].'" id="service'.$lawyer['dni'].'">'.utf8_encode($lawyer['studies']).'</a>

        $rs       =  mysqli_query($conexion, $sql);
        //$html.="<ul id='cliente-list'>";
        
        //AAAAAAA$html.="<ul class='list-unstyle'>";
        while($row = mysqli_fetch_array($rs))
        { 
          //$html.="<li onClick=selectCliente('".$row['Id']."';)>".$row["Nombres"]."</li>";
            $html.="<a href='#' class='list-group-item' tipdoc='".utf8_encode($row['TipDoc'])."' direccion='".$row['direccion']."' email='".$row['email']."' telefonos='".$row['Telefono']."' cedula='".$row['Ruc']."' id='".$row['Id']."' value='".$row['Nombres']."'>".$row['Nombres']."</a>";
 
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


