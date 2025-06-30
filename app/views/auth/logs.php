<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico">
    <title>Logs | Painel Guardião</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4">Logs do Sistema</h2>
        <div class="text-end mb-3">
            <a href="<?= BASE_URL ?>/auth/dashboard" class="btn btn-secondary">Voltar ao Painel</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Ação</th>
                    <th>IP</th>
                    <th>Agente</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['logs'] as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= htmlspecialchars($log['nome_usuario'] ?? 'Desconhecido') ?></td>
                        <td><?= htmlspecialchars($log['acao']) ?></td>
                        <td><?= $log['ip'] ?></td>
                        <td><?= htmlspecialchars($log['user_agent']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($log['data_hora'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <?php if ($data['pagina'] > 1): ?>
                <a href="?pagina=<?= $data['pagina'] - 1 ?>" class="btn btn-outline-primary me-2">&laquo; Anterior</a>
            <?php endif; ?>

            <span>Página <?= $data['pagina'] ?> de <?= $data['totalPaginas'] ?></span>

            <?php if ($data['pagina'] < $data['totalPaginas']): ?>
                <a href="?pagina=<?= $data['pagina'] + 1 ?>" class="btn btn-outline-primary ms-2">Próxima &raquo;</a>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>