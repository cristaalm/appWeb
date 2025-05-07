<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Restablece tu contraseña</title>
</head>

<body
  style="
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    ">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0">
    <tr>
      <td align="center">
        <table
          width="600"
          cellpadding="0"
          cellspacing="0"
          style="
              background-color: #ffffff;
              border-radius: 8px;
              overflow: hidden;
              box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            ">
          <tr style="background-color: #0b4d91">
            <td
              style="
                  padding: 20px;
                  text-align: center;
                  color: #ffffff;
                  font-size: 24px;
                ">
              AQUANOVA
            </td>
          </tr>
          <tr>
            <td style="padding: 30px; color: #333">
              <h2 style="margin-top: 0">
                Hola {{ explode(' ', $user->name)[0] ?? 'usuario' }} 👋
              </h2>
              <p>Recibimos una solicitud para restablecer tu contraseña.</p>
              <p style="text-align: center; margin: 30px 0">
                <a
                  href="{{ $url }}"
                  style="
                      padding: 12px 24px;
                      background-color: #17a2b8;
                      color: white;
                      text-decoration: none;
                      border-radius: 4px;
                      font-weight: bold;
                    ">
                  Restablecer contraseña
                </a>
              </p>
              <p>
                Si no solicitaste este cambio, puedes ignorar este mensaje.
              </p>
              <p style="margin-bottom: 0">
                Saludos,<br />El equipo de AQUANOVA
              </p>
            </td>
          </tr>
          <tr>
            <td
              style="
                  background-color: #f1f1f1;
                  padding: 20px;
                  text-align: center;
                  font-size: 12px;
                  color: #777;
                ">
              © {{ date('Y') }} AQUANOVA. Todos los derechos reservados.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
