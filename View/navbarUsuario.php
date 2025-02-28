<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Usuário</title>
    <style>
        .navbar {
            background: linear-gradient(135deg, #518076, #79a79a);
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
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
        }
        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
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
            <a href="logout.php">Sair</a>
        </div>
    </div>
</body>
</html>
