<?php
/**
 * Editar Evento
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/db/Database.php';
require_once '../../includes/models/Evento.php';
require_once '../../includes/models/Categoria.php';
require_once '../../includes/models/Local.php';
require_once '../../includes/helpers/slugify.php';
require_once '../../includes/helpers/upload.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Editar Evento';

$eventoModel = new Evento();
$categoriaModel = new Categoria();
$localModel = new Local();

// Buscar ID do evento
$eventoId = $_GET['id'] ?? null;

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

// Buscar categorias e locais para os selects
$categorias = $categoriaModel->getByTipo('evento');
$locais = $localModel->getTodosAtivos();

$erros = [];
$dados = $evento; // Preencher com dados existentes

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        $erros[] = 'Token de segurança inválido';
    } else {
        // Dados do formulário
        $dados = [
            'titulo' => sanitizeString($_POST['titulo'] ?? ''),
            'descricao' => sanitizeString($_POST['descricao'] ?? ''),
            'conteudo' => sanitizeHTML($_POST['conteudo'] ?? ''),
            'data_evento' => $_POST['data_evento'] ?? '',
            'hora_evento' => $_POST['hora_evento'] ?? '',
            'local_id' => $_POST['local_id'] ?? '',
            'categoria_id' => $_POST['categoria_id'] ?? '',
            'tipo_evento' => sanitizeString($_POST['tipo_evento'] ?? ''),
            'preco_minimo' => $_POST['preco_minimo'] ?? '',
            'preco_maximo' => $_POST['preco_maximo'] ?? '',
            'link_ingressos' => $_POST['link_ingressos'] ?? '',
            'status' => $_POST['status'] ?? 'rascunho',
            'destaque' => isset($_POST['destaque']) ? 1 : 0,
            'atualizado_por' => $ADMIN_ID
        ];

        // Manter imagem antiga caso não seja enviada nova
        $dados['imagem_destaque'] = $evento['imagem_destaque'];

        // Atualizar slug se título mudou
        if ($dados['titulo'] !== $evento['titulo']) {
            $dados['slug'] = slugifyUnique($dados['titulo'], 'eventos', $eventoId);
        } else {
            $dados['slug'] = $evento['slug'];
        }

        // Processar upload de nova imagem (VALIDAÇÃO RÍGIDA: 475x180px)
        if (!empty($_FILES['imagem_destaque']['name'])) {
            $uploadResult = uploadImagemEvento($_FILES['imagem_destaque'], $dados['titulo']);

            if (!$uploadResult['success']) {
                $erros[] = $uploadResult['message'];
            } else {
                // Deletar imagem antiga
                if ($evento['imagem_destaque'] && file_exists('../../' . $evento['imagem_destaque'])) {
                    unlink('../../' . $evento['imagem_destaque']);
                }
                $dados['imagem_destaque'] = $uploadResult['file_path'];
            }
        }

        // Se não houver erros, validar e atualizar
        if (empty($erros)) {
            try {
                $eventoModel->atualizar($eventoId, $dados);

                // Registrar log
                registrarLog($ADMIN_ID, 'atualizar', 'eventos', $eventoId, 'Evento atualizado: ' . $dados['titulo']);

                header('Location: /admin/eventos/index.php?msg=atualizado');
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
                    <h2 class="card-title">Editar Evento</h2>
                    <a href="/admin/eventos/index.php" class="btn btn-secondary">
                        ← Voltar
                    </a>
                </div>

                <div class="card-body">
                    <?php if (!empty($erros)): ?>
                        <div class="alert alert-error">
                            <strong>❌ Erro ao atualizar evento:</strong>
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
                            <label for="titulo" class="required">Título do Evento</label>
                            <input type="text"
                                   id="titulo"
                                   name="titulo"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['titulo'] ?? '') ?>"
                                   required
                                   maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição Curta</label>
                            <textarea id="descricao"
                                      name="descricao"
                                      class="form-control"
                                      rows="3"
                                      maxlength="500"><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                            <small class="form-help">Resumo que aparecerá no card do evento (máx. 500 caracteres)</small>
                        </div>

                        <div class="form-group">
                            <label for="conteudo">Descrição Completa</label>
                            <textarea id="conteudo"
                                      name="conteudo"
                                      class="form-control"
                                      rows="8"><?= htmlspecialchars($dados['conteudo'] ?? '') ?></textarea>
                            <small class="form-help">Descrição detalhada do evento (aceita HTML básico)</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Data e Hora -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);"> Data e Horário</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="data_evento" class="required">Data do Evento</label>
                                <input type="date"
                                       id="data_evento"
                                       name="data_evento"
                                       class="form-control"
                                       value="<?= htmlspecialchars($dados['data_evento'] ?? '') ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="hora_evento" class="required">Horário</label>
                                <input type="time"
                                       id="hora_evento"
                                       name="hora_evento"
                                       class="form-control"
                                       value="<?= htmlspecialchars($dados['hora_evento'] ?? '') ?>"
                                       required>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Local e Categoria -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">📍 Local e Categoria</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="local_id" class="required">Local</label>
                                <select id="local_id" name="local_id" class="form-control" required>
                                    <option value="">Selecione o local...</option>
                                    <?php foreach ($locais as $local): ?>
                                        <option value="<?= $local['id'] ?>"
                                                <?= ($dados['local_id'] ?? '') == $local['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($local['nome']) ?>
                                            <?php if ($local['capacidade']): ?>
                                                (Capacidade: <?= number_format($local['capacidade']) ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

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
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_evento">Tipo de Evento</label>
                            <input type="text"
                                   id="tipo_evento"
                                   name="tipo_evento"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['tipo_evento'] ?? '') ?>"
                                   placeholder="Ex: show, esporte, festival, corporativo"
                                   maxlength="50">
                            <small class="form-help">Opcional - tipo específico do evento</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Ingressos -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🎟️ Ingressos</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="preco_minimo" class="required">Preço Mínimo (R$)</label>
                                <input type="number"
                                       id="preco_minimo"
                                       name="preco_minimo"
                                       class="form-control"
                                       step="0.01"
                                       min="0"
                                       value="<?= htmlspecialchars($dados['preco_minimo'] ?? '') ?>"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="preco_maximo">Preço Máximo (R$)</label>
                                <input type="number"
                                       id="preco_maximo"
                                       name="preco_maximo"
                                       class="form-control"
                                       step="0.01"
                                       min="0"
                                       value="<?= htmlspecialchars($dados['preco_maximo'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="link_ingressos" class="required">Link para Compra de Ingressos</label>
                            <input type="url"
                                   id="link_ingressos"
                                   name="link_ingressos"
                                   class="form-control"
                                   value="<?= htmlspecialchars($dados['link_ingressos'] ?? '') ?>"
                                   placeholder="https://www.bilheteria.com.br/evento"
                                   required>
                            <small class="form-help">URL completa onde o público pode comprar ingressos</small>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Imagem -->
                        <h3 style="margin-bottom: 1rem; color: var(--gray-700);">🖼️ Imagem de Destaque</h3>

                        <?php if ($dados['imagem_destaque']): ?>
                            <div style="margin-bottom: 1rem;">
                                <p style="margin-bottom: 0.5rem; font-weight: 600;">Imagem Atual:</p>
                                <img src="/<?= htmlspecialchars($dados['imagem_destaque']) ?>"
                                     alt="<?= htmlspecialchars($dados['titulo']) ?>"
                                     style="max-width: 475px; height: auto; border: 2px solid var(--gray-300); border-radius: 8px;">
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info" style="margin-bottom: 1rem;">
                            <strong>ℹ️ INFO:</strong> Deixe em branco para manter a imagem atual.<br>
                            Se enviar nova imagem, ela deve ter <strong>EXATAMENTE 475x180 pixels</strong>.
                        </div>

                        <div class="form-group">
                            <label for="imagem_destaque">Upload de Nova Imagem (475x180px)</label>
                            <input type="file"
                                   id="imagem_destaque"
                                   name="imagem_destaque"
                                   class="form-control"
                                   accept="image/jpeg,image/png,image/webp">
                            <small class="form-help">
                                Formatos: JPEG, PNG ou WebP | Tamanho máximo: 2MB | Dimensões: <strong>475x180px</strong>
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
                                <small class="form-help">Eventos em destaque aparecem na home do site</small>
                            </div>
                        </div>

                        <hr style="margin: 2rem 0;">

                        <!-- Botões -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Salvar Alterações
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
