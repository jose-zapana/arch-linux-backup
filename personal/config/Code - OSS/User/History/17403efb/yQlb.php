<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Ticket de compra</title>

  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;

      .ticket {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
      }

      h1, h2, h3, h4 {
        text-align: center;
        margin-bottom: 10px;
      }

      .info {
        margin-bottom: 20px;
      }

    }
  </style>


</head>
<body>

  <div class="ticket">
    <h4>
        Número de orden : {{ $order->id }}
    </h4>

    <div class="info">
      <h3>
        Información de la Empresa
      </h3>
      <div>
        Nombre: PC-Hard Technology
      </div>
      <div>
        RUC: 2061001513
      </div>
      <div>
        Telefono: 957686487
      </div>
      <div>
        Correo: ventas@pc-hard.com
      </div>

    </div>

    <div class="info">
      <h3>
        Datos del cliente
      </h3>
      <div>
        Nombre: {{ $order->user->name }}
      </div>
      <div>
        RUC: 2061001513
      </div>
      <div>
        Telefono: 957686487
      </div>
      <div>
        Correo: ventas@pc-hard.com
      </div>

    </div>

  </div>
  
</body>
</html>