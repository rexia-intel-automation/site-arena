<?php
/**
 * Listar Eventos - Admin
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/functions.php';

$pageTitle = 'Eventos';

$eventoModel = new Evento();
$categoriaModel = new Categoria();

// Paginação
$porPagina = 20;
$paginaAtual = $_GET['pagina'] ?? 1;
$offset = ($paginaAtual - 1) * $porPagina;

// Filtros
$filtros = [];
if (!empty($_GET['status'])) {
    $filtros['status'] = $_GET['status'];
}
if (!empty($_GET['categoria'])) {
    $filtros['categoria_id'] = $_GET['categoria'];
}
if (!empty($_GET['busca'])) {
    $filtros['busca'] = $_GET['busca'];
}

$eventos = $eventoModel->getTodos($porPagina, $offset, $filtros);
$totalEventos = $eventoModel->contarTotal($filtros);
$totalPaginas = ceil($totalEventos / $porPagina);

// Buscar categorias para filtro
$categorias = $categoriaModel->getByTipo('evento');

// Mensagens
$mensagem = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Arena BRB Admin</title>
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
                    Evento criado com sucesso!
                </div>
            <?php elseif ($mensagem === 'atualizado'): ?>
                <div class="alert alert-success">
                    Evento atualizado com sucesso!
                </div>
            <?php elseif ($mensagem === 'deletado'): ?>
                <div class="alert alert-success">
                    Evento deletado com sucesso!
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Eventos (<?= $totalEventos ?>)</h2>
                    <a href="/admin/eventos/criar.php" class="btn btn-primary">
                        Novo Evento
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="form-row mb-3" style="margin-bottom: 1.5rem;">
                        <input type="text"
                               name="busca"
                               class="form-control"
                               placeholder="Buscar eventos..."
                               value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">

                        <select name="status" class="form-control">
                            <option value="">Todos os status</option>
                            <option value="publicado" <?= ($_GET['status'] ?? '') === 'publicado' ? 'selected' : '' ?>>Publicado</option>
                            <option value="rascunho" <?= ($_GET['status'] ?? '') === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
                            <option value="cancelado" <?= ($_GET['status'] ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>

                        <select name="categoria" class="form-control">
                            <option value="">Todas as categorias</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($_GET['categoria'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="/admin/eventos/index.php" class="btn btn-secondary">Limpar</a>
                    </form>

                    <!-- Tabela -->
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Imagem</th>
                                    <th>Título</th>
                                    <th>Data/Hora</th>
                                    <th>Local</th>
                                    <th>Categoria</th>
                                    <th>Status</th>
                                    <th>Visualizações</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($eventos)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 3rem; color: #6b7280;">
                                            Nenhum evento encontrado.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($eventos as $evento): ?>
                                    <tr>
                                        <td>
                                            <?php if ($evento['imagem_destaque']): ?>
                                                <img src="<?= htmlspecialchars($evento['imagem_destaque']) ?>"
                                                     alt=""
                                                     class="table-thumb">
                                            <?php else: ?>
                                                <div style="width: 80px; height: 45px; background: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                                    
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($evento['titulo']) ?></strong>
                                            <?php if ($evento['destaque']): ?>
                                                <span class="badge badge-warning" style="font-size: 0.7rem; margin-left: 0.5rem;">Destaque</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= formatarData($evento['data_evento']) ?><br>
                                            <small style="color: #6b7280;"><?= formatarHora($evento['hora_evento']) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($evento['local_nome']) ?></td>
                                        <td>
                                            <span class="badge" style="background-color: <?= $evento['categoria_cor'] ?>">
                                                <?= htmlspecialchars($evento['categoria_nome']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge status-<?= $evento['status'] ?>">
                                                <?= ucfirst($evento['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= number_format($evento['visualizacoes']) ?></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="/admin/eventos/editar.php?id=<?= $evento['id'] ?>"
                                                   class="action-btn edit"
                                                   title="Editar">
                                                    Editar
                                                </a>
                                                <a href="/eventos/<?= $evento['slug'] ?>"
                                                   class="action-btn view"
                                                   title="Ver no site"
                                                   target="_blank">
                                                    Ver
                                                </a>
                                                <button onclick="deletarEvento(<?= $evento['id'] ?>, '<?= htmlspecialchars($evento['titulo']) ?>')"
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

                    <!-- Paginação -->
                    <?php if ($totalPaginas > 1): ?>
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <a href="?pagina=<?= $i ?><?= !empty($_GET['status']) ? '&status=' . $_GET['status'] : '' ?><?= !empty($_GET['categoria']) ? '&categoria=' . $_GET['categoria'] : '' ?><?= !empty($_GET['busca']) ? '&busca=' . urlencode($_GET['busca']) : '' ?>"
                                   class="<?= $i == $paginaAtual ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function deletarEvento(id, titulo) {
            if (confirm(`Tem certeza que deseja deletar o evento "${titulo}"?\n\nEsta ação não pode ser desfeita.`)) {
                window.location.href = `/admin/eventos/deletar.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
