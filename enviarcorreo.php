<?php
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
          // Recibir vía POST los datos del formulario
          $nombre = $_POST["nombre"];
          $correo = $_POST["correo"];
          $comentarios = $_POST["comentarios"];

          if (empty($correo)){ // Validar si la dirección de correo no esta vacia
            $error=1;
            $mensaje="Correo electrónico vacío.";
            $datos=0;
          } else {

            $usuario_mail="franco11navarro11@gmail.com"; // Direccion de envio
            $remite = "Formulario de Mi webpage"; //Nombre de Quien remite o envia
            $remite_email = "franco11navarro11@gmail.com";
            $asunto = "Se envío un correo de contacto desde $remite";

            // Armar un mensaje html para el cuerpo del correo electrónico
            $mensaje = "<!doctype html>
            <html class=''><head><meta charset='utf-8'>
            <title>Han enviado los siguientes comentarios!</title>
            </head>
            <body>
            <h1>Contacto desde el sitio www.puvel.com.mx (Punto de Venta en Línea)</h1>
            Nombre: ".$nombre." <br clear='all'/>
            Correo: ".$correo." <br clear='all'/>
            Comentario: <br clear='all'/> ".$comentarios." <br clear='all'/>
            </body></html>";

            $cabeceras = "From: ".$remite." <".$remite_email.">\r\n";
            $cabeceras = $cabeceras."Mime-Version: 1.0\n";
            $cabeceras = $cabeceras.'Content-type: text/html; charset=utf-8' . "\r\n";

            // Realizar el envío con la función mail de php
            $enviar_email = mail($usuario_mail, $asunto, $mensaje, $cabeceras);

            if($enviar_email) { // Envío exitoso
              $error=0;
              $mensaje="Correo enviado";
              $datos=0;
            }else { // No se pudo enviar el correo
              $error=1;
              $mensaje="El correo no fue enviado";
              $datos=0;
            }

          }

        // Empaquetado de la respuesta en formato JSON
          $resp=[
            "error"=>$error,
            "mensaje"=>$mensaje,
            "datos"=>$datos,
          ];

        echo json_encode($resp);

        } else {
          $resp=[
           "error"=>1,
           "mensaje"=>"El servidor denego la peticion.",
           "datos"=>0
          ];
          echo json_encode($resp);
        }
?>

      