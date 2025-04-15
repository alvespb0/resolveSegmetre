<?php
session_start();
if (!isset($_SESSION['userName']) || $_SESSION['userName'] !== 'administrator') {
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit(); 
}

require_once '../Controller/controllerFiles.php';
require_once '../Controller/controllerUsuario.php';

use controllers\ControllerUsuario;
use controllers\ControllerFiles;

$controllerUsuario = new ControllerUsuario;
$controllerFiles = new ControllerFiles;

$filterDate = isset($_GET['filterDate']) ? $_GET['filterDate'] : '';
$filterSearch = isset($_GET['search']) ? $_GET['search'] : '';
$totalPaginas = $controllerFiles->obtainNumberPages();

$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaAtual - 1) * 20;

$maxLinks = 3; // Quantidade de páginas visíveis
$inicio = max($paginaAtual - 1, 1);
$fim = min($paginaAtual + 1, $totalPaginas);

// Corrigir se estiver no início ou final
if ($paginaAtual <= 2) {
    $fim = min(3, $totalPaginas);
}
if ($paginaAtual >= $totalPaginas - 1) {
    $inicio = max($totalPaginas - 2, 1);
}

if ($filterDate) {
    $files = $controllerFiles->obtainFilesByDate($filterDate);
} elseif ($filterSearch) {
    $files = $controllerFiles->obtainFilesBySearch($filterSearch);
} else {
    $files = $controllerFiles->obtainFilesByPage($offset);
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $controllerFiles->deleteFilesId($id);
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/exames.php");
    exit();
}
include_once('navbar.php');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="logo1.png">
    <title>Exames Cadastrados</title>
    <style>
        body {
            height: 100%;
            margin: 0;
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
            background-color: #DDEDEB; /* Verde suave para fundo */
            text-align: center;
            overflow: hidden; /* Remove a barra de rolagem do body */
            flex-direction: column;
        }
        .containerExames {
            max-width: 1150px;
            margin: 35px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
            flex-grow: 1;
            justify-content: center; /* Centraliza verticalmente */
            align-items: center; /* Centraliza horizontalmente */

        }
        .containerExames:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #1F7262; /* Cor do logo */
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .table-container {
            max-height: 350px; /* Limite de altura */
            overflow-y: auto; /* Rolagem vertical */
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
        .search-bar {
            position: relative;
            display: inline-flex;
            width: 100%;
         }
        .search-bar input[type="text"] {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 6px 0 0 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .search-bar button {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }
        .search-bar button:hover {
            background: linear-gradient(135deg, #165A50, #2B8A7A);
            transform: scale(1.05);
        }
        .search-bar .fa-search {
            margin-right: 5px;
        }
        .pagination-link {
            display: inline-block;
            padding: 10px 15px;
            margin: 0 5px;
            min-width: 40px;
            text-align: center;
            border: 1px solid #1F7262;
            border-radius: 8px;
            color: #1F7262;
            text-decoration: none;
            font-weight: 500;
            background-color: white;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination-link:hover {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .pagination-link.active {
            background: #1F7262;
            color: white;
            font-weight: bold;
        }


    </style>
</head>
<body>
    <div class="containerExames">
    <?php if(is_array($files)){?>
        <h2>Exames Cadastrados</h2>
        <form action="" method = "GET">
        <div class="search-bar">
            <input type="text" placeholder="Buscar Exame..." name="search">
            <button type="submit">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        </form>
        <div class="table-container">
        <table id = "examTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Filename</th>
                    <th>
                        Data
                        <i class="fas fa-calendar-alt calendar-icon" onclick="document.getElementById('filterDate').style.display = 'inline-block';"></i>

                        <form action="" METHOD = "GET">
                        <input type="date" id="filterDate" style="display:none;" onchange="this.form.submit();" name="filterDate" />
                        </form>
                    </th>
                    <th>Operador Id</th>
                    <th>Company  Id</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(count($files) > 0){ 
                foreach ($files as $file) : ?>
            <tr>
                <td><?= $file['id'] ?></td>
                <td><?= htmlspecialchars($file['file_name']) ?></td>
                <td><?= htmlspecialchars($file['uploaded_at']) ?></td>
                <td><?= htmlspecialchars($file['operator_id']) ?></td>
                <td><?= htmlspecialchars($controllerUsuario->getUserNameByIdCompany($file['company_id'])); ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn-excluir" onclick="confirmarExclusao(<?= $file['id']; ?>)">
                        excluir
                    </a>
                </td>
            </tr>
        <?php endforeach;}else {echo "<tr><td colspan='10' style='text-align: center;'>Nenhum Arquivo Disponível para esta Data</td></tr>";}} else{ echo "<h2>Nenhum Arquivo Disponível!</h2>"; } ?>
            </tbody>
        </table>
        </div>
        <!-- PARTE DE PAGINAÇÃO -->
        <div style="margin-top: 20px;">
        <?php if ($paginaAtual > 1): ?>
        <a href="?pagina=<?= $paginaAtual - 1 ?>" class="pagination-link">«</a>
        <?php endif; ?>

        <?php for ($i = $inicio; $i <= $fim; $i++): ?>
            <a href="?pagina=<?= $i ?>" class="pagination-link <?= $i == $paginaAtual ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($fim < $totalPaginas): ?>
            <span class="pagination-link">...</span>
            <a href="?pagina=<?= $totalPaginas ?>" class="pagination-link"><?= $totalPaginas ?></a>
        <?php endif; ?>

        <?php if ($paginaAtual < $totalPaginas): ?>
            <a href="?pagina=<?= $paginaAtual + 1 ?>" class="pagination-link">»</a>
        <?php endif; ?>

        </div>
        <!-- FIM DA PAGINAÇÃO -->
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
