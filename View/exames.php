<?php
session_start();
include_once('navbarAdministrador.php');

if (!isset($_SESSION['userName']) || $_SESSION['userName'] !== 'administrator') {
    header("Location: http://{$_SERVER['HTTP_HOST']}/resolvesegmetre/View/Login.php");
    exit(); 
}
require_once '../Controller/controllerFiles.php';
use controllers\ControllerFiles;

$controllerFiles = new ControllerFiles;

$files = $controllerFiles->obtainAllFiles();

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $controllerFiles->deleteFilesId($id);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames Cadastrados</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
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
            text-align: center;
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
        .btn-excluir {
            background: linear-gradient(135deg,rgb(255, 3, 3),rgb(178, 0, 0));
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-excluir:hover {
            background: linear-gradient(135deg, #165A50, #2B8A7A);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Exames Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>Data</th>
                    <th>Operador Id</th>
                    <th>Company  Id</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($files as $file) : ?>
            <tr>
                <td><?= $file['id'] ?></td>
                <td><?= htmlspecialchars($file['file_name']) ?></td>
                <td><?= htmlspecialchars($file['uploaded_at']) ?></td>
                <td><?= htmlspecialchars($file['operator_id']) ?></td>
                <td><?= htmlspecialchars($file['company_id']) ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn-excluir" onclick="confirmarExclusao(<?= $file['id']; ?>)">
                        excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

            </tbody>
        </table>
        <div class="pagination" id="pagination"></div>

    </div>
    <?php include 'footer.php'; ?>
    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este arquivo?")) {
                // Se o usuário confirmar, redireciona para a página com o parâmetro de exclusão
                window.location.href = "?excluir=" + id;
            }
        }
        
    </script>

</body>
</html>
