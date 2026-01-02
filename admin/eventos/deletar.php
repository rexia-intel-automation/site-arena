<?php
/**
 * Deletar Evento
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/helpers/security.php';

$eventoModel = new Evento();

// Buscar ID do evento
$eventoId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$eventoId) {
    header('Location: /admin/eventos/index.php?erro=id_invalido');
    exit;
}

// Buscar evento
$evento = $eventoModel->getById($eventoId);

if (!$evento) {
    header('Location: /admin/eventos/index.php?erro=nao_encontrado');
    exit;
}

$pageTitle = 'Deletar Evento';

// Processar exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        header('Location: /admin/eventos/index.php?erro=csrf_invalido');
        exit;
    }

    try {
        // Deletar imagem do servidor
        if ($evento['imagem_destaque'] && file_exists('../../' . $evento['imagem_destaque'])) {
            unlink('../../' . $evento['imagem_destaque']);
        }

        // Deletar evento do banco
        $eventoModel->deletar($eventoId);

        // Registrar log
        registrarLog($ADMIN_ID, 'deletar', 'eventos', $eventoId, 'Evento deletado: ' . $evento['titulo']);

        header('Location: /admin/eventos/index.php?msg=deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /admin/eventos/index.php?erro=' . urlencode($e->getMessage()));
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
                    <h2 class="card-title">Deletar Evento</h2>
                    <a href="/admin/eventos/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-error" style="margin-bottom: 2rem;">
                        <strong>⚠️ ATENÇÃO!</strong><br>
                        Esta ação é <strong>irreversível</strong>. O evento será permanentemente excluído do sistema.
                    </div>

                    <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                        <h3 style="margin: 0 0 1rem 0; color: var(--gray-700);">Dados do Evento:</h3>

                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600; width: 200px;">Título:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($evento['titulo']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Data:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?= date('d/m/Y', strtotime($evento['data_evento'])) ?> às
                                    <?= date('H:i', strtotime($evento['hora_evento'])) ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Local:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($evento['local_nome']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Categoria:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($evento['categoria_nome']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Status:</td>
                                <td style="padding: 0.75rem 0;">
                                    <span class="badge status-<?= $evento['status'] ?>">
                                        <?= ucfirst($evento['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <?php if ($evento['imagem_destaque']): ?>
                            <div style="margin-top: 1.5rem;">
                                <p style="font-weight: 600; margin-bottom: 0.5rem;">Imagem:</p>
                                <img src="/<?= htmlspecialchars($evento['imagem_destaque']) ?>"
                                     alt="<?= htmlspecialchars($evento['titulo']) ?>"
                                     style="max-width: 475px; height: auto; border: 2px solid var(--gray-300); border-radius: 8px;">
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este evento? Esta ação não pode ser desfeita!');">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="id" value="<?= $eventoId ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                Deletar Sim, Deletar Evento
                            </button>
                            <a href="/admin/eventos/index.php" class="btn btn-secondary">
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
