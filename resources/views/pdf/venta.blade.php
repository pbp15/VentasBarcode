<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de venta</title>
    <style>
        body {
            position: relative;
            width: 40%;
            height: 30px;
            margin: 0 ;
            padding: 10px 10px;
            font-family: ‘Bookman Old Style’, serif;
            font-size: 14px;
        }
      
        #datos{
       
        display:flex;
        justify-content: center;
        align-items:center;
        }

        #encabezado{
        text-align: center;
        font-size: 13px;
        }

        #encabezado b {
        font-size: 15px;
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
        font-size: 14px;
        }

        #fac,  #fa{
        color: black;
        font-size: 14px;
        text-align: center;
        }
        #fa-datos{
            text-align: center; 
            font-size: 14px;
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
        #total {
        text-align: center;
        }
        #total1 {
            border : 1px solid black;
        text-align: center;
        }
    </style>
    <body>
        @foreach ($venta as $v)
        <header>
          
            <div id="datos">
                <p id="encabezado">
                    <b>Inversiones "Roque" S.R.L</b><br>CALLE GIRALDEZ Nº 487-TARMA<br>
                     TELEFONO : 987456123  <br> R.U.C : 102596786
                     <br>TICKET DE VENTA   <br>
                     <br> FECHA DE EMISION : {{$v->fecha_hora }}
                     <br> Nº COMPROBANTE : 0000{{$v->id}} 
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
                            <td id="total" >s/. {{round($v->total-($v->total*$v->impuesto),2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Impuesto</th>
                            <td id="total">s/. {{round($v->total*$v->impuesto,2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <td id="total1" >s/. {{$v->total}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
                </table>




            </div>
        </section>   

        <footer>
            <div id="gracias">
                <p>Gracias!!! <br>

            </div>
        </footer>
    </body>
</html>

