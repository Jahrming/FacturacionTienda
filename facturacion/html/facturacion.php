<?php

  include("../php/Conexion.php");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/funciones.js"></script>
    <link rel="stylesheet" href="../css/bootstrap-4.6.0/dist/css/bootstrap.css">
 
    <style type="text/css">
        .sinborde   { border: 0;   }
        body,select { font-family: arial, 'Times New Roman',Times, serif;
                      font-size: 12px;} 
        input{
          padding: 3px;
          margin: 3px;
        }
        ul{
          float: left;
          background-color: #eee;
          cursor:pointer;
        }
        li{
          float: left;
          padding: 12px;
        }
        #sugerencias {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
        #filtrarProductos {
                font-size: 11px;
                box-shadow: 2px 2px 8px 0 rgba(0,0,0,.2);
                height: auto;
                position: absolute;
                /*top: 45px;*/
                z-index: 9999;
                width: 400px;
                float: left;
        }
 
        #sugerencias .suggest-element {
                background-color: #EEEEEE;
                border-top: 1px solid #d6d4d4;
                cursor: pointer;
                padding: 8px;
                width: 400%;
                float: left;
        }

    </style>    
    <title>FACTURACION</title>

</head>
<body onload="fecha()">
    <div class="container">
        <form action="../php/grabarFactura.php" method="post">
           <h1> <center>FACTURACION</center></h1> 
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Cliente:</label>
                    <input type="text" name="codigoCliente" id="codigoCliente" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Nombre</label>
                    <input type="text" name="nombreCliente" id="nombreCliente" class="form-control" onkeyup="buscaClienteNombre()">
                    <div id="sugerencias" class="list-group"></div>
                </div>
                <input type="hidden" name="numeroFilas" id="numeroFilas">  
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Fecha:</label>
                    <input type="text" name="fecha" id="fecha" class="form-control">
                </div>
                <div class="form-group col-md-2"> 
                    <label for="">SubTotal</label>
                    <input type="text" name="subTotal" id="subTotal" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="">Iva:</label>
                    <input type="text" name="iva" id="iva" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="">Total:</label>
                    <input type="text" name="totalFactura" id="totalFactura" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-1">
                    <label for="">IdProd</label>
                    <input type="text" name="idProducto" id="idProducto" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="">Descripcion Producto</label>
                    <input type="text" name="nombreProducto" id="nombreProducto" class="form-control" onkeyup="buscarProductoNombre()">
                    <div id="filtrarProductos" class="list-group"></div>
                </div>
                <div class="form-group col-md-2">
                    <label for="">PVP</label>
                    <input type="text" name="pvp" id="pvp" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label for="">Cant</label>
                    <input type="text" name="cantidad" id="cantidad" class="form-control">
                </div>
                <div class="form-group col-md-1">
                    <label for="">Registrar</label>
                    <input type="button" value="Add" class="form-control" onclick="agregarFilas()">
                </div>
            </div>

            <table id="detalle" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>IdProducto</th>
                        <th>Descripcioón Producto</th>
                        <th>PVP</th>
                        <th>Cant.</th>
                        <th>Total</th>
                    </tr>
                </thead>

            </table>
            <input type="submit" value="Grabar Factura" >
        </form>
    </div>
</body>
<script>
    function buscaClienteNombre()
    {
        var criterio = document.getElementById("nombreCliente").value;
        var lista;
        
        if(criterio.length >3)
        {
            // AJAX 
            if(window.XMLHttpRequest)
            {
                xhr = new XMLHttpRequest();
            }
            else if(window.ActiveXObject)
                {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            xhr.onreadystatechange = confirmar;
            xhr.open('POST','../php/retornaDatos.php',false);
            xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xhr.send("nombre="+document.getElementById("nombreCliente").value);
            //xhr.send("nombre="+criterio);
            function confirmar()
            {
                if(xhr.readyState==4)
                {
                    if(xhr.status=200)
                    {
                        respuesta= this.responseText;
                       //alert(respuesta);
                        if(respuesta==0)
                        {
                            alert("no existen coincidencias");
                        }
                        else
                        {
                            // truco para la lista
                            lista= document.getElementById("sugerencias");
                            lista.innerHTML= respuesta;
                        }
                    }
                }
            }

            
        }
    }

    function retornaDatosCliente(idcliente,nombreCliente)
    {
        document.getElementById('codigoCliente').value = idcliente;
        document.getElementById('nombreCliente').value = nombreCliente;
        document.getElementById('sugerencias').innerHTML = "";
    }

    function fecha()
    {
        var today =  new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if(dd<10)
        {
            dd= '0' + dd;
        }
        if(mm < 10)
        {
            mm = "0" + mm;
        }
        today = mm + '/' + dd + '/' + yyyy;
        document.getElementById("fecha").value = today;
    }

</script>
    

</html>