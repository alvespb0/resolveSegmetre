<?php
session_start();

require '../Controller/controllerFiles.php';
use controllers\ControllerFiles;

$controllerFiles = new ControllerFiles;

$files = $controllerFiles->obtainFilesbyId($_SESSION['empresaId']);

if ($_SESSION['type'] !== 'usuario') {
    echo json_encode(["error" => "tens de fazer login!"]);
    header("Location: http://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit; // Importante para interromper a execução após o redirecionamento
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo1.png">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
            background-color: #DDEDEB; /* Verde suave para fundo */
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
        }
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #1F7262; /* Cor do logo */
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            font-size: 16px;
            text-transform: uppercase;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-download {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }
        .btn-download:hover {
            background: linear-gradient(135deg, #165A50, #2B8A7A);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php include 'navbarUsuario.php';  ?>
    <div class="container">
    <?php if(is_array($files)){ ?>
        <h2>Arquivos Disponíveis</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Arquivo</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($files as $file) : ?>
            <tr>
                <td><?= $file['id'] ?></td>
                <td><?= htmlspecialchars($file['file_name']) ?></td>
                <td><?= date("d/m/Y", strtotime($file['uploaded_at'])) ?></td>
                <td>
                    <button class="btn-download" data-id="<?= $file['id'] ?>" data-path="<?= htmlspecialchars($file['file_path']) ?>">
                        Download
                    </button>
                    </a>
                </td>
            </tr>
        <?php endforeach;}else{ echo "<h2>Nenhum Arquivo Disponível!</h2>";};?>

            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        document.querySelectorAll('.btn-download').forEach(button => {
            button.addEventListener('click', function() {
                const fileId = this.getAttribute('data-id'); // Pega o ID do arquivo
                const filePath = this.getAttribute('data-path'); // Pega o caminho do arquivo

                fetch('../Route/routeDownload.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: fileId, path: filePath }) // Envia ID e path
                })
                .then(response => {
                    // Verifica se a resposta é válida
                    if (response.ok) {
                        return response.blob(); // Converte a resposta em um blob (arquivo)
                    }
                    throw new Error('Erro ao processar download.');
                })
                .then(blob => {
                    // Cria um link temporário para o download
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = filePath.split('/').pop(); // Pega o nome do arquivo do path
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url); // Libera o URL após o download
                })
                .catch(error => {
                    console.error("Erro na requisição:", error);
                    alert("Erro no download: " + error.message);
                });
            });
        });

    </script>


</body>
</html>
