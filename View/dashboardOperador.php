<?php
require_once ('../Controller/controllerUsuario.php');
use controllers\ControllerUsuario;
session_start();

$controllerUsuario = new ControllerUsuario;

$empresas = $controllerUsuario->obtainIdCompany();

if ($_SESSION['type'] !== 'operador') {
    echo json_encode(["error" => "tela somente de operadores!"]);
    header("Location: http://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit; // Importante para interromper a execução após o redirecionamento
}else{
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo1.png">
    <title>Dashboard Operador</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #DDEDEB; /* Verde suave para o fundo de toda a página */
        }
        /* Estilização para o conteúdo específico da página */
        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Ajusta o alinhamento para o topo */
            background-color: #DDEDEB;
            margin: 0;
            padding: 1.8%; /* Remover qualquer padding-top fixo */
            position: relative; /* Garantir que o container não seja fixo */
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 600px;
            transition: 0.3s;
        }

        .form-container:hover {
            transform: translateY(-5px);
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
        .form-container select,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-container button {
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

        .form-container button:hover {
            background: linear-gradient(135deg, #406659, #5c8b7f);
            transform: scale(1.05);
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
<?php 
if($_SESSION['userName'] == 'administrator'){
    include 'navbarAdministrador.php';
}else{
    include 'navbarOperador.php';  
}

?>
    <div class="dashboard-container">
        
        <div class="form-container">
            <h2>Upload de Arquivo</h2>
            
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="hidden" name="OperadorId" value = "<?php echo $_SESSION['idOperador']; ?>">
                <label for="company">Empresa:</label>
                <select name="company_id" id="company" required>
                    <option value="">Selecione uma empresa</option>
                    <?php
                    foreach ($empresas as $name => $company_id) {
                        echo "<option value='".$company_id."'>";
                        echo $name;
                        echo "</option>";
                    }
                    ?>
                </select>

                <label for="file_name">Nome do Arquivo:</label>
                <input type="text" id="file_name" name="file_name" required>

                <label for="upload_date">Data de Upload:</label>
                <input type="date" id="upload_date" name="upload_date">

                <label for="file">Selecionar Arquivo:</label>
                <input type="file" id="file" name="file" required>

                <button type="submit">Enviar Arquivo</button>
            </form>

            <div class="response" id="response"></div>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('../Route/routeUpload.php', {
                method: 'POST',
                body: formData // Não precisamos de JSON, apenas FormData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);

                    sendEmailAfterUpload(data.company_id);
                }
                if (data.error) {
                    alert(data.error);
                }
            })
            .catch((error) => {
                console.error('Erro:', error);
            });
        });

        function sendEmailAfterUpload(companyId) {
            fetch('../Route/routeSendEmail.php', {
                method: 'POST',
                body: JSON.stringify({
                    company_id: companyId // Passa o company_id para a requisição
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    console.log("E-mail enviado com sucesso!");
                } else if(data.error){
                    console.error("Erro ao enviar e-mail:", data.error);
                }
            })
            .catch((error) => {
                console.error('Erro ao tentar enviar o e-mail:', error);
            });
        }

    </script>


</body>
</html>
<?php } ?>