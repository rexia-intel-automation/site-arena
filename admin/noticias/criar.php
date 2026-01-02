<?php
/**
 * Criar Nova Notícia
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Post.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/upload.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Nova Notícia';

$postModel = new Post();
$categoriaModel = new Categoria();

// Buscar categorias de notícias para o select
$categorias = $categoriaModel->getByTipo('noticia');

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
            'titulo' => sanitizeString($_POST['titulo'] ?? ''),
            'resumo' => sanitizeString($_POST['resumo'] ?? ''),
            'conteudo' => sanitizeHTML($_POST['conteudo'] ?? ''),
            'categoria_id' => $_POST['categoria_id'] ?? '',
            'status' => $_POST['status'] ?? 'rascunho',
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'criado_por' => $ADMIN_ID
        ];

        // Gerar slug único
        $dados['slug'] = slugifyUnique($dados['titulo'], 'posts');

        // Processar upload de imagem (800x450px recomendado)
        if (!empty($_FILES['imagem_destaque']['name'])) {
            $uploadResult = uploadImagemNoticia($_FILES['imagem_destaque'], $dados['titulo']);

            if (!$uploadResult['success']) {
                $erros[] = $uploadResult['message'];
            } else {
                $dados['imagem_destaque'] = $uploadResult['file_path'];
            }
        } else {
            $erros[] = 'Imagem de destaque é obrigatória (800x450px recomendado)';
        }

        // Se não houver erros de upload, validar dados da notícia
        if (empty($erros)) {
            try {
                $postId = $postModel->criar($dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'criar', 'posts', $postId, 'Notícia criada: ' . $dados['titulo']);

                header('Location: /admin/noticias/index.php?msg=criado');
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
                    <h2 class="card-title">Nova Notícia</h2>
                    <a href="/admin/noticias/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao criar notícia:</strong>
                            <ul style="margin: 0.5rem 0 0 1.5rem;">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data" class="admin-form">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                        <!-- Informações Básicas -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📝 Informações Básicas</h3>

                        <div class="form-group">
                            <label for="titulo" class="required">Título da Notícia</label>
                            <input type="text"
                                   id="titulo"
                                   name="titulo"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['titulo'] ?? '') ?>"
                                   required
                                   maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="resumo">Resumo</label>
                            <textarea id="resumo"
                                      name="resumo"
                                      class="form-control"
                                      rows="3"
                                      maxlength="500"><?= htmlspecialchars($dados['resumo'] ?? '') ?></textarea>
                            <small class="form-help">Resumo que aparecerá no card da notícia (máx. 500 caracteres)</small>
                        </div>

                        <div class="form-group">
                            <label for="conteudo" class="required">Conteúdo Completo</label>
                            <textarea id="conteudo"
                                      name="conteudo"
                                      class="form-control"
                                      rows="12"
                                      required><?= htmlspecialchars($dados['conteudo'] ?? '') ?></textarea>
                            <small class="form-help">Texto completo da notícia (aceita HTML básico)</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Categoria -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🏷️ Categoria</h3>

                        <div class="form-group">
                            <label for="categoria_id" class="required">Categoria</label>
                            <select id="categoria_id" name="categoria_id" class="form-control" required>
                                <option value="">Selecione a categoria...</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id'] ?>"
                                            <?= ($dados['categoria_id'] ?? '') == $categoria['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categoria['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-help">Categoria ajuda a organizar as notícias no site</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Imagem -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🖼️ Imagem de Destaque</h3>

                        <div class="alert alert-info" style="margin-bottom: 1rem;">
                            <strong>ℹ️ RECOMENDAÇÃO:</strong> A imagem deve ter preferencialmente <strong>800x450 pixels</strong> para melhor visualização.
                        </div>

                        <div class="form-group">
                            <label for="imagem_destaque" class="required">Upload de Imagem</label>
                            <input type="file"
                                   id="imagem_destaque"
                                   name="imagem_destaque"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp"
                                   required>
                            <small class="form-help">
                                Formatos: JPEG, PNG ou WebP | Tamanho máximo: 5MB | Dimensões recomendadas: 800x450px
                            </small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Publicação -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🚀 Publicação</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="status" class="required">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="rascunho" <?= ($dados['status'] ?? 'rascunho') === 'rascunho' ? 'selected' : '' ?>>
                                        Rascunho
                                    </option>
                                    <option value="publicado" <?= ($dados['status'] ?? '') === 'publicado' ? 'selected' : '' ?>>
                                        Publicado
                                    </option>
                                </select>
                                <small class="form-help">Rascunho não aparece no site público</small>
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; margin-top: 2rem;">
                                    <input type="checkbox"
                                           name="destaque"
                                           value="1"
                                           <?= ($dados['destaque'] ?? false) ? 'checked' : '' ?>
                                           style="width: 20px; height: 20px;">
                                    <span style="font-weight: 600;">Destacar na home</span>
                                </label>
                                <small class="form-help">Notícias em destaque aparecem na home do site</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                Criar Notícia
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
