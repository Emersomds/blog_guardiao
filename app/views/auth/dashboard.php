<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Painel Administrativo - Guardião Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/assets/css/dashboard.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="p-3 bg-primary text-white">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?= BASE_URL ?>/public/assets/imgs/favicon.ico" alt="Logo" width="32" class="me-2">
                <h1 class="h5 m-0">Painel Admin - Guardião Digital</h1>
            </div>
            <nav class="nav nav-pills">
                <a class="nav-link text-white" href="<?= BASE_URL ?>/posts/create">Novo Post</a>
                <a class="nav-link text-white" href="<?= BASE_URL ?>/posts/manage">Gerenciar Posts</a>

                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <a class="nav-link text-white" href="<?= BASE_URL ?>/users/manage">Gerenciar Usuários</a>
                    <a class="nav-link text-white" href="<?= BASE_URL ?>/auth/logs">Logs</a>
                <?php endif; ?>

                <a class="nav-link text-warning" href="<?= BASE_URL ?>/auth/logout">Sair</a>
            </nav>
        </div>
    </header>


    <main class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total de Posts</h5>
                        <p class="card-text fs-4"><?= $data['totalPosts'] ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Usuários Cadastrados</h5>
                        <p class="card-text fs-4"><?= $data['totalUsers'] ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Acessos/Logs</h5>
                        <p class="card-text fs-4"><?= $data['totalLogs'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>


</body>

</html>