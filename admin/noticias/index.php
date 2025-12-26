<?php
/**
 * Listar Notícias - Painel Administrativo
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Post.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/functions.php';

$pageTitle = 'Gerenciar Notícias';

$postModel = new Post();
$categoriaModel = new Categoria();

// Filtros
$filtros = [];
$status = $_GET['status'] ?? '';
$categoriaId = $_GET['categoria_id'] ?? '';
$busca = $_GET['busca'] ?? '';

if ($status) {
    $filtros['status'] = $status;
}

if ($categoriaId) {
    $filtros['categoria_id'] = $categoriaId;
}

if ($busca) {
    $filtros['busca'] = $busca;
}

// Paginação
$paginaAtual = $_GET['pagina'] ?? 1;
$itensPorPagina = 15;

// Buscar posts
$posts = $postModel->listar($filtros, $paginaAtual, $itensPorPagina);
$totalPosts = $postModel->contarTotal($filtros);
$totalPaginas = ceil($totalPosts / $itensPorPagina);

// Buscar categorias para filtro
$categorias = $categoriaModel->getByTipo('noticia');

// Mensagens de feedback
$mensagem = '';
$tipoMensagem = '';

if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'criado':
            $mensagem = 'Notícia criada com sucesso!';
            $tipoMensagem = 'success';
            break;
        case 'atualizado':
            $mensagem = 'Notícia atualizada com sucesso!';
            $tipoMensagem = 'success';
            break;
        case 'deletado':
            $mensagem = 'Notícia deletada com sucesso!';
            $tipoMensagem = 'success';
            break;
    }
}

if (isset($_GET['erro'])) {
    $mensagem = 'Ocorreu um erro: ' . htmlspecialchars($_GET['erro']);
    $tipoMensagem = 'error';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Arena BRB Admin</title>
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/header.php'; ?>

        <main class="admin-content">
            <!-- Header da Página -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">📰 Notícias</h1>
                    <p class="page-subtitle">Gerencie todas as notícias do site</p>
                </div>
                <a href="/admin/noticias/criar.php" class="btn btn-primary">
                    ➕ Nova Notícia
                </a>
            </div>

            <!-- Mensagens -->
            <?php if ($mensagem): ?>
                <div class="alert alert-<?= $tipoMensagem ?>">
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>

            <!-- Filtros -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-body">
                    <form method="GET" class="filters-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Todos os status</option>
                                    <option value="publicado" <?= $status === 'publicado' ? 'selected' : '' ?>>Publicado</option>
                                    <option value="rascunho" <?= $status === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="categoria_id">Categoria</label>
                                <select name="categoria_id" id="categoria_id" class="form-control">
                                    <option value="">Todas as categorias</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $categoriaId == $cat['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" style="flex: 2;">
                                <label for="busca">Buscar</label>
                                <input type="text"
                                       name="busca"
                                       id="busca"
                                       class="form-control"
                                       placeholder="Buscar por título..."
                                       value="<?= htmlspecialchars($busca) ?>">
                            </div>

                            <div class="form-group" style="display: flex; align-items: flex-end;">
                                <button type="submit" class="btn btn-primary" style="margin-right: 0.5rem;">
                                    🔍 Filtrar
                                </button>
                                <a href="/admin/noticias/index.php" class="btn btn-secondary">
                                    🔄 Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Notícias -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        Total: <?= $totalPosts ?> <?= $totalPosts === 1 ? 'notícia' : 'notícias' ?>
                    </h2>
                </div>

                <div class="card-body" style="padding: 0;">
                    <?php if (empty($posts)): ?>
                        <div style="text-align: center; padding: 3rem; color: var(--gray-500);">
                            <p style="font-size: 3rem; margin: 0;">📰</p>
                            <p style="margin: 1rem 0 0 0; font-size: 1.125rem;">Nenhuma notícia encontrada</p>
                            <?php if (!empty($filtros)): ?>
                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-400);">Tente ajustar os filtros</p>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">Imagem</th>
                                        <th>Título</th>
                                        <th style="width: 150px;">Categoria</th>
                                        <th style="width: 150px;">Autor</th>
                                        <th style="width: 130px;">Data</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 180px; text-align: center;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post): ?>
                                        <tr>
                                            <td>
                                                <?php if ($post['imagem_destaque']): ?>
                                                    <img src="/<?= htmlspecialchars($post['imagem_destaque']) ?>"
                                                         alt="<?= htmlspecialchars($post['titulo']) ?>"
                                                         style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                <?php else: ?>
                                                    <div style="width: 60px; height: 40px; background: var(--gray-200); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: var(--gray-400); font-size: 1.5rem;">
                                                        📰
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($post['titulo']) ?></strong>
                                                <?php if ($post['destaque']): ?>
                                                    <span style="color: var(--warning); margin-left: 0.5rem;" title="Em destaque">⭐</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge" style="background: var(--info); color: white;">
                                                    <?= htmlspecialchars($post['categoria_nome'] ?? 'Sem categoria') ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small style="color: var(--gray-600);">
                                                    <?= htmlspecialchars($post['autor_nome'] ?? 'Admin') ?>
                                                </small>
                                            </td>
                                            <td>
                                                <small style="color: var(--gray-600);">
                                                    <?= formatarDataHora($post['criado_em']) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge status-<?= $post['status'] ?>">
                                                    <?= ucfirst($post['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="/noticias/<?= $post['slug'] ?>"
                                                       class="btn btn-sm btn-secondary"
                                                       title="Visualizar"
                                                       target="_blank">
                                                        👁️
                                                    </a>
                                                    <a href="/admin/noticias/editar.php?id=<?= $post['id'] ?>"
                                                       class="btn btn-sm btn-primary"
                                                       title="Editar">
                                                        ✏️
                                                    </a>
                                                    <a href="/admin/noticias/deletar.php?id=<?= $post['id'] ?>"
                                                       class="btn btn-sm btn-danger"
                                                       title="Deletar">
                                                        🗑️
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação -->
                        <?php if ($totalPaginas > 1): ?>
                            <div class="pagination">
                                <?php
                                $queryString = $_GET;
                                unset($queryString['pagina']);
                                $queryBase = !empty($queryString) ? '&' . http_build_query($queryString) : '';
                                ?>

                                <?php if ($paginaAtual > 1): ?>
                                    <a href="?pagina=<?= $paginaAtual - 1 ?><?= $queryBase ?>" class="pagination-link">
                                        ← Anterior
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <?php if ($i == $paginaAtual): ?>
                                        <span class="pagination-link active"><?= $i ?></span>
                                    <?php elseif ($i == 1 || $i == $totalPaginas || abs($i - $paginaAtual) <= 2): ?>
                                        <a href="?pagina=<?= $i ?><?= $queryBase ?>" class="pagination-link">
                                            <?= $i ?>
                                        </a>
                                    <?php elseif (abs($i - $paginaAtual) == 3): ?>
                                        <span class="pagination-link">...</span>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <?php if ($paginaAtual < $totalPaginas): ?>
                                    <a href="?pagina=<?= $paginaAtual + 1 ?><?= $queryBase ?>" class="pagination-link">
                                        Próxima →
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
