<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Facturación Bepensa Código #</title>
    <style>
      /* Agrega estos nuevos estilos para la tabla */
      .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 12px;
        /* font-size: 11px; */
      }
      .order-table th {
        padding: 4px 8px;
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        font-weight: 600;
      }
      .order-table td {
        padding: 8px;
        border: 1px solid #ddd;
      }
      .order-table tr:last-child td {
        border-bottom: 1px solid #ddd;
      }

      .text-left {
        text-align: left;
      }

      .text-right {
        text-align: right;
      }

      .text-center {
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div style="padding:0;background-color:#ffffff;font-family:'Lato',sans-serif;font-size:16px;color:#272727;width:100%;max-width:800px;margin:0 auto">
      <img style="width:120px;height:auto;margin-bottom:2%;margin-left:8%" src="https://www.bepensa.com/wp-content/uploads/2018/05/favicon.png" alt="">
      <table border="0" cellpadding="0" cellspacing="0" align="center" style="width:100%;max-width:800px;margin:0 auto;padding:0 30px;border-collapse:collapse;border:0">
        <tbody>
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" align="center" style="width:100%;max-width:688px;margin:0 auto;padding:0 30px;border-collapse:collapse;border:1px solid #cccccc">
                <tbody>
                  <tr>
                    <td style="padding:24px 40px;background:#343a40">
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                          <tr>
                            <td width="100%" style="color:#fff;font-size:80%">
                              <h1>Código: {{ $factura_codigo }}</h1>
                              <h3>{{ $fecha }}</h3>
                              @if ($dias_restantes >= 0 && $dias_restantes != null)
                                <h4>Vencimiento: {{ $fecha_vencimiento }}</h4>
                              @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td style="padding:24px 40px;border-bottom:1px solid #cccccc">
                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                          <tr>
                            <td width="100%">
                              <div style="font-size:80%;text-align:left">
                                <h2>Estimado(a) usuario</h2>
                              </div>
                              @if($factura_estatus == 'PENDIENTE')
                                <p style="font-size:95%">Hemos recibido una facturación y está en seguimiento.</p>
                              @elseif($factura_estatus == 'CANCELADO')
                                <p style="font-size:95%">La facturación con código <strong>{{ $factura_codigo }}</strong> ha sido cancelada</p>
                              @elseif($factura_estatus == 'PAGADO')
                                <p style="font-size:95%">La facturación con código <strong>{{ $factura_codigo }}</strong> ha sido pagada</p>
                              @else
                                <p></p>
                              @endif
                              @if($dias_restantes === "15" && $dias_restantes != null)
                                <p style="font-size:95%">Tiene <strong>{{ $dias_restantes }} días</strong> para realizar el cobro</p>
                              @elseif($dias_restantes === "7" && $dias_restantes != null)
                                <p style="font-size:95%">Tiene <strong>{{ $dias_restantes }} días</strong> para realizar el cobro</p>
                              @elseif($dias_restantes === "3" && $dias_restantes != null )
                                <p style="font-size:95%">Tiene <strong>{{ $dias_restantes }} días</strong> para realizar el cobro</p>
                              @elseif($dias_restantes === "1" && $dias_restantes != null)
                                <p style="font-size:95%"><strong>Último día para cobrar</strong></p>
                              @elseif($dias_restantes === "0" && $dias_restantes != null)
                                <p style="font-size:95%"><strong>La facturación ha vencido</strong></p>
                              @else
                                <p></p>
                              @endif
                              <p style="font-size:95%">¡Gracias, ten un buen día!</p>
                              <p></p>
                              <p></p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                      
                  <tr>
                    <td style="padding:24px 40px;border-bottom:1px solid #cccccc">
                      <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                          <tr>
                            <th>
                              <div style="font-size:80%;text-align:left">
                                <h2>Datos del cliente</h2>
                              </div>
                            </th>
                            <th>
                              <div style="font-size:80%;text-align:left">
                                <h2>Datos de facturación</h2>
                              </div>
                            </th>
                          </tr>
                          <tr>
                            <td>
                              <div style="font-size:16px;text-align:left">                                                            
                              <p style="margin: 0 0 10px 0; font-size: 95%">{{ $cliente_tienda }}</p>
                              <p style="margin: 0 0 10px 0; font-size: 95%">{{ $propietario }}</p>
                              <p style="margin: 0 0 10px 0; font-size: 95%">{{ $rfc }}</p>
                              <p style="margin: 0; font-size: 95%">{{ $direccion }}</p>
                              </div>
                            </td>
                            <td>
                              <div style="font-size:16px;text-align:lef">
                                <p style="margin: 0 0 10px 0; font-size: 95%">{{ $cfdi_tipo }}</p>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:24px 40px;border-bottom:1px solid #cccccc">
                      <div style="font-size:80%;margin-bottom:20px">
                        <h2>Detalle del pedido</h2>   
                      </div>
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="order-table">
                        <thead>
                          <tr>
                            <th class="text-left">Producto</th>
                            <th class="text-center">Cantidad * PU</th>
                            <th class="text-right">Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($productos as $producto)
                            <tr>
                              <td width="100%" style="font-size:14px;width:33%;padding-bottom:16px">
                                {{ $producto->producto->nombre }}<br>
                                Código {{ $producto->producto->codigo }}
                              </td>
                              <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-top:16px;padding-bottom:16px;text-align:center">
                                {{ $producto->cantidad }} X ${{ number_format($producto->precio, 2) }}
                              </td>
                              <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-top:16px;padding-bottom:16px;text-align:right">
                                ${{ number_format($producto->subtotal, 2) }}</
                              </td>
                            </tr>
                          @endforeach
                          <tr>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-top:16px;padding-bottom:16px">
                            </td>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-top:16px;padding-bottom:16px;text-align:center">
                            </td>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-top:16px;padding-bottom:16px;text-align:center">
                            </td>
                          </tr>
                          <tr>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-bottom:16px">
                              Total
                            </td>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-bottom:16px;text-align:center">
                            </td>
                            <td width="33%" style="font-size:16px;font-weight:700;width:33%;padding-bottom:16px;text-align:right">
                              ${{ $total }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td width="100%" style="font-size:14px;width:10%;padding-bottom:16px;text-align:center">
                Favor de <b>NO CONTESTAR</b> este correo ya que es automático y se genera desde la plataforma de Bepensa.
            </td>
          </tr>
          <tr>
            <td style="padding-top:20px;font-size:80%;padding-bottom:2%;color:#272727">
              AVISO IMPORTANTE:
              Este correo electrónico y/o material adjunto es/son para uso exclusivo de la persona o la entidad a la
              que expresamente se le ha enviado, y puede contener información confidencial o material privilegiado. Si
              usted no es el destinatario legítimo del mismo, por favor repórtelo inmediatamente al originador del
              correo y bórrelo. Cualquier revisión, retransmisión, difusión o cualquier otro uso de este correo, por
              personas o entidades distintas a las del destinatario legítimo, queda expresamente prohibido. Este
              correo electrónico no pretende ni debe ser considerado como constitutivo de ninguna relación legal,
              contractual o de otra índole similar.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>
</html>