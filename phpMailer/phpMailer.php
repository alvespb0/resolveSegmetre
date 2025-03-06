<?php
namespace mail;

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public function enviarEmail($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }    
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Google
        $mail->SMTPAuth = true;        // Ativar autenticação SMTP
        $mail->Username = 'documentos@segmetre.com.br'; // Substitua pelo seu e-mail
        $mail->Password = 'gijs mxbr juwx fbkq';   // Substitua pela senha de aplicativo
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar TLS
        $mail->Port = 587;             // Porta do servidor SMTP

        $mail->setFrom('documentos@segmetre.com.br', 'Segmetre'); // Remetente
        $mail->addAddress($email); // Destinatário

        $mail->isHTML(true);
        $mail->Subject = 'Novo arquivo no sistema!'; // Assunto
        $mail->Body = '
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Notificação de Novo Arquivo</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f7f7f7;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        padding: 20px;
                        background-color: #f7f7f7;
                    }
                    .content {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        border-radius: 8px;
                        padding: 40px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        font-size: 2.2em;
                        margin-bottom: 15px;
                        color: #1f7262;
                        font-weight: bold;
                    }
                    p {
                        font-size: 1.1em;
                        line-height: 1.6;
                        color: #555;
                    }
                    a {
                        color: #1f7262;
                        font-weight: bold;
                    }

                    .footer {
                        font-size: 0.9em;
                        color: #999;
                        margin-top: 30px;
                        text-align: center;
                    }
                    .footer p {
                        margin: 0;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="content">
                        <h1>Novo Arquivo Disponível</h1>
                        <p>Olá,</p>
                        <p>Temos o prazer de informar que há um novo arquivo aguardando o seu download no sistema <strong><a href="http://resolveSegmetre.com.br:8081" target="_blank">ResolveSegmetre</a></strong>.</p>
                        <p>Não perca tempo! O arquivo estará disponível para você a qualquer momento.</p>
                        <div class="footer">
                            <p>Este é um e-mail automático. Caso não tenha solicitado este arquivo, ignore esta mensagem.</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
                    ';
                    
        if($mail->send()){
            return true;
        }else{
            return false;
        }
    }
}


?>
