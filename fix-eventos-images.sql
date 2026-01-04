-- ============================================
-- CORREÇÃO: Caminhos de Imagens de Eventos
-- ============================================
-- Remove a barra inicial dos caminhos de imagem
-- Executar via phpMyAdmin ou linha de comando MySQL

-- 1. VERIFICAR eventos ANTES da correção
SELECT id, titulo, imagem_destaque
FROM eventos
WHERE imagem_destaque IS NOT NULL
LIMIT 10;

-- 2. CORRIGIR eventos (remover barra inicial)
UPDATE eventos
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';

-- 3. VERIFICAR eventos APÓS a correção
SELECT id, titulo, imagem_destaque
FROM eventos
WHERE imagem_destaque IS NOT NULL
LIMIT 10;

-- Os caminhos devem estar SEM barra inicial:
-- ✅ CORRETO: public/assets/uploads/eventos/nome.jpg
-- ❌ ERRADO: /public/assets/uploads/eventos/nome.jpg
