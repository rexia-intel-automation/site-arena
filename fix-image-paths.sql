-- Script SQL para corrigir caminhos de imagens
-- Remove a barra inicial dos caminhos que começam com '/'

-- Corrigir eventos
UPDATE eventos
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';

-- Corrigir notícias
UPDATE noticias
SET imagem_destaque = TRIM(LEADING '/' FROM imagem_destaque)
WHERE imagem_destaque LIKE '/%';

-- Verificar os resultados
SELECT id, titulo, imagem_destaque FROM eventos WHERE imagem_destaque IS NOT NULL LIMIT 5;
SELECT id, titulo, imagem_destaque FROM noticias WHERE imagem_destaque IS NOT NULL LIMIT 5;
