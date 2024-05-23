<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba         =   $_SESSION['user'];
        $CodigoBarra            =   $_POST['codigoBarra'];
        $DescripcionReferencia  =   $_POST['nombreProducto'];
        $IdMarca                =   $_POST['IdMarca'];
        //$IdNivel                =   $_POST['IdNivel'];
        //$IdEditorial            =   $_POST['IdEditorial'];
        //$AnioEdicion            =   $_POST['anio']; 
        //$IdAutor                =   $_POST['IdAutor'];
        $IdCategoria            =   $_POST['IdCategoria'];
        $IdProveedor            =   $_POST['IdProveedor'];
        $IdSubCategoria            =   $_POST['IdSubCategoria'];
        $Isbn                   =   $_POST['isbn'];
        $Costo                 =   $_POST['costo1'];
        $CostoPromedio                =   $_POST['costoPromedio'];
        $UltimoCosto            =   $_POST['ultimoCosto'];
        $Descuento              =   $_POST['descuento'];
        $Pvp                    =   $_POST['precio'];
        $IdUbicacion            =   $_POST['Ubicacion'];
        $Estado                 =   $_POST['Estado'];
        $Iva                    =   $_POST['IVA'];
        $xDescAmplia            =   $_POST['DescripcionAmplia'];
        $pvpFinal               =   $_POST['preciofinal'];
         if($IdMarca==null){
            $IdMarca='null';
        }
        if($IdEditorial==null){
            $IdEditorial='null';
        }     
        if($IdProveedor==null){
            $IdProveedor='null';
        }      
        if($IdUbicacion==null){
            $IdUbicacion='null';
        }


        if($Stock==null){
            $Stock='null';
        }
     
        if($IdCategoria==null){
            $IdCategoria='null';
        }         
        if($IdSubCategoria==null){
            $IdSubCategoria='null';
        }  


        if($IdAutor==null){
            $IdAutor='null';
        }  
        if($AnioEdicion==null){
            $AnioEdicion='null';
        }        if($IdNivel==null){
            $IdNivel='null';
        }    
        $SqlInsert="insert into referencias values( '0',
                                                    '$CodigoBarra',
                                                    \"$DescripcionReferencia\",
                                                    $IdMarca,
                                                    $IdEditorial,
                                                    $AnioEdicion,
                                                    $IdAutor,
                                                    $IdCategoria,
                                                    $IdSubCategoria,
                                                    $IdProveedor,
                                                    '$Isbn',
                                                    $IdNivel,
                                                    $Costo,
                                                    $CostoPromedio,
                                                    $UltimoCosto,
                                                    $Descuento,
                                                    $Pvp,
                                                    '$Iva',
                                                    $pvpFinal,
                                                    1,
                                                    $IdUbicacion,
                                                    '$Estado',
                                                    '$v_usuarioGraba',
                                                    now(),
                                                    '$xDescAmplia')";


            if ($conexion->query($SqlInsert)==TRUE)
            {
                $last_id=$conexion->insert_id;
                $str2 = "select * from almacenes ";
                echo $str2;
                $rs2  = mysqli_query($conexion,$str2);
                while ($reg2 = mysqli_fetch_array($rs2))
                {
                        $sql="INSERT INTO stock VALUES(".$reg2['IdAlmacen'].",".$reg2['IdBodega'].",".$last_id.",0)";
                        echo $sql;
                        //mysqli_query($conexion,$sql);
                        if ($conexion->query($sql)==TRUE)
                        {
                            header('Location:Mensajes.php?mensaje=Producto grabado exitosamente&Destino=ConsultaReferencias.php' );
                        }
                        else
                        {
                            echo "Error al grabar stock: ".$Sql."<br>".$conexion->error;
                        }                    
                }


            }
            else
            {
                echo "Error: ".$SqlInsert."<br>".$conexion->error;
            }
            $conexion->close();
        }
       