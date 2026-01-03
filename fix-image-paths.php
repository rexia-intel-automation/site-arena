<?php
/**
 * Script de correção de caminhos de imagens
 * Corrige caminhos que começam com '/' para evitar duplicação de barras
 */

require_once 'config/database.php';
require_once 'includes/db/Database.php';

echo "=== Correção de Caminhos de Imagens ===\n\n";

$db = Database::getInstance()->getConnection();

// Corrigir eventos
echo "Corrigindo eventos...\n";
$sql = "UPDATE eventos
        SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
        WHERE imagem_destaque LIKE '/%'";
$stmt = $db->prepare($sql);
$stmt->execute();
$eventosAtualizados = $stmt->rowCount();
echo "✓ {$eventosAtualizados} evento(s) atualizado(s)\n\n";

// Corrigir notícias
echo "Corrigindo notícias...\n";
$sql = "UPDATE noticias
        SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
        WHERE imagem_destaque LIKE '/%'";
$stmt = $db->prepare($sql);
$stmt->execute();
$noticiasAtualizadas = $stmt->rowCount();
echo "✓ {$noticiasAtualizadas} notícia(s) atualizada(s)\n\n";

echo "=== Correção concluída com sucesso! ===\n";
echo "Total de registros atualizados: " . ($eventosAtualizados + $noticiasAtualizadas) . "\n";
