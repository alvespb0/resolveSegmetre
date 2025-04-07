<?php
session_start();

if (!isset($_SESSION['userName']) || $_SESSION['userName'] !== 'administrator') {
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit(); // Garante que o código abaixo não será executado
}

include_once('navbar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo1.png">
    <title>Financeiro</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #DDEDEB; /* Verde suave para o fundo de toda a página */
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
            overflow:hidden;
        }
        /* Estilização para o conteúdo específico da página */
        .financeiro-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Ajusta o alinhamento para o topo */
            background-color: #DDEDEB;
            margin: 0;
            padding: 2.8%; /* Remover qualquer padding-top fixo */
            position: relative; /* Garantir que o container não seja fixo */
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 600px;
            margin-top: -2%;            
            transition: 0.3s;
            max-height: 600px;  /* Ajuste conforme necessário */
            overflow-y: auto;
        }

        .form-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container label {
            font-size: 16px;
            color: #333;
            margin: 20px 0 5px;
            display: block;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-container button.submit {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            width: 100%;
        }

        .form-container button.submit:hover {
            background: linear-gradient(135deg, #406659, #5c8b7f);
            transform: scale(1.03);
        }

        .form-container button#addFileBtn {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 10px; /* <--- Adiciona espaçamento antes do botão de submit */
            transition: 0.3s;
            width: fit-content;
        }

        .form-container button#addFileBtn:hover {
            background: linear-gradient(135deg, #406659, #5c8b7f);
            transform: scale(1.03);
        }

        .file-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .file-wrapper input[type="file"] {
            flex: 1;
        }

        .remove-btn {
            background-color: #ff5f5f;
            border: none;
            color: white;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
        }

        .remove-btn:hover {
            background-color: #e04747;
        }

        .response {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
        }

        /* Responsividade para dispositivos móveis */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                max-width: 90%;
            }

            .form-container h2 {
                font-size: 20px;
            }

            .form-container input[type="text"],
            .form-container input[type="date"],
            .form-container select,
            .form-container input[type="file"] {
                font-size: 14px;
            }

            .form-container button {
                padding: 12px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="financeiro-container">
        <div class="form-container">
            <h2>Encaminha NF e Boleto</h2>
            <form id="finForm" enctype="multipart/form-data">
                <label for="email">Email</label>
                <input type="text" id="email" name = "email" required>
                <label for="dataVenc">Data de Vencimento</label>
                <input type="date" name="dataVenc" id="dataVenc" required>
                <label for="file">Arquivo</label>
                <div id="fileInputs">
                    <input type="file" name="file[]" required>
                </div>
                <button type="button" id="addFileBtn">Adicionar mais arquivos</button>
                <button class="submit" type="submit">Enviar</button>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script>
        /* ------------------------------------------------------------------*/
        /*                       SCRIPT PARA ADICIONAR FILES                 */

        document.getElementById('addFileBtn').addEventListener('click', function () {
        const fileInputs = document.getElementById('fileInputs');

        // Cria o container do input + botão
        const wrapper = document.createElement('div');
        wrapper.className = 'file-wrapper';

        // Cria o input de arquivo
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'file[]';
        newInput.required = true;

        // Cria o botão "X"
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = 'X';
        removeBtn.className = 'remove-btn';

        // Remove o campo ao clicar no "X"
        removeBtn.addEventListener('click', function () {
            wrapper.remove();
        });

        // Adiciona input e botão ao wrapper
        wrapper.appendChild(newInput);
        wrapper.appendChild(removeBtn);

        // Adiciona o wrapper ao container
        fileInputs.appendChild(wrapper);
    });
    /*                   FIM DO SCRIPT DE ADICIONAR FILES                */
    /* ------------------------------------------------------------------*/

    /* ------------------------------------------------------------------*/
    /*                       SCRIPT PARA A ROUTE                         */
    document.getElementById('finForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('../Route/routeFinanceiro.php', {
                method: 'POST',
                body: formData // Não precisamos de JSON, apenas FormData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                }
                if (data.error) {
                    alert(data.error);
                }
            })
            .catch((error) => {
                console.error('Erro:', error);
            });

    });
</script>

</body>
</html>
