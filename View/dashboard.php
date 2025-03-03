<?php
session_start();
echo $_SESSION['userName'];
echo $_SESSION['empresaId'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Empresa</title>
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
        <h2>Arquivos Disponíveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome do Arquivo</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Exame_123.pdf</td>
                    <td>25/02/2025</td>
                    <td><button class="btn-download">Download</button></td>
                </tr>
                <tr>
                    <td>ASO_456.pdf</td>
                    <td>24/02/2025</td>
                    <td><button class="btn-download">Download</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
