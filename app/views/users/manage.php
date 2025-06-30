<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Usuários | Painel Guardião</title>
    <link rel="icon" href="<?= BASE_URL ?>/public/assets/imgs/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Usuários</h2>
            <div class="btn-fm">
                <a href="<?= BASE_URL ?>/auth/dashboard" class="btn btn-secondary">Voltar ao Painel</a>
                <a href="<?= BASE_URL ?>/users/create" class="btn btn-primary">Novo Usuário</a>
            </div>
        </div>

        <table class="table table-bordered table-hover bg-white shadow-sm">
            <?php if (!empty($data['mensagem'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($data['mensagem']) ?>
                </div>
            <?php endif; ?>
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['usuarios'] as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?></td>
                        <td>
                            <!-- Ações futuras -->
                        <td>
                            <a href="<?= BASE_URL ?>/users/edit/<?= $usuario['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?= BASE_URL ?>/users/delete/<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (empty($data['usuarios'])): ?>
            <div class="alert alert-info">Nenhum usuário cadastrado.</div>
        <?php endif; ?>
    </div>

</body>

</html>