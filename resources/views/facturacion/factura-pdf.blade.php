<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura Bepensa</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        padding: 20px;
        background: white;
    }

    .factura-container {
        width: 1250px;
        /* Adjusted to fit all content */
        margin: 0 auto;
        border: 1px solid #ccc;
        padding: 20px;
        position: relative;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        width: 100%;
    }

    .header .logo {
        width: 180px;
    }

    .empresa-info {
        font-size: 14px;
        width: calc(100% - 200px);
    }

    .empresa-info div {
        margin-bottom: 5px;
    }

    .regimen-info {
        margin-top: 10px;
        font-size: 12px;
        width: 100%;
    }

    .seccion {
        border: 1px solid black;
        padding: 10px;
        margin-top: 10px;
        width: 98.3%;
    }

    .seccion-header {
        background: #ddd;
        font-weight: bold;
        padding: 5px;
        margin-bottom: 8px;
        width: 100%;
    }

    .bold {
        font-weight: bold;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        table-layout: fixed;
    }

    .tabla td,
    .tabla th {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
        word-wrap: break-word;
    }

    .tabla th {
        background: #f1f1f1;
    }

    .right {
        text-align: right;
    }

    .center {
        text-align: center;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        table-layout: fixed;
    }

    .product-table th,
    .product-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
        word-wrap: break-word;
    }

    .product-table th {
        background-color: #f2f2f2;
        font-size: 12px;
    }

    .product-table td {
        font-size: 12px;
    }

    img {
        width: 100px;
        height: 50px;
        max-width: 100%;
    }

    .section-title {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .section-content {
        font-size: 14px;
        margin-bottom: 3px;
    }

    .product-table th:nth-child(1),
    .product-table td:nth-child(1) {
        width: 8%;
        /* CODIGO */
    }

    .product-table th:nth-child(2),
    .product-table td:nth-child(2) {
        width: 6%;
        /* CANT */
    }

    .product-table th:nth-child(3),
    .product-table td:nth-child(3) {
        width: 40%;
        /* DESCRIPCION - WIDER COLUMN */
    }

    .product-table th:nth-child(4),
    .product-table td:nth-child(4) {
        width: 12%;
        /* P.U. */
    }

    .product-table th:nth-child(5),
    .product-table td:nth-child(5) {
        width: 12%;
        /* IMPORTE */
    }

    /* Column widths for client info table */
    .tabla th:nth-child(1),
    .tabla td:nth-child(1) {
        width: 20%;
    }

    /* COD. CTE. */
    .tabla th:nth-child(2),
    .tabla td:nth-child(2) {
        width: 20%;
    }

    /* FACTURA */
    .tabla th:nth-child(3),
    .tabla td:nth-child(3) {
        width: 20%;
    }

    /* Folio Fiscal */
    </style>
</head>

<body>

    <div class="factura-container">
        <div style="width: 100%; margin-bottom: 20px;">

            <table style="width: 100%; border-collapse: collapse;">
                <tr>

                    <td style="vertical-align: middle; width: 60%; padding-right: 30px;">
                        <div style="font-family: 'DejaVu Sans', sans-serif;">
                            <div style="font-weight: bold; font-size: 28px; margin-bottom: 8px; line-height: 1.2;">
                                EMBOTELLADORAS BEPENSA</div>
                            <div style="font-size: 14px; margin-bottom: 6px; line-height: 1.3;">Izamal: CALLE 46 No.312
                                X 37 Y 39 C.P. 97540 IZAMAL, YUCATÁN, MÉXICO</div>
                            <div style="font-size: 14px; line-height: 1.3;">MATRIZ: CALLE 29 NO. 340 X 122 Y 124 NUEVA
                                YUCALPETÉN CP. 97320 PROGRESO, YUCATÁN</div>
                        </div>
                    </td>

                    <td style="vertical-align: middle; width: 40%; text-align: right; padding-left: 20px;">
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/bepensa_logo.png'))) }}"
                            style="width: auto; max-height: 180px; height: auto; display: block; margin-left: auto;">
                    </td>
                </tr>
            </table>
        </div>

        <div class="seccion">
            <div class="seccion-header">Lugar de Expedición: 97540</div>
            <!-- <div class="section-content">A: 2025-03-01T19:25:30 &nbsp;&nbsp; 12028</div> -->
            <div class="section-content">{{$cliente_nombre}}</div>
        </div>

        <table class="tabla">
            <tr>
                <th>COD. CTE.</th>
                <th>FACTURA</th>
            </tr>
            <tr>
                <td class="center">{{$cod_cte}}</td>
                <td class="center bold">{{$factura_codigo}}</td>
            </tr>
        </table>

        <div class="seccion">
            <div class="section-title">FACTURADO A: {{$propietario}}</div>
            <div class="section-content">DIRECCIÓN: {{$direccion}}</div>
            <div class="section-content">RFC: {{$rfc}}</div>
        </div>

        <div class="seccion">
            <div class="section-content">Uso de CFDI: {{$cfdi_tipo}}</div>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>CANT</th>
                    <th>DESCRIPCION</th>
                    <th>P.U.</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->producto->codigo }}</td>
                    <td>{{ $producto->cantidad }}</td>
                    <td>{{ $producto->producto->nombre }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>${{ number_format($producto->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="tabla">
            <tr>
                <td style="vertical-align: top; padding: 0;">
                    <!-- Tabla principal con celdas autoajustables -->
                    <table style="width: 100%; border: 1px solid #000; border-collapse: collapse; table-layout: auto;">
                        <tr>
                            <!-- Celda de imagen - se ajusta al contenido -->
                            <td
                                style="border-right: 1px solid #000; padding: 5px; vertical-align: middle; white-space: nowrap; width: auto;">
                                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/selloSAT.png'))) }}"
                                    style="width: 235px; height: 108px; display: block;">
                            </td>

                            <!-- Celda de texto - ocupa el espacio disponible -->
                            <td style="padding: 5px; vertical-align: top; width: 50%;">
                                <div style="margin-left: 20px;">
                                    <p style="margin: 0 0 5px 0; font-weight: bold; font-size: 16px;">TODO PAGO CON
                                        CHEQUE DEBERA CRUZARSE Y GIRADO A NOMBRE DE:</p>
                                    <p style="margin: 0 0 0 0; font-size: 16px;">Embotelladoras Bepensa S.A. de C.V.
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CON LA LEYENDA "NO NEGOCIABLE"</p>
                                    <p style="margin: 6px 0 0 180px; font-size: 14px;">EFECTOS FISCALES AL PAGO</p>
                                    <p style="margin: 6px 0 0 240px; font-size: 14px;">
                                        R&nbsp;E&nbsp;V&nbsp;I&nbsp;S&nbsp;O</p>
                                    <p style="margin: 6px 0 0 0; font-weight: bold; font-size: 16px;">FIRMA:</p>
                                    <p style="margin: 6px 0 0 0; font-weight: bold; font-size: 16px;">NOMBRE:</p>
                                    <div style="height: 50px;"></div>
                                </div>
                            </td>

                            <!-- Celda de totales - se ajusta al contenido -->
                            <td style="padding: 5px; vertical-align: top; white-space: nowrap; width: auto;">
                                <table style="width: 100%; border: none; border-collapse: collapse;">
                                    <tr>
                                        <td style="text-align: left; padding: 0 0 5px 0; border: none;">Subtotal:</td>
                                        <td
                                            style="text-align: right; padding: 0 0 5px 0; font-weight: bold; border: none;">
                                            ${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <!-- <tr>
                        <td style="text-align: left; padding: 0 0 5px 0; border: none;">I.V.A. % 0.00:</td>
                        <td style="text-align: right; padding: 0 0 5px 0; font-weight: bold; border: none;">0.00</td>
                    </tr> -->
                                    <!-- <tr>
                        <td style="text-align: left; padding: 0 0 5px 0; border: none;">I.V.A. % 16.00:</td>
                        <td style="text-align: right; padding: 0 0 5px 0; font-weight: bold; border: none;">622.90</td>
                    </tr> -->
                                    <tr>
                                        <td style="text-align: left; padding: 0; font-weight: bold; border: none;">Neto
                                            a Pagar:</td>
                                        <td style="text-align: right; padding: 0; font-weight: bold; border: none;">
                                            ${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="tabla">
            <tr>
                <th>{{ numeroALetras($subtotal) }}</th>
            </tr>
        </table>

        <!-- <table class="tabla">
            <tr>
            <td style="vertical-align: top; padding: 0; width: 100%;">

    <table style="width: 100%; max-width: 100%; border: 1px solid #000; border-collapse: collapse; table-layout: fixed;">
        <tr>
         
            <td style="border-right: 1px solid #000; padding: 5px; vertical-align: top; width: 8%;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('dist/img/qrFactura.png'))) }}" 
                     style="width: 100%; max-width: 304px; height: auto; display: block;">
            </td>
            
           
            <td style="padding: 5px 10px; vertical-align: top; word-wrap: break-word;">
                
                <div style="margin-bottom: 10px;">
                    <p style="margin: 6px 0 2px 0; font-weight: bold; font-size: 14px;">Sello digital del Emisor:</p>
                    <p style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-all; font-family: 'Courier New', monospace;">
                        Esbv0Ig37XIjwiJpgx/T/mvuBw26/O8T+atDokjVIXih/eDP2ObUKywP10NNphj6n4Zxq36vZM1seIlkx9R5zbnLMfmTxMg6whXinJg9Vlpo9DIystqDJcIaEZaKhgB75uPGB8drSjiJZg1MHpUqIM6rdBhKfqWF4ODD9EsQOY+UjyUJ4v2zta+bI4YkIBw7X41B7DuCbChb9UU2aummd4jO/5fMkitr+nMvdDxs0GNzwcF6PARQCzKqSlCo/uBF1OoXiFIcZas4GdRGa7mNCbRZfvzesijIWEBzDphZPBAaNsJrutXlB9GdcVgyeNm6TrZIOsc38A/fPWJGB2l5FA==
                    </p>
                </div>
                
           
                <div style="margin-bottom: 10px;">
                    <p style="margin: 6px 0 2px 0; font-weight: bold; font-size: 14px;">Sello digital del SAT:</p>
                    <p style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-all; font-family: 'Courier New', monospace;">
                        Qg2muWwgh3AbATJ81Ada9JVARQkPl/b2Eo6mjzwKrRtRYXaeTsNz4+jV8t1BMp89fQcc4X6S02tWzjeQuRmqqYfoG7c7ZwAJ66SZSBtiA0fvJEiffSziDROZH1YW2mSdGUXHxZ1iwSfEAMw9vRbODQ4Uy5NPmyPudLTvEors6Xofw9sJ6FuJL9AAQQ9s0gklLxB6kwqP7p6MfZK3pYYmjZWlBJIlz7rji3MDl+NQS/pdZEubgwAC5U1l8mgpeMcnPMjVFZ6E+8weQo6fcm5gGNTKI2VlNbloVgFmfZD9mocFeMZgc/T07tn4IY8ZYkaLfa+Ba3bjEDhkoQ6pDd13IA==
                    </p>
                </div>
                
             
                <div>
                    <p style="margin: 6px 0 2px 0; font-weight: bold; font-size: 14px;">Cadena original del complemento de certificación digital del SAT</p>
                    <p style="margin: 0; font-size: 12px; line-height: 1.2; word-break: break-all; font-family: 'Courier New', monospace;">
                        ||1.1|AA929D7D-620A-4346-B05D-5774416B4704|2025-03-01T19:26:15|MAS980812UK1|Esbv0Ig37XIjwiJpgx/T/mvuBw26/O8T+atDokjVIXih/eDP2ObUKywP10NNphj6n4Zxq36vZM1seIlkx9R5zbnLMfmTxMg6whXinJg9Vlpo9DIystqDJcIaEZaKhgB75uPGB8drSjiJZg1MHpUqIM6rdBhKfqWF4ODD9EsQOY+UjyUJ4v2zta+bI4YkIBw7X41B7DuCbChb9UU2aummd4jO/5fMkitr+nMvdDxs0GNzwcF6PARQCzKqSlCo/uBF1OoXiFIcZas4GdRGa7mNCbRZfvzesijIWEBzDphZPBAaNsJrutXlB9GdcVgyeNm6TrZIOsc38A/fPWJGB2l5FA==|00001000000712749552||
                    </p>
                </div>
                
               
                <div style="height: 30px;"></div>
            </td>
        </tr>
    </table>
</td>

            </tr>
        </table> -->

        <!-- Tabla sin bordes y centrada -->
        <table style="width: 100%; border: none; border-collapse: collapse; margin: 10px 0;">
            <tr>
                <th
                    style="text-align: center; font-weight: bold; border: none; padding: 8px 0; background-color: #f8f8f8;">
                    Este documento es una representación impresa de un CFDI
                </th>
            </tr>
        </table>
    </div>

</body>

</html>