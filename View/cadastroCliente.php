<?php
if (!isset($_GET['token'])) {
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit;
}
require_once '../Controller/controllerUsuario.php';
use controllers\ControllerUsuario;

$controllerUsuario = new ControllerUsuario;

$token = $_GET['token'];

if(!$controllerUsuario->validaToken($token)){
    session_start();
    $_SESSION['tokenInvalido'] = 'Link fornecido expirado após o prazo de 24 horas ou já utilizado';
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
            ; /* <-- Alinha os elementos à esquerda */

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

        .termos-container {
            display: flex;
            align-items: center;
            gap: 8px; /* Espaço entre o checkbox e o texto */
            font-size: 0.95rem;
        }

        .termos-container input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #006666; /* cor do check para bater com o estilo da página */
            cursor: pointer;
        }

        .termos-container label {
            cursor: pointer;
            user-select: none;
        }

        .termos-container a {
            color: #006666;
            text-decoration: underline;
        }



    </style>
</head>
<body class= "registro-body">
    <div class="containerRegistro">
        <div class="registro-box">
        <h2>Registro</h2>
        <form id="formCadastro">
            <input type="hidden" name="type" value = "usuario">
            <input type="hidden" name ="token" value = "<?php echo $token ?>">
            <input type="text" placeholder="Empresa" name="usuario" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Senha" name="senha" required>
            <input type="text" name="cnpj" id="cnpj" placeholder="CNPJ" required>
            <div class="termos-container">
                <input type="checkbox" id="termos" name="termos" required>
                <label for="termos">
                    Li e concordo com os <a href="termoUso.php" target="_blank">termos de uso</a>.
                </label>
            </div>
            <button type="submit">Registrar</button>
        </form>
        </div>
    </div>

    <script>
        document.getElementById('formCadastro').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch('../Route/routeRegistro.php', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())  // Converte a resposta para JSON
            .then(data => {
                console.log('Success:', data);
                if (data.message) {
                    alert(data.message);  // Exibe a mensagem em um alerta
                    setTimeout(function() {
                        window.location.href = "Login.php";
                    }, 100); // Espera 100ms depois do alerta
                }
                if (data.error) {
                    alert(data.error);  // Exibe a mensagem de erro em um alerta
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });

        });
    </script>

    <?php include 'footer.php';?>
</body>
</html>
