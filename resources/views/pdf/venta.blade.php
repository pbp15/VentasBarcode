<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
            position: relative;
            width: 50%;
            height: 30px;
            margin: 0 auto;
            padding: 10px 10px;
        font-family: ‘Bookman Old Style’, serif;
        font-size: 12px;
        }
      
        #datos{
        display:flex;
        justify-content: center;
        align-items:center;
        }

        #encabezado{
        text-align: center;
        }

        #seccion_tabla{
            border: 2px solid red;
            display:flex;
            justify-content: center;
            align-items:center;
            text-align: center;
        }


      
      
    
        #facliente{
        width:60%;
        /* border-collapse: collapse; */
        margin: 0 auto;
        border-spacing: 0;
        margin-bottom: 5px;
        }
        #cliente{
        text-align: center;
        font-size: 10px;
        }

        #fac,  #fa{
        color: black;
        font-size: 12px;
        text-align: center;
        }
        #fa-datos{
            text-align: center; 
        }

        #facliente thead{
        padding: 20px;
        background: white;
        text-align: center;
        color: black;
        }
         #facarticulo{
        width: 60%;
        margin: 0 auto;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 5px;
        }

        #facarticulo thead{
        padding: 20px;
        text-align: center;
        background : white;
        }

        #gracias{
        text-align: center; 


        }
    </style>
    <body>
        @foreach ($venta as $v)
        <header>
          
            <div id="datos">
                <p id="encabezado">
                    <b>CENTRO COMERCIAL "P&Y"</b><br>CALLE GIRALDEZ Nº 487 <br>TARMA-TARMA-JUNIN 
                    <br>TELEFONO : 987456123  <br> R.U.C : 102596786
                     <br>TICKET DE VENTA   <br>
                     <br> FECHA DE EMISION : {{$v->created_at}} 
                     <br> Nº COMPROBANTE : CMT0000{{$v->id}} 
                     <br> CLIENTE: Sr(a). {{$v->nombre}} 
                     <br> VENDEDOR : {{$v->usuario}} 
                </p> 
            </div>  
       
        </header>    
      

        @endforeach
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>Cant</th>
                            <th>Descrp</th>
                            <th>Prec.Unit</th>
                            <th>Prec.Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr id="fa-datos">
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->articulo}}</td>
                            <td>{{$det->precio}}</td>
                            <td>{{$det->cantidad*$det->precio-$det->descuento}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @foreach ($venta as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Subtotal</th>
                            <td>s/. {{round($v->total-($v->total*$v->impuesto),2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Impuesto</th>
                            <td>s/. {{round($v->total*$v->impuesto,2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <td>s/. {{$v->total}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>




            </div>
        </section>   

        <footer>
            <div id="gracias">
                <p>TODO CAMBIO SERA DENTRO <br>
                DEL DIA CON COMPROBANTE DE PAGO <br>
                REPRESENTACION IMPRESA DE LA <br>
                BOLETA DE VENTA ELECTRONICA <br>
                ESTE DOCUMENTO PUEDE SER VALIDADO<br>
                EN www.efacturando.com/emisiones<br>
                </p>

            </div>
        </footer>
    </body>
</html>

