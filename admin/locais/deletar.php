<?php
/**
 * Deletar Local
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Local.php';
require_once '../../includes/helpers/security.php';

$localModel = new Local();

// Buscar ID do local
$localId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$localId) {
    header('Location: /admin/locais/index.php?erro=id_invalido');
    exit;
}

// Buscar local
$local = $localModel->getById($localId);

if (!$local) {
    header('Location: /admin/locais/index.php?erro=nao_encontrado');
    exit;
}

// Buscar estatísticas de eventos vinculados
$db = Database::getInstance()->getConnection();

$stmt = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE local_id = :id");
$stmt->execute(['id' => $localId]);
$totalEventos = $stmt->fetch()['total'];

$pageTitle = 'Deletar Local';

// Processar exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        header('Location: /admin/locais/index.php?erro=csrf_invalido');
        exit;
    }

    // Verificar se há eventos vinculados
    if ($totalEventos > 0) {
        header('Location: /admin/locais/index.php?msg=erro_vinculo');
        exit;
    }

    try {
        // Deletar local do banco
        $localModel->deletar($localId);

        // Registrar log
        registrarLog($ADMIN_ID, 'deletar', 'locais', $localId, 'Local deletado: ' . $local['nome']);

        header('Location: /admin/locais/index.php?msg=deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /admin/locais/index.php?erro=' . urlencode($e->getMessage()));
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
                    <h2 class="card-title">Deletar Local</h2>
                    <a href="/admin/locais/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($totalEventos > 0): ?>
                        <div class="alert alert-error" style="margin-bottom: 2rem;">
                            <strong>❌ IMPOSSÍVEL DELETAR!</strong><br>
                            Este local possui <strong><?= $totalEventos ?> evento(s) vinculado(s)</strong>.<br>
                            <br>
                            Para deletar este local, primeiro edite ou delete os eventos vinculados a ele.
                        </div>

                        <div class="d-flex gap-2">
                            <a href="/admin/locais/index.php" class="btn btn-primary">
                                ← Voltar para Locais
                            </a>
                            <a href="/admin/eventos/index.php" class="btn btn-secondary">
                                Ver Eventos
                            </a>
                        </div>

                    <?php else: ?>
                        <div class="alert alert-error" style="margin-bottom: 2rem;">
                            <strong>⚠️ ATENÇÃO!</strong><br>
                            Esta ação é <strong>irreversível</strong>. O local será permanentemente excluído do sistema.
                        </div>

                        <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                            <h3 style="margin: 0 0 1rem 0; color: var(--gray-700);">Dados do Local:</h3>

                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600; width: 200px;">Nome:</td>
                                    <td style="padding: 0.75rem 0;"><?= htmlspecialchars($local['nome']) ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Slug:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <code style="background: #f3f4f6; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                            <?= htmlspecialchars($local['slug']) ?>
                                        </code>
                                    </td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Tipo:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <?php
                                        $tipoLabels = [
                                            'arena' => 'Arena',
                                            'ginasio' => 'Ginásio',
                                            'estadio' => 'Estádio',
                                            'gramado' => 'Gramado',
                                            'outro' => 'Outro'
                                        ];
                                        echo htmlspecialchars($tipoLabels[$local['tipo']]);
                                        ?>
                                    </td>
                                </tr>
                                <?php if ($local['endereco']): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Endereço:</td>
                                    <td style="padding: 0.75rem 0;"><?= htmlspecialchars($local['endereco']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($local['capacidade']): ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Capacidade:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <?= number_format($local['capacidade'], 0, ',', '.') ?> pessoas
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Status:</td>
                                    <td style="padding: 0.75rem 0;">
                                        <span class="badge status-<?= $local['ativo'] ? 'publicado' : 'rascunho' ?>">
                                            <?= $local['ativo'] ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php if ($local['descricao']): ?>
                                <tr>
                                    <td style="padding: 0.75rem 0; font-weight: 600;">Descrição:</td>
                                    <td style="padding: 0.75rem 0;"><?= htmlspecialchars($local['descricao']) ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>

                        <form method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este local? Esta ação não pode ser desfeita!');">
                            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                            <input type="hidden" name="id" value="<?= $localId ?>">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">
                                    🗑️ Sim, Deletar Local
                                </button>
                                <a href="/admin/locais/index.php" class="btn btn-secondary">
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
