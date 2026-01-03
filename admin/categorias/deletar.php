<?php
/**
 * Deletar Categoria
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/security.php';

$categoriaModel = new Categoria();

// Buscar ID da categoria
$categoriaId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$categoriaId) {
    header('Location: /admin/categorias/index.php?erro=id_invalido');
    exit;
}

// Buscar categoria
$categoria = $categoriaModel->getById($categoriaId);

if (!$categoria) {
    header('Location: /admin/categorias/index.php?erro=nao_encontrado');
    exit;
}

// Buscar estatísticas de vinculação
$db = Database::getInstance()->getConnection();

$stmtEventos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE categoria_id = :id");
$stmtEventos->execute(['id' => $categoriaId]);
$totalEventos = $stmtEventos->fetch()['total'];

$stmtPosts = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE categoria_id = :id");
$stmtPosts->execute(['id' => $categoriaId]);
$totalPosts = $stmtPosts->fetch()['total'];

$totalVinculos = $totalEventos + $totalPosts;

$pageTitle = 'Deletar Categoria';

// Processar exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        header('Location: /admin/categorias/index.php?erro=csrf_invalido');
        exit;
    }

    // Verificar se há vínculos
    if ($totalVinculos > 0) {
        header('Location: /admin/categorias/index.php?msg=erro_vinculo');
        exit;
    }

    try {
        // Deletar categoria do banco
        $categoriaModel->deletar($categoriaId);

        // Registrar log
        registrarLog($ADMIN_ID, 'deletar', 'categorias', $categoriaId, 'Categoria deletada: ' . $categoria['nome']);

        header('Location: /admin/categorias/index.php?msg=deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /admin/categorias/index.php?erro=' . urlencode($e->getMessage()));
        exit;
    }
}

$csrfToken = gerarCSRFToken();
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
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Deletar Categoria</h2>
                    <a href="/admin/categorias/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($totalVinculos > 0): ?>
                        <div class="alert alert-error" style="margin-bottom: 2rem;">
                            <strong>❌ IMPOSSÍVEL DELETAR!</strong><br>
                            Esta categoria possui <strong><?= $totalVinculos ?> registro(s) vinculado(s)</strong>:
                            <ul style="margin: 0.5rem 0 0 1.5rem;">
                                <li><?= $totalEventos ?> evento(s)</li>
                                <li><?= $totalPosts ?> notícia(s)</li>
                            </ul>
                            <br>
                            Para deletar esta categoria, primeiro edite ou delete os registros vinculados a ela.
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/admin/categorias/index.php" class="btn btn-primary">
                                ← Voltar para Categorias
                            </a>
                            <a href="/admin/eventos/index.php?categoria=<?= $categoriaId ?>" class="btn btn-secondary">
                                Ver Eventos desta Categoria
                            </a>
                            <a href="/admin/noticias/index.php?categoria=<?= $categoriaId ?>" class="btn btn-secondary">
                                Ver Notícias desta Categoria
                            </a>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-error" style="margin-bottom: 2rem;">
                            <strong>⚠️ ATENÇÃO!</strong><br>
                            Esta ação é <strong>irreversível</strong>. A categoria será permanentemente excluída do sistema.
                        </div>

                        <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                            <h3 style="margin: 0 0 1rem 0; color: var(--gray-700);">Dados da Categoria:</h3>

                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600; width: 200px;">Nome:</td>
                                    <td style="padding: 0.75rem 0;"><?= htmlspecialchars($categoria['nome']) ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Slug:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                            <?= htmlspecialchars($categoria['slug']) ?>
                                        </code>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Tipo:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <?php
                                        $tipoLabels = [
                                            'evento' => 'Evento',
                                            'noticia' => 'Notícia',
                                            'ambos' => 'Ambos'
                                        ];
                                        echo htmlspecialchars($tipoLabels[$categoria['tipo']]);
                                        ?>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Cor:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <div style="width: 32px; height: 32px; border-radius: 4px; background-color: <?= htmlspecialchars($categoria['cor']) ?>; border: 2px solid #d1d5db;"></div>
                                            <code><?= htmlspecialchars($categoria['cor']) ?></code>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Status:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge status-<?= $categoria['ativo'] ? 'publicado' : 'rascunho' ?>">
                                            <?= $categoria['ativo'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php if ($categoria['descricao']): ?>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Descrição:</td>
                                    <td style="padding: 0.75rem 0;"><?= htmlspecialchars($categoria['descricao']) ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                        <form method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta categoria? Esta ação não pode ser desfeita!');">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <input type="hidden" name="id" value="<?= $categoriaId ?>">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">
                                    🗑️ Sim, Deletar Categoria
                                </button>
                                <a href="/admin/categorias/index.php" class="btn btn-secondary">
                                    ❌ Cancelar
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
