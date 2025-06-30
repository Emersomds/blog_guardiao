<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Novo Post | Painel Guardião</title>
    <link rel="icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container ">
        <h2 class="mb-4">Criar Novo Post</h2>
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

        <div class="d-flex justify-content-center">
            <div class="w-75">

                <form method="POST" action="<?= BASE_URL ?>/posts/create" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?? '' ?>">

                    <div class="mb-5">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="conteudo" class="form-label">Conteúdo</label>
                        <textarea name="conteudo" id="conteudo" class="form-control" rows="6" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem (opcional)</label>
                        <input type="file" name="imagem" id="imagem" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-success">Publicar</button>
                    <a href="<?= BASE_URL ?>/auth/dashboard" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

</body>

</html>