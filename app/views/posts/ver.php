<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title><?= htmlspecialchars($data['post']['titulo']) ?> | Blog Guardião</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
     <header class="p-3 bg-primary text-white">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="<?= BASE_URL ?>/public/assets/imgs/logo.png" alt="Logo do Blog" class="logo">
                <h1 class="ms-3 fs-4">Blog - Guardião Digital</h1>
            </div>
            <nav class="nav-menu">
                <a href="<?= BASE_URL ?>/home">Home</a>
                <a href="<?= BASE_URL ?>/sobre.php">Sobre</a>
            </nav>
        </div>
    </header>

    <div class="container py-5">
        <h1 class="mb-3"><?= htmlspecialchars($data['post']['titulo']) ?></h1>

        <?php if (!empty($data['post']['imagem'])): ?>
            <img src="<?= BASE_URL ?>/public/uploads/<?= htmlspecialchars($data['post']['imagem']) ?>" 
                 alt="Imagem do post" 
                 class="img-fluid mb-4" 
                 style="max-height: 400px; object-fit: cover;">
        <?php endif; ?>

        <p class="text-muted mb-3">
            Publicado em <?= date('d/m/Y H:i', strtotime($data['post']['data_publicacao'])) ?>
        </p>

        <div class="mb-5">
            <?= nl2br(htmlspecialchars($data['post']['conteudo'])) ?>
        </div>

        <a href="<?= BASE_URL ?>/home" class="btn btn-secondary">← Voltar</a>
    </div>

</body>
</html>
