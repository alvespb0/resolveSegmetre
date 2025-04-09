<?php
session_start();

if (!isset($_SESSION['userName']) || $_SESSION['userName'] !== 'administrator') {
    // Redireciona o usuário não autorizado
    header("Location: https://{$_SERVER['HTTP_HOST']}/View/Login.php");
    exit(); // Garante que o código abaixo não será executado
}
require_once '../Controller/controllerUsuario.php';
require_once '../Controller/controllerFiles.php';
use controllers\ControllerFiles;
use controllers\ControllerUsuario;

$controllerUsuario = new ControllerUsuario;
$controllerFiles = new ControllerFiles;

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $controllerUsuario->deleteUsuario($id);
    $controllerFiles->deleteFiles($id);
    $controllerUsuario->deleteCompany($id);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

include('navbar.php');

$usuarios = $controllerUsuario->obtainUserNameASC2();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Cadastrados</title>
    <style>
        body {
            margin: 0;
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
            background-color: #DDEDEB; /* Verde suave para fundo */
            text-align: center;
            overflow: hidden; /* Remove a barra de rolagem da página */
        }

        .containerUsuarios {
            width: 900px;
            max-height: 70vh; /* Define altura máxima para evitar que passe da tela */
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            transition: 0.3s;
            /* Centralização absoluta */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .containerUsuarios:hover {
            transform: translate(-50%, -51%); 
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #1F7262; /* Cor do logo */
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .tabela-container {
            max-height: 400px; /* Define uma altura máxima */
            overflow-y: auto;  /* Adiciona rolagem apenas na tabela */
            border-radius: 8px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra interna para estética */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
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
            background: linear-gradient(135deg, rgb(255, 3, 3), rgb(178, 0, 0));
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
    <div class="containerUsuarios">
        <h2>Usuario Cadastrados</h2>
        <div class="tabela-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $user => $id) : ?>
            <tr>
                <td><?= $id ?></td>
                <td><?= htmlspecialchars($user) ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn-excluir" onclick="confirmarExclusao(<?= $id; ?>)">
                        excluir
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este usuario?")) {
                // Se o usuário confirmar, redireciona para a página com o parâmetro de exclusão
                window.location.href = "?excluir=" + id;
            }
        }
    </script>

</body>
</html>
