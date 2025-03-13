<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <style>
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
        }
        .content {
            flex: 1;
        }
        .footer {
            background: linear-gradient(135deg, #1F7262, #3CA597); /* Cores ajustadas ao logo */
            color: white;
            text-align: center;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .footer a {
            color: #FFD700; /* Amarelo ouro para destacar links */
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }
        .footer a:hover {
            text-decoration: underline;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="content">
            <!-- Conteúdo da página aqui -->
        </div>
        <div class="footer">
            &copy; <?php echo date("Y"); ?> Segmetre Assessoria Ambiental. Todos os direitos reservados. | <a href="politica_privacidade.php">Política de Privacidade</a>
        </div>
    </div>
</body>
</html>
