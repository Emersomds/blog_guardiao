<!-- app/views/posts/edit.php -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/imgs/favicon.ico">
    <title>Editar Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>Editar Post</h2>
        <form method="POST" action="<?= BASE_URL ?>/posts/edit/<?= $data['post']['id'] ?>" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token'] ?>">
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($data['post']['titulo']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="conteudo" class="form-label">Conteúdo</label>
                <textarea name="conteudo" id="conteudo" rows="6" class="form-control" required><?= htmlspecialchars($data['post']['conteudo']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem (opcional)</label>
                <input type="file" name="imagem" id="imagem" class="form-control">
                <?php if (!empty($data['post']['imagem'])): ?>
                    <small>Imagem atual: <?= htmlspecialchars($data['post']['imagem']) ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="<?= BASE_URL ?>/posts/manage" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
