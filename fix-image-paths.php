<?php
/**
 * Script de correção de caminhos de imagens - VERSÃO MELHORADA
 * Corrige caminhos que começam com '/' para evitar duplicação de barras
 */

require_once 'config/database.php';
require_once 'includes/db/Database.php';

echo "=== Correção de Caminhos de Imagens ===\n\n";

try {
    $db = Database::getInstance()->getConnection();

    // Verificar eventos antes da correção
    echo "Verificando eventos...\n";
    $sql = "SELECT id, titulo, imagem_destaque FROM eventos WHERE imagem_destaque IS NOT NULL LIMIT 5";
    $stmt = $db->query($sql);
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($eventos)) {
        echo "Eventos encontrados ANTES da correção:\n";
        foreach ($eventos as $evento) {
            echo "  ID: {$evento['id']} | Título: {$evento['titulo']}\n";
            echo "  Caminho ANTES: {$evento['imagem_destaque']}\n\n";
        }
    } else {
        echo "Nenhum evento com imagem encontrado.\n\n";
    }

    // Corrigir eventos
    echo "Corrigindo eventos...\n";
    $sql = "UPDATE eventos
            SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
            WHERE imagem_destaque LIKE '/%'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $eventosAtualizados = $stmt->rowCount();
    echo "✓ {$eventosAtualizados} evento(s) atualizado(s)\n\n";

    // Verificar eventos após a correção
    if (!empty($eventos)) {
        echo "Verificando eventos APÓS correção:\n";
        $sql = "SELECT id, titulo, imagem_destaque FROM eventos WHERE id IN (" . implode(',', array_column($eventos, 'id')) . ")";
        $stmt = $db->query($sql);
        $eventosDepois = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($eventosDepois as $evento) {
            echo "  ID: {$evento['id']} | Título: {$evento['titulo']}\n";
            echo "  Caminho DEPOIS: {$evento['imagem_destaque']}\n\n";
        }
    }

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

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
