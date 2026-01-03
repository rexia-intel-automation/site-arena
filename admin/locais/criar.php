<?php
/**
 * Criar Novo Local
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Local.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Novo Local';

$localModel = new Local();

$erros = [];
$dados = [];

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

        // Gerar slug único
        if (empty($erros)) {
            $dados['slug'] = slugifyUnique($dados['nome'], 'locais');

            try {
                $localId = $localModel->criar($dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'criar', 'locais', $localId, 'Local criado: ' . $dados['nome']);

                header('Location: /admin/locais/index.php?msg=criado');
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
                    <h2 class="card-title">Novo Local</h2>
                    <a href="/admin/locais/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao criar local:</strong>
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
                                   maxlength="255"
                                   placeholder="Ex: Arena BRB Mané Garrincha">
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea id="descricao"
                                      name="descricao"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Descrição opcional do local..."><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
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
                                      maxlength="500"
                                      placeholder="Rua, número, bairro, cidade, CEP..."><?= htmlspecialchars($dados['endereco'] ?? '') ?></textarea>
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
                                       min="0"
                                       placeholder="Ex: 72000">
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
                                       <?= ($dados['ativo'] ?? true) ? 'checked' : '' ?>
                                       style="width: 20px; height: 20px;">
                                <span style="font-weight: 600;">Local Ativo</span>
                            </label>
                            <small class="form-help">Apenas locais ativos aparecem nos formulários de cadastro de eventos</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✓ Criar Local
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
