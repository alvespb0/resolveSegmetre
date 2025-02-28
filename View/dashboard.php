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
            background-color: #eef2f3;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
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
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
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
            background: linear-gradient(135deg, #518076, #79a79a);
            color: white;
            font-size: 16px;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-download {
            background: linear-gradient(135deg, #518076, #79a79a);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: bold;
        }
        .btn-download:hover {
            background: linear-gradient(135deg, #406659, #5c8b7f);
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
