<?php
/**
 * Listar Usuários - Admin
 * RESTRIÇÃO: Apenas administradores podem acessar
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Usuario.php';

// Verificar se é admin
if ($ADMIN_NIVEL !== 'admin') {
    header('Location: /admin/index.php?erro=sem_permissao');
    exit;
}

$pageTitle = 'Usuários';

$usuarioModel = new Usuario();

// Filtros
$filtros = [];
if (!empty($_GET['nivel'])) {
    $filtroNivel = $_GET['nivel'];
} else {
    $filtroNivel = '';
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

// Buscar todos os usuários
$todosUsuarios = $usuarioModel->getTodos();

// Aplicar filtros manualmente
$usuarios = array_filter($todosUsuarios, function($usuario) use ($filtroNivel, $filtroStatus, $filtroBusca) {
    // Filtro de nível
    if ($filtroNivel !== '' && $usuario['nivel_acesso'] !== $filtroNivel) {
        return false;
    }

    // Filtro de status
    if ($filtroStatus !== '') {
        $ativo = $filtroStatus === 'ativo' ? 1 : 0;
        if ($usuario['ativo'] != $ativo) {
            return false;
        }
    }

    // Filtro de busca
    if ($filtroBusca !== '') {
        $busca = strtolower($filtroBusca);
        $nome = strtolower($usuario['nome']);
        $email = strtolower($usuario['email']);
        if (strpos($nome, $busca) === false && strpos($email, $busca) === false) {
            return false;
        }
    }

    return true;
});

// Ordenação alfabética
usort($usuarios, function($a, $b) {
    return strcmp($a['nome'], $b['nome']);
});

$totalUsuarios = count($usuarios);

// Buscar quantidade de conteúdo criado por cada usuário
$db = Database::getInstance()->getConnection();
$usuarioStats = [];

foreach ($usuarios as $usuario) {
    $stmtEventos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE criado_por = :id");
    $stmtEventos->execute(['id' => $usuario['id']]);
    $eventos = $stmtEventos->fetch();

    $stmtPosts = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE criado_por = :id");
    $stmtPosts->execute(['id' => $usuario['id']]);
    $posts = $stmtPosts->fetch();

    $usuarioStats[$usuario['id']] = [
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
                    Usuário criado com sucesso!
                </div>
            <?php elseif ($mensagem === 'atualizado'): ?>
                <div class="alert alert-success">
                    Usuário atualizado com sucesso!
                </div>
            <?php elseif ($mensagem === 'deletado'): ?>
                <div class="alert alert-success">
                    Usuário deletado com sucesso!
                </div>
            <?php elseif ($mensagem === 'erro_proprio_usuario'): ?>
                <div class="alert alert-error">
                    Não é possível deletar o seu próprio usuário.
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Usuários Administrativos (<?= $totalUsuarios ?>)</h2>
                    <a href="/admin/usuarios/criar.php" class="btn btn-primary">
                        Novo Usuário
                    </a>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" class="form-row mb-3" style="margin-bottom: 1.5rem;">
                        <input type="text"
                               name="busca"
                               class="form-control"
                               placeholder="Buscar usuários..."
                               value="<?= htmlspecialchars($filtroBusca) ?>">

                        <select name="nivel" class="form-control">
                            <option value="">Todos os níveis</option>
                            <option value="admin" <?= $filtroNivel === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="editor" <?= $filtroNivel === 'editor' ? 'selected' : '' ?>>Editor</option>
                            <option value="moderador" <?= $filtroNivel === 'moderador' ? 'selected' : '' ?>>Moderador</option>
                        </select>

                        <select name="status" class="form-control">
                            <option value="">Todos os status</option>
                            <option value="ativo" <?= $filtroStatus === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                            <option value="inativo" <?= $filtroStatus === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="/admin/usuarios/index.php" class="btn btn-secondary">Limpar</a>
                    </form>

                    <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                        ℹ️ <strong>Níveis de acesso:</strong>
                        <span class="badge" style="background: #dc2626; margin-left: 0.5rem;">Admin</span> Acesso total |
                        <span class="badge" style="background: #2563eb; margin-left: 0.5rem;">Editor</span> Gerenciar conteúdo |
                        <span class="badge" style="background: #16a34a; margin-left: 0.5rem;">Moderador</span> Acesso básico
                    </div>

                    <!-- Tabela -->
                    <div class="table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Nível de Acesso</th>
                                    <th>Status</th>
                                    <th>Último Login</th>
                                    <th>Conteúdo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($usuarios)): ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 3rem; color: #6b7280;">
                                            Nenhum usuário encontrado.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($usuarios as $usuario): ?>
                                    <tr <?= $usuario['id'] == $ADMIN_ID ? 'style="background: #fef3c7;"' : '' ?>>
                                        <td>
                                            <strong><?= htmlspecialchars($usuario['nome']) ?></strong>
                                            <?php if ($usuario['id'] == $ADMIN_ID): ?>
                                                <span class="badge" style="background: #f59e0b; font-size: 0.7rem; margin-left: 0.5rem;">Você</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small style="color: #6b7280;">
                                                <?= htmlspecialchars($usuario['email']) ?>
                                            </small>
                                        </td>
                                        <td>
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
                                        <td>
                                            <span class="badge status-<?= $usuario['ativo'] ? 'publicado' : 'rascunho' ?>">
                                                <?= $usuario['ativo'] ? 'Ativo' : 'Inativo' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($usuario['ultimo_login']): ?>
                                                <small style="color: #6b7280;">
                                                    <?= date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) ?>
                                                </small>
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">Nunca</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $stats = $usuarioStats[$usuario['id']];
                                            $total = $stats['total'];
                                            ?>
                                            <?php if ($total > 0): ?>
                                                <div style="font-size: 0.875rem;">
                                                    <strong><?= $total ?></strong>
                                                    <br>
                                                    <small style="color: #6b7280;">
                                                        <?= $stats['eventos'] ?>ev / <?= $stats['posts'] ?>not
                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: #9ca3af;">0</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="/admin/usuarios/editar.php?id=<?= $usuario['id'] ?>"
                                                   class="action-btn edit"
                                                   title="Editar">
                                                    Editar
                                                </a>
                                                <?php if ($usuario['id'] != $ADMIN_ID): ?>
                                                    <button onclick="deletarUsuario(<?= $usuario['id'] ?>, '<?= htmlspecialchars($usuario['nome']) ?>')"
                                                            class="action-btn delete"
                                                            title="Deletar">
                                                        Deletar
                                                    </button>
                                                <?php else: ?>
                                                    <button class="action-btn delete"
                                                            disabled
                                                            title="Não pode deletar você mesmo"
                                                            style="opacity: 0.5; cursor: not-allowed;">
                                                        Deletar
                                                    </button>
                                                <?php endif; ?>
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
        function deletarUsuario(id, nome) {
            if (confirm(`Tem certeza que deseja deletar o usuário "${nome}"?\n\nEsta ação não pode ser desfeita.`)) {
                window.location.href = `/admin/usuarios/deletar.php?id=${id}`;
            }
        }
    </script>
</body>
</html>
