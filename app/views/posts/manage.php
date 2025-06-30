<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Posts | Painel Guardião</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/imgs/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Gerenciar Postagens</h2>
    <div class="text-end mb-3">
        <a href="<?= BASE_URL ?>/auth/dashboard" class="btn btn-secondary ">Voltar ao Painel</a>
    </div>
    <?php if (!empty($data['mensagem'])): ?>
        <div class="alert alert-info"><?= htmlspecialchars($data['mensagem']) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Publicado em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['posts'] as $post): ?>
                <tr>
                    <td><?= $post['id'] ?></td>
                    <td><?= htmlspecialchars($post['titulo']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($post['data_publicacao'])) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/posts/edit/<?= $post['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="<?= BASE_URL ?>/posts/delete/<?= $post['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este post?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</div>

</body>
</html>
