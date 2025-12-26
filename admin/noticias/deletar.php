<?php
/**
 * Deletar Notícia
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Post.php';
require_once '../../includes/helpers/security.php';

$postModel = new Post();

// Buscar ID da notícia
$postId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$postId) {
    header('Location: /admin/noticias/index.php?erro=id_invalido');
    exit;
}

// Buscar notícia
$post = $postModel->getById($postId);

if (!$post) {
    header('Location: /admin/noticias/index.php?erro=nao_encontrado');
    exit;
}

$pageTitle = 'Deletar Notícia';

// Processar exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        header('Location: /admin/noticias/index.php?erro=csrf_invalido');
        exit;
    }

    try {
        // Deletar imagem do servidor
        if ($post['imagem_destaque'] && file_exists('../../' . $post['imagem_destaque'])) {
            unlink('../../' . $post['imagem_destaque']);
        }

        // Deletar notícia do banco
        $postModel->deletar($postId);

        // Registrar log
        registrarLog($ADMIN_ID, 'deletar', 'posts', $postId, 'Notícia deletada: ' . $post['titulo']);

        header('Location: /admin/noticias/index.php?msg=deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /admin/noticias/index.php?erro=' . urlencode($e->getMessage()));
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
    <link rel="stylesheet" href="/admin/assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/header.php'; ?>

        <main class="admin-content">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Deletar Notícia</h2>
                    <a href="/admin/noticias/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-error" style="margin-bottom: 2rem;">
                        <strong>⚠️ ATENÇÃO!</strong><br>
                        Esta ação é <strong>irreversível</strong>. A notícia será permanentemente excluída do sistema.
                    </div>

                    <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                        <h3 style="margin: 0 0 1rem 0; color: var(--gray-700);">Dados da Notícia:</h3>

                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600; width: 200px;">Título:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($post['titulo']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Categoria:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($post['categoria_nome'] ?? 'Sem categoria') ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Data de Criação:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?= date('d/m/Y \à\s H:i', strtotime($post['criado_em'])) ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Autor:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($post['autor_nome'] ?? 'Admin') ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Status:</td>
                                <td style="padding: 0.75rem 0;">
                                    <span class="badge status-<?= $post['status'] ?>">
                                        <?= ucfirst($post['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <?php if ($post['imagem_destaque']): ?>
                            <div style="margin-top: 1.5rem;">
                                <p style="font-weight: 600; margin-bottom: 0.5rem;">Imagem:</p>
                                <img src="/<?= htmlspecialchars($post['imagem_destaque']) ?>"
                                     alt="<?= htmlspecialchars($post['titulo']) ?>"
                                     style="max-width: 800px; height: auto; border: 2px solid var(--gray-300); border-radius: 8px;">
                            </div>
                        <?php endif; ?>

                        <?php if ($post['resumo']): ?>
                            <div style="margin-top: 1.5rem;">
                                <p style="font-weight: 600; margin-bottom: 0.5rem;">Resumo:</p>
                                <p style="color: var(--gray-600); line-height: 1.6;">
                                    <?= htmlspecialchars($post['resumo']) ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja deletar esta notícia? Esta ação não pode ser desfeita!');">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="id" value="<?= $postId ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                🗑️ Sim, Deletar Notícia
                            </button>
                            <a href="/admin/noticias/index.php" class="btn btn-secondary">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
