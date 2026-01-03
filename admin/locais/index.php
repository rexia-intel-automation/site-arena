<?php
/**
 * Listar Locais - Admin
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Local.php';

$pageTitle = 'Locais';

$localModel = new Local();

// Filtros
$filtros = [];
if (!empty($_GET['tipo'])) {
    $filtroTipo = $_GET['tipo'];
} else {
    $filtroTipo = '';
}

if (!empty($_GET['status'])) {
    $filtroStatus = $_GET['status'];
} else {
    $filtroStatus = '';
}

if (!empty($_GET['busca'])) {
    $filtroBusca = $_GET['busca'];
} else {
    $filtroBusca = '';
}

// Buscar todos os locais
$todosLocais = $localModel->getTodos();

// Aplicar filtros manualmente
$locais = array_filter($todosLocais, function($local) use ($filtroTipo, $filtroStatus, $filtroBusca) {
    // Filtro de tipo
    if ($filtroTipo !== '' && $local['tipo'] !== $filtroTipo) {
        return false;
    }

    // Filtro de status
    if ($filtroStatus !== '') {
        $ativo = $filtroStatus === 'ativo' ? 1 : 0;
        if ($local['ativo'] != $ativo) {
            return false;
        }
    }

    // Filtro de busca
    if ($filtroBusca !== '') {
        $busca = strtolower($filtroBusca);
        $nome = strtolower($local['nome']);
        $endereco = strtolower($local['endereco'] ?? '');
        if (strpos($nome, $busca) === false && strpos($endereco, $busca) === false) {
            return false;
        }
    }

    return true;
});

// Ordenação alfabética sempre
usort($locais, function($a, $b) {
    return strcmp($a['nome'], $b['nome']);
});

$totalLocais = count($locais);

// Buscar quantidade de eventos por local
$db = Database::getInstance()->getConnection();
$localStats = [];

foreach ($locais as $local) {
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE local_id = :id");
    $stmt->execute(['id' => $local['id']]);
    $eventos = $stmt->fetch();

    $localStats[$local['id']] = [
        'eventos' => $eventos['total']
    ];
}

// Mensagens
$mensagem = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Arena BRB Admin</title>
    <link rel="stylesheet" href="assets/css/design-system.css">
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
    <link rel="stylesheet" href="/admin/assets/css/admin-minimal.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/header.php'; ?>

        <main class="admin-content">
            <?php if ($mensagem === 'criado'): ?>
                <div class="alert alert-success">
                    Local criado com sucesso!
                </div>
            <?php elseif ($mensagem === 'atualizado'): ?>
                <div class="alert alert-success">
                    Local atualizado com sucesso!
                </div>
            <?php elseif ($mensagem === 'deletado'): ?>
                <div class="alert alert-success">
                    Local deletado com sucesso!
                </div>
            <?php elseif ($mensagem === 'erro_vinculo'): ?>
                <div class="alert alert-error">
                    Não é possível deletar este local pois existem eventos vinculados a ele.
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Locais (<?= $totalLocais ?>)</h2>
                    <a href="/admin/locais/criar.php" class="btn btn-primary">
                        Novo Local
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="form-row mb-3" style="margin-bottom: 1.5rem;">
                        <input type="text"
                               name="busca"
                               class="form-control"
                               placeholder="Buscar locais..."
                               value="<?= htmlspecialchars($filtroBusca) ?>">

                        <select name="tipo" class="form-control">
                            <option value="">Todos os tipos</option>
                            <option value="arena" <?= $filtroTipo === 'arena' ? 'selected' : '' ?>>Arena</option>
                            <option value="ginasio" <?= $filtroTipo === 'ginasio' ? 'selected' : '' ?>>Ginásio</option>
                            <option value="estadio" <?= $filtroTipo === 'estadio' ? 'selected' : '' ?>>Estádio</option>
                            <option value="gramado" <?= $filtroTipo === 'gramado' ? 'selected' : '' ?>>Gramado</option>
                            <option value="outro" <?= $filtroTipo === 'outro' ? 'selected' : '' ?>>Outro</option>
                        </select>

                        <select name="status" class="form-control">
                            <option value="">Todos os status</option>
                            <option value="ativo" <?= $filtroStatus === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= $filtroStatus === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="/admin/locais/index.php" class="btn btn-secondary">Limpar</a>
                    </form>

                    <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                        ℹ️ <strong>Ordenação:</strong> Os locais são sempre ordenados alfabeticamente por nome.
                    </div>

                    <!-- Tabela -->
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Tipo</th>
                                    <th>Endereço</th>
                                    <th>Capacidade</th>
                                    <th>Ordem</th>
                                    <th>Status</th>
                                    <th>Eventos</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($locais)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 3rem; color: #6b7280;">
                                            Nenhum local encontrado.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($locais as $local): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($local['nome']) ?></strong>
                                            <br>
                                            <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; color: #6b7280;">
                                                <?= htmlspecialchars($local['slug']) ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php
                                            $tipoLabels = [
                                                'arena' => 'Arena',
                                                'ginasio' => 'Ginásio',
                                                'estadio' => 'Estádio',
                                                'gramado' => 'Gramado',
                                                'outro' => 'Outro'
                                            ];
                                            $tipoColors = [
                                                'arena' => '#3b82f6',
                                                'ginasio' => '#10b981',
                                                'estadio' => '#f59e0b',
                                                'gramado' => '#84cc16',
                                                'outro' => '#6b7280'
                                            ];
                                            ?>
                                            <span class="badge" style="background-color: <?= $tipoColors[$local['tipo']] ?>">
                                                <?= $tipoLabels[$local['tipo']] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($local['endereco']): ?>
                                                <small style="color: #6b7280;">
                                                    <?= htmlspecialchars(mb_strimwidth($local['endereco'], 0, 50, '...')) ?>
                                                </small>
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($local['capacidade']): ?>
                                                <strong><?= number_format($local['capacidade'], 0, ',', '.') ?></strong>
                                                <small style="color: #6b7280;">pessoas</small>
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $local['ordem'] ?></td>
                                        <td>
                                            <span class="badge status-<?= $local['ativo'] ? 'publicado' : 'rascunho' ?>">
                                                <?= $local['ativo'] ? 'Ativo' : 'Inativo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $stats = $localStats[$local['id']];
                                            $total = $stats['eventos'];
                                            ?>
                                            <?php if ($total > 0): ?>
                                                <strong><?= $total ?></strong> evento(s)
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">Nenhum</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="/admin/locais/editar.php?id=<?= $local['id'] ?>"
                                                   class="action-btn edit"
                                                   title="Editar">
                                                    Editar
                                                </a>
                                                <button onclick="deletarLocal(<?= $local['id'] ?>, '<?= htmlspecialchars($local['nome']) ?>', <?= $total ?>)"
                                                        class="action-btn delete"
                                                        title="Deletar">
                                                    Deletar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function deletarLocal(id, nome, totalEventos) {
            if (totalEventos > 0) {
                alert(`⚠️ Não é possível deletar o local "${nome}".\n\nExistem ${totalEventos} evento(s) vinculado(s) a ele.\n\nPara deletar este local, primeiro edite ou delete os eventos vinculados.`);
                return;
            }

            if (confirm(`Tem certeza que deseja deletar o local "${nome}"?\n\nEsta ação não pode ser desfeita.`)) {
                window.location.href = `/admin/locais/deletar.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
