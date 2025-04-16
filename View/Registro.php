<?php
session_start();

if (!isset($_SESSION['userName']) || $_SESSION['userName'] !== 'administrator') {
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit(); // Garante que o código abaixo não será executado
}

require_once '../Controller/controllerUsuario.php';
use controllers\ControllerUsuario;

$controllerUsuario = new ControllerUsuario;

$linkGerado = '';

if (isset($_GET['link'])) {
    $controllerUsuario = new ControllerUsuario;
    $linkGerado = $controllerUsuario->getLinkCadastro();
}

include_once('navbar.php');

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
        <h2>Registro</h2>
        <form id="formCadastro">
            <input type="text" placeholder="Usuário" name="usuario" required>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Senha" name="senha" required>
            <select id="tipo" name="type" required>
                <option value="recepcao">Recepcao</option>
                <option value="usuario">Usuário</option>
                <option value="financeiro">Financeiro</option>
            </select>
            <input type="text" name="cnpj" id="cnpj" class="hidden" placeholder="CNPJ">
            <button type="submit">Registrar</button>
        </form>
        <form action="" method = "GET">
            <input type="hidden" name="link">
            <button type="submit">Gerar Link de Cadastro</button>
        </form>

        <?php if (!empty($linkGerado) && !is_array($linkGerado)): ?>
            <div style="margin-top: 15px; display: flex; align-items: center; gap: 10px;">
                <input type="text" id="linkGerado" value="<?= htmlspecialchars($linkGerado) ?>" readonly
                    style="padding: 8px; width: 100%; max-width: 500px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">
                <button onclick="copiarLink()" type="button"
                    style="padding: 8px 12px; background-color: #518076; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    Copiar
                </button>
            </div>

            <script>
                function copiarLink() {
                    const campo = document.getElementById("linkGerado");
                    campo.select();
                    campo.setSelectionRange(0, 99999); // Para dispositivos móveis
                    document.execCommand("copy");
                    alert("Link copiado para a área de transferência!");
                }
            </script>

        <?php elseif (is_array($linkGerado) && isset($linkGerado['error'])): ?>
            <p style="color:red;">Erro: <?= htmlspecialchars($linkGerado['error']) ?></p>
        <?php endif; ?>

        </div>
    </div>

    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            let cnpjField = document.getElementById('cnpj');
            if (this.value === 'usuario') {
                cnpjField.classList.remove('hidden');
            } else {
                cnpjField.classList.add('hidden');
            }
        });

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
