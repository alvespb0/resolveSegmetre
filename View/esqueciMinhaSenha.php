<?php
if (!isset($_GET['token'])) {
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit;
}
require_once '../Controller/controllerUsuario.php';
use controllers\ControllerUsuario;

$controllerUsuario = new ControllerUsuario;

$token = $_GET['token'];

if(!$controllerUsuario->validaTokenSenha($token)){
    session_start();
    $_SESSION['tokenInvalido'] = 'Link fornecido expirado após o prazo de 1 hora ou já utilizado';
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit;
}
include_once('navbarLogin.php');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        .registro-body {
            margin: 0;
            background-color: #DDEDEB;
            height: 100vh;
            display: fixed;
            justify-content: center;
            align-items: center;
            overflow: hidden; /* Impede a barra de rolagem */
        }

        /* Container do Registro */
        .containerRegistro {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -85px;
            width: 100%; /* Para centralizar */
            height: 100%; /* Para centralizar */
        }

        .registro-box{
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

        label {
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
            width: 95%;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background: #79a79a;
        }
    </style>
</head>
<body class= "registro-body">
    <div class="containerRegistro">
        <div class="registro-box">
        <h2>Redefinir Senha</h2>
        <form id="formSenha">
            <input type="hidden" name ="token" value = "<?php echo $token ?>">
            <label for="senha">Senha</label>
            <input type="password" placeholder="Senha" name="senha" required>
            <label for="confirmar_senha">Confirmar Senha</label>
            <input type="password" placeholder="Senha" name="confirmar_senha" required>
            <button type="submit">Registrar</button>
        </form>
        </div>
    </div>

    <script>
        document.getElementById('formSenha').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            const senha = document.querySelector('input[name="senha"]').value;
            const confirmar = document.querySelector('input[name="confirmar_senha"]').value;

            if (senha !== confirmar) {
                alert('As senhas não coincidem.');
                return; // Interrompe aqui se estiver errado
            }

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch('../Route/routeRedefinirSenha.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())  // Converte a resposta para JSON
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 100);
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Erro ao redefinir a senha. Tente novamente mais tarde.');
            });
        });
    </script>

    <?php include 'footer.php';?>
</body>
</html>
