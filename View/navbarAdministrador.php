<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Usuário</title>
    <style>
        .navbar {
            background: linear-gradient(135deg, #1F7262, #3CA597); /* Cores do logo */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 0 0 12px 12px;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }
        .navbar .user-info {
            display: flex;
            align-items: center;
        }
        .navbar .user-info span {
            margin-right: 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .navbar a {
            color: #FFD700; /* Amarelo ouro para destaque */
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
            font-weight: bold;
        }
        .navbar a:hover {
            background: rgba(255, 215, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="user-info">
            <span>Olá, <?php echo $_SESSION['userName']; ?>!</span>
        </div>
        <div>
            <a href="Registro.php">Registro</a>
            <a href="../setSession/logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
