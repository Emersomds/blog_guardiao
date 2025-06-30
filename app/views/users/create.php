<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Novo Usuário | Painel Guardião</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Criar Novo Usuário</h2>
        <?php if (!empty($data['erros'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($data['erros'] as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['mensagem'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($data['mensagem']) ?></div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>/users/create">
            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?? '' ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required />
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Perfil</label>
                <select name="role" id="role" class="form-select">
                    <option value="user" selected>Usuário</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Criar Usuário</button>
            <a href="<?= BASE_URL ?>/users/manage" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>

</html>