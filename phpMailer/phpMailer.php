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
                        <p>Temos o prazer de informar que há um novo arquivo aguardando o seu download no sistema <strong><a href="https://resolveSegmetre.com.br:1443" target="_blank">ResolveSegmetre</a></strong>.</p>
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
    
    public function enviaFinanceiro($mailForm, $file){

        try{
            $destinatario = $mailForm['email'];
            $dataVenc = $mailForm['dataVenc'];

            if (empty($destinatario) || empty($dataVenc)) {
                return false;
            }
            
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP do Google
            $mail->SMTPAuth = true;        // Ativar autenticação SMTP
            $mail->Username = 'financeiro@segmetre.com.br'; // Substitua pelo seu e-mail
            $mail->Password = 'mgel lcgm iuhw vtoe';   // Substitua pela senha de aplicativo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar TLS
            $mail->Port = 587;             // Porta do servidor SMTP

            $mail->setFrom('financeiro@segmetre.com.br', 'Segmetre'); // Remetente
            $mail->addAddress($destinatario); // Destinatário

            $mail->isHTML(true);
            $mail->Subject = 'Envio de NF e Boleto!'; // Assunto
            $mail->Body = '<!DOCTYPE html>
                            <html lang="pt-br">
                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Document</title>
                                <style>
                                    body {
                                        font-family: Arial, sans-serif;
                                        background-color: #e2eeec;
                                        color: #518173;
                                        margin: 0;
                                        padding: 0;
                                    }
                                    .container {
                                        width: 100%;
                                        max-width: 600px;
                                        margin: 0 auto;
                                        padding: 20px;
                                        background-color: #ffffff;
                                        border-radius: 8px;
                                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                    }
                                    h2 {
                                        color: #7dc5b7;
                                        font-size: 24px;
                                        margin-bottom: 20px;
                                    }
                                    p {
                                        font-size: 16px;
                                        line-height: 1.5;
                                        margin-bottom: 10px;
                                    }
                                    .highlight {
                                        color: #6c948c;
                                        font-weight: bold;
                                    }
                                    .footer {
                                        font-size: 14px;
                                        color: #518173;
                                        margin-top: 20px;
                                        text-align: center;
                                    }
                                    .footer a {
                                        color: #649c8c;
                                        text-decoration: none;
                                    }
                                    .footer a:hover {
                                        text-decoration: underline;
                                    }
                                </style>
                            </head>
                            <body>
                                <div class="container">
                                    <h2>Prezado Cliente,</h2>
                                    <p>Agradecemos a confiança e preferência em nossos serviços.</p>
                                    <p>Em anexo, você encontrará a nota fiscal e os relatórios referentes ao último período.</p>
                                    <p>Data de vencimento: <span class="highlight">' . $dataVenc . '</span></p>
                                    <p>Qualquer dúvida, estamos à disposição!</p>
                                    <p><b>Favor confirmar recebimento.</b></p>
                                    <div class="footer">
                                        <p>Atenciosamente, <br> Segmetre</p>
                                        <p><a href="mailto:financeiro@segmetre.com.br">financeiro@segmetre.com.br</a> | <a href="https://wa.me/+554999480118" target="_blank">(49) 9948-0118 </a></p>
                                    </div>
                                </div>
                            </body>
                            </html>';

            foreach ($file['tmp_name'] as $index => $tmpName) {
                if ($file['error'][$index] === UPLOAD_ERR_OK) {
                    $mail->addAttachment($tmpName, mb_encode_mimeheader($file['name'][$index], 'UTF-8'));
                }
            }
                
            $mail->send();
            return true;
        }catch (Exception $e) {
            // opcional: log do erro
            return $mail->ErrorInfo;
        }        
    }
    
    public function enviaEmailRecuperacao($email, $link){
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
        $mail->Subject = 'Recuperação de Senha!'; // Assunto
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
                        <h1>Recuperação de Senha</h1>
                        <p>Olá,</p>
                            <p>Recebemos uma solicitação de recuperação de senha para a sua conta. Se você não solicitou essa recuperação, pode desconsiderar este e-mail.</p>
                            <p>Para redefinir sua senha, clique no link abaixo:</p>
                            <p><a href="'.$link.'">Redefinir sua Senha</p>
                        <div class="footer">
                            <p>Este link será válido por 1 hora. Após esse período, será necessário solicitar uma nova recuperação de senha.</p>
                            <p>Se você não reconhece essa solicitação, recomendamos que altere sua senha imediatamente ao acessar sua conta.</p>
                            <p>Atenciosamente,</p>
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
