<?php
/**
 * Listar Categorias - Admin
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Categoria.php';

$pageTitle = 'Categorias';

$categoriaModel = new Categoria();

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

// Buscar todas as categorias
$todasCategorias = $categoriaModel->getTodas();

// Aplicar filtros manualmente
$categorias = array_filter($todasCategorias, function($cat) use ($filtroTipo, $filtroStatus, $filtroBusca) {
    // Filtro de tipo
    if ($filtroTipo !== '' && $cat['tipo'] !== $filtroTipo && $cat['tipo'] !== 'ambos') {
        return false;
    }

    // Filtro de status
    if ($filtroStatus !== '') {
        $ativo = $filtroStatus === 'ativo' ? 1 : 0;
        if ($cat['ativo'] != $ativo) {
            return false;
        }
    }

    // Filtro de busca
    if ($filtroBusca !== '') {
        $busca = strtolower($filtroBusca);
        $nome = strtolower($cat['nome']);
        if (strpos($nome, $busca) === false) {
            return false;
        }
    }

    return true;
});

// Ordenação alfabética sempre
usort($categorias, function($a, $b) {
    return strcmp($a['nome'], $b['nome']);
});

$totalCategorias = count($categorias);

// Buscar quantidade de eventos e posts por categoria
$db = Database::getInstance()->getConnection();
$categoriaStats = [];

foreach ($categorias as $cat) {
    $stmtEventos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE categoria_id = :id");
    $stmtEventos->execute(['id' => $cat['id']]);
    $eventos = $stmtEventos->fetch();

    $stmtPosts = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE categoria_id = :id");
    $stmtPosts->execute(['id' => $cat['id']]);
    $posts = $stmtPosts->fetch();

    $categoriaStats[$cat['id']] = [
        'eventos' => $eventos['total'],
        'posts' => $posts['total'],
        'total' => $eventos['total'] + $posts['total']
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
                    Categoria criada com sucesso!
                </div>
            <?php elseif ($mensagem === 'atualizado'): ?>
                <div class="alert alert-success">
                    Categoria atualizada com sucesso!
                </div>
            <?php elseif ($mensagem === 'deletado'): ?>
                <div class="alert alert-success">
                    Categoria deletada com sucesso!
                </div>
            <?php elseif ($mensagem === 'erro_vinculo'): ?>
                <div class="alert alert-error">
                    Não é possível deletar esta categoria pois existem registros vinculados a ela.
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Categorias (<?= $totalCategorias ?>)</h2>
                    <a href="/admin/categorias/criar.php" class="btn btn-primary">
                        Nova Categoria
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="form-row mb-3" style="margin-bottom: 1.5rem;">
                        <input type="text"
                               name="busca"
                               class="form-control"
                               placeholder="Buscar categorias..."
                               value="<?= htmlspecialchars($filtroBusca) ?>">

                        <select name="tipo" class="form-control">
                            <option value="">Todos os tipos</option>
                            <option value="evento" <?= $filtroTipo === 'evento' ? 'selected' : '' ?>>Evento</option>
                            <option value="noticia" <?= $filtroTipo === 'noticia' ? 'selected' : '' ?>>Notícia</option>
                            <option value="ambos" <?= $filtroTipo === 'ambos' ? 'selected' : '' ?>>Ambos</option>
                        </select>

                        <select name="status" class="form-control">
                            <option value="">Todos os status</option>
                            <option value="ativo" <?= $filtroStatus === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= $filtroStatus === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="/admin/categorias/index.php" class="btn btn-secondary">Limpar</a>
                    </form>

                    <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                        ℹ️ <strong>Ordenação:</strong> As categorias são sempre ordenadas alfabeticamente por nome.
                    </div>

                    <!-- Tabela -->
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Slug</th>
                                    <th>Tipo</th>
                                    <th>Cor</th>
                                    <th>Ordem</th>
                                    <th>Status</th>
                                    <th>Vinculações</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($categorias)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 3rem; color: #6b7280;">
                                            Nenhuma categoria encontrada.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($categorias as $categoria): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($categoria['nome']) ?></strong>
                                        </td>
                                        <td>
                                            <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">
                                                <?= htmlspecialchars($categoria['slug']) ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php
                                            $tipoLabels = [
                                                'evento' => 'Evento',
                                                'noticia' => 'Notícia',
                                                'ambos' => 'Ambos'
                                            ];
                                            $tipoColors = [
                                                'evento' => '#3b82f6',
                                                'noticia' => '#10b981',
                                                'ambos' => '#8b5cf6'
                                            ];
                                            ?>
                                            <span class="badge" style="background-color: <?= $tipoColors[$categoria['tipo']] ?>">
                                                <?= $tipoLabels[$categoria['tipo']] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <div style="width: 24px; height: 24px; border-radius: 4px; background-color: <?= htmlspecialchars($categoria['cor']) ?>; border: 1px solid #d1d5db;"></div>
                                                <code style="font-size: 0.75rem; color: #6b7280;">
                                                    <?= htmlspecialchars($categoria['cor']) ?>
                                                </code>
                                            </div>
                                        </td>
                                        <td><?= $categoria['ordem'] ?></td>
                                        <td>
                                            <span class="badge status-<?= $categoria['ativo'] ? 'publicado' : 'rascunho' ?>">
                                                <?= $categoria['ativo'] ? 'Ativo' : 'Inativo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                            $stats = $categoriaStats[$categoria['id']];
                                            $total = $stats['total'];
                                            ?>
                                            <div style="font-size: 0.875rem;">
                                                <?php if ($total > 0): ?>
                                                    <strong><?= $total ?></strong> registro(s)
                                                    <br>
                                                    <small style="color: #6b7280;">
                                                        <?= $stats['eventos'] ?> evento(s), <?= $stats['posts'] ?> notícia(s)
                                                    </small>
                                                <?php else: ?>
                                                    <span style="color: #9ca3af;">Nenhum</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="/admin/categorias/editar.php?id=<?= $categoria['id'] ?>"
                                                   class="action-btn edit"
                                                   title="Editar">
                                                    Editar
                                                </a>
                                                <button onclick="deletarCategoria(<?= $categoria['id'] ?>, '<?= htmlspecialchars($categoria['nome']) ?>', <?= $stats['total'] ?>)"
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
        function deletarCategoria(id, nome, totalVinculos) {
            if (totalVinculos > 0) {
                alert(`⚠️ Não é possível deletar a categoria "${nome}".\n\nExistem ${totalVinculos} registro(s) vinculado(s) a ela (eventos ou notícias).\n\nPara deletar esta categoria, primeiro edite ou delete os registros vinculados.`);
                return;
            }

            if (confirm(`Tem certeza que deseja deletar a categoria "${nome}"?\n\nEsta ação não pode ser desfeita.`)) {
                window.location.href = `/admin/categorias/deletar.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
