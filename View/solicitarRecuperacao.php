<?php
include_once('navbarLogin.php');
require_once '../Controller/controllerUsuario.php';
use controllers\ControllerUsuario;

$controllerUsuario = new ControllerUsuario;
$email = '';

$email = isset($_GET['email']) ? $_GET['email'] : '';
if($email){
    $link = $controllerUsuario->getLinkRecSenha($email);
    if($link !== false){
        $controllerUsuario->enviaEmailSenha($email, $link);
    } #não vai haver else, irá printar na tela, se esse email existir no sistema, será enviado um email de recuperação
}#não vai haver else, irá printar na tela, se esse email existir no sistema, será enviado um email de recuperação
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        .recuperacao-body {
            margin: 0;
            background-color: #DDEDEB;
            height: 100vh;
            display: fixed;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Impede a barra de rolagem */
        }

        /* Container do Registro */
        .containerMailRec {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -85px;
            width: 100%; /* Para centralizar */
            height: 100%; /* Para centralizar */
        }

        .recuperacao-box {
            background: #fefefe;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px; /* Aumentei a largura */
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Título */
        h2 {
            font-family: Arial, sans-serif; /* Fonte Arial */
            color: #518076;
            font-weight: bold;
        }

        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input, select {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #79a79a;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        input:focus, select:focus {
            border-color: #518076;
            box-shadow: 0 0 8px rgba(81, 128, 118, 0.6);
        }

        .hidden {
            display: none;
        }

        button {
            background: #518076;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            width: 45%; /* Alterado para ajustarmos os botões lado a lado */
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #79a79a;
        }

        .cancelar-btn {
            background: #bdc3c7; /* Cor cinza suave para o botão cancelar */
            margin-left: 10px;
        }

        .cancelar-btn:hover {
            background:rgb(128, 128, 128); /* Cor cinza suave para o botão cancelar */
        }

        /* Estilo para a mensagem */
        #mensagem {
            font-size: 16px;
            color: #518076;
            font-weight: bold;
        }
    </style>
</head>
<body class="recuperacao-body">

    <div class="containerMailRec">
        <div class="recuperacao-box">
            <h2>Recuperar Senha</h2>
            <form id="formulario-recuperacao" action="" method="GET">
                <label for="email">E-mail cadastrado</label>
                <input type="text" placeholder="Email" name="email" id="email" required>
                <div style="display: flex; justify-content: space-between; width: 100%;" id="buttons-container">
                    <button type="button" class="cancelar-btn" onclick="window.location.href='login.php'">Cancelar</button>
                    <button type="submit">Recuperar Senha</button>
                </div>
            </form>
            <p id="mensagem" class="hidden">Se esse e-mail estiver cadastrado na plataforma, um link de recuperação será enviado.</p>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('email')) {
            document.getElementById('formulario-recuperacao').style.display = 'none';
            document.getElementById('mensagem').classList.remove('hidden');
        }
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
