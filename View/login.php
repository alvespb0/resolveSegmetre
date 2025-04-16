
<?php
    session_start();
    include_once('navbarLogin.php');
    $tokenMensagem = '';

    if (isset($_SESSION['tokenInvalido'])) {
        $tokenMensagem = $_SESSION['tokenInvalido'];
        unset($_SESSION['tokenInvalido']); 
    }

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="logo1.png">
    <title>Login</title>
    <style>
        /* Reset global styles */
        .login-body {
            margin: 0;
            background-color: #DDEDEB;
            height: 100vh;
            display: fixed;
            justify-content: center;
            align-items: center;
            overflow: hidden; 
        }

        /* Container do Login */
        .container-login {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -85px;
            width: 100%; 
            height: 100%; 
        }

        /* Caixa de Login */
        .login-box {
            background: #fefefe;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px; 
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Título */
        .login-title {
            font-family: Arial, sans-serif; 
            color: #518076;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Formulário de Login */
        .login-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Estilos para os campos de input */
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #79a79a;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        /* Efeito de foco nos campos */
        .input-field:focus {
            border-color: #518076;
            box-shadow: 0 0 8px rgba(81, 128, 118, 0.6);
        }

        /* Estilo para o botão de login */
        .btn-login {
            background: linear-gradient(135deg, #1F7262, #3CA597);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            width: 95%;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        /* Hover no botão */
        .btn-login:hover {
            transform: translateY(-3px);
        }

        /* Estilo para o campo select */
        .select-field {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #79a79a;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
        }

        /* Estilo para o label */
        .input-label {
            font-family: Arial, sans-serif; 
            color: #518076;
        }

    </style>
</head>
<body class="login-body">
    <?php if (!empty($tokenMensagem)): ?>
        <script>
            alert("<?= addslashes($tokenMensagem) ?>");
        </script>
    <?php endif; ?>
    <div class="container-login">
        <div class="login-box">
            <h2 class="login-title">Login</h2>
            <form id="formLogin" class="login-form">
                <input type="text" placeholder="Email" name="email" class="input-field" required>
                <input type="password" placeholder="Senha" name="senha" class="input-field" required>
                <label for="type" class="input-label"><b>Eu sou:</b></label>
                <select id="tipo" name="type" class="select-field" required>
                    <option value="operador">Funcionário Segmetre</option>
                    <option value="usuario">Cliente Segmetre</option>
                </select>
                <button class="btn-login" type="submit">Entrar</button>
            </form>
            <a href="solicitarRecuperacao.php" id="linkEsqueciSenha" style="display: none; margin-top: 10px; color: #1F7262; font-weight: bold;">
                Esqueci minha senha
            </a>
        </div>
    </div>


    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            const link = document.getElementById('linkEsqueciSenha');
            if (this.value === 'usuario') {
                link.style.display = 'block';
            } else {
                link.style.display = 'none';
            }
        });

        document.getElementById('formLogin').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });

            fetch('../Route/routeLogin.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);

                    fetch("../SetSession/setSession.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        userName: data.userName,
                        empresaId: data.empresaId,
                        operadorId: data.operadorId,
                        setor: data.setor,
                        type: data.type
                    })
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.success){
                            if (result.type === "recepcao") {
                                window.location.href = "dashboardOperador.php";
                            } else if(result.type === "usuario"){
                                window.location.href = "dashboard.php";
                            } else if(result.type === "medico"){
                                window.location.href = "telaMedica.php";
                            } else if(result.type === "financeiro"){
                                window.location.href = "financeiro.php";
                            } else if(result.type === 'admin'){
                                window.location.href = "dashboardOperador.php";
                            }
                        }
                        
                    })
                }
                if (data.error) {
                    alert(data.error);
                }
            })
            .catch((error) => {
                console.error('Erro:', error);
            });
        });
    </script>
    <?php include 'footer.php';?>
</body>
</html>
