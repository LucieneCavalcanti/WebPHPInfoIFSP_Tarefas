<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gerenciamento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .page-header {
            margin: 20px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .action-icons a {
            margin-right: 10px;
            color: #333;
            text-decoration: none;
        }
        .action-icons a:hover {
            color: #007bff;
        }
        .search-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Sistema de Gerenciamento</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="listausuarios.php">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listacategorias.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listatarefas.php">Tarefas</a>
                    </li>
                    <?php if(isset($_SESSION['idUsuario'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="perfil.php">Meu Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
