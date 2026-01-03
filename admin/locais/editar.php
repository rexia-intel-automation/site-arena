<?php
/**
 * Editar Local
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Local.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Editar Local';

$localModel = new Local();

// Validar ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /admin/locais/index.php');
    exit;
}

// Buscar local
$local = $localModel->getById($id);
if (!$local) {
    header('Location: /admin/locais/index.php');
    exit;
}

// Buscar estatísticas de eventos vinculados
$db = Database::getInstance()->getConnection();

$stmt = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE local_id = :id");
$stmt->execute(['id' => $id]);
$totalEventos = $stmt->fetch()['total'];

// Buscar eventos futuros
$stmtFuturos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE local_id = :id AND data_evento >= CURDATE()");
$stmtFuturos->execute(['id' => $id]);
$eventosFuturos = $stmtFuturos->fetch()['total'];

$erros = [];
$dados = $local;

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        $erros[] = 'Token de segurança inválido';
    } else {
        // Dados do formulário
        $dados = [
            'nome' => sanitizeString($_POST['nome'] ?? ''),
            'descricao' => sanitizeString($_POST['descricao'] ?? ''),
            'endereco' => sanitizeString($_POST['endereco'] ?? ''),
            'capacidade' => !empty($_POST['capacidade']) ? (int)$_POST['capacidade'] : null,
            'tipo' => $_POST['tipo'] ?? 'arena',
            'ordem' => (int)($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0
        ];

        // Validações
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (strlen($dados['nome']) > 255) {
            $erros[] = 'Nome deve ter no máximo 255 caracteres';
        }

        // Validar tipo
        if (!in_array($dados['tipo'], ['arena', 'ginasio', 'estadio', 'gramado', 'outro'])) {
            $erros[] = 'Tipo inválido';
        }

        // Validar capacidade
        if ($dados['capacidade'] !== null && $dados['capacidade'] < 0) {
            $erros[] = 'Capacidade deve ser um número positivo';
        }

        // Gerar slug único (excluindo o próprio registro)
        if (empty($erros)) {
            // Se o nome mudou, gerar novo slug
            if ($dados['nome'] !== $local['nome']) {
                $dados['slug'] = slugifyUnique($dados['nome'], 'locais', $id);
            } else {
                $dados['slug'] = $local['slug'];
            }

            try {
                $localModel->atualizar($id, $dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'atualizar', 'locais', $id, 'Local atualizado: ' . $dados['nome']);

                header('Location: /admin/locais/index.php?msg=atualizado');
                exit;
            } catch (Exception $e) {
                $erros[] = $e->getMessage();
            }
        }
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
                    <h2 class="card-title">Editar Local: <?= htmlspecialchars($local['nome']) ?></h2>
                    <a href="/admin/locais/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($totalEventos > 0): ?>
                        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                            ℹ️ <strong>Este local possui <?= $totalEventos ?> evento(s) vinculado(s)</strong>
                            <?php if ($eventosFuturos > 0): ?>
                                (<?= $eventosFuturos ?> evento(s) futuro(s))
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao atualizar local:</strong>
                            <ul style="margin: 0.5rem 0 0 1.5rem;">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="admin-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                        <!-- Informações Básicas -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📝 Informações Básicas</h3>

                        <div class="form-group">
                            <label for="nome" class="required">Nome do Local</label>
                            <input type="text"
                                   id="nome"
                                   name="nome"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                                   required
                                   maxlength="255">
                        </div>

                        <div class="form-group">
                            <label>Slug Atual</label>
                            <div style="background: #f3f4f6; padding: 0.75rem; border-radius: 6px; border: 1px solid #d1d5db;">
                                <code style="font-size: 0.875rem;"><?= htmlspecialchars($local['slug']) ?></code>
                            </div>
                            <small class="form-help">O slug será atualizado automaticamente se você mudar o nome</small>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea id="descricao"
                                      name="descricao"
                                      class="form-control"
                                      rows="3"><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                            <small class="form-help">Descrição opcional do local</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Localização e Capacidade -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📍 Localização e Capacidade</h3>

                        <div class="form-group">
                            <label for="endereco">Endereço Completo</label>
                            <textarea id="endereco"
                                      name="endereco"
                                      class="form-control"
                                      rows="2"
                                      maxlength="500"><?= htmlspecialchars($dados['endereco'] ?? '') ?></textarea>
                            <small class="form-help">Endereço completo do local (máx. 500 caracteres)</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tipo" class="required">Tipo de Local</label>
                                <select id="tipo" name="tipo" class="form-control" required>
                                    <option value="arena" <?= ($dados['tipo'] ?? 'arena') === 'arena' ? 'selected' : '' ?>>
                                        Arena
                                    </option>
                                    <option value="ginasio" <?= ($dados['tipo'] ?? '') === 'ginasio' ? 'selected' : '' ?>>
                                        Ginásio
                                    </option>
                                    <option value="estadio" <?= ($dados['tipo'] ?? '') === 'estadio' ? 'selected' : '' ?>>
                                        Estádio
                                    </option>
                                    <option value="gramado" <?= ($dados['tipo'] ?? '') === 'gramado' ? 'selected' : '' ?>>
                                        Gramado
                                    </option>
                                    <option value="outro" <?= ($dados['tipo'] ?? '') === 'outro' ? 'selected' : '' ?>>
                                        Outro
                                    </option>
                                </select>
                                <small class="form-help">Classificação do tipo de espaço</small>
                            </div>

                            <div class="form-group">
                                <label for="capacidade">Capacidade (pessoas)</label>
                                <input type="number"
                                       id="capacidade"
                                       name="capacidade"
                                       class="form-control"
                                       value="<?= htmlspecialchars($dados['capacidade'] ?? '') ?>"
                                       min="0">
                                <small class="form-help">Capacidade máxima do local</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Configurações -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">⚙️ Configurações</h3>

                        <div class="form-group">
                            <label for="ordem">Ordem de Exibição</label>
                            <input type="number"
                                   id="ordem"
                                   name="ordem"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['ordem'] ?? '0') ?>"
                                   min="0"
                                   style="max-width: 200px;">
                            <small class="form-help">Número para ordenação (0 = padrão alfabético)</small>
                        </div>

                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox"
                                       name="ativo"
                                       value="1"
                                       <?= ($dados['ativo'] ?? false) ? 'checked' : '' ?>
                                       style="width: 20px; height: 20px;">
                                <span style="font-weight: 600;">Local Ativo</span>
                            </label>
                            <small class="form-help">Apenas locais ativos aparecem nos formulários de cadastro de eventos</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✓ Salvar Alterações
                            </button>
                            <a href="/admin/locais/index.php" class="btn btn-secondary">
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
