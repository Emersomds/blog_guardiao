<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Editar Usuário</h2>

    <form method="POST" action="<?= BASE_URL ?>/users/edit/<?= $data['usuario']['id'] ?>">
        <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?>">

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?= htmlspecialchars($data['usuario']['nome']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['usuario']['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Tipo de Usuário</label>
            <select name="role" id="role" class="form-select">
                <option value="admin" <?= $data['usuario']['role'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                <option value="user" <?= $data['usuario']['role'] === 'user' ? 'selected' : '' ?>>Usuário</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="<?= BASE_URL ?>/users/manage" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
