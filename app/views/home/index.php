<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Guardião Digital - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/public/assets/css/style.css" rel="stylesheet">

</head>

<body>

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

    <div class="container my-5">

        <?php foreach ($data['posts'] as $post): ?>
            <article>
                <?php if (!empty($post['imagem'])): ?>
                    <div>
                        <img src="<?= BASE_URL ?>/public/uploads/<?= htmlspecialchars($post['imagem']) ?>" alt="Imagem do post">
                    </div>
                <?php endif; ?>

                <div>
                    <h2><?= htmlspecialchars($post['titulo']) ?></h2>
                    <p><?= substr(strip_tags($post['conteudo']), 0, 100) ?>...</p>

                    <?php if (!empty($post['data_publicacao'])): ?>
                        <p><small>Publicado em <?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?></small></p>
                    <?php endif; ?>

                    <p><a href="<?= BASE_URL ?>/posts/ver/<?= $post['id'] ?>">Ler mais</a></p>
                </div>
            </article>
        <?php endforeach; ?>

        <!-- Paginação -->
        <?php if (!empty($data['totalPaginas']) && $data['totalPaginas'] > 1): ?>
            <div class="paginacao">
                <?php if ($data['pagina'] > 1): ?>
                    <a href="?pagina=<?= $data['pagina'] - 1 ?>">&laquo; Anterior</a>
                <?php endif; ?>

                <span>Página <?= $data['pagina'] ?> de <?= $data['totalPaginas'] ?></span>

                <?php if ($data['pagina'] < $data['totalPaginas']): ?>
                    <a href="?pagina=<?= $data['pagina'] + 1 ?>">Próxima &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>