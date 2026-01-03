<?php
/**
 * Deletar Imagem da Galeria
 */

require_once '../includes/auth-check.php';
require_once '../../includes/helpers/security.php';

// Diretório da galeria
$galeriaDir = __DIR__ . '/../../public/assets/uploads/galeria/';

// Buscar nome do arquivo
$nomeArquivo = $_GET['nome'] ?? null;

if (!$nomeArquivo) {
    header('Location: /admin/galeria/index.php?erro=nome_invalido');
    exit;
}

// Sanitizar nome do arquivo (segurança)
$nomeArquivo = basename($nomeArquivo);

// Verificar se arquivo existe
$caminhoArquivo = $galeriaDir . $nomeArquivo;
if (!file_exists($caminhoArquivo)) {
    header('Location: /admin/galeria/index.php?erro=arquivo_nao_encontrado');
    exit;
}

// Deletar arquivo
if (unlink($caminhoArquivo)) {
    // Registrar log
    registrarLog($ADMIN_ID, 'deletar', 'galeria', 0, 'Imagem deletada: ' . $nomeArquivo);

    header('Location: /admin/galeria/index.php?msg=deletado');
    exit;
} else {
    header('Location: /admin/galeria/index.php?erro=falha_deletar');
    exit;
}
