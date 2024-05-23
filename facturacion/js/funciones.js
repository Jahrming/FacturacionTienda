function buscarProductoNombre()
{
    var criterio  =document.getElementById("nombreProducto").value;
    var lista;
    if(criterio.length > 3)
    {
        //AJAX
        if(window.XMLHttpRequest)
        {
            xhr = new XMLHttpRequest();
        }
        else if(window.ActiveXObject)
        {
            xhr = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhr.onreadystatechange = confirmaProductos;
        xhr.open('POST','../php/retornaDatosProductos.php',false);
        xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhr.send("nombreProducto="+criterio);
        function confirmaProductos()
        {
            if(xhr.readyState==4)
            {
                if(xhr.status==200)
                {
                    respuesta= this.responseText;
                    if(respuesta==0)
                    {
                        alert("no hay coincidencias");
                    }
                    else
                    {
                        lista= document.getElementById("filtrarProductos");
                        lista.innerHTML = respuesta;
                    }
                }
            }
        }
    }
}

function retornaDatosProducto(idProducto,nombreProducto,precioProducto)
{
    document.getElementById('idProducto').value= idProducto;
    document.getElementById('nombreProducto').value =nombreProducto;
    document.getElementById('pvp').value =precioProducto;
    document.getElementById('filtrarProductos').innerHTML="";
}

function agregarFilas()
{
    var subtotal;
    var codigoProducto= document.getElementById("idProducto").value;
    var nombreProducto= document.getElementById("nombreProducto").value;
    var pvp = document.getElementById("pvp").value;
    var cant =  document.getElementById("cantidad").value;
    var tabla = document.getElementById("detalle"); 
    var numeroFilas = tabla.rows.length;
    subtotal = parseFloat(pvp) * parseFloat(cant);
    tabla.insertRow(numeroFilas).outerHTML= 
      "<tr>"+"<td><input type='text' id='idProducto_"+numeroFilas+"' name='idProducto_"+numeroFilas+"' value='"+codigoProducto+"' class='sinborde'></td>"+
      "<td>"+nombreProducto+"</td>"+
      "<td><input type='number' id='pvp_"+numeroFilas+"' name='pvp_"+numeroFilas+"' value="+pvp+" class='sinborde'></td> "+
      "<td><input type='number' id='cant_"+numeroFilas+"' name='cant_"+numeroFilas+"' value="+cant+" class='sinborde'></td>"+
      "<td><input type='number' id='subtotal_"+numeroFilas+"' name='subtotal_"+numeroFilas+"' value="+subtotal.toFixed(2)+" class='sinborde'></td>"+
      "</tr>";
      document.getElementById('numeroFilas').value=numeroFilas;
      calcularTotal(numeroFilas);


}

function calcularTotal(numeroFilas)
{
    var iva=0.12;
    var i ;
    var campoSubTotal=0;
    var elementoSubTotal=0;
    var valorIva = 0;
    for(i=1;i<=numeroFilas;i++)
    {
        campoSubTotal = "subtotal_"+i;
        elementoSubTotal= elementoSubTotal+ parseFloat(document.getElementById(campoSubTotal).value);

    }
    document.getElementById('subTotal').value = elementoSubTotal.toFixed(2);
    valorIva = elementoSubTotal * iva;
    document.getElementById('iva').value = valorIva.toFixed(2);
    document.getElementById('totalFactura').value = (elementoSubTotal+valorIva).toFixed(2);
}