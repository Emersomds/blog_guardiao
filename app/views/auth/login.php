<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Login | Blog Guardião</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/public/assets/css/login.css" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <h2 class="mb-4 text-center">Administrativo</h2>

        <?php if (!empty($data['erro'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($data['erro']) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token']) ?>">

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus />
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

</body>
</html>
