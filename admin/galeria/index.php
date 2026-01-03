<?php
/**
 * Galeria de Imagens - Admin
 * Upload, visualização e gerenciamento de imagens
 */

require_once '../includes/auth-check.php';
require_once '../../config/database.php';
require_once '../../includes/helpers/security.php';

$pageTitle = 'Galeria de Imagens';

// Diretório da galeria
$galeriaDir = __DIR__ . '/../../public/assets/uploads/galeria/';
$galeriaUrl = '/public/assets/uploads/galeria/';

// Criar diretório se não existir
if (!is_dir($galeriaDir)) {
    mkdir($galeriaDir, 0755, true);
}

$mensagem = '';
$erros = [];
$sucessos = [];

// Processar upload múltiplo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagens'])) {
    // Validar CSRF
    if (!verificarCSRFToken($_POST['csrf_token'] ?? '')) {
        $erros[] = 'Token de segurança inválido';
    } else {
        $files = $_FILES['imagens'];
        $totalFiles = count($files['name']);

        for ($i = 0; $i < $totalFiles; $i++) {
            // Pular arquivos vazios
            if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            // Verificar erro de upload
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                $erros[] = "Erro no upload do arquivo " . htmlspecialchars($files['name'][$i]);
                continue;
            }

            // Verificar tamanho (5MB)
            $maxSize = 5 * 1024 * 1024;
            if ($files['size'][$i] > $maxSize) {
                $erros[] = "Arquivo {$files['name'][$i]} muito grande (máx 5MB)";
                continue;
            }

            // Verificar tipo MIME
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $files['tmp_name'][$i]);
            finfo_close($finfo);

            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($mimeType, $allowedTypes)) {
                $erros[] = "Arquivo {$files['name'][$i]} não é uma imagem válida";
                continue;
            }

            // Gerar nome único
            $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $fileName = 'galeria-' . time() . '-' . $i . '.' . $extension;
            $filePath = $galeriaDir . $fileName;

            // Mover arquivo
            if (move_uploaded_file($files['tmp_name'][$i], $filePath)) {
                $sucessos[] = "Imagem {$files['name'][$i]} enviada com sucesso";

                // Registrar log
                registrarLog($ADMIN_ID, 'criar', 'galeria', 0, 'Imagem adicionada: ' . $fileName);
            } else {
                $erros[] = "Erro ao salvar {$files['name'][$i]}";
            }
        }

        if (!empty($sucessos) && empty($erros)) {
            $mensagem = 'success';
        } elseif (!empty($sucessos) && !empty($erros)) {
            $mensagem = 'partial';
        } elseif (empty($sucessos) && !empty($erros)) {
            $mensagem = 'error';
        }
    }
}

// Listar imagens da galeria
$imagens = [];
if (is_dir($galeriaDir)) {
    $files = scandir($galeriaDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $galeriaDir . $file;
        if (is_file($filePath)) {
            $imagens[] = [
                'nome' => $file,
                'url' => $galeriaUrl . $file,
                'tamanho' => filesize($filePath),
                'data' => filemtime($filePath)
            ];
        }
    }
}

// Ordenar por data (mais recentes primeiro)
usort($imagens, function($a, $b) {
    return $b['data'] - $a['data'];
});

$totalImagens = count($imagens);

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
    <style>
        .upload-zone {
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-zone:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .upload-zone.drag-over {
            border-color: #3b82f6;
            background: #dbeafe;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        .gallery-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            background: #f3f4f6;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .gallery-item-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.5rem;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .gallery-item:hover .gallery-item-actions {
            opacity: 1;
        }
        .gallery-item-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            color: white;
            padding: 1rem 0.5rem 0.5rem;
            font-size: 0.75rem;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .gallery-item:hover .gallery-item-info {
            opacity: 1;
        }
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.9);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .lightbox.active {
            display: flex;
        }
        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }
        .lightbox-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
        }
        .btn-icon {
            background: white;
            border: none;
            padding: 0.5rem;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-icon:hover {
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <?php include '../includes/header.php'; ?>

        <main class="admin-content">
            <?php if ($mensagem === 'success'): ?>
                <div class="alert alert-success">
                    ✓ <?= count($sucessos) ?> imagem(ns) enviada(s) com sucesso!
                </div>
            <?php elseif ($mensagem === 'partial'): ?>
                <div class="alert alert-info">
                    ℹ️ <?= count($sucessos) ?> imagem(ns) enviada(s), <?= count($erros) ?> erro(s) ocorreram.
                </div>
            <?php elseif ($mensagem === 'error'): ?>
                <div class="alert alert-error">
                    <strong>❌ Erro ao enviar imagens:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        <?php foreach ($erros as $erro): ?>
                            <li><?= htmlspecialchars($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($erros) && !empty($sucessos)): ?>
                <div class="alert alert-error" style="margin-top: 1rem;">
                    <strong>Erros:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        <?php foreach ($erros as $erro): ?>
                            <li><?= htmlspecialchars($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">📸 Galeria de Imagens (<?= $totalImagens ?>)</h2>
                </div>

                <div class="card-body">
                    <!-- Upload Zone -->
                    <form method="POST" enctype="multipart/form-data" id="uploadForm">
                        <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

                        <div class="upload-zone" id="uploadZone">
                            <input type="file"
                                   id="imagens"
                                   name="imagens[]"
                                   multiple
                                   accept="image/jpeg,image/png,image/webp"
                                   style="display: none;">

                            <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                            <h3 style="margin-bottom: 0.5rem;">Arraste imagens aqui ou clique para selecionar</h3>
                            <p style="color: #6b7280; font-size: 0.875rem;">
                                Formatos: JPEG, PNG, WebP | Máximo: 5MB por imagem
                            </p>
                            <p style="color: #6b7280; font-size: 0.875rem;">
                                Você pode selecionar múltiplas imagens de uma vez
                            </p>
                        </div>

                        <div id="fileList" style="margin-top: 1rem; display: none;">
                            <h4>Arquivos selecionados:</h4>
                            <ul id="fileListItems" style="list-style: none; padding: 0;"></ul>
                            <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                                📤 Fazer Upload
                            </button>
                        </div>
                    </form>

                    <!-- Gallery Grid -->
                    <?php if ($totalImagens > 0): ?>
                        <hr style="margin: 2rem 0;">

                        <div class="gallery-grid">
                            <?php foreach ($imagens as $imagem): ?>
                                <div class="gallery-item" data-url="<?= htmlspecialchars($imagem['url']) ?>">
                                    <img src="<?= htmlspecialchars($imagem['url']) ?>"
                                         alt="<?= htmlspecialchars($imagem['nome']) ?>"
                                         loading="lazy">

                                    <div class="gallery-item-actions">
                                        <button class="btn-icon" onclick="copiarUrl(event, '<?= htmlspecialchars($imagem['url']) ?>')" title="Copiar URL">
                                            📋
                                        </button>
                                        <button class="btn-icon" onclick="deletarImagem(event, '<?= htmlspecialchars($imagem['nome']) ?>')" title="Deletar">
                                            🗑️
                                        </button>
                                    </div>

                                    <div class="gallery-item-info">
                                        <div><strong><?= htmlspecialchars(substr($imagem['nome'], 0, 20)) ?><?= strlen($imagem['nome']) > 20 ? '...' : '' ?></strong></div>
                                        <div><?= number_format($imagem['tamanho'] / 1024, 1) ?> KB</div>
                                        <div><?= date('d/m/Y H:i', $imagem['data']) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 3rem; color: #6b7280;">
                            <div style="font-size: 4rem; margin-bottom: 1rem;">🖼️</div>
                            <p>Nenhuma imagem na galeria ainda.</p>
                            <p>Faça upload de imagens usando o formulário acima.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">✕</button>
        <img id="lightboxImage" src="" alt="">
    </div>

    <script>
        // Upload zone interactions
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('imagens');
        const fileList = document.getElementById('fileList');
        const fileListItems = document.getElementById('fileListItems');

        uploadZone.addEventListener('click', () => fileInput.click());

        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('drag-over');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('drag-over');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('drag-over');
            fileInput.files = e.dataTransfer.files;
            updateFileList();
        });

        fileInput.addEventListener('change', updateFileList);

        function updateFileList() {
            const files = fileInput.files;
            if (files.length === 0) {
                fileList.style.display = 'none';
                return;
            }

            fileList.style.display = 'block';
            fileListItems.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const li = document.createElement('li');
                li.style.padding = '0.5rem';
                li.style.background = '#f9fafb';
                li.style.borderRadius = '4px';
                li.style.marginBottom = '0.5rem';
                li.textContent = `${files[i].name} (${(files[i].size / 1024).toFixed(1)} KB)`;
                fileListItems.appendChild(li);
            }
        }

        // Gallery lightbox
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (e.target.closest('.gallery-item-actions')) return;
                openLightbox(item.dataset.url);
            });
        });

        function openLightbox(url) {
            document.getElementById('lightboxImage').src = url;
            document.getElementById('lightbox').classList.add('active');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
        }

        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') {
                closeLightbox();
            }
        });

        // Copiar URL
        function copiarUrl(event, url) {
            event.stopPropagation();
            const fullUrl = window.location.origin + url;
            navigator.clipboard.writeText(fullUrl).then(() => {
                alert('URL copiada para a área de transferência:\n' + fullUrl);
            });
        }

        // Deletar imagem
        function deletarImagem(event, nome) {
            event.stopPropagation();
            if (confirm(`Tem certeza que deseja deletar a imagem "${nome}"?\n\nEsta ação não pode ser desfeita.`)) {
                window.location.href = `/admin/galeria/deletar.php?nome=${encodeURIComponent(nome)}`;
            }
        }

        // ESC para fechar lightbox
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
