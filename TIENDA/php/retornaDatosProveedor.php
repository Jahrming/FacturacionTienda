


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
        $v_criterio= $_POST['ruc'];
        $html='';
        $sql   ="SELECT IdProveedor AS Id, RUC AS Ruc,".
                  " DescripcionProveedor AS NombreProveedor ".
                  " FROM proveedores where RUC = '$v_criterio' ";
             

//'<div><a class="suggest-element" data="'.utf8_encode($row['name']).'" id="product'.$row['id_product'].'">'.utf8_encode($row['name']).'</a></div>'
//<a class="suggest-element" data="'.$lawyer['studies'].'" id="service'.$lawyer['dni'].'">'.utf8_encode($lawyer['studies']).'</a>

        $rs       =  mysqli_query($conexion, $sql);
        $registro =  mysqli_fetch_assoc($rs); 
        //$html.="<ul id='cliente-list'>";
        
       if($registro['Id']==null)
        {
                echo 0;
        }
        else
        {
            echo implode("_;_", $registro);
        }
    }
        
         //$html.="</ul>";
        // echo $html;

          //echo json_encode($return_arr);



    