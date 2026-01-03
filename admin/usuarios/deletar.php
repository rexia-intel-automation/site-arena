<?php
/**
 * Deletar Usuário
 * RESTRIÇÃO: Apenas administradores
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Usuario.php';
require_once '../../includes/helpers/security.php';

// Verificar se é admin
if ($ADMIN_NIVEL !== 'admin') {
    header('Location: /admin/index.php?erro=sem_permissao');
    exit;
}

$usuarioModel = new Usuario();

// Buscar ID do usuário
$usuarioId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$usuarioId) {
    header('Location: /admin/usuarios/index.php?erro=id_invalido');
    exit;
}

// Não pode deletar próprio usuário
if ($usuarioId == $ADMIN_ID) {
    header('Location: /admin/usuarios/index.php?msg=erro_proprio_usuario');
    exit;
}

// Buscar usuário
$usuario = $usuarioModel->getById($usuarioId);

if (!$usuario) {
    header('Location: /admin/usuarios/index.php?erro=nao_encontrado');
    exit;
}

// Buscar estatísticas de conteúdo criado
$db = Database::getInstance()->getConnection();

$stmtEventos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE criado_por = :id");
$stmtEventos->execute(['id' => $usuarioId]);
$totalEventos = $stmtEventos->fetch()['total'];

$stmtPosts = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE criado_por = :id");
$stmtPosts->execute(['id' => $usuarioId]);
$totalPosts = $stmtPosts->fetch()['total'];

$totalConteudo = $totalEventos + $totalPosts;

$pageTitle = 'Deletar Usuário';

// Processar exclusão
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        header('Location: /admin/usuarios/index.php?erro=csrf_invalido');
        exit;
    }

    // Verificar novamente se não é o próprio usuário
    if ($usuarioId == $ADMIN_ID) {
        header('Location: /admin/usuarios/index.php?msg=erro_proprio_usuario');
        exit;
    }

    try {
        // Deletar usuário do banco
        $usuarioModel->deletar($usuarioId);

        // Registrar log
        registrarLog($ADMIN_ID, 'deletar', 'usuarios_admin', $usuarioId, 'Usuário deletado: ' . $usuario['nome']);

        header('Location: /admin/usuarios/index.php?msg=deletado');
        exit;
    } catch (Exception $e) {
        header('Location: /admin/usuarios/index.php?erro=' . urlencode($e->getMessage()));
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
                    <h2 class="card-title">Deletar Usuário</h2>
                    <a href="/admin/usuarios/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <div class="alert alert-error" style="margin-bottom: 2rem;">
                        <strong>⚠️ ATENÇÃO!</strong><br>
                        Esta ação é <strong>irreversível</strong>. O usuário será permanentemente excluído do sistema.
                    </div>

                    <?php if ($totalConteudo > 0): ?>
                        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                            ℹ️ <strong>Este usuário criou <?= $totalConteudo ?> conteúdo(s):</strong>
                            <?= $totalEventos ?> evento(s) e <?= $totalPosts ?> notícia(s).<br>
                            O conteúdo NÃO será deletado, apenas o usuário.
                        </div>
                    <?php endif; ?>

                    <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                        <h3 style="margin: 0 0 1rem 0; color: var(--gray-700);">Dados do Usuário:</h3>

                        <table style="width: 100%; border-collapse: collapse;">
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600; width: 200px;">Nome:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($usuario['nome']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Email:</td>
                                <td style="padding: 0.75rem 0;"><?= htmlspecialchars($usuario['email']) ?></td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Nível de Acesso:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?php
                                    $nivelLabels = [
                                        'admin' => 'Admin',
                                        'editor' => 'Editor',
                                        'moderador' => 'Moderador'
                                    ];
                                    $nivelColors = [
                                        'admin' => '#dc2626',
                                        'editor' => '#2563eb',
                                        'moderador' => '#16a34a'
                                    ];
                                    ?>
                                    <span class="badge" style="background-color: <?= $nivelColors[$usuario['nivel_acesso']] ?>">
                                        <?= $nivelLabels[$usuario['nivel_acesso']] ?>
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Status:</td>
                                <td style="padding: 0.75rem 0;">
                                    <span class="badge status-<?= $usuario['ativo'] ? 'publicado' : 'rascunho' ?>">
                                        <?= $usuario['ativo'] ? 'Ativo' : 'Inativo' ?>
                                    </span>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Criado em:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?>
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <td style="padding: 0.75rem 0; font-weight: 600;">Último login:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?php if ($usuario['ultimo_login']): ?>
                                        <?= date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) ?>
                                    <?php else: ?>
                                        <span style="color: #9ca3af;">Nunca</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0.75rem 0; font-weight: 600;">Conteúdo criado:</td>
                                <td style="padding: 0.75rem 0;">
                                    <?php if ($totalConteudo > 0): ?>
                                        <strong><?= $totalConteudo ?></strong> (<?= $totalEventos ?> eventos, <?= $totalPosts ?> notícias)
                                    <?php else: ?>
                                        <span style="color: #9ca3af;">Nenhum</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja deletar este usuário? Esta ação não pode ser desfeita!');">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
                        <input type="hidden" name="id" value="<?= $usuarioId ?>">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger">
                                🗑️ Sim, Deletar Usuário
                            </button>
                            <a href="/admin/usuarios/index.php" class="btn btn-secondary">
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
