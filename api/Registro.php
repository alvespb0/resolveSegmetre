<?php
include_once('navbar.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body{
            background-color: #f4f4f4;
        }
        .container1 {
            font-family: Arial, sans-serif;
            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fefefe;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            color: #518076;
        }
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input, select {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #79a79a;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }
        input:focus, select:focus {
            border-color: #518076;
            box-shadow: 0 0 8px rgba(81, 128, 118, 0.6);
        }
        .hidden {
            display: none;
        }
        button {
            background: #518076;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            width: 95%;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background: #79a79a;
        }
    </style>
</head>
<body>
    <div class="container1">
    <div class="container">
        <h2>Registro</h2>
            <form id="formCadastro">
                <input type="text" placeholder="Usuário" name="usuario" required>
                <input type="text" placeholder="Email" name="email" required>
                <input type="password" placeholder="Senha" name="senha" required>
                <select id="tipo" name="type" required>
                    <option value="operador">Operador</option>
                    <option value="usuario">Usuário</option>
                </select>
                <input type="text" id="cnpj" class="hidden" placeholder="CNPJ">
                <button type="submit">Registrar</button>
            </form>
    </div>
    <script>
        document.getElementById('formCadastro').addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o envio padrão do formulário

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        fetch('route.php', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data); 
        })
        .catch((error) => {
            console.error('Error:', error); // Caso ocorra algum erro
        });
        });
    </script>

    </div>
</body>
</html>

