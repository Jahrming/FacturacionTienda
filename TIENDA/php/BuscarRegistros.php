
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
       $x_idAlmacen = $_SESSION['idalmacen'];
       $v_criterio= $_POST['criterio'];
       $v_buscarPor= $_POST['BuscarPor'];
       //$v_buscarPor='A';
       //########## buscar por Apellidos ##################
       if($v_buscarPor=='N')
       {
         $strSQl="SELECT a.IdReferencia as Refe,a.CodigoBarra as CodigoBarra, a.DescripcionReferencia as Descripcion, 
                         IFNULL(a.pvpfinal ,0) as pvp  ,m.descripcionmarca as Marca,
                          (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=1 and IdReferencia=a.IdReferencia) stock_local1,
                          (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=2 and IdReferencia=a.IdReferencia) stock_local2
                    FROM referencias a  
              left outer join marcas m  on m.IdMarca = a.IdMarca  
                   WHERE a.DescripcionReferencia like '%".$v_criterio."%' 
                     ";



                  
       }
      //########## buscar por Nombres ##################
      if($v_buscarPor=='C')
      {
         $strSQl="SELECT a.IdReferencia as Refe,a.CodigoBarra as CodigoBarra, a.DescripcionReferencia as Descripcion, 
                         IFNULL(a.pvpfinal ,0) as pvp  ,marcas.descripcionmarca as Marca,
                         (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=1 and stock.IdReferencia=a.IdReferencia) stock_local1,
                         (SELECT IFNULL(STOCK,0) FROM stock where IdAlmacen=2 and stock.IdReferencia=a.IdReferencia) stock_local2                         
                    FROM referencias a  
                    left outer join marcas on marcas.IdMarca = a.IdMarca 
                     WHERE a.CodigoBarra like '%".$v_criterio."%'  ";

       }

       $rs =  mysqli_query($conexion,$strSQl);
       //echo $strSQl;
       //$arreglo[][]='';
       while ($reg= mysqli_fetch_array($rs) ) 
       {
          //$arreglo['data'][]= $reg;    
          $arreglo['IdReferencia'][]= $reg['Refe'];
          $arreglo['CodigoBarra'][]= $reg['CodigoBarra'];
          $arreglo['Descripcion'][]= utf8_encode($reg['Descripcion']);

          $arreglo['Pvp'][]= $reg['pvp'];
          $arreglo['Marca'][]= $reg['Marca'];
          $arreglo['SaldoLocal1'][]= $reg['stock_local1'];
          $arreglo['SaldoLocal2'][]= $reg['stock_local2'];          
       }

          echo json_encode($arreglo);

      }

