<?php
/**
 * Editar Categoria
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Editar Categoria';

$categoriaModel = new Categoria();

// Validar ID
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /admin/categorias/index.php');
    exit;
}

// Buscar categoria
$categoria = $categoriaModel->getById($id);
if (!$categoria) {
    header('Location: /admin/categorias/index.php');
    exit;
}

// Buscar estatísticas de vinculação
$db = Database::getInstance()->getConnection();

$stmtEventos = $db->prepare("SELECT COUNT(*) as total FROM eventos WHERE categoria_id = :id");
$stmtEventos->execute(['id' => $id]);
$totalEventos = $stmtEventos->fetch()['total'];

$stmtPosts = $db->prepare("SELECT COUNT(*) as total FROM posts WHERE categoria_id = :id");
$stmtPosts->execute(['id' => $id]);
$totalPosts = $stmtPosts->fetch()['total'];

$totalVinculos = $totalEventos + $totalPosts;

$erros = [];
$dados = $categoria;

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
            'tipo' => $_POST['tipo'] ?? 'ambos',
            'cor' => $_POST['cor'] ?? '#8e44ad',
            'icone' => sanitizeString($_POST['icone'] ?? ''),
            'ordem' => (int)($_POST['ordem'] ?? 0),
            'ativo' => isset($_POST['ativo']) ? 1 : 0
        ];

        // Validações
        if (empty($dados['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (strlen($dados['nome']) > 100) {
            $erros[] = 'Nome deve ter no máximo 100 caracteres';
        }

        // Validar tipo
        if (!in_array($dados['tipo'], ['evento', 'noticia', 'ambos'])) {
            $erros[] = 'Tipo inválido';
        }

        // Validar cor (formato hex)
        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $dados['cor'])) {
            $erros[] = 'Cor deve estar no formato hexadecimal (#000000)';
        }

        // Gerar slug único (excluindo o próprio registro)
        if (empty($erros)) {
            // Se o nome mudou, gerar novo slug
            if ($dados['nome'] !== $categoria['nome']) {
                $dados['slug'] = slugifyUnique($dados['nome'], 'categorias', $id);
            } else {
                $dados['slug'] = $categoria['slug'];
            }

            try {
                $categoriaModel->atualizar($id, $dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'atualizar', 'categorias', $id, 'Categoria atualizada: ' . $dados['nome']);

                header('Location: /admin/categorias/index.php?msg=atualizado');
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
                    <h2 class="card-title">Editar Categoria: <?= htmlspecialchars($categoria['nome']) ?></h2>
                    <a href="/admin/categorias/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if ($totalVinculos > 0): ?>
                        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                            ℹ️ <strong>Esta categoria possui <?= $totalVinculos ?> registro(s) vinculado(s):</strong>
                            <?= $totalEventos ?> evento(s) e <?= $totalPosts ?> notícia(s).
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao atualizar categoria:</strong>
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
                            <label for="nome" class="required">Nome da Categoria</label>
                            <input type="text"
                                   id="nome"
                                   name="nome"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['nome'] ?? '') ?>"
                                   required
                                   maxlength="100">
                            <small class="form-help">Exemplo: Show, Futebol, Festa, etc.</small>
                        </div>

                        <div class="form-group">
                            <label>Slug Atual</label>
                            <div style="background: #f3f4f6; padding: 0.75rem; border-radius: 6px; border: 1px solid #d1d5db;">
                                <code style="font-size: 0.875rem;"><?= htmlspecialchars($categoria['slug']) ?></code>
                            </div>
                            <small class="form-help">O slug será atualizado automaticamente se você mudar o nome</small>
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição</label>
                            <textarea id="descricao"
                                      name="descricao"
                                      class="form-control"
                                      rows="3"><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                            <small class="form-help">Descrição opcional da categoria</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Configurações -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">⚙️ Configurações</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tipo" class="required">Tipo</label>
                                <select id="tipo" name="tipo" class="form-control" required>
                                    <option value="ambos" <?= ($dados['tipo'] ?? 'ambos') === 'ambos' ? 'selected' : '' ?>>
                                        Ambos (Eventos e Notícias)
                                    </option>
                                    <option value="evento" <?= ($dados['tipo'] ?? '') === 'evento' ? 'selected' : '' ?>>
                                        Apenas Eventos
                                    </option>
                                    <option value="noticia" <?= ($dados['tipo'] ?? '') === 'noticia' ? 'selected' : '' ?>>
                                        Apenas Notícias
                                    </option>
                                </select>
                                <small class="form-help">Define onde esta categoria pode ser usada</small>
                            </div>

                            <div class="form-group">
                                <label for="cor" class="required">Cor</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="color"
                                           id="cor"
                                           name="cor"
                                           value="<?= htmlspecialchars($dados['cor'] ?? '#8e44ad') ?>"
                                           style="width: 60px; height: 40px; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer;">
                                    <input type="text"
                                           id="cor_hex"
                                           class="form-control"
                                           value="<?= htmlspecialchars($dados['cor'] ?? '#8e44ad') ?>"
                                           pattern="^#[0-9a-fA-F]{6}$"
                                           maxlength="7"
                                           style="flex: 1;"
                                           readonly>
                                </div>
                                <small class="form-help">Cor de destaque da categoria (em hexadecimal)</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="icone">Ícone</label>
                                <input type="text"
                                       id="icone"
                                       name="icone"
                                       class="form-control"
                                       value="<?= htmlspecialchars($dados['icone'] ?? '') ?>"
                                       maxlength="50">
                                <small class="form-help">Nome do ícone (opcional, para uso futuro)</small>
                            </div>

                            <div class="form-group">
                                <label for="ordem">Ordem de Exibição</label>
                                <input type="number"
                                       id="ordem"
                                       name="ordem"
                                       class="form-control"
                                       value="<?= htmlspecialchars($dados['ordem'] ?? '0') ?>"
                                       min="0">
                                <small class="form-help">Número para ordenação (0 = padrão)</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Status -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🚀 Status</h3>

                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox"
                                       name="ativo"
                                       value="1"
                                       <?= ($dados['ativo'] ?? false) ? 'checked' : '' ?>
                                       style="width: 20px; height: 20px;">
                                <span style="font-weight: 600;">Categoria Ativa</span>
                            </label>
                            <small class="form-help">Apenas categorias ativas aparecem nos formulários de cadastro</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                ✓ Salvar Alterações
                            </button>
                            <a href="/admin/categorias/index.php" class="btn btn-secondary">
                                ❌ Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sincronizar color picker com input de texto
        const colorPicker = document.getElementById('cor');
        const colorHex = document.getElementById('cor_hex');

        colorPicker.addEventListener('input', function() {
            colorHex.value = this.value.toUpperCase();
        });

        colorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                colorPicker.value = this.value;
            }
        });
    </script>
</body>
</html>
