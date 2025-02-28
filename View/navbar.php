<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <style>

        .navbar {
            background: linear-gradient(135deg, #518076, #79a79a);
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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="login.php">Login</a>
            <a href="registro.php">Registro</a>
        </div>
        <div id="operadorMenu" class="hidden">
            <a href="cadastro_arquivo.php">Cadastro de Arquivo</a>
        </div>
    </div>
    <script>
        // Simulando sessão de usuário logado
        let usuarioLogado = "operador"; // Alterar para "usuario" para testar
        if (usuarioLogado === "operador") {
            document.getElementById("operadorMenu").classList.remove("hidden");
        }
    </script>
</body>
</html>