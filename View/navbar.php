<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>
        .navbar {
            background: linear-gradient(135deg, #1F7262, #3CA597); /* Tons baseados no logo */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border-radius: 0 0 12px 12px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s ease-in-out;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        .navbar-brand img {
            height: 35px;
        }

        .menu {
            display: flex;
            align-items: center;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="navbar-brand">
            <img src="logo1.png" alt="Logo" >
        </a>
        <div class="menu">
            <a href="login.php">Login</a>
            <a href="sobre.php">Sobre</a>
            <a href="contato.php">Contato</a>
        </div>
    </div>
</body>
</html>
