gr<?php

    SESSION_START();
    if(!isset($_SESSION['user']))
    {
            header("location:../index.php");
    }
    else
    {
        include("Conexion.php");
        $v_usuarioGraba         =   $_SESSION['user'];
        $IdReferencia           =   $_POST['IdProducto'];
        $CodigoBarra            =   $_POST['codigoBarra'];
        $DescripcionReferencia  =   $_POST['nombreProducto'];
        $IdNivel                =   $_POST['IdNivel'];
        $IdMarca                =   $_POST['IdMarca'];
        $IdEditorial            =   $_POST['IdEditorial'];
        $AnioEdicion            =   $_POST['anio']; 
        $IdAutor                =   $_POST['IdAutor'];
        $IdCategoria            =   $_POST['IdCategoria'];
        $IdSubCategoria         =   $_POST['IdSubCategoria'];
        $IdProveedor            =   $_POST['IdProveedor'];
        $Isbn                   =   $_POST['isbn'];
        $Costo1                 =   $_POST['costo1'];
        $CostoPromedio          =   $_POST['costoPromedio'];
        $UltimoCosto            =   $_POST['ultimoCosto'];
        $Descuento              =   $_POST['descuento'];
        $Pvp                    =   $_POST['precio'];
        $IdUbicacion            =   $_POST['Ubicacion'];
        $Estado                 =   $_POST['Estado'];
        $Iva                    =   $_POST['IVA'];
        $Stock                  =   $_POST['stock'];
        $pvpfinal               =   $_POST['preciofinal']; 
        if($IdMarca==null){
            $IdMarca='null';
        }
        if($IdEditorial==null){
            $IdEditorial='null';
        }        
        if($IdUbicacion==null){
            $IdUbicacion='null';
        }
        if($AnioEdicion==null){
            $AnioEdicion='null';
        }
        if($Stock==null){
            $Stock='null';
        }
        if($IdAutor==null){
            $IdAutor='null';
        }       
        if($IdCategoria==null){
            $IdCategoria='null';
        }         
        if($IdSubCategoria==null){
            $IdSubCategoria='null';
        }  
        if($IdNivel==null){
            $IdNivel='null';
        }      
        if($IdProveedor==null){
            $IdProveedor='null';
        }    
        if($Descuento==null){
            $Descuento='null';
        }     
        if($pvpfinal==null){
            $pvpfinal='null';
        }              
        $SqlUpdate="update referencias set  IdReferencia             =      $IdReferencia,
                                            DescripcionReferencia   =       \"$DescripcionReferencia\",
                                            CodigoBarra             =       '$CodigoBarra',
                                            IdMarca                 =       $IdMarca,
                                            IdEditorial             =       $IdEditorial,
                                            AnioEdicion             =       $AnioEdicion,
                                            IdAutor                 =       $IdAutor,
                                            IdCategoria             =       $IdCategoria,
                                            IdSubCategoria          =       $IdSubCategoria,
                                            IdProveedor             =       $IdProveedor,
                                            IdNivel                 =       $IdNivel,
                                            Isbn                    =       '$Isbn',
                                            Costo1                  =       $Costo1,
                                            CostoPromedio           =       $CostoPromedio,
                                            UltimoCosto             =       $UltimoCosto,
                                            Descuento               =       $Descuento,
                                            Pvp                     =       $Pvp,
                                            CargaIva                =       '$Iva',
                                            IdUbicacion             =       $IdUbicacion,
                                            Stock                   =       $Stock,
                                            Estado                  =       '$Estado',
                                            aud_usuario_proc        =       '$v_usuarioGraba',
                                            aud_fecha_proc          =        now(),
                                            pvpfinal                =        $pvpfinal
                                where IdReferencia = $IdReferencia ";

            if ($conexion->query($SqlUpdate)==TRUE)
            {
              header('Location:Mensajes.php?mensaje=Producto actualizado exitosamente&Destino=ConsultaReferencias.php' );
            }
            else
            {
                echo "Error: ".$SqlUpdate."<br>".$conexion->error;
            }
            $conexion->close();
        }
    