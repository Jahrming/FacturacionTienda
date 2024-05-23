function cambiarDisplay(id)
{
    filas = document.getElementById('tabla').rows.length - 1;
    obj = document.getElementsByTagName('tr');

    if($('#'+id).css('display') == 'none')
    {
        for(i=1;i<=filas;i++)
        {  
            if(obj[i].id==id)
            {
                obj[i].className = 'clasex';
            }
            else
            {
                if(obj[i].className == 'clasex' || obj[i].className == 'clasey')
                {
                    obj[i].className = 'clasey';
                }
            }
        }
    }
    else 
    {
        for(i=1;i<=filas;i++)
        {  
            if(obj[i].id==id)
            {
                obj[i].className = 'clasey';
            }
            else
            {
                if(obj[i].className == 'clasex' || obj[i].className == 'clasey')
                {
                    obj[i].className = 'clasey';
                }
            }
        }
    }
}

function getFileExtension3(filename) 
{
  var a=0;
  return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
}

function mostrarVentana()
{
    var ventana = document.getElementById('miVentana');
    ventana.style.marginTop = '120px';
    ventana.style.left = ((document.body.clientWidth-350) / 2) +  'px';
    ventana.style.display = 'block';
}

function ocultarVentana()
{
    var ventana = document.getElementById('miVentana');
    ventana.style.display = 'none';
}

function addFilasFactura()
{  
    var DescripcionProducto = document.getElementById('NombreProducto').value;
    var IdReferencia        = document.getElementById('IdReferencia').value;
    var CodigoBarra         = document.getElementById('Codigo').value;
    var Cantidad            = document.getElementById('Cantidad').value;
    var Precio              = document.getElementById('pvp').value;
    var PrecioFinal         = document.getElementById('PrecioFinal').value;
    var PorcDescuento       = document.getElementById('Descuento').value;
    var CargaIva            = document.getElementById('CargaIva').value;
    var Iva                 = document.getElementById('Iva').value;
    var SubTotalPrincipal   = document.getElementById('SubTotalPrincipal').value;
    var DescuentoPrincipal  = document.getElementById('DescuentoPrincipal').value;
    var IvaPrincipal        = document.getElementById('IvaPrincipal').value;
    var TotalFactura        = document.getElementById('TotalFactura').value;
    var TotalBruto          = 0;
    var Descuento           = 0;
    var TotalLinea          = 0;
    var ValorDescuento      = 0;
    var SubTotal            = 0;
    var descItem    =document.getElementById('NombreProducto').value;
  

    if(IdReferencia==null){
      return;
    }

    if(CargaIva=='S'){
      Iva=parseFloat(Iva);
    }
    else
    {
      Iva=0;
    }
    
    Cantidad            = parseFloat(Cantidad);
    Precio              = parseFloat(Precio);
    PorcDescuento       = parseFloat(PorcDescuento);
    TotalBruto          = Precio*Cantidad;
    Descuento           = TotalBruto*(PorcDescuento/100);
    Subtotal            = TotalBruto- Descuento;
    Iva                 = Subtotal*(Iva/100);

    TotalLinea          = Subtotal+Iva;
    SubTotal = (Cantidad * Precio)-Descuento;
    var tabla       =   document.getElementById('tabla1');
    var numFilas    =   tabla.rows.length;
    var indiceFila  =   parseInt(document.getElementById('NumeroFilas').value);
    var iconoEliminar = 'glyphicon glyphicon-trash';
//alert('id' + document.getElementById('IdReferencia').value);

///  ********   agrega filas
        indiceFila++;

        //indiceFila = indiceFila+1;
        tabla.insertRow(numFilas).outerHTML=
        "<tr>"+
        "<td width='4%' ><input type='hidden' id='CargaIva"+indiceFila+"' value='"+CargaIva+"'><input type='text' id='IdReferencia" +indiceFila+"' Name='IdReferencia" +indiceFila+"' value='"+IdReferencia +"' class='sinborde'  readOnly size='5'></td>"+
        "<td width='10%'><input type='text' id='CodigoBarra"  +indiceFila+"' Name='CodigoBarra"  +indiceFila+"' value='"+CodigoBarra  +"' class='sinborde'  readOnly size='10'></td>"+
        "<td width='32%'><input type='text' id='DescripcionProducto"+indiceFila+"' Name='DescripcionProducto"+indiceFila+"' value='"+DescripcionProducto+"' class='sinborde'  readOnly='yes' size='35'></td>"+
       "<td width='7%' ><input type='number' class='form-controlxs' id='Cantidad"+indiceFila+"' Name='Cantidad"+indiceFila+"' value='"+Cantidad+"' class='sinborde'  size='6' onkeypress='CalculaTotalLinea("+indiceFila+")' onkeydown='CalculaTotalLinea("+indiceFila+")'   onkeyup='CalculaTotalLinea("+indiceFila+")' onchange='CalculaTotalLinea("+indiceFila+")' onblur='CalculaTotalLinea("+indiceFila+")'></td>"+
       //                                                                                                                                                                     onkeydown="calcularPVP()"   onkeypress="calcularPVP()"
       //onkeyup='CalculaTotalLineaProveedor("+indiceFila+");' onblur='CalculaTotalLineaProveedor("+indiceFila+");' onchange='CalculaTotalLineaProveedor("+indiceFila+");
        "<td width='7%' ><input type='hidden' id='Subtotal"+indiceFila+"' Name='Subtotal"+indiceFila+"' value='"+Subtotal+ "' class='sinborde' readOnly size='5'><input type='hidden' id='Descuento"+indiceFila+"' Name='Descuento"+indiceFila+"' value='"+Descuento+    "' class='sinborde' readOnly size='5'><input type='hidden' id='TotalBruto"+indiceFila+"' Name='TotalBruto"+indiceFila+"' value='"+TotalBruto+    "' class='sinborde' readOnly size='5'><input type='text' id='Precio"+indiceFila+"' Name='Precio"+indiceFila+"' value='"+Precio+"'   size='6' readOnly class='sinborde' >" + // KeyUp='CalculaTotalLinea("+indiceFila+")' onChange='CalculaTotalLinea("+indiceFila+")' onBlur='CalculaTotalLinea("+indiceFila+")'></td>"+
        //"<td width='7%' ><input type='number' id='Precio"+indiceFila+"' Name='Precio"+indiceFila+"' value='"+Precio+"' class='sinborde'  size='6' readOnly='yes'></td>"+
       // "<td width='7%' ><input type='hidden' id='TotalBruto"+indiceFila+"' Name='TotalBruto"+indiceFila+"' value='"+TotalBruto+    "' class='sinborde' readOnly size='5'></td>"+
      //  "<td width='7%' ><input type='hidden' id='Descuento"+indiceFila+"' Name='Descuento"+indiceFila+"' value='"+Descuento+    "' class='sinborde' readOnly size='5'></td>"+
      //  "<td width='7%' ><input type='hidden' id='Subtotal"+indiceFila+"' Name='Subtotal"+indiceFila+"' value='"+Subtotal+ "' class='sinborde' readOnly size='5'></td>"+
        "<td width='7%' ><input type='text' id='Iva"+indiceFila+"' Name='Iva" +indiceFila+"' value='"+Iva+ "' class='sinborde' readOnly size='5'></td>"+
        "<td width='7%' ><input type='number' id='PvpFinal"+indiceFila+"' Name='PvpFinal" +indiceFila+"' value='"+PrecioFinal+ "' size='5'                                    onkeypress='CalculaTotalLinea2("+indiceFila+")' onkeydown='CalculaTotalLinea2("+indiceFila+")'  onkeyup='CalculaTotalLinea2("+indiceFila+")' onchange='CalculaTotalLinea2("+indiceFila+")' onblur='CalculaTotalLinea2("+indiceFila+")'  ></td>"+
        "<td width='7%' ><input type='text' id='TotalLinea"+indiceFila+"' Name='TotalLinea"+indiceFila+"' value='"+TotalLinea+ "' class='sinborde' readOnly size='5'></td>"+
        
        "<td  width='3%' ><center><a href='#' class='eliminar' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td>"+ 
        "<td  width='3%' ><input type='hidden' class='numeroSerie' id='series"+descItem+"' name='IdCodigoItem' value='"+IdReferencia+"' ><center><a href='#' class='.series'  width='5%'><span title='Ingresar números de Series' style='color: #19070B' class='glyphicon glyphicon-barcode'  onclick='pasaCodigoProducto(\""+CodigoBarra+"\","+IdReferencia+","+indiceFila+");setearTablaSeries();' data-toggle='modal' data-target='#series' ></span></a></center></td></tr>";          

    ///document.getElementById('subtotalxs').value=12544;
        SubTotalPrincipal  = parseFloat(SubTotalPrincipal);
        DescuentoPrincipal = parseFloat(DescuentoPrincipal);
        IvaPrincipal       = parseFloat(IvaPrincipal);
   // TotalFactura      = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;
//alert(SubTotalPrincipal);
    document.getElementById('NumeroFilas').value=indiceFila;
    numFilas=tabla.rows.length; 
    //SubTotal=document.getElementById('TotalContrato').value;
    //TotalContrato=parseFloat(TotalContrato)+Valor;
    SubTotalPrincipal= SubTotalPrincipal+TotalBruto;
    DescuentoPrincipal = DescuentoPrincipal+Descuento;
    IvaPrincipal = IvaPrincipal+Iva;
    TotalFactura = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;

    $('#SubTotalPrincipal').val(SubTotalPrincipal.toFixed(2));
    $('#DescuentoPrincipal').val(DescuentoPrincipal.toFixed(2));
    $('#IvaPrincipal').val(IvaPrincipal.toFixed(2));
    $('#TotalFactura').val(TotalFactura.toFixed(2));
    reiniciaElementos();
}

function addFilasFacturaIvaCero()
{  
    var DescripcionProducto = document.getElementById('NombreProducto').value;
    var IdReferencia        = document.getElementById('IdReferencia').value;
    var CodigoBarra         = document.getElementById('Codigo').value;
    var Cantidad            = document.getElementById('Cantidad').value;
    var Precio              = document.getElementById('pvp').value;
    var PrecioFinal         = document.getElementById('PrecioFinal').value;
    var PorcDescuento       = document.getElementById('Descuento').value;
    var CargaIva            = document.getElementById('CargaIva').value;
    var Iva                 = document.getElementById('Iva').value;
    var SubTotalPrincipal   = document.getElementById('SubTotalPrincipal').value;
    var DescuentoPrincipal  = document.getElementById('DescuentoPrincipal').value;
    var IvaPrincipal        = document.getElementById('IvaPrincipal').value;
    var TotalFactura        = document.getElementById('TotalFactura').value;
    var TotalBruto          = 0;
    var Descuento           = 0;
    var TotalLinea          = 0;
    var ValorDescuento      = 0;
    var SubTotal            = 0;
    var descItem    =document.getElementById('NombreProducto').value;
  

    if(IdReferencia==null){
      return;
    }

    if(CargaIva=='S'){
      Iva=0;
    }
    else
    {
      Iva=0;
    }
    
    Cantidad            = parseFloat(Cantidad);
    Precio              = parseFloat(Precio);
    PorcDescuento       = parseFloat(PorcDescuento);
    TotalBruto          = Precio*Cantidad;
    Descuento           = TotalBruto*(PorcDescuento/100);
    Subtotal            = TotalBruto- Descuento;
    Iva                 = Subtotal*(Iva/100);

    TotalLinea          = Subtotal+Iva;
    SubTotal = (Cantidad * Precio)-Descuento;
    var tabla       =   document.getElementById('tabla1');
    var numFilas    =   tabla.rows.length;
    var indiceFila  =   parseInt(document.getElementById('NumeroFilas').value);
    var iconoEliminar = 'glyphicon glyphicon-trash';
//alert('id' + document.getElementById('IdReferencia').value);

///  ********   agrega filas
        indiceFila++;

        //indiceFila = indiceFila+1;
        tabla.insertRow(numFilas).outerHTML=
        "<tr>"+
        "<td width='4%' ><input type='hidden' id='CargaIva"+indiceFila+"' value='"+CargaIva+"'><input type='text' id='IdReferencia" +indiceFila+"' Name='IdReferencia" +indiceFila+"' value='"+IdReferencia +"' class='sinborde'  readOnly size='5'></td>"+
        "<td width='10%'><input type='text' id='CodigoBarra"  +indiceFila+"' Name='CodigoBarra"  +indiceFila+"' value='"+CodigoBarra  +"' class='sinborde'  readOnly size='10'></td>"+
        "<td width='32%'><input type='text' id='DescripcionProducto"+indiceFila+"' Name='DescripcionProducto"+indiceFila+"' value='"+DescripcionProducto+"' class='sinborde'  readOnly='yes' size='35'></td>"+
       "<td width='7%' ><input type='number' class='form-controlxs' id='Cantidad"+indiceFila+"' Name='Cantidad"+indiceFila+"' value='"+Cantidad+"' class='sinborde'  size='6' onkeypress='CalculaTotalLineaNotaVenta("+indiceFila+")' onkeydown='CalculaTotalLineaNotaVenta("+indiceFila+")'   onkeyup='CalculaTotalLineaNotaVenta("+indiceFila+")' onchange='CalculaTotalLineaNotaVenta("+indiceFila+")' onblur='CalculaTotalLineaNotaVenta("+indiceFila+")'></td>"+
       //                                                                                                                                                                     onkeydown="calcularPVP()"   onkeypress="calcularPVP()"
       //onkeyup='CalculaTotalLineaNotaVentaProveedor("+indiceFila+");' onblur='CalculaTotalLineaNotaVentaProveedor("+indiceFila+");' onchange='CalculaTotalLineaNotaVentaProveedor("+indiceFila+");
        "<td width='7%' ><input type='hidden' id='Subtotal"+indiceFila+"' Name='Subtotal"+indiceFila+"' value='"+Subtotal+ "' class='sinborde' readOnly size='5'><input type='hidden' id='Descuento"+indiceFila+"' Name='Descuento"+indiceFila+"' value='"+Descuento+    "' class='sinborde' readOnly size='5'><input type='hidden' id='TotalBruto"+indiceFila+"' Name='TotalBruto"+indiceFila+"' value='"+TotalBruto+    "' class='sinborde' readOnly size='5'><input type='text' id='Precio"+indiceFila+"' Name='Precio"+indiceFila+"' value='"+Precio+"'   size='6' readOnly class='sinborde' >" + // KeyUp='CalculaTotalLineaNotaVenta("+indiceFila+")' onChange='CalculaTotalLineaNotaVenta("+indiceFila+")' onBlur='CalculaTotalLineaNotaVenta("+indiceFila+")'></td>"+
        //"<td width='7%' ><input type='number' id='Precio"+indiceFila+"' Name='Precio"+indiceFila+"' value='"+Precio+"' class='sinborde'  size='6' readOnly='yes'></td>"+
       // "<td width='7%' ><input type='hidden' id='TotalBruto"+indiceFila+"' Name='TotalBruto"+indiceFila+"' value='"+TotalBruto+    "' class='sinborde' readOnly size='5'></td>"+
      //  "<td width='7%' ><input type='hidden' id='Descuento"+indiceFila+"' Name='Descuento"+indiceFila+"' value='"+Descuento+    "' class='sinborde' readOnly size='5'></td>"+
      //  "<td width='7%' ><input type='hidden' id='Subtotal"+indiceFila+"' Name='Subtotal"+indiceFila+"' value='"+Subtotal+ "' class='sinborde' readOnly size='5'></td>"+
        "<td width='7%' ><input type='text' id='Iva"+indiceFila+"' Name='Iva" +indiceFila+"' value='"+Iva+ "' class='sinborde' readOnly size='5'></td>"+
        "<td width='7%' ><input type='number' id='PvpFinal"+indiceFila+"' Name='PvpFinal" +indiceFila+"' value='"+PrecioFinal+ "' size='5'                                    onkeypress='CalculaTotalLineaNotaVenta2("+indiceFila+")' onkeydown='CalculaTotalLineaNotaVenta2("+indiceFila+")'  onkeyup='CalculaTotalLineaNotaVenta2("+indiceFila+")' onchange='CalculaTotalLineaNotaVenta2("+indiceFila+")' onblur='CalculaTotalLineaNotaVenta2("+indiceFila+")'  ></td>"+
        "<td width='7%' ><input type='text' id='TotalLinea"+indiceFila+"' Name='TotalLinea"+indiceFila+"' value='"+TotalLinea+ "' class='sinborde' readOnly size='5'></td>"+
        
        "<td  width='3%' ><center><a href='#' class='eliminar' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td>"+ 
        "<td  width='3%' ><input type='hidden' class='numeroSerie' id='series"+descItem+"' name='IdCodigoItem' value='"+IdReferencia+"' ><center><a href='#' class='.series'  width='5%'><span title='Ingresar números de Series' style='color: #19070B' class='glyphicon glyphicon-barcode'  onclick='pasaCodigoProducto(\""+CodigoBarra+"\","+IdReferencia+","+indiceFila+");setearTablaSeries();' data-toggle='modal' data-target='#series' ></span></a></center></td></tr>";          

    ///document.getElementById('subtotalxs').value=12544;
        SubTotalPrincipal  = parseFloat(SubTotalPrincipal);
        DescuentoPrincipal = parseFloat(DescuentoPrincipal);
        IvaPrincipal       = parseFloat(IvaPrincipal);
   // TotalFactura      = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;
//alert(SubTotalPrincipal);
    document.getElementById('NumeroFilas').value=indiceFila;
    numFilas=tabla.rows.length; 
    //SubTotal=document.getElementById('TotalContrato').value;
    //TotalContrato=parseFloat(TotalContrato)+Valor;
    SubTotalPrincipal= SubTotalPrincipal+TotalBruto;
    DescuentoPrincipal = DescuentoPrincipal+Descuento;
    IvaPrincipal = IvaPrincipal+Iva;
    TotalFactura = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;

    $('#SubTotalPrincipal').val(SubTotalPrincipal.toFixed(2));
    $('#DescuentoPrincipal').val(DescuentoPrincipal.toFixed(2));
    $('#IvaPrincipal').val(IvaPrincipal.toFixed(2));
    $('#TotalFactura').val(TotalFactura.toFixed(2));
    reiniciaElementos();
}

function pasaCodigoProducto(NombreItem,Id,indice)
{
  var tabNumerosSerie = document.getElementById('tablaNumerosSerie');
  var nfilas  = tabNumerosSerie.rows.length;
  var CampoCantidadActualLinea = "Cantidad"+indice;

  var cantidadFinal =0;

  if (nfilas > 1 ) 
  {
    //alert('wfwffew');
    $(tabNumerosSerie).closest('tr').remove();
  }

  cantidadFinal = document.getElementById(CampoCantidadActualLinea).value;
  $('#IdCodigoItem').val(Id+'-'+NombreItem);
  $('#inputNumeroSerie').val(Id);
  $('#cantidadItems').val(cantidadFinal);

}
function pasaCodigoProductoPr(NombreItem,Id,indice)
{
  var tabNumerosSerie = document.getElementById('tablaNumerosSeriePr');
  var nfilas  = tabNumerosSerie.rows.length;
  var CampoCantidadActualLinea = "Cantidad"+indice;

  var cantidadFinal =0;

  if (nfilas > 1 ) 
  {
    //alert('wfwffew');
    $(tabNumerosSerie).closest('tr').remove();
  }


  cantidadFinal = document.getElementById(CampoCantidadActualLinea).value;
  //alert('nombre item '+NombreItem);
  $('#IdCodigoItem').val(Id+'-'+NombreItem);
  $('#inputNumeroSeriePr').val(Id);
  $('#cantidadItems').val(cantidadFinal);

}


function CalculaTotalLinea(i)
{

  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "CargaIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;
  var valor_descuento   = 0;
  var campo_subtotal    = "Subtotal"+i;
  var campo_iva         = "Iva"+i;
  var campo_total       = "TotalLinea"+i;
  var porcentajeActualIva = parseFloat(document.getElementById('ivaActual').value);
  
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = parseFloat(document.getElementById(campo_total_bruto).value);
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var ValorIva          = parseFloat(document.getElementById(campo_iva).value);
  var ValorDescuento    = TotalBruto*(Descuento/100);
  var SubTotal          = TotalBruto-ValorDescuento;
  var Iva               = 0;
  var Total             = 0;


  //Total    = SubTotal+Iva;
  document.getElementById(campo_cantidad).value=Cantidad.toFixed(0);
  document.getElementById(campo_total_bruto).value=(Cantidad*Precio).toFixed(2);
  document.getElementById(campo_descuento).value=ValorDescuento.toFixed(2);
  document.getElementById(campo_subtotal).value=((Cantidad*Precio)-ValorDescuento).toFixed(2);
  SubTotal = parseFloat(document.getElementById(campo_subtotal).value);

  if(CargaIva=="N")
  {
    Iva=0;
  }
  else
  {
    Iva  =   SubTotal *( porcentajeActualIva  /100);
  }

  document.getElementById(campo_iva).value=Iva.toFixed(2);
  document.getElementById(campo_total).value= (SubTotal+Iva).toFixed(2);
  recalculaTotal();
}


function CalculaTotalLineaNotaVenta(i)
{

  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "CargaIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;
  var valor_descuento   = 0;
  var campo_subtotal    = "Subtotal"+i;
  var campo_iva         = "Iva"+i;
  var campo_total       = "TotalLinea"+i;
  var porcentajeActualIva = parseFloat(document.getElementById('ivaActual').value);
  
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = parseFloat(document.getElementById(campo_total_bruto).value);
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var ValorIva          = parseFloat(document.getElementById(campo_iva).value);
  var ValorDescuento    = TotalBruto*(Descuento/100);
  var SubTotal          = TotalBruto-ValorDescuento;
  var Iva               = 0;
  var Total             = 0;


  //Total    = SubTotal+Iva;
  document.getElementById(campo_cantidad).value=Cantidad.toFixed(0);
  document.getElementById(campo_total_bruto).value=(Cantidad*Precio).toFixed(2);
  document.getElementById(campo_descuento).value=ValorDescuento.toFixed(2);
  document.getElementById(campo_subtotal).value=((Cantidad*Precio)-ValorDescuento).toFixed(2);
  SubTotal = parseFloat(document.getElementById(campo_subtotal).value);

  if(CargaIva=="N")
  {
    Iva=0;
  }
  else
  {
    Iva  =   0;
  }

  document.getElementById(campo_iva).value=Iva.toFixed(2);
  document.getElementById(campo_total).value= (SubTotal+Iva).toFixed(2);
  recalculaTotalNotaVenta();
}



function CalculaTotalLineaNV(i)
{

  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "CargaIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;
  var valor_descuento   = 0;
  var campo_subtotal    = "Subtotal"+i;
  var campo_iva         = "Iva"+i;
  var campo_total       = "TotalLinea"+i;
  var porcentajeActualIva = parseFloat(document.getElementById('ivaActual').value);
  
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = parseFloat(document.getElementById(campo_total_bruto).value);
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var ValorIva          = parseFloat(document.getElementById(campo_iva).value);
  var ValorDescuento    = TotalBruto*(Descuento/100);
  var SubTotal          = TotalBruto-ValorDescuento;
  var Iva               = 0;
  var Total             = 0;


  //Total    = SubTotal+Iva;
  document.getElementById(campo_cantidad).value=Cantidad.toFixed(0);
  document.getElementById(campo_total_bruto).value=(Cantidad*Precio).toFixed(2);
  document.getElementById(campo_descuento).value=ValorDescuento.toFixed(2);
  document.getElementById(campo_subtotal).value=((Cantidad*Precio)-ValorDescuento).toFixed(2);
  SubTotal = parseFloat(document.getElementById(campo_subtotal).value);

    Iva  =  0;
  

  document.getElementById(campo_iva).value=Iva.toFixed(2);
  document.getElementById(campo_total).value= (SubTotal+Iva).toFixed(2);
  recalculaTotal();
}





function CalculaTotalLinea2(i)
{


  //alert('calcularpvp');
  var preciofinal = parseFloat(document.getElementById('PvpFinal'+i).value);
  var porciva    = parseFloat(document.getElementById('ivaActual').value);
  var porcentajecompleto = 100 + porciva;
  var preciobase = 0;
  var valorIva = 0;
   // alert('precio final ' + preciofinal + "  " + "iva " + iva);
   //alert('por completo ' + porcentajecompleto);
  preciobase= (preciofinal *100)/ porcentajecompleto;
  //alert(preciobase);
  document.getElementById('Precio'+i).value=preciobase.toFixed(2);
   //alert(preciobase);
  valorIva = preciobase*(100/porciva);
  valorIva = valorIva.toFixed(2);
    


  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "CargaIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;
  var valor_descuento   = 0;
  var campo_subtotal    = "Subtotal"+i;
  var campo_iva         = "Iva"+i;
  var precio_final      = "PvpFinal"+i;
  var campo_total       = "TotalLinea"+i;
  var porcentajeActualIva = parseFloat(document.getElementById('ivaActual').value);
  
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = parseFloat(document.getElementById(campo_total_bruto).value);
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var ValorIva          = parseFloat(document.getElementById(campo_iva).value);
  var ValorDescuento    = TotalBruto*(Descuento/100);
  var SubTotal          = TotalBruto-ValorDescuento;
  var Iva               = 0;
  var Total             = 0;

  //Total    = SubTotal+Iva;
  document.getElementById('Cantidad').value=Cantidad;
  document.getElementById(campo_total_bruto).value=(Cantidad*Precio).toFixed(2);
  document.getElementById(campo_descuento).value=ValorDescuento.toFixed(2);
  document.getElementById(campo_subtotal).value=((Cantidad*Precio)-ValorDescuento).toFixed(2);
  SubTotal = parseFloat(document.getElementById(campo_subtotal).value);
  if(CargaIva=="N")
  {
    Iva=0;
  }
  else
  {
    Iva  =  SubTotal*( porcentajeActualIva  /100);
  }
  document.getElementById(campo_iva).value=Iva.toFixed(2);
  document.getElementById(campo_total).value= (SubTotal+Iva).toFixed(2);
  recalculaTotal();
}


function CalculaTotalLineaNotaVenta2(i)

{


  //alert('calcularpvp');
  var preciofinal = parseFloat(document.getElementById('PvpFinal'+i).value);
  var porciva    = parseFloat(document.getElementById('ivaActual').value);
  var porcentajecompleto = 100 + porciva;
  var preciobase = 0;
  var valorIva = 0;
   // alert('precio final ' + preciofinal + "  " + "iva " + iva);
   //alert('por completo ' + porcentajecompleto);
 // preciobase= (preciofinal *100)/ porcentajecompleto;
  preciobase= preciofinal ;
  //alert(preciobase);
  document.getElementById('Precio'+i).value=preciobase.toFixed(2);
   //alert(preciobase);
  valorIva = preciobase*(100/porciva);
  valorIva = valorIva.toFixed(2);
    


  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "CargaIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;
  var valor_descuento   = 0;
  var campo_subtotal    = "Subtotal"+i;
  var campo_iva         = "Iva"+i;
  var precio_final      = "PvpFinal"+i;
  var campo_total       = "TotalLinea"+i;
  var porcentajeActualIva = parseFloat(document.getElementById('ivaActual').value);
  
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = parseFloat(document.getElementById(campo_total_bruto).value);
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var ValorIva          = parseFloat(document.getElementById(campo_iva).value);
  var ValorDescuento    = TotalBruto*(Descuento/100);
  var SubTotal          = TotalBruto-ValorDescuento;
  var Iva               = 0;
  var Total             = 0;

  //Total    = SubTotal+Iva;
  document.getElementById('Cantidad').value=Cantidad;
  document.getElementById(campo_total_bruto).value=(Cantidad*Precio).toFixed(2);
  document.getElementById(campo_descuento).value=ValorDescuento.toFixed(2);
  document.getElementById(campo_subtotal).value=((Cantidad*Precio)-ValorDescuento).toFixed(2);
  SubTotal = parseFloat(document.getElementById(campo_subtotal).value);
  if(CargaIva=="N")
  {
    Iva=0;
  }
  else
  {
    Iva  =  0;
  }
  document.getElementById(campo_iva).value=Iva.toFixed(2);
  document.getElementById(campo_total).value= (SubTotal+Iva).toFixed(2);
  recalculaTotalNotaVenta();
}




function addFilasFacturaProveedor()
         
{  
    var DescripcionProducto = document.getElementById('NombreProducto').value;
    var IdReferencia        = document.getElementById('IdReferencia').value;
    var CodigoBarra         = document.getElementById('Codigo').value;
    var Cantidad            = document.getElementById('Cantidad').value;
    var Precio              = document.getElementById('Precio').value;
    var PorcDescuento       = document.getElementById('Descuento').value;
    var CargaIva            = document.getElementById('CargaIva').value;
    var Iva                 = document.getElementById('Iva').value;
    var SubTotalPrincipal   = document.getElementById('SubTotalPrincipal').value;
    var DescuentoPrincipal  = document.getElementById('DescuentoPrincipal').value;
    var IvaPrincipal        = document.getElementById('IvaPrincipal').value;
    var TotalFactura        = document.getElementById('TotalFactura').value;
    var TotalBruto          = 0;
    var Descuento           = 0;
    var TotalLinea          = 0;
    var ValorDescuento      = 0;
    var SubTotal            = 0;
    var CostoUnitario       = 0;
    var descItem    =document.getElementById('NombreProducto').value;
    var valorIvaLinea       = 0;
      
    Cantidad            = parseFloat(Cantidad);
    Precio              = parseFloat(Precio);
    if (PorcDescuento==null)
    {
      PorcDescuento=0;
    }
    PorcDescuento       = parseFloat(PorcDescuento);
    TotalBruto          = Precio*Cantidad;
    Descuento           = TotalBruto*(PorcDescuento/100);
    Subtotal            = TotalBruto- Descuento;
   // alert(CargaIva);
    if(CargaIva=='N')
    {
      Iva=0;
    }
    else
    {
      Iva = Subtotal * (Iva/100);
    }

    TotalLinea          = Subtotal+Iva;
    SubTotal = (Cantidad * Precio)-Descuento;
    var tabla       =   document.getElementById('tabla1');
    var numFilas    =   tabla.rows.length;
    var indiceFila  =   parseInt(document.getElementById('NumeroFilas').value);
    var iconoEliminar = 'glyphicon glyphicon-trash';
    //alert('id' + document.getElementById('IdReferencia').value);
    //#---------------  agrega filas factura de proveedor ------------------------
        indiceFila++;
        tabla.insertRow(numFilas).outerHTML=
    "<tr>"+
    "<td width='3%' ><input type='hidden' id='CodigoBarra"  +indiceFila+"' Name='CodigoBarra"  +indiceFila+"' value='"+CodigoBarra  +"'><input id='IdIva"+indiceFila+"' type='hidden'  value='"+CargaIva+"'> <input type='text' id='IdReferencia" +indiceFila+"' Name='IdReferencia" +indiceFila+"' value='"+IdReferencia +"' class='sinborde'  readOnly size='5'></td>"+
    //#####----------------FACTURAS PROVEEDORES -------------------------
    "<td width='32%'><input type='text' id='DescripcionProducto"+indiceFila+"' Name='DescripcionProducto"+indiceFila+"' value='"+DescripcionProducto+"' class='sinborde'  readOnly='yes' size='35'></td>"+
    "<td width='10%' ><input type='number' style='color:#0080FF;padding: 2px;margin: 0px;text-align:right;' class='form-controlxs' id='Cantidad"+indiceFila+"' Name='Cantidad"+indiceFila+"' value='"+Cantidad+"' class='sinborde'  step='0.01'   onkeypress='return pulsar(event);' onkeyup='CalculaTotalLineaProveedor("+indiceFila+");' onkeydown='CalculaTotalLineaProveedor("+indiceFila+");' onblur='CalculaTotalLineaProveedor("+indiceFila+");' onchange='CalculaTotalLineaProveedor("+indiceFila+");'></td>"+
    "<td width='10%' ><input type='number' style='color:#0080FF;padding: 2px;margin: 0px;text-align:right;' class='form-controlxs' id='Precio"    +indiceFila+"' Name='Precio"    +indiceFila+"' value='"+Precio+"' class='sinborde'  step='0.01' onkeypress='return pulsar(event);' onkeyup='CalculaTotalLineaProveedor("+indiceFila+");' onkeydown='CalculaTotalLineaProveedor("+indiceFila+");'  onblur='CalculaTotalLineaProveedor("+indiceFila+");' onchange='CalculaTotalLineaProveedor("+indiceFila+");'></td>"+
    "<td width='3%' ><input type='text' id='TotalBruto"    +indiceFila+"' Name='TotalBruto"    +indiceFila+"' value='"+TotalBruto+    "' onkeypress='return pulsar(event);' class='sinborde' readOnly size='5'></td>"+
    "<td width='3%' ><input type='text' id='Descuento"    +indiceFila+"' Name='Descuento"    +indiceFila+"' value='"+Descuento+    "' onkeypress='return pulsar(event);' class='sinborde' readOnly size='5'></td>"+
    "<td width='3%' ><input type='text' id='Subtotal" +indiceFila+"' Name='Subtotal" +indiceFila+"' value='"+Subtotal+ "' class='sinborde' onkeypress='return pulsar(event);' readOnly size='5'></td>"+
    "<td width='3%' ><input type='text' id='Iva" +indiceFila+"' Name='Iva" +indiceFila+"' value='"+Iva+ "' class='sinborde' readOnly size='5' onkeypress='return pulsar(event);'></td>"+
    "<td width='3%' ><input type='text' id='TotalLinea" +indiceFila+"' Name='TotalLinea" +indiceFila+"' value='"+TotalLinea+ "' onkeypress='return pulsar(event);' class='sinborde' readOnly size='5'></td>"+
    "<td width='3%' ><input type='text' id='CostoUnitario"+indiceFila+"' Name='CostoUnitario"+indiceFila+"' value='"+CostoUnitario+ "' onkeypress='return pulsar(event);' class='sinborde' readOnly size='5'></td>"+
    "<td width='2%' ><center><a href='#' class='eliminar' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td>"+
    "<td width='2%' ><input type='hidden' class='numeroSerie' id='series"+descItem+"' name='IdCodigoItem' value='"+IdReferencia+"' ><center>"+
    "<a href='#' class='.series'  width='5%'><span title='Ingresar números de Serie' style='color: #19070B' class='glyphicon glyphicon-barcode' onclick='pasaCodigoProductoPr(\""+CodigoBarra+"\","+IdReferencia+","+indiceFila+");setearTablaSeries();'  data-toggle='modal' data-target='#seriesProv'  </span></a></center></td></tr>"; 

    ///document.getElementById('subtotalxs').value=12544;
    //####----------------comparacion


//-----------------------------------------------------------------------------
    document.getElementById('NumeroFilas').value=indiceFila;
    SubTotalPrincipal  = parseFloat(SubTotalPrincipal);
    DescuentoPrincipal = parseFloat(DescuentoPrincipal);
    IvaPrincipal       = parseFloat(IvaPrincipal);
    //SubTotal=document.getElementById('TotalContrato').value;
    //TotalContrato=parseFloat(TotalContrato)+Valor;
    SubTotalPrincipal= SubTotalPrincipal+TotalBruto;
    DescuentoPrincipal = DescuentoPrincipal+Descuento;
    IvaPrincipal = IvaPrincipal+Iva;
    TotalFactura = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;
    $('#SubTotalPrincipal').val(SubTotalPrincipal.toFixed(2));
    $('#DescuentoPrincipal').val(DescuentoPrincipal.toFixed(2));
    $('#IvaPrincipal').val(IvaPrincipal.toFixed(2));
    $('#TotalFactura').val(TotalFactura.toFixed(2));
    //alert('numero filas despues de insert '+numFilas);          
    // document.getElementById('NumeroCedula').value='';
    //document.getElementById('NombreBeneficiario').value='';
   //  alert('numero filas : '+numFilas);
    //alert(document.getElementById('l2').value)  
    reiniciaElementos();
}

function CalculaTotalLineaProveedor(i)

{

  var campo_cantidad    = "Cantidad"+i;
  var campo_cargaIva    = "IdIva"+i;
  var campo_precio      = "Precio"+i;
  var campo_iva         = "Iva"+i;
  var campo_total       =  "TotalLinea"+i;

  var campo_total_bruto = "TotalBruto"+i;
  var campo_descuento   = "Descuento"+i;

  var campo_subtotal    = "Subtotal"+i;
  var campo_costoUnitario = "CostoUnitario"+i;


  var Total             = 0;
  var ValorIva          = 0;
  var costoUnitario     = 0;
  var CargaIva          = document.getElementById(campo_cargaIva).value;
  var Cantidad          = parseFloat(document.getElementById(campo_cantidad).value);
  var Precio            = parseFloat(document.getElementById(campo_precio).value);
  var TotalBruto        = Cantidad*Precio;
  var Descuento         = parseFloat(document.getElementById('Descuento').value);
  var valor_descuento   = TotalBruto*(Descuento/100);
  var subtotal          = TotalBruto-Descuento;
  var IvaCorriente      = parseFloat(document.getElementById('ivaActual').value);
  var totalBruto        = 0;

  if (CargaIva=='S')
  {  
     ValorIva = subtotal*(IvaCorriente/100);
  }
  else
  {
       ValorIva=0;
  }

  costoUnitario = subtotal/Cantidad;
  Total = subtotal+ValorIva;

  document.getElementById(campo_total_bruto).value=TotalBruto.toFixed(2);
  document.getElementById(campo_descuento).value=valor_descuento.toFixed(2); 
  document.getElementById(campo_subtotal).value=subtotal.toFixed(2);
  document.getElementById(campo_costoUnitario).value = costoUnitario.toFixed(2);
  document.getElementById(campo_iva).value= ValorIva.toFixed(2);
  document.getElementById(campo_subtotal).value= subtotal.toFixed(2);
  document.getElementById(campo_total).value= Total.toFixed(2);
  recalculaTotal();
}

/**************************************************************\
/    Add Filas Movimientos de Inventarios
****************************************************************/
function addFilasMovimientosInventarios()
{  
    var DescripcionProducto = document.getElementById('NombreProducto').value;
    var IdReferencia        = document.getElementById('IdReferencia').value;
    var CodigoBarra         = document.getElementById('Codigo').value;
    var Cantidad            = document.getElementById('Cantidad').value;
    Cantidad                = parseFloat(Cantidad);
    var tabla               = document.getElementById('tabla1');
    var numFilas            = tabla.rows.length;
    var indiceFila          = parseInt(document.getElementById('NumeroFilas').value);
    var iconoEliminar       = 'glyphicon glyphicon-trash';
    //alert('id' + document.getElementById('IdReferencia').value);
    //#---------------  agrega filas factura de proveedor ------------------------
    indiceFila++;
    tabla.insertRow(numFilas).outerHTML=
    "<tr>"+
    "<td width='3%' ><input type='text' id='IdReferencia" +indiceFila+"' Name='IdReferencia" +indiceFila+"' value='"+IdReferencia +"' class='sinborde'  readOnly size='5'></td>"+
    "<td width='10%'><input type='text' id='CodigoBarra"  +indiceFila+"' Name='CodigoBarra"  +indiceFila+"' value='"+CodigoBarra  +"' class='sinborde'  readOnly size='10'></td>"+
    "<td width='30%'>"+DescripcionProducto+"</td>"+
    "<td width='8%' ><input type='number' class='form-controlxs' id='Cantidad"+indiceFila+"' Name='Cantidad"+indiceFila+"' value='"+Cantidad+"' class='sinborde'  step='0.01' onkeypress='return pulsar(event);' ></td>"+
    "<td width='3%' ><center><a href='#' class='eliminar' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td></tr>";   
    document.getElementById('NumeroFilas').value=indiceFila;
    reiniciaElementoMov();
}



function addFilasNV()
{  
    var DescripcionProducto = document.getElementById('NombreProducto').value;
    var IdReferencia        = document.getElementById('IdReferencia').value;
    var CodigoBarra         = document.getElementById('Codigo').value;
    var Cantidad            = document.getElementById('Cantidad').value;
    var Precio              = document.getElementById('Precio').value;
    var PorcDescuento       = document.getElementById('Descuento').value;
   // var CargaIva            = document.getElementById('CargaIva').value;
  //  var Iva                 = document.getElementById('Iva').value;
    var SubTotalPrincipal   = document.getElementById('SubTotalPrincipal').value;
    var DescuentoPrincipal  = document.getElementById('DescuentoPrincipal').value;
    //var IvaPrincipal        = document.getElementById('IvaPrincipal').value;
    var TotalFactura        = document.getElementById('TotalFactura').value;
    var TotalBruto          = 0;
    var Descuento           = 0;
    var TotalLinea          = 0;
    var ValorDescuento      = 0;
    var SubTotal            = 0;
    //alert('adiciona nv');
    if(IdReferencia==null){
      return;
    }
/*
    if(CargaIva=='S'){
      Iva=parseFloat(Iva);
    }
    else
    {
      Iva=0;
    }
    */
    Cantidad            = parseFloat(Cantidad);
    Precio              = parseFloat(Precio);
    PorcDescuento       = parseFloat(PorcDescuento);
    TotalBruto          = Precio*Cantidad;
    Descuento           = TotalBruto*(PorcDescuento/100);
    Subtotal            = TotalBruto- Descuento;
 //   Iva                 = Subtotal*(Iva/100);
    TotalLinea          = Subtotal; //+Iva;
    SubTotal = (Cantidad * Precio)-Descuento;
    var tabla       =   document.getElementById('tabla1');
    var numFilas    =   tabla.rows.length;
    var indiceFila  =   parseInt(document.getElementById('NumeroFilas').value);
    var iconoEliminar = 'glyphicon glyphicon-trash';
//alert('id' + document.getElementById('IdReferencia').value);

///  ********   agrega filas
        indiceFila++;
        //indiceFila = indiceFila+1;
        tabla.insertRow(numFilas).outerHTML=
        "<tr>"+
        "<td width='5%' ><input type='hidden' id='CargaIva"+indiceFila+"' value='"+CargaIva+"'><input type='text' id='IdReferencia" +indiceFila+"' Name='IdReferencia" +indiceFila+"' value='"+IdReferencia +"' class='sinborde'  readOnly size='5'></td>"+
        "<td width='10%'><input type='text' id='CodigoBarra"  +indiceFila+"' Name='CodigoBarra"  +indiceFila+"' value='"+CodigoBarra  +"' class='sinborde'  readOnly size='10'></td>"+
        "<td width='32%'><input type='text' id='DescripcionProducto"+indiceFila+"' Name='DescripcionProducto"+indiceFila+"' value='"+DescripcionProducto+"' class='sinborde'  readOnly='yes' size='35'></td>"+
        "<td width='6%' ><input type='number' class='form-controlxs' id='Cantidad"+indiceFila+"' Name='Cantidad"+indiceFila+"' value='"+Cantidad+"' class='sinborde'  size='6' onkeypress='CalculaTotalLineaNV("+indiceFila+")' onkeydown='CalculaTotalLineaNV("+indiceFila+")'   onkeyup='CalculaTotalLineaNV("+indiceFila+")' onchange='CalculaTotalLineaNV("+indiceFila+")' onblur='CalculaTotalLineaNV("+indiceFila+")'></td>"+
        

        "<td width='7%' ><input type='number' id='Precio"+indiceFila+"' Name='Precio"+indiceFila+"' value='"+Precio+"' size='6'  onkeypress='CalculaTotalLineaNV("+indiceFila+")' onkeydown='CalculaTotalLineaNV("+indiceFila+")'   onkeyup='CalculaTotalLineaNV("+indiceFila+")' onchange='CalculaTotalLineaNV("+indiceFila+")' onblur='CalculaTotalLineaNV("+indiceFila+")'></td>"+
        "<td width='7%' ><input type='hidden' id='TotalBruto"+indiceFila+"' Name='TotalBruto"+indiceFila+"' value='"+TotalBruto+    "' class='sinborde' readOnly size='5'>"+
                        "<input type='hidden' id='Descuento"+indiceFila+"' Name='Descuento"+indiceFila+"' value='"+Descuento+    "' class='sinborde' readOnly size='5'>"+
                        "<input type='hidden' id='Subtotal"+indiceFila+"' Name='Subtotal"+indiceFila+"' value='"+Subtotal+ "' class='sinborde' readOnly size='5'>"+
                        "<input type='text' id='TotalLinea"+indiceFila+"' Name='TotalLinea"+indiceFila+"' value='"+TotalLinea+ "' class='sinborde' readOnly size='5'></td>"+
        "<td  width='4%' ><center><a href='#' class='eliminar' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td>"+
        "<td  width='3%' ><input type='hidden' class='numeroSerie' id='series"+DescripcionProducto+"' name='IdCodigoItem' value='"+IdReferencia+"' ><center><a href='#' class='.series'  width='5%'><span title='Ingresar números de Series' style='color: #19070B' class='glyphicon glyphicon-barcode'  onclick='pasaCodigoProducto(\""+CodigoBarra+"\","+IdReferencia+","+indiceFila+");setearTablaSeries();' data-toggle='modal' data-target='#series' ></span></a></center></td></tr>";           


    ///document.getElementById('subtotalxs').value=12544;
        SubTotalPrincipal  = parseFloat(SubTotalPrincipal);
        DescuentoPrincipal = parseFloat(DescuentoPrincipal);
      //  IvaPrincipal       = parseFloat(IvaPrincipal);
   // TotalFactura      = (SubTotalPrincipal-DescuentoPrincipal)+IvaPrincipal;
//alert(SubTotalPrincipal);
    document.getElementById('NumeroFilas').value=indiceFila;
    numFilas=tabla.rows.length; 
    SubTotalPrincipal= SubTotalPrincipal+TotalBruto;
    DescuentoPrincipal = DescuentoPrincipal+Descuento;
    //IvaPrincipal = IvaPrincipal+Iva;
    TotalFactura = (SubTotalPrincipal-DescuentoPrincipal);//+IvaPrincipal;

    $('#SubTotalPrincipal').val(SubTotalPrincipal.toFixed(2));
    $('#DescuentoPrincipal').val(DescuentoPrincipal.toFixed(2));
  //  $('#IvaPrincipal').val(IvaPrincipal.toFixed(2));
    $('#TotalFactura').val(TotalFactura.toFixed(2));
    reiniciaElementos();
}


function addsFormaPago()    
{  
    var tabla         =  document.getElementById('tablaFormasPago');
    var numeroFilas   =  tabla.rows.length;
    var indiceFila    =  parseInt(document.getElementById('numeroFilasFormaPago').value);
   
    var Numero        =  document.getElementById('numeroTarjeta').value;
    var IdFormaPago   =  document.getElementById('IdFormaPago').value;
    var IdBanco       =  document.getElementById('IdBanco').value;
    var CodigoTarjeta =  document.getElementById('IdTarjeta').value;

    var ValorTipoFormaPago =  document.getElementById('valorRecibido').value;

    var selFormaPago     = document.getElementById('IdFormaPago');
    var selFormaPagoText = selFormaPago.options[selFormaPago.selectedIndex].text;

    var selBancoPago     = document.getElementById('IdBanco');
    var selBancoText = selBancoPago.options[selBancoPago.selectedIndex].text;


    var selTarjetaPago     = document.getElementById('IdTarjeta');
    var selTarjetaText = selTarjetaPago.options[selTarjetaPago.selectedIndex].text; 

    var iconoEliminar = 'glyphicon glyphicon-trash';
    var numeroFilasFormaPago    =   tabla.rows.length;

    var codigoHtml='';
    
        //#---------------  agrega filas formas de pago ------------------------
        indiceFila++;   
        if(IdFormaPago==1)
        {
          codigoHtml="<tr>"+
              "<td>"+
               "<input type='hidden' id='IdFormaPago"+indiceFila+"' Name='IdFormaPago"+indiceFila+"' value='"+IdFormaPago+"' class='sinborde' readOnly size='5'>"+
                "<input type='hidden' id='IdBanco"+indiceFila+"' Name='IdBanco"+indiceFila+"' value='' class='sinborde' readOnly size='5'>"+
                "<input type='hidden' id='IdTarjeta"+indiceFila+"' Name='IdTarjeta"+indiceFila+"' value='' class='sinborde' readOnly size='5'>"+
                "<input type='hidden' id='numeroTarjeta"+indiceFila+"' Name='numeroTarjeta"+indiceFila+"' value='' class='sinborde' readOnly size='5'>"+  
                  selFormaPagoText+
              "</td>"+             
              "<td>"+
                "<input type='text' id='ValorTipoFormaPago"+indiceFila+"' Name='ValorTipoFormaPago"+indiceFila+"' value='"+ValorTipoFormaPago+"' class='sinborde' readOnly size='5'>"+
              "</td>"+ 
             "<td><center><a href='#' class='eliminarFormaPago' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center></td>"+
             "</tr>";       
        }
        else
        { 
          codigoHtml=
            "<tr>"+
              "<td>"+
                "<input type='hidden' id='IdFormaPago"+indiceFila+"' Name='IdFormaPago"+indiceFila+"' value='"+IdFormaPago+"' class='sinborde' readOnly size='5'>"+
                "<input type='hidden' id='IdBanco"+indiceFila+"' Name='IdBanco"+indiceFila+"' value='"+IdBanco+"' class='sinborde' readOnly size='5'>"+ 
                "<input type='hidden' id='IdTarjeta"+indiceFila+"' Name='IdTarjeta"+indiceFila+"' value='"+CodigoTarjeta+"' class='sinborde' readOnly size='5'>"+
                "<input type='hidden' id='numeroTarjeta"+indiceFila+"' Name='numeroTarjeta"+indiceFila+"' value='"+Numero+"' class='sinborde' readOnly size='5'>"+
                selFormaPagoText+" "+selTarjetaText+" "+selBancoText+
              "</td>"+             
              "<td>"+
                "<input type='text' id='ValorTipoFormaPago"+indiceFila+"' Name='ValorTipoFormaPago"+indiceFila+"' value='"+ValorTipoFormaPago+"' class='sinborde' readOnly size='5'>"+
              "</td>"+   
              "<td>"+
                 "<center><a href='#' class='eliminarFormaPago' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center>"+
              "</td>"+  
          "</tr>";
        }         
        tabla.insertRow(numeroFilas).outerHTML=codigoHtml;
        $('#numeroFilasFormaPago').val(indiceFila);

}
//-----Agrega filas de numeros de serie para la factura de venta------------------
function addSeries()    
{  
    var tablaSeries   =  document.getElementById('tablaNumerosSerie');
    var numeroFilas   =  tablaSeries.rows.length;
    var indiceFila    =  parseInt(document.getElementById('numerosFilasSeries').value);
  //  var CodigoProducto = document.getElementById('IdCodigoItem');  
    var NumeroSerie   =  document.getElementById('numeroSerie').value;
    var iconoEliminar = 'glyphicon glyphicon-trash';
    var codigoHtml='';
    var nfilasTabla = tablaSeries.rows.length-1;   
    if (nfilasTabla >= $('#cantidadItems').val())
    {
      alert('No puede ingresar más números de serie');
      return;
    }
        //#---------------  agrega filas formas de pago ------------------------
        indiceFila++;   
          codigoHtml=
            "<tr>"+
              "<td>"+
                "<input type='text' id='IdNumeroSerie_"+indiceFila+"' Name='IdNumeroSerie_"+indiceFila+"' value='"+NumeroSerie+"' class='sinborde' readOnly size='20'>"+
              "</td>"+   
              "<td>"+
                 "<center><a href='#' class='eliminarSeries' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center>"+
              "</td>"+  
          "</tr>";
                
        tablaSeries.insertRow(numeroFilas).outerHTML=codigoHtml;
        $('#numerosFilasSeries').val(indiceFila);
}

//-----Agrega filas de numeros de serie para la factura de proveedor------------------
function addSeriesPr()    
{  
    var tablaSeries   =  document.getElementById('tablaNumerosSeriePr');
    var numeroFilas   =  tablaSeries.rows.length;
    var indiceFila    =  parseInt(document.getElementById('numerosFilasSeriesPr').value);
  //  var CodigoProducto = document.getElementById('IdCodigoItem');
    var NumeroSerie   =  document.getElementById('numeroSerie').value;
    var iconoEliminar = 'glyphicon glyphicon-trash';
    var codigoHtml='';
    var nfilasTabla = tablaSeries.rows.length-1;
    if (nfilasTabla >= $('#cantidadItems').val())
    {
      alert('No puede ingresar más números de serie');
      return;
    }
        //#---------------  agrega filas formas de pago ------------------------
        indiceFila++;   

          codigoHtml=
            "<tr>"+
              "<td>"+
                "<input type='text' id='IdNumeroSerie_"+indiceFila+"' Name='IdNumeroSerie_"+indiceFila+"' value='"+NumeroSerie+"' class='sinborde' readOnly size='20'>"+
              "</td>"+   
              "<td>"+
                 "<center><a href='#' class='eliminarSeriesPr' width='5%'><span style='color: #FF0040' class='glyphicon glyphicon-trash'></span></a></center>"+
              "</td>"+  
          "</tr>";
                
        tablaSeries.insertRow(numeroFilas).outerHTML=codigoHtml;
        $('#numerosFilasSeriesPr').val(indiceFila);
        //alert('indice fila'+indiceFila);

}

//-------------Fin Números de serie-------------
function activaElementos(){
   if($('#IdFormaPago').val()==1)
   {
      $('#IdTarjeta').prop('disabled',true);
      $('#numeroTarjeta').prop('disabled',true);
      $('#IdBanco').prop('disabled',true);
   }
   else
   {
      $('#IdTarjeta').prop('disabled',false);
      $('#numeroTarjeta').prop('disabled',false);
      $('#IdBanco').prop('disabled',false);
   } 
}

function calculaSaldos()
{
   //var valorTotalaPagar = parseFloat($('#ValorPagar').val());
   var pagoAnterior;
   if($('#saldoPendiente').val().length<1)
   {
      $('#saldoPendiente').val('0');
   }
   var saldoAnterior = parseFloat($('#saldoPendiente').val());  // -parseFloat($('#valorRecibido').val()) ;

   if(saldoAnterior>0)
    { var pagoAnterior = parseFloat($('#ValorPagar').val())-saldoAnterior; }
   else { pagoAnterior=0;}

   var saldoActual = (parseFloat($('#ValorPagar').val()) -pagoAnterior)-parseFloat($('#valorRecibido').val());

   $('#saldoPendiente').val(saldoActual.toFixed(2));
   
}



function bloquearEnter(event)
{
     var tecla= event.which|| event.keyCode;
     if (tecla==13){
          alert('enter');
            document.getElementById('numeroSerie').focus();
          }
}

    function reiniciaElementoMov()
    {
      document.getElementById('IdReferencia').value   = null;
      document.getElementById('Codigo').value         = null;
      document.getElementById('NombreProducto').value = null;
    }


    function reiniciaElementos()
    {
      document.getElementById('IdReferencia').value   = null;
      document.getElementById('Codigo').value         = null;
      document.getElementById('NombreProducto').value = null;
      document.getElementById('pvp').value         = null;
      document.getElementById('CargaIva').value       = null;
      document.getElementById('Iva').value            = null;
      document.getElementById('PrecioFinal').value            = null;
    }




function meses(mesActual){
        //var mes1,mes2,mes3,mes4,mes5,mes6,mes7,mes8,mes9,mes10,mes11,mes12;
        if(mesActual==1){
            meses="'Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero'";
        }
        if(mesActual==2){
            meses="'Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero'";
        }
        if(mesActual==3){
            meses="'Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo'";
        }   
        if(mesActual==4){
            meses="'Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril'";
        }       
        if(mesActual==4){
            meses="'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo'";
        }
        if(mesActual==5){
            meses="'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo'";
        }   
        if(mesActual==6){
            meses="'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio'";
        }
        if(mesActual==7){
            meses="'Agosto','Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio'";
        }   
        if(mesActual==8){
            meses="'Septiembre','Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto'";
        }   
        if(mesActual==9){
            meses="'Octubre','Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre'";
        }           
        if(mesActual==10){
            meses="'Noviembre','Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre'";
        }                       
        if(mesActual==11){
            meses="'Diciembre','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre'";
        }
        if(mesActual==12){
            meses="'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'";
        }     
        return meses;     
}

 function verificaNumeroContrato(){
      
      //alert('verificaContrato');
      if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= verificaContrato;
      xhr.open('POST','verificaContrato.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("IdContratoFisico="+document.getElementById('NumeroContratoFisico').value);
      function verificaContrato(){
        if(xhr.readyState==4 && xhr.status==200){
          respuesta=this.responseText;
          //alert(respuesta);
          if(respuesta=='S'){ 
                alert('Número de contrato ya existe');
                document.formulario.NumeroContratoFisico.focus();
          }
          
        }
       }
   }


 function VerificaDatosVendedor(){
      var Rsspuesta;
       if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= verificaDatos;
      xhr.open('POST','verificaDatosVendedor.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("NumeroDocumento="+document.getElementById('NumeroDocumento').value);
      function verificaDatos(){
          if(xhr.readyState==4 && xhr.status==200){
              respuesta=this.responseText;

              
                  if(respuesta==''){ 
                    
                  }
                  else{
                    alert('Vendedor : '+respuesta+' Ya se encuentra registrado');
                    document.Formulario.NumeroDocumento.focus();
                  }
        }
       }
   }

 function VerificarDatosUsuario(){
      var Respuesta;
       if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= verificaDatosUsuario;
      xhr.open('POST','verificaDatosUsuario.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("Usuario="+document.getElementById('Usuario').value);
      function verificaDatosUsuario(){
          if(xhr.readyState==4 && xhr.status==200){
              respuesta=this.responseText;          
                  if(respuesta==''){ 
                    
                  }
                  else{
                    alert('Usuario : '+respuesta+' Ya se encuentra registrado');
                    document.Formulario.Usuario.focus();
                    document.Formulario.Usuario.select();
                  }
        }
       }

   }

 function VerificarAlumno(){
      var Respuesta;
       if(window.XMLHttpRequest){
          xhr= new XMLHttpRequest();
      }
      else if(window.ActiveXObject){
           xhr=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xhr.onreadystatechange= verificaAlumno;
      xhr.open('POST','verificaEstudiante.php',true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("Alumno="+document.getElementById('Cedula').value);
      function verificaAlumno(){
          if(xhr.readyState==4 && xhr.status==200){
              respuesta=this.responseText;          
                  if(respuesta==''){ 
                    
                  }
                  else{
                    alert('Alumno : '+respuesta+' Ya se encuentra registrado con esa cédula');
                    document.Formulario.Usuario.focus();
                    document.Formulario.Usuario.select();
                  }
        }
       }

   }

function datos_clientes(id,cedula,Nombres,Telefono,Email,Direccion){

    opener.document.formulario.IdCliente.value= id;
    opener.document.formulario.Cedula.value = cedula;
    opener.document.formulario.NombreCliente.value = Nombres;
    opener.document.formulario.Telefono.value = Telefono;
    opener.document.formulario.Email.value = Email;
    opener.document.formulario.Direccion.value= Direccion;
    window.close();
    
}

function datos_referencia(id,codigoBarra,Descripcion,Precio,cargaIva){
    opener.document.formulario.Codigo.value=codigoBarra;
    opener.document.formulario.IdReferencia.value=id;
    opener.document.formulario.NombreProducto.value=Descripcion;
    opener.document.formulario.Precio.value = Precio;
    opener.document.formulario.CargaIva.value = cargaIva;
    window.close();   
}


function datos_referencia_inv(id,codigoBarra,Descripcion){
    opener.document.formulario.Codigo.value=codigoBarra;
    opener.document.formulario.IdReferencia.value=id;
    opener.document.formulario.NombreProducto.value=Descripcion;
    window.close();   
}

function datos_proveedor(id,cedula,Nombres,Telefono,Email,Direccion){
    opener.document.formulario.IdProveedor.value= id;
    opener.document.formulario.RucProveedor.value= cedula;
    opener.document.formulario.NombreProveedor.value = Nombres;
    window.close();
}

function datos_estudiantes(id,cedula,Nombres){
    opener.document.formulario.IdEstudiante.value = id;
    opener.document.formulario.CedulaEstudiante.value = cedula;
    opener.document.formulario.NombresEstudiante.value = Nombres;
    window.close();
}


function Resaltar_On(GridView)
{

     if(GridView != null)
    {
        GridView.originalBgColor = GridView.style.backgroundColor;
        GridView.style.backgroundColor='#F2F5A9';
        GridView.style.cursor = 'hand'; 
    }
}

function Resaltar_Off(GridView){
  
    if(GridView != null)
    {
        GridView.style.backgroundColor = GridView.originalBgColor;
    }
}

function Close() 
{
    window.close();
}


function popup(opcion)
{ 

    //mi_mensaje("");
    switch(opcion)
    {
        case "cliente":
        {
            miPopup = window.open("popup_cliente.php?programa="+opcion+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
            break;
        }
        case "producto":
        {
            miPopup = window.open("popup_buscar_producto.php?Id="+opcion+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
            break;          
        }
        case "proveedor":
        {
            miPopup = window.open("popup_proveedor.php?Id="+opcion+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
            break;          
        }        
        case "producto_inv":
        {
          alert('aca');
            miPopup = window.open("popup_buscar_producto_inv.php?Id="+opcion+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
            break;          
        }           
        default:
        break;
    }

}

function popup_estudiante(idRepresentante)
{ alert(idRepresentante);
            miPopup = window.open("popup_estudiante.php?IdRepresentante="+idRepresentante+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
}

function popup_detalle(id)
{
            miPopup = window.open("popup_producto.php?IdReferencia="+id+" ","formulario","top=250, left=250, width=750, height=300");
            miPopup.focus();
}

function popup_detalle_factura(id)
{
          miPopup = window.open("popup_detalle_factura.php?IdMov="+id+" ","formulario","top=250, left=250, width=1000, height=800");
          miPopup.focus();
}
function popup_detalle_factura_proveedor(id)
{
          miPopup = window.open("popup_detalle_factura_proveedor.php?IdMov="+id+" ","formulario","top=250, left=250, width=1000, height=800");
          miPopup.focus();
}
/*
function inicio(programa)
{
    mi_mensaje("");
    switch (programa)
    {
        case 'ingreso_notas':
        {
            document.getElementById('asistencia1').focus();
            break;
        }

        case 'nuevo_profesor':
        {
            document.getElementById('f_cedula').readOnly        = true; 
            document.getElementById('f_apellidos').readOnly     = true; 
            document.getElementById('f_nombres').readOnly       = true; 
            document.getElementById('f_direccion').readOnly     = true; 
            document.getElementById('f_mail').readOnly          = true; 
            document.getElementById('f_sexo').disabled          = true; 
            document.getElementById('f_estado').disabled        = true; 
            document.getElementById('f_fecnac').disabled        = true; 
            document.getElementById('f_fecing').disabled        = true; 
            document.getElementById('f_convencional').readOnly  = true; 
            document.getElementById('f_movil').readOnly         = true;     
            document.getElementById('btn_grabar').disabled      = true;
            document.getElementById('f_codigo').readOnly        = false; 
            document.getElementById('f_codigo').focus();
            break;
        }
        
        case 'nuevo_carrera':
        {
            document.getElementById('f_descripcion').readOnly   = true; 
            document.getElementById('f_niveles').readOnly       = true; 
            document.getElementById('f_estado').disabled        = true; 
            document.getElementById('f_coordinador').disabled   = true; 
            document.getElementById('btn_grabar').disabled      = true;
            document.getElementById('f_codigo').readOnly        = false; 
            document.getElementById('f_codigo').focus();
            break;
        }

        case 'nuevo_ciclo':
        {
            document.getElementById('f_codigociclo').focus();
            break;
        }

        case 'nuevo_etnia':
        {
            document.getElementById('f_descripcion').focus();
            break;
        }

        case 'historial_estudiante':
        {
            document.getElementById('f_cedula').focus();
            break;
        }

        case 'historial_docente':
        {
            document.getElementById('f_cedula').focus();
            break;
        }

        case 'asignacion_curso_docente':
        {
            document.getElementById('f_carrera').focus();
            break;
        }

        case 'nuevo_jornada':
        {
            document.getElementById('f_descripcion').focus();
            break;
        }

        default:
        {
            alert('Error !!! En funcion inicio pero no me llego parametro '+programa);
            break;
        }
    }
    return;
}   

*/
function si_existe(tabla, campo, codigo)
{
    if (window.XMLHttpRequest) {
        xmlhttp3 = new XMLHttpRequest();
    }
    else{
        xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp3.onreadystatechange=function(){
        if(xmlhttp3.readyState==4 && xmlhttp3.status==200){
            respuesta=xmlhttp3.responseText;
            respuesta = respuesta.split("_;_");
            if (respuesta[0]=='' || respuesta[0]==' ')
            {   
                // No existe    
                switch(tabla)
                {
                    case 'carreras':
                    {
                        document.getElementById('f_codigo').readOnly = true;
                        document.getElementById('f_descripcion').readOnly = false;
                        document.getElementById('f_niveles').readOnly = false;
                        document.getElementById('f_estado').disabled = false;
                        document.getElementById('f_coordinador').disabled = false;
                        document.getElementById('btn_grabar').disabled = false;
                        document.getElementById('f_descripcion').focus();
                        return true;
                    }
                    case 'profesores':
                    {
                        document.getElementById('f_codigo').readOnly = true;
                        document.getElementById('f_cedula').readOnly = false;
                        document.getElementById('f_apellidos').readOnly = false;
                        document.getElementById('f_nombres').readOnly = false;
                        document.getElementById('f_apellidos').readOnly = false;
                        document.getElementById('f_direccion').readOnly = false;
                        document.getElementById('f_mail').readOnly = false;
                        document.getElementById('f_sexo').disabled = false;
                        document.getElementById('f_estado').disabled = false;
                        document.getElementById('f_fecnac').disabled = false;
                        document.getElementById('f_fecing').disabled = false;
                        document.getElementById('f_convencional').readOnly = false;
                        document.getElementById('f_movil').readOnly = false;
                        document.getElementById('btn_grabar').disabled = false;
                        document.getElementById('f_cedula').focus();
                        return true;
                    }
                }
            }
            else
            {
                // Si existe
                switch(tabla)
                {
                    case 'carreras':
                    {
                        mi_mensaje("Codigo ya existe");
                        document.getElementById('f_codigo').focus();
                        return false;
                    }
                    case 'profesores':
                    {
                        mi_mensaje("Codigo ya existe");
                        document.getElementById('f_codigo').focus();
                        return false;
                    }
                }
            }
        }
    }
    xmlhttp3.open("GET","../php/get_general.php?tabla="+tabla+"&campo="+campo+"&codigo="+codigo,true);
    xmlhttp3.send();
}





function valida(opcion)
{
/* En esta funcion se hacen las validaciones ANTES de GRABAR */
    mi_mensaje("");
    switch(opcion)
    {
        case 'excel':
        {
            if (document.getElementById("x_file").value=='' || document.getElementById("x_file").value==' ')
            {
                //mi_mensaje('Debe Seleccionar Archivo ');
                alert('Debe Seleccionar Archivo ');
                document.getElementById('x_file').focus();
            }
            else
            {
                //var archivo = $("#file").val();
                var archivo = document.getElementById("x_file").value;
                var extensiones = archivo.substring(archivo.lastIndexOf("."));
                if(extensiones != ".xls" && extensiones != ".xlsx" && extensiones != ".csv")
                {
                    alert("El archivo de tipo " + extensiones + " no es válido");
                    document.getElementById('x_file').focus();
                }
            }
            return true;
            break;
        }

        case 'nuevo_profesor':
        {
            if (document.getElementById("f_codigo").value=='' || document.getElementById("f_codigo").value==' ')
            {
                mi_mensaje('Debe ingresar Codigo ');
                document.getElementById('f_codigo').focus();
            }
            else
            {
                if(document.getElementById("btn_grabar").disabled==true)
                {
                    si_existe("profesores", "CodUsuario", document.getElementById("f_codigo").value);
                    document.getElementById('f_codigo').focus();
                }
            }   
            return true;
        }

        case 'nuevo_carrera':
        {
            if (document.getElementById("f_codigo").value=='' || document.getElementById("f_codigo").value==' ')
            {
                mi_mensaje('Debe ingresar Codigo ');
                document.getElementById('f_codigo').focus();
                return false
            }
            else
            {
                if(document.getElementById("btn_grabar").disabled==true)
                {
                    si_existe("carreras", "CodigoCarrera", document.getElementById("f_codigo").value);
                }
                
            }
            return true;
        }

        case 'nuevo_jornada':
        {
            if (document.getElementById("f_descripcion").value=='' || document.getElementById("f_descripcion").value==' ')
            {
                mi_mensaje("Ingrese Descripcion");
                document.getElementById('f_descripcion').focus();
                break;
            }
            return true;
        }   

        case 'nuevo_etnia':
        {
            if (document.getElementById("f_descripcion").value=='' || document.getElementById("f_descripcion").value==' ')
            {
                mi_mensaje("Ingrese Descripcion");
                document.getElementById('f_descripcion').focus();
                break;
            }
            return true;
        }

        case 'nuevo_ciclo':
        {
            if (document.getElementById("f_codigociclo").value=='' || document.getElementById("f_codigociclo").value==' ')
            {
                mi_mensaje("Ingrese Codigo de Ciclo");
                document.getElementById('f_codigociclo').focus();
                break;
            }
            if (document.getElementById("f_aniociclo").value=='' || document.getElementById("f_aniociclo").value==' ')
            {
                mi_mensaje("Ingrese Año de Ciclo");
                document.getElementById('f_aniociclo').focus();
                break;
            }
            return true;
        }

        default:
            return false;
            break;
    }
}

function set_cookie(nombre, valor)
{
    //document.cookie = "cookie_id_program="+valor;
    document.cookie = nombre+"="+valor;
}




function mi_mensaje(msg)
{
    document.getElementById("mi_mensaje").innerHTML=msg;
    //$("#titulo").text('Texto de sustitución');
    //setTimeout('',50000);
}


function soloLetras(e)
{
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toUpperCase();
    letras = ' ABCDEFGHIJKLMNOPQRSTUVWXYZÑ';
    especiales = '8-37-39-46';
    tecla_especial = false
    for(var i in especiales)
    {
        if(key == especiales[i])
        {
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
    {
        return false;
    }
}

function soloNumeros(e)
{
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
}



function x_valida(i, campo, MaxValor)
{   
    var x_min = 0;
    
    if (document.getElementById(campo).value == ""   || document.getElementById(campo).value == " " )
    {
        document.getElementById(campo).value = 0;
    }
    if (document.getElementById(campo).value < x_min || document.getElementById(campo).value > MaxValor )
    {
        alertify.error('Ingrese un valor entre '+x_min+" y "+MaxValor);
        document.getElementById(campo).focus();
    }
    document.getElementById(campo).value = roundNumber(document.getElementById(campo).value,2);
    calcula_promedio(i);
}

function roundNumber(number, decimals) { // Arguments: number to round, number of decimal places
    var n = parseFloat(number);
    n = n.toFixed(decimals);
    return n; 
}





function calcula_promedio(i)
{
    var campo       = "promedio"+i;
    var g_formativa = "g_formativa"+i;
    var g_practica  = "g_practica"+i;
    var g_examen    = "g_examen"+i;

    document.getElementById(campo).value  = roundNumber( (parseFloat(document.getElementById(g_formativa).value) + 
                                                          parseFloat(document.getElementById(g_practica).value)  + 
                                                          parseFloat(document.getElementById(g_examen).value)     ), 2)  ;
    //style="color:#FF0000";
    //var d = document.getElementById(campo); 
    //d.setAttribute("align", "center");
    /*
    var num = parseFloat(document.getElementById(campo).value) ;
    if (num < 5)
    {
        alert("aqui");
        campo = "document.f_notas.promedio".$i."style.color";
        //document.f_notas.promedio1.style.color='red' ;    
        campo = "red";
    }
    */
}


function validateDecimal(valor) {
    var RE = /^d*.?d*$/;
    if (RE.test(valor)) {
        mi_mensaje("Ok");
        return true;
    } else {
        mi_mensaje("Error");
        return false;
    }
}


function valida_cedula(x_Cedula)
{
    mi_mensaje("");
    var cedula = x_Cedula;
    //alert(cedula);
    var xflag=1;
    //Preguntamos si la cedula consta de 10 digitos
    if(cedula.length == 10)
    {        
        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0,2);
        //Pregunto si la region existe ecuador se divide en 24 regiones
        if( digito_region >= 1 && digito_region <=24 )
        {
            // Extraigo el ultimo digito
            var ultimo_digito   = cedula.substring(9,10);
            //Agrupo todos los pares y los sumo
            var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));
            //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
            var numero1 = cedula.substring(0,1);
            var numero1 = (numero1 * 2);
            if( numero1 > 9 ){ var numero1 = (numero1 - 9); }
            var numero3 = cedula.substring(2,3);
            var numero3 = (numero3 * 2);
            if( numero3 > 9 ){ var numero3 = (numero3 - 9); }
            var numero5 = cedula.substring(4,5);
            var numero5 = (numero5 * 2);
            if( numero5 > 9 ){ var numero5 = (numero5 - 9); }
            var numero7 = cedula.substring(6,7);
            var numero7 = (numero7 * 2);
            if( numero7 > 9 ){ var numero7 = (numero7 - 9); }
            var numero9 = cedula.substring(8,9);
            var numero9 = (numero9 * 2);
            if( numero9 > 9 ){ var numero9 = (numero9 - 9); }
            var impares = numero1 + numero3 + numero5 + numero7 + numero9;
            //Suma total
            var suma_total = (pares + impares);
            //extraemos el primero digito
            var primer_digito_suma = String(suma_total).substring(0,1);
            //Obtenemos la decena inmediata
            var decena = (parseInt(primer_digito_suma) + 1)  * 10;
            //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
            var digito_validador = decena - suma_total;
            //Si el digito validador es = a 10 toma el valor de 0
            if(digito_validador == 10)
                var digito_validador = 0;
            //Validamos que el digito validador sea igual al de la cedula
            if(digito_validador == ultimo_digito)
            {
                xflag = 0;
            }
            else
            {
                alertify.error('Cédula Incorrecta');
                xflag = 1;
            }         
        }
        else
        {
            alertify.error('Cédula no pertenece a ninguna region');
            xflag = 1;
        }
    }
   /* else
    {
        alertify.error('Cédula debe tener 10 digitos');
        xflag = 1;
    }    */
    if (xflag==1)
    {
        document.getElementById('Cedula').focus();
        return false;
    }
    return true;
    /*{
        if(x_evento=="nuevo")
        {
            getcedula(x_tabla);
        }
        return true;
    }*/
}

function alerta(texto_alerta){
    //alertify.alert('Alert Title', texto_alerta, function(){ alertify.success('Ok'); });
    alertify.success('Ok');
}


function confirmar(texto_de_confirmacion)
{
    var x_flag = false;
    alertify.confirm("<b>"+texto_de_confirmacion+"</b>", 
    function (e) 
    {
        if (e) 
        {
            x_flag = true; //alertify.success("Has pulsado '" + alertify.labels.ok + "'"); 
        } 
        else 
        { 
            x_flag = false; //alertify.error("Has pulsado '" + alertify.labels.cancel + "'");
        }
    }); 
    alert(x_flag); return x_flag;
}

/////////////////////////////////////////////

function carga_cursos(x_curso)
{
    //$('#f_curso').append("<option value='1'> opcion 1</option>");
    //var x_curso = document.getElementById('f_curso').value;

    $('#f_curso').empty();
    $.getJSON('datos.php',{Accion:'GetCursos',IdCarrera:$('#f_carrera option:selected').val() }, function(Datos)
    {
    for(x=0;x<Datos.length;x++)
    {           
        var x_selected = "";
        if(x_curso==Datos[x].idCurso)
        {
            x_selected = "selected";
        }
        $('#f_curso').append("<option value='"+Datos[x].idCurso+"' "+x_selected+" >"+Datos[x].IdNivel+" "+Datos[x].IdParalelo+"</option>");
    }
    })
}


function getcedula(tabla)
{
    var codigo = document.getElementById('f_cedula').value;
    if(tabla=="profesores")
    {
        var campo = "Cedula";
    }
    else
    {
        var campo = "AlumnoCedula";
    }

    if (window.XMLHttpRequest) {
        xmlhttp3 = new XMLHttpRequest();
    }
    else{
        xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp3.onreadystatechange=function(){
        if(xmlhttp3.readyState==4 && xmlhttp3.status==200){
            respuesta=xmlhttp3.responseText;
            respuesta = respuesta.split("_;_");
            if (respuesta[0]=='' || respuesta[0]==' ')
            {               
                mi_mensaje('');
            }
            else
            {
                alertify.error('Cedula ya está registrada en '+tabla);
                document.getElementById('f_cedula').focus();
            }
        }
    }
    xmlhttp3.open("GET","../php/get_general.php?tabla="+tabla+"&campo="+campo+"&codigo="+codigo,true);
    xmlhttp3.send();
}