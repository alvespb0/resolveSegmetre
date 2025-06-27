
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="icon" type="image/png" href="logo1.png">

    <style>
        :root {
            --primary-color: #1F7262;
            --secondary-color: #3CA597;
            --dark-color: #2C3E50;
            --light-color: #ECF0F1;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
        }

        .dropdown-item {
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-color);
            transform: translatey(-1px);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.1);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 1rem;
            }

            .nav-link {
                padding: 0.8rem 1rem;
            }

            .user-info {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <?php if($_SESSION['type'] == 'recepcao' || $_SESSION['type'] == 'admin'){?>
            <a class="navbar-brand" href="dashboardOperador.php">
                <img src="logo1.png" alt="Segmetre Logo">
                Segmetre
            </a>
            <?php }else{ ?>
            <a class="navbar-brand" href="dashboard.php">
                <img src="logo1.png" alt="Segmetre Logo">
                Segmetre
            </a>
            <?php }?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (isset($_SESSION['userName'])): ?>
                        <?php if ($_SESSION['userName'] === 'administrator'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="Registro.php">
                                    <i class="bi bi-speedometer2 me-1"></i> Registro
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="usuarios.php">
                                    <i class="bi bi-people me-1"></i> Usuários
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="operadores.php">
                                    <i class="bi bi-person-badge me-1"></i> Operadores
                                </a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="exames.php?pagina=1">
                            <i class="bi bi-file-earmark-text me-1"></i> Exames
                                </a>
                            </li>
                        <?php elseif ($_SESSION['type'] === 'recepcao'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboardOperador.php">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="exames.php?pagina=1">
                                    <i class="bi bi-clipboard-pulse me-1"></i> Exames Cadastrados
                                </a>
                            </li>
   
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="Login.php">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contato.php">
                                <i class="bi bi-envelope me-1"></i> Contato
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (isset($_SESSION['userName'])): ?>
                    <div class="user-info">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-white text-decoration-none dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <?php echo $_SESSION['userName']; ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="../setSession/logout.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
